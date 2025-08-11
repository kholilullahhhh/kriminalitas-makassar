<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kecamatan;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Mariso'],
            ['nama' => 'Mamajang'],
            ['nama' => 'Tamalate'],
            ['nama' => 'Rappocini'],
            ['nama' => 'Makassar'],
            ['nama' => 'Ujung Pandang'],
            ['nama' => 'Wajo'],
            ['nama' => 'Bontoala'],
            ['nama' => 'Ujung Tanah'],
            ['nama' => 'Kepulauan Sangkarrang'],
            ['nama' => 'Tallo'],
            ['nama' => 'Panakkukang'],
            ['nama' => 'Manggala'],
            ['nama' => 'Biring Kanaya'],
            ['nama' => 'Tamalarea'],
        ];

        Kecamatan::insert($data);
    }
}
