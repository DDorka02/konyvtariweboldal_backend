<?php

namespace App\Http\Controllers;

use App\Models\FelhasznaloKonyv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FelhasznaloKonyvController extends Controller
{
    public function index()
    {
        // 🔥 JAVÍTOTT: megfelelő elsődleges kulcsokkal
        $felhasznaloKonyvek = FelhasznaloKonyv::with(['konyv', 'user'])
            ->where('felhasznalo_id', Auth::id())
            ->get();

        return response()->json($felhasznaloKonyvek);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'statusz' => 'required|in:elerheto,foglalt,elkelt',
            'megjegyzes' => 'nullable|string|max:500'
        ]);

        $felhasznaloKonyv = FelhasznaloKonyv::findOrFail($id);
        
        // 🔥 ELLENŐRZÉS: CSAK A SAJÁT KÖNYVÉT SZERKESZTHETI
        if ($felhasznaloKonyv->felhasznalo_id !== Auth::id()) {
            return response()->json(['error' => 'Nincs jogosultságod ehhez a művelethez'], 403);
        }

        $felhasznaloKonyv->update($request->only(['statusz', 'megjegyzes']));

        return response()->json($felhasznaloKonyv);
    }

    public function destroy($id)
    {
        $felhasznaloKonyv = FelhasznaloKonyv::findOrFail($id);
        
        // 🔥 ELLENŐRZÉS: CSAK A SAJÁT KÖNYVÉT TÖRÖLHETI
        if ($felhasznaloKonyv->felhasznalo_id !== Auth::id()) {
            return response()->json(['error' => 'Nincs jogosultságod ehhez a művelethez'], 403);
        }

        $felhasznaloKonyv->delete();

        return response()->json(['message' => 'Könyv sikeresen eltávolítva a gyűjteményből']);
    }
}