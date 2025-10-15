<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->telefon = $request->telefon;
        $user->varos = $request->varos;
        $user->cim = $request->cim;
        $user->szerep = $request->szerep ?? 'felhasznalo';
        $user->save();

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->fill($request->except('password'));
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        return response()->json($user);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['message' => 'Felhasználó törölve'], 204);
    }
}