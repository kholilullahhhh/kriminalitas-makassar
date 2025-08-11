<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\Datakriminal;

class KmeansMethodController extends Controller
{
    public function index()
    {
        $data = Datakriminal::with('kecamatan')->get();

        // Persiapkan dataset
        $dataset = [];
        foreach ($data as $item) {
            $totalKasus = $item->tipu_online + $item->pencurian + $item->curanmor + $item->penipuan + $item->kdrt;
            $persentase = ($item->jumlah_penduduk > 0)
                ? ($totalKasus / $item->jumlah_penduduk) * 100
                : 0;

            $dataset[] = [
                'id' => $item->id,
                'persentase' => $persentase,
                'features' => [
                    'persentase' => $persentase,
                    'jumlah_penduduk' => $item->jumlah_penduduk
                ]
            ];
        }

        $k = 3;
        $centroids = $this->initializeCentroids($dataset, $k);

        $maxIterations = 100;
        $iterations = 0;
        $clusters = [];

        while ($iterations < $maxIterations) {
            $newClusters = array_fill(0, $k, []);

            // Assign data ke cluster terdekat
            foreach ($dataset as $point) {
                $minDistance = PHP_FLOAT_MAX;
                $clusterIndex = 0;

                foreach ($centroids as $index => $centroid) {
                    $distance = $this->calculateDistance($point['features'], $centroid);
                    if ($distance < $minDistance) {
                        $minDistance = $distance;
                        $clusterIndex = $index;
                    }
                }

                $newClusters[$clusterIndex][] = $point;
            }

            $newCentroids = [];
            foreach ($newClusters as $cluster) {
                $newCentroids[] = count($cluster) > 0
                    ? $this->calculateCentroid($cluster)
                    : $centroids[count($newCentroids)];
            }

            if ($this->centroidsEqual($centroids, $newCentroids)) {
                $clusters = $newClusters; // pastikan cluster terakhir tersimpan
                break;
            }

            $centroids = $newCentroids;
            $clusters = $newClusters;
            $iterations++;
        }

        // Simpan hasil clustering
        Cluster::truncate();
        foreach ($clusters as $clusterIndex => $cluster) {
            foreach ($cluster as $point) {
                Cluster::create([
                    'data_kriminal_id' => $point['id'],
                    'cluster' => $clusterIndex,
                    'kategori' => $this->kategoriCluster($clusterIndex),
                    'nilai' => $point['persentase']
                ]);
            }
        }

        $clusterNames = [
            0 => 'High Risk Area',
            1 => 'Medium Risk Area',
            2 => 'Low Risk Area'
        ];

        return view('pages.uji.index', [
            'menu' => 'uji',
            'clusters' => Cluster::with('dataKriminal.kecamatan')->get(),
            'centroid' => $centroids,
            'iterations' => $iterations,
            'clusterNames' => $clusterNames
        ]);
    }

    private function initializeCentroids(array $dataset, int $k): array
    {
        $centroids = [];
        $firstIndex = array_rand($dataset);
        $centroids[] = $dataset[$firstIndex]['features'];

        while (count($centroids) < $k) {
            $distances = [];
            $totalDistance = 0;

            foreach ($dataset as $point) {
                $minDistance = PHP_FLOAT_MAX;
                foreach ($centroids as $centroid) {
                    $distance = $this->calculateDistance($point['features'], $centroid);
                    if ($distance < $minDistance) {
                        $minDistance = $distance;
                    }
                }
                $distances[] = $minDistance ** 2;
                $totalDistance += $minDistance ** 2;
            }

            if ($totalDistance == 0) {
                break; // semua titik sama
            }

            $random = mt_rand() / mt_getrandmax() * $totalDistance;
            $cumulative = 0;
            foreach ($distances as $index => $distance) {
                $cumulative += $distance;
                if ($cumulative >= $random) {
                    $centroids[] = $dataset[$index]['features'];
                    break;
                }
            }
        }

        return $centroids;
    }

    private function calculateDistance(array $point1, array $point2): float
    {
        $sum = 0;
        foreach ($point1 as $key => $value) {
            $sum += ($value - $point2[$key]) ** 2;
        }
        return sqrt($sum);
    }

    private function calculateCentroid(array $cluster): array
    {
        $centroid = [];
        $count = count($cluster);
        $keys = array_keys($cluster[0]['features']);

        foreach ($keys as $key) {
            $centroid[$key] = 0;
        }

        foreach ($cluster as $point) {
            foreach ($point['features'] as $key => $value) {
                $centroid[$key] += $value;
            }
        }

        foreach ($centroid as $key => $value) {
            $centroid[$key] = $value / $count;
        }

        return $centroid;
    }

    private function centroidsEqual(array $centroids1, array $centroids2, float $tolerance = 0.0001): bool
    {
        if (count($centroids1) !== count($centroids2)) {
            return false;
        }
        foreach ($centroids1 as $i => $centroid1) {
            foreach ($centroid1 as $key => $value) {
                if (abs($value - $centroids2[$i][$key]) > $tolerance) {
                    return false;
                }
            }
        }
        return true;
    }

    private function kategoriCluster(int $cluster): string
    {
        $map = [
            0 => 'Tinggi',
            1 => 'Sedang',
            2 => 'Rendah'
        ];
        return $map[$cluster] ?? 'Unknown';
    }
}
