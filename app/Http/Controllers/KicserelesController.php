<?php

namespace App\Http\Controllers;

use App\Models\Kicsereles;
use Illuminate\Http\Request;

class KicserelesController extends Controller
{
    public function index()
    {
        return Kicsereles::with(['felado', 'fogado', 'feladoKonyv', 'fogadoKonyv'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'felado_id' => 'required|exists:users,id',
            'fogado_id' => 'required|exists:users,id',
            'felado_konyv_id' => 'required|exists:felhasznalo_konyveks,felhasznalo_konyv_id'
        ]);

        $csere = new Kicsereles();
        $csere->felado_id = $request->felado_id;
        $csere->fogado_id = $request->fogado_id;
        $csere->felado_konyv_id = $request->felado_konyv_id;
        $csere->fogado_konyv_id = $request->fogado_konyv_id;
        $csere->statusz = $request->statusz ?? 'fuggo';
        $csere->save();

        return response()->json($csere->load(['felado', 'fogado', 'feladoKonyv', 'fogadoKonyv']), 201);
    }

    public function show($id)
    {
        return Kicsereles::with(['felado', 'fogado', 'feladoKonyv', 'fogadoKonyv'])->find($id);
    }

    public function update(Request $request, $id)
    {
        $csere = Kicsereles::find($id);
        $csere->fill($request->all());
        $csere->save();
        
        return response()->json($csere->load(['felado', 'fogado', 'feladoKonyv', 'fogadoKonyv']));
    }

    public function destroy($id)
    {
        Kicsereles::find($id)->delete();
        return response()->json(['message' => 'Csere törölve'], 204);
    }
}