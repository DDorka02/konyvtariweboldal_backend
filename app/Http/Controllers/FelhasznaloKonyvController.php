<?php

namespace App\Http\Controllers;

use App\Models\FelhasznaloKonyv;
use App\Models\Konyv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FelhasznaloKonyvController extends Controller
{
     public function index()
    {
        // 🔥 CSAK A BEJELENTKEZETT FELHASZNÁLÓ KÖNYVEIT ADJA VISSZA
        $felhasznaloKonyvek = FelhasznaloKonyv::with('konyv')
            ->where('felhasznalo_id', Auth::id())
            ->get();

        return response()->json($felhasznaloKonyvek);
    }

    public function store(Request $request)
    {
        $request->validate([
            'konyv_id' => 'required|exists:konyvs,konyv_id',
            'statusz' => 'required|in:elerheto,foglalt,elkelt',
            'megjegyzes' => 'nullable|string|max:500',
        ]);

        // 🔥 Automatikusan a bejelentkezett user ID-ját használjuk
        $felhasznaloKonyv = FelhasznaloKonyv::create([
            'felhasznalo_id' => Auth::id(),
            'konyv_id' => $request->konyv_id,
            'statusz' => $request->statusz,
            'megjegyzes' => $request->megjegyzes,
        ]);

        return response()->json($felhasznaloKonyv, 201);
    }

    public function show($id)
    {
        // 🔥 Csak a saját könyvét kérheti le
        $felhasznaloKonyv = FelhasznaloKonyv::with('konyv')
            ->where('id', $id)
            ->where('felhasznalo_id', Auth::id())
            ->firstOrFail();

        return response()->json($felhasznaloKonyv);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'statusz' => 'required|in:elerheto,foglalt,elkelt',
            'megjegyzes' => 'nullable|string|max:500',
        ]);

        // 🔥 Csak a saját könyvét módosíthatja
        $felhasznaloKonyv = FelhasznaloKonyv::where('id', $id)
            ->where('felhasznalo_id', Auth::id())
            ->firstOrFail();

        $felhasznaloKonyv->update($request->only(['statusz', 'megjegyzes']));

        return response()->json($felhasznaloKonyv);
    }

    public function destroy($id)
    {
        // 🔥 Csak a saját könyvét törölheti
        $felhasznaloKonyv = FelhasznaloKonyv::where('id', $id)
            ->where('felhasznalo_id', Auth::id())
            ->firstOrFail();

        $felhasznaloKonyv->delete();

        return response()->json(['message' => 'Könyv sikeresen eltávolítva a gyűjteményből.']);
    }
}