<?php

namespace App\Http\Controllers;

use App\Models\Jelentes;
use Illuminate\Http\Request;

class JelentesController extends Controller
{
    public function index()
    {
        return Jelentes::with(['bejelento', 'celFelhasznalo', 'celKonyv', 'admin'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'bejelento_id' => 'required|exists:users,id',
            'tipus' => 'required',
            'leiras' => 'required'
        ]);

        $jelentes = new Jelentes();
        $jelentes->bejelento_id = $request->bejelento_id;
        $jelentes->cel_felhasznalo_id = $request->cel_felhasznalo_id;
        $jelentes->cel_konyv_id = $request->cel_konyv_id;
        $jelentes->tipus = $request->tipus;
        $jelentes->leiras = $request->leiras;
        $jelentes->statusz = $request->statusz ?? 'fuggo';
        $jelentes->save();

        return response()->json($jelentes->load(['bejelento', 'celFelhasznalo', 'celKonyv']), 201);
    }

    public function show($id)
    {
        return Jelentes::with(['bejelento', 'celFelhasznalo', 'celKonyv', 'admin'])->find($id);
    }

    public function update(Request $request, $id)
    {
        $jelentes = Jelentes::find($id);
        $jelentes->fill($request->all());
        $jelentes->save();
        
        return response()->json($jelentes->load(['bejelento', 'celFelhasznalo', 'celKonyv', 'admin']));
    }

    public function destroy($id)
    {
        Jelentes::find($id)->delete();
        return response()->json(['message' => 'Jelentés törölve'], 204);
    }
}