<?php

namespace App\Http\Controllers;

use App\Models\FelhasznaloKonyv;
use App\Models\Konyv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class KonyvController extends Controller
{
    public function index()
    {
        return Konyv::all();
    }

    public function store(Request $request)
{
    $request->validate([
        'cim' => 'required|string|max:255',
        'szerzo' => 'required|string|max:255',
        'kiado' => 'nullable|string|max:255',
        'kiadas_ev' => 'nullable|integer|min:1900|max:' . date('Y'),
        'kategoria' => 'nullable|string|max:100',
        'allapot' => 'required|in:új,jó,közepes,elhasznált',
        'leiras' => 'nullable|string',
        'kep' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'megjegyzes' => 'nullable|string|max:500',
        'statusz' => 'required|in:elerheto,foglalt,elkelt',
    ]);

    try {
        // 🔥 KÉP FELTÖLTÉS
        $kepUtvonal = null;
        if ($request->hasFile('kep')) {
            $file = $request->file('kep');
            $kepNev = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Kép mentése a public/kepek könyvtárba
            $file->move(public_path('kepek'), $kepNev);
            $kepUtvonal = 'kepek/' . $kepNev;
            
            Log::info('Kép feltöltve:', ['utvonal' => $kepUtvonal]);
        }

        // 🔥 KÖNYV LÉTREHOZÁSA
        $konyv = Konyv::create([
            'cim' => $request->cim,
            'szerzo' => $request->szerzo,
            'kiado' => $request->kiado,
            'kiadas_ev' => $request->kiadas_ev,
            'kategoria' => $request->kategoria,
            'allapot' => $request->allapot,
            'leiras' => $request->leiras,
            'kep' => $kepUtvonal,
        ]);

        // 🔥 FELHASZNÁLÓ_KÖNYV KAPCSOLAT LÉTREHOZÁSA - JAVÍTOTT
        $felhasznaloKonyv = FelhasznaloKonyv::create([
            'felhasznalo_id' => Auth::id(), // 🔥 EZ MOST MŰKÖDNI FOG
            'konyv_id' => $konyv->konyv_id,
            'statusz' => $request->statusz,
            'megjegyzes' => $request->megjegyzes,
        ]);

        Log::info('Könyv sikeresen létrehozva:', [
            'konyv_id' => $konyv->konyv_id,
            'felhasznalo_id' => Auth::id(),
            'felhasznalo_konyv_id' => $felhasznaloKonyv->felhasznalo_konyv_id
        ]);

        return response()->json([
            'message' => 'Könyv sikeresen hozzáadva!',
            'konyv' => $konyv,
            'felhasznalo_konyv' => $felhasznaloKonyv
        ], 201);

    } catch (\Exception $e) {
        Log::error('Hiba a könyv létrehozásakor:', [
            'error' => $e->getMessage(),
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'message' => 'Hiba történt a könyv hozzáadásakor',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function show($id)
    {
        $konyv = Konyv::find($id);
        return $konyv;
    }

    public function update(Request $request, $id)
    {
        $konyv = Konyv::find($id);
        $konyv->fill($request->all());
        $konyv->save();
        
        return response()->json($konyv);
    }

    public function destroy($id)
    {
        Konyv::find($id)->delete();
        return response()->json(['message' => 'Könyv törölve'], 204);
    }
}