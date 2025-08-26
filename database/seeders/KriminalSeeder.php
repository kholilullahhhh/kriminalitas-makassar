<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataKriminal;
use App\Models\Kecamatan;

class KriminalSeeder extends Seeder
{
    public function run(): void
    {
        // Data jumlah penduduk per kecamatan untuk tahun 2021, 2022, dan 2023
        $penduduk = [
            2021 => [
                'Mariso' => 57594,
                'Mamajang' => 56056,
                'Tamalate' => 181533,
                'Rappocini' => 144619,
                'Makassar' => 82142,
                'Ujung Pandang' => 24526,
                'Bontoala' => 55102,
                'Tallo' => 145400,
                'Panakkukang' => 139635,
                'Manggala' => 147549,
                'Biringkanaya' => 210076,
                'Tamalanrea' => 103220,
            ],
            2022 => [
                'Mariso' => 57795,
                'Mamajang' => 56094,
                'Tamalate' => 182348,
                'Rappocini' => 144733,
                'Makassar' => 82265,
                'Ujung Pandang' => 24541,
                'Bontoala' => 55239,
                'Tallo' => 145908,
                'Panakkukang' => 139759,
                'Manggala' => 148462,
                'Biringkanaya' => 211228,
                'Tamalanrea' => 103322,
            ],
            2023 => [
                'Mariso' => 58730,
                'Mamajang' => 58293,
                'Tamalate' => 188432,
                'Rappocini' => 150613,
                'Makassar' => 82237,
                'Ujung Pandang' => 24851,
                'Bontoala' => 55201,
                'Tallo' => 148055,
                'Panakkukang' => 144204,
                'Manggala' => 160466,
                'Biringkanaya' => 215820,
                'Tamalanrea' => 106262,
            ],
        ];

        $data = [
            // 2023
            ['nama_kecamatan' => 'Ujung Pandang', 'pencurian' => 43, 'curanmor' => 16, 'penipuan' => 11, 'kdrt' => 0, 'tipu_online' => 0, 'tahun' => 2023],
            ['nama_kecamatan' => 'Mariso', 'pencurian' => 47, 'curanmor' => 16, 'penipuan' => 0, 'kdrt' => 1, 'tipu_online' => 0, 'tahun' => 2023],
            ['nama_kecamatan' => 'Makassar', 'pencurian' => 106, 'curanmor' => 9, 'penipuan' => 8, 'kdrt' => 8, 'tipu_online' => 0, 'tahun' => 2023],
            ['nama_kecamatan' => 'Mamajang', 'pencurian' => 91, 'curanmor' => 14, 'penipuan' => 17, 'kdrt' => 6, 'tipu_online' => 0, 'tahun' => 2023],
            ['nama_kecamatan' => 'Bontoala', 'pencurian' => 120, 'curanmor' => 2, 'penipuan' => 18, 'kdrt' => 3, 'tipu_online' => 0, 'tahun' => 2023],
            ['nama_kecamatan' => 'Tallo', 'pencurian' => 100, 'curanmor' => 14, 'penipuan' => 27, 'kdrt' => 16, 'tipu_online' => 0, 'tahun' => 2023],
            ['nama_kecamatan' => 'Panakkukang', 'pencurian' => 179, 'curanmor' => 36, 'penipuan' => 27, 'kdrt' => 5, 'tipu_online' => 5, 'tahun' => 2023],
            ['nama_kecamatan' => 'Biringkanaya', 'pencurian' => 85, 'curanmor' => 30, 'penipuan' => 31, 'kdrt' => 29, 'tipu_online' => 0, 'tahun' => 2023],
            ['nama_kecamatan' => 'Rappocini', 'pencurian' => 287, 'curanmor' => 70, 'penipuan' => 52, 'kdrt' => 13, 'tipu_online' => 11, 'tahun' => 2023],
            ['nama_kecamatan' => 'Manggala', 'pencurian' => 84, 'curanmor' => 44, 'penipuan' => 18, 'kdrt' => 14, 'tipu_online' => 15, 'tahun' => 2023],
            ['nama_kecamatan' => 'Tamalate', 'pencurian' => 116, 'curanmor' => 52, 'penipuan' => 32, 'kdrt' => 15, 'tipu_online' => 0, 'tahun' => 2023],
            ['nama_kecamatan' => 'Tamalanrea', 'pencurian' => 73, 'curanmor' => 139, 'penipuan' => 18, 'kdrt' => 13, 'tipu_online' => 0, 'tahun' => 2023],

            // 2022
            ['nama_kecamatan' => 'Ujung Pandang', 'pencurian' => 21, 'curanmor' => 0, 'penipuan' => 3, 'kdrt' => 0, 'tipu_online' => 0, 'tahun' => 2022],
            ['nama_kecamatan' => 'Mariso', 'pencurian' => 35, 'curanmor' => 2, 'penipuan' => 16, 'kdrt' => 1, 'tipu_online' => 0, 'tahun' => 2022],
            ['nama_kecamatan' => 'Makassar', 'pencurian' => 29, 'curanmor' => 9, 'penipuan' => 2, 'kdrt' => 7, 'tipu_online' => 0, 'tahun' => 2022],
            ['nama_kecamatan' => 'Mamajang', 'pencurian' => 34, 'curanmor' => 2, 'penipuan' => 3, 'kdrt' => 1, 'tipu_online' => 0, 'tahun' => 2022],
            ['nama_kecamatan' => 'Bontoala', 'pencurian' => 16, 'curanmor' => 0, 'penipuan' => 5, 'kdrt' => 5, 'tipu_online' => 0, 'tahun' => 2022],
            ['nama_kecamatan' => 'Tallo', 'pencurian' => 58, 'curanmor' => 13, 'penipuan' => 17, 'kdrt' => 11, 'tipu_online' => 0, 'tahun' => 2022],
            ['nama_kecamatan' => 'Panakkukang', 'pencurian' => 345, 'curanmor' => 34, 'penipuan' => 26, 'kdrt' => 10, 'tipu_online' => 1, 'tahun' => 2022],
            ['nama_kecamatan' => 'Biringkanaya', 'pencurian' => 22, 'curanmor' => 5, 'penipuan' => 34, 'kdrt' => 32, 'tipu_online' => 0, 'tahun' => 2022],
            ['nama_kecamatan' => 'Rappocini', 'pencurian' => 34, 'curanmor' => 2, 'penipuan' => 18, 'kdrt' => 7, 'tipu_online' => 3, 'tahun' => 2022],
            ['nama_kecamatan' => 'Manggala', 'pencurian' => 114, 'curanmor' => 13, 'penipuan' => 29, 'kdrt' => 6, 'tipu_online' => 0, 'tahun' => 2022],
            ['nama_kecamatan' => 'Tamalate', 'pencurian' => 24, 'curanmor' => 3, 'penipuan' => 8, 'kdrt' => 13, 'tipu_online' => 0, 'tahun' => 2022],
            ['nama_kecamatan' => 'Tamalanrea', 'pencurian' => 107, 'curanmor' => 14, 'penipuan' => 40, 'kdrt' => 8, 'tipu_online' => 0, 'tahun' => 2022],

            // 2021
            ['nama_kecamatan' => 'Ujung Pandang', 'pencurian' => 7, 'curanmor' => 2, 'penipuan' => 7, 'kdrt' => 0, 'tipu_online' => 0, 'tahun' => 2021],
            ['nama_kecamatan' => 'Mariso', 'pencurian' => 16, 'curanmor' => 1, 'penipuan' => 7, 'kdrt' => 1, 'tipu_online' => 0, 'tahun' => 2021],
            ['nama_kecamatan' => 'Makassar', 'pencurian' => 7, 'curanmor' => 1, 'penipuan' => 1, 'kdrt' => 3, 'tipu_online' => 0, 'tahun' => 2021],
            ['nama_kecamatan' => 'Mamajang', 'pencurian' => 18, 'curanmor' => 2, 'penipuan' => 7, 'kdrt' => 0, 'tipu_online' => 0, 'tahun' => 2021],
            ['nama_kecamatan' => 'Bontoala', 'pencurian' => 18, 'curanmor' => 2, 'penipuan' => 7, 'kdrt' => 3, 'tipu_online' => 0, 'tahun' => 2021],
            ['nama_kecamatan' => 'Tallo', 'pencurian' => 19, 'curanmor' => 5, 'penipuan' => 14, 'kdrt' => 14, 'tipu_online' => 0, 'tahun' => 2021],
            ['nama_kecamatan' => 'Panakkukang', 'pencurian' => 12, 'curanmor' => 1, 'penipuan' => 2, 'kdrt' => 2, 'tipu_online' => 0, 'tahun' => 2021],
            ['nama_kecamatan' => 'Biringkanaya', 'pencurian' => 6, 'curanmor' => 2, 'penipuan' => 11, 'kdrt' => 13, 'tipu_online' => 0, 'tahun' => 2021],
            ['nama_kecamatan' => 'Rappocini', 'pencurian' => 10, 'curanmor' => 5, 'penipuan' => 11, 'kdrt' => 9, 'tipu_online' => 0, 'tahun' => 2021],
            ['nama_kecamatan' => 'Manggala', 'pencurian' => 4, 'curanmor' => 1, 'penipuan' => 6, 'kdrt' => 5, 'tipu_online' => 0, 'tahun' => 2021],
            ['nama_kecamatan' => 'Tamalate', 'pencurian' => 21, 'curanmor' => 0, 'penipuan' => 1, 'kdrt' => 7, 'tipu_online' => 0, 'tahun' => 2021],
            ['nama_kecamatan' => 'Tamalanrea', 'pencurian' => 5, 'curanmor' => 1, 'penipuan' => 2, 'kdrt' => 3, 'tipu_online' => 0, 'tahun' => 2021],
        ];

        foreach ($data as $item) {
            $kecamatan = Kecamatan::where('nama', $item['nama_kecamatan'])->first();
            if ($kecamatan) {
                DataKriminal::create([
                    'kecamatan_id' => $kecamatan->id,
                    'tahun' => $item['tahun'],
                    'tipu_online' => $item['tipu_online'],
                    'pencurian' => $item['pencurian'],
                    'curanmor' => $item['curanmor'],
                    'penipuan' => $item['penipuan'],
                    'kdrt' => $item['kdrt'],
                    'jumlah_penduduk' => $penduduk[$item['tahun']][$item['nama_kecamatan']] ?? 0
                ]);
            }
        }
    }
}
