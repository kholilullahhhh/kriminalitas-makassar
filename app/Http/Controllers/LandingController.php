<?php

namespace App\Http\Controllers;
use App\Models\tb_kodepos;
use App\Models\tb_warga;
use App\Models\tb_obser_disabilitas;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $totalKecamatan = DB::table("tb_kodepos")
            ->select(DB::raw("COUNT(DISTINCT kecamatan) as total"))
            ->first()->total;

        $totalPenyandang = DB::table("tb_obser_disabilitas")
            ->select(DB::raw("COUNT(DISTINCT id_warga) as total"))
            ->first()->total;

        $penyandangTerbanyak = DB::table("tb_obser_disabilitas as a")
            ->join("tb_disabilitas as b", "b.id", "=", "a.id_disabilitas")
            ->select("b.kriteria", DB::raw("COUNT(a.id) as jumlah"))
            ->groupBy("b.kriteria")
            ->orderByDesc("jumlah")
            ->first();

        //data kecamatan dengan jumlah penyandang disabilitas terbanyak
        $kecamatanData = DB::table('tb_kodepos')
            ->select('tb_kodepos.*')
            ->selectRaw('COUNT(tb_obser_disabilitas.id) as disabilitas_count')
            ->leftJoin('tb_wargas', 'tb_kodepos.id', '=', 'tb_wargas.id_pos')
            ->leftJoin('tb_obser_disabilitas', 'tb_wargas.id', '=', 'tb_obser_disabilitas.id_warga')
            ->groupBy('tb_kodepos.id')
            ->orderByDesc('disabilitas_count')
            ->limit(18)
            ->get();

        return view('pages.landing.index', compact('kecamatanData', 'totalKecamatan', 'totalPenyandang', 'penyandangTerbanyak'));
    }
}
