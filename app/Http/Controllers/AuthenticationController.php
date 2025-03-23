<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function loginAction(Request $request)
    {
        try {
            //code...
            $validated = $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:6',
            ]);

            if (Auth::attempt($validated)) {
                return redirect()->to('dashboard');
            } else {
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage());
        }
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    public function registerAction(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|min:3|max:20',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'profile' => 'assets/img/avatars/1.png',
                'id_role' => Role::where('nama', 'tes')->first()->id_role,
            ]);

            return redirect()->to('auth/login');
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage());
        }
    }
}
