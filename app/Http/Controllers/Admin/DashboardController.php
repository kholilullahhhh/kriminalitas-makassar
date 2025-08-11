<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Datakriminal;
use App\Models\Cluster;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalKasus = Datakriminal::selectRaw('SUM(tipu_online + pencurian + curanmor + penipuan + kdrt) as total')
            ->value('total');

        $pencurian = Datakriminal::sum('pencurian');
        $kdrt = Datakriminal::sum('kdrt');
        $totalKecamatan = Kecamatan::count();

        // Data trend 3 tahun terakhir
        $years = Datakriminal::select('tahun')->distinct()->orderBy('tahun', 'asc')->pluck('tahun')->toArray();

        $trendData = [
            'years' => $years,
            'total' => [],
            'pencurian' => [],
            'kdrt' => []
        ];

        foreach ($years as $year) {
            $totalKasusPerTahun = Datakriminal::where('tahun', $year)
                ->selectRaw('SUM(tipu_online + pencurian + curanmor + penipuan + kdrt) as total')
                ->first()
                ->total;

            $trendData['total'][] = $totalKasusPerTahun;

            $trendData['pencurian'][] = Datakriminal::where('tahun', $year)->sum('pencurian');
            $trendData['kdrt'][] = Datakriminal::where('tahun', $year)->sum('kdrt');
        }

        // Data cluster
        $clusterHigh = Cluster::where('kategori', 'Tinggi')->count();
        $clusterMedium = Cluster::where('kategori', 'Sedang')->count();
        $clusterLow = Cluster::where('kategori', 'Rendah')->count();

        // Data untuk chart radar cluster
        $clusterSeries = [
            [
                'name' => 'High Risk',
                'data' => [
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Tinggi')->avg('pencurian'),
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Tinggi')->avg('penipuan'),
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Tinggi')->avg('curanmor'),
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Tinggi')->avg('kdrt'),
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Tinggi')->avg('tipu_online'),
                ]
            ],
            [
                'name' => 'Medium Risk',
                'data' => [
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Sedang')->avg('pencurian'),
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Sedang')->avg('penipuan'),
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Sedang')->avg('curanmor'),
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Sedang')->avg('kdrt'),
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Sedang')->avg('tipu_online'),
                ]
            ],
            [
                'name' => 'Low Risk',
                'data' => [
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Rendah')->avg('pencurian'),
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Rendah')->avg('penipuan'),
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Rendah')->avg('curanmor'),
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Rendah')->avg('kdrt'),
                    Datakriminal::join('clusters', 'clusters.id', '=', 'datakriminal.cluster_id')
                        ->where('clusters.kategori', 'Rendah')->avg('tipu_online'),
                ]
            ]
        ];

        // Data tabel datakriminal per kecamatan
        $data = Datakriminal::with(['kecamatan', 'cluster'])->get();

        // Data untuk peta
        $mapData = [];
        $kecamatanData = [];
        foreach ($data as $item) {
            $mapData[$item->kecamatan->nama] = $item->total_kasus;
            $kecamatanData[$item->kecamatan->nama] = [
                'total' => $item->total_kasus,
                'pencurian' => $item->pencurian,
                'kdrt' => $item->kdrt,
                'cluster' => $item->cluster ? $item->cluster->kategori : 'Belum Dianalisis'
            ];
        }

        return view('pages.dashboard.index', compact(
            'totalKasus',
            'pencurian',
            'kdrt',
            'totalKecamatan',
            'trendData',
            'clusterHigh',
            'clusterMedium',
            'clusterLow',
            'clusterSeries',
            'data',
            'mapData',
            'kecamatanData'
        ));
    }
}
