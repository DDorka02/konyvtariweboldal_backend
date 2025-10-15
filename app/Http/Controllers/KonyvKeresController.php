<?php

namespace App\Http\Controllers;

use App\Models\KonyvKeres;
use Illuminate\Http\Request;

class KonyvKeresController extends Controller
{
    public function index()
    {
        return KonyvKeres::with(['felhasznalo', 'konyv'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'felhasznalo_id' => 'required|exists:users,id',
            'konyv_id' => 'required|exists:konyveks,konyv_id'
        ]);

        $keres = new KonyvKeres();
        $keres->felhasznalo_id = $request->felhasznalo_id;
        $keres->konyv_id = $request->konyv_id;
        $keres->statusz = $request->statusz ?? 'aktiv';
        $keres->save();

        return response()->json($keres->load(['felhasznalo', 'konyv']), 201);
    }

    public function show($id)
    {
        return KonyvKeres::with(['felhasznalo', 'konyv'])->find($id);
    }

    public function update(Request $request, $id)
    {
        $keres = KonyvKeres::find($id);
        $keres->fill($request->all());
        $keres->save();
        
        return response()->json($keres->load(['felhasznalo', 'konyv']));
    }

    public function destroy($id)
    {
        KonyvKeres::find($id)->delete();
        return response()->json(['message' => 'Könyvkeresés törölve'], 204);
    }
}