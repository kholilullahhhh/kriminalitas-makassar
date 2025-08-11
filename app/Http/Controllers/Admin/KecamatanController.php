<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    //
    public function index()
    {
        $data = Kecamatan::orderBy('nama', 'ASC')->get();
        return view('pages.kecamatan.index', ['menu' => 'kecamatan'], compact('data'));
    }
}
