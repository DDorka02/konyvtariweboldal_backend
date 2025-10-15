<?php

namespace App\Http\Controllers;

use App\Models\FelhasznaloKonyv;
use App\Models\Konyv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        'kep' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'megjegyzes' => 'nullable|string|max:500',
        'statusz' => 'required|in:elerheto,foglalt,elkelt',
    ]);

    // Könyv létrehozása
    $konyv = Konyv::create($request->only([
        'cim', 'szerzo', 'kiado', 'kiadas_ev', 
        'kategoria', 'allapot', 'leiras'
    ]));

    // Kép feltöltése
   if ($request->hasFile('kep')) {
    \Log::info('Kép feltöltés kezdete');
    
    // Biztosítsuk, hogy a könyvtár létezik
    $konyvKepekPath = 'public/kepek';
    if (!Storage::exists($konyvKepekPath)) {
        Storage::makeDirectory($konyvKepekPath);
    }
    
    $kepNev = time() . '_' . $request->file('kep')->getClientOriginalName();
    $path = $request->file('kep')->storeAs($konyvKepekPath, $kepNev);
    
    // 🔥 FONTOS: csak a relatív útvonalat mentsük
    $konyv->kep = 'kepek/' . $kepNev;
    $konyv->save();
    
    \Log::info('Kép elérési út: ' . $konyv->kep);
    \Log::info('Teljes path: ' . storage_path('app/' . $path));
}

    // 🔥 AUTOMATIKUS HÖZZÁRENDELÉS a felhasználóhoz
    FelhasznaloKonyv::create([
        'felhasznalo_id' => Auth::id(),
        'konyv_id' => $konyv->konyv_id,
        'statusz' => $request->statusz,
        'megjegyzes' => $request->megjegyzes,
    ]);

    return response()->json($konyv, 201);
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