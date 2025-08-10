<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use App\Models\Datakriminal;

class kriminalitasController extends Controller
{
    //
    public function index()
    {
        $data = Datakriminal::get();
        return view('pages.kriminalitas.index', ['menu' => 'kriminalitas'], compact('data'));
    }
    public function store(Request $request)
    {
        $req = $request->all();
        Datakriminal::create($req);
        return redirect()->route('kriminalitas.index')->with('message', 'store');
    }

    /**
     * Display the specified resource.
     */
    public function viewBaru()
    {
        $kecamatans = Kecamatan::get();
        return view('pages.kriminalitas.create', ['menu' => 'kriminalitas' ], compact('kecamatans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kecamatans = Kecamatan::get();
        $data = Datakriminal::find($id);
        return view('pages.kriminalitas.edit', ['menu' => 'kriminalitas'], compact('data', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $req = $request->all();
        $data = Datakriminal::find($req['id']);
        $data->update($req);
        return redirect()->route('kriminalitas.index')->with('message', 'update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function hapus(string $id)
    {
        $data = Datakriminal::find($id);
        $data->delete();
        return response()->json($data);
    }
}
