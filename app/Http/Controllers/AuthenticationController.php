<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

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

            $remember_me = $request->has('remember-me');

            if (Auth::attempt($validated, $remember_me)) {
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
                'id_role' => Role::where('nama', 'superadmin')->first()->id_role,
            ]);

            return redirect()->to('auth/login');
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage());
        }
    }

    public function forgotPassword()
    {
        return view('pages.auth.forgotPassword');
    }

    public function forgotPasswordAction(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|min:3|max:20',
                'email' => 'required|email|exists:users,email',
            ]);
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                Alert::error('Gagal', 'Email tidak ditemukan.');
                return back()->withInput();
            }
            if ($user->nama !== $request->nama) {
                Alert::warning('Peringatan', 'Nama tidak sesuai dengan email.');
                return back()->withInput();
            }

            $token = Str::random(64);
            session([
                'reset_email' => $user->email,
                'reset_nama' => $user->nama,
                'reset_token' => $token,
            ]);

            Alert::success('Berhasil', 'Silakan lanjut untuk reset password.');
            return redirect()->route('auth.resetPassword.form', ['token' => $token]);
        } catch (\Throwable $th) {
            Alert::error('Kesalahan', 'Terjadi kesalahan: ' . $th->getMessage());
            return back()->withInput();
        }
    }



    public function showResetPasswordForm($token)
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('auth.forgotPassword')->withErrors(['email' => 'Session tidak ditemukan. Silakan ulangi.']);
        }

        return view('pages.auth.resetPassword', ['token' => $token]);
    }



    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|min:6|confirmed',
                'token' => 'required',
            ], [
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',
                'password.required' => 'Password baru wajib diisi.',
            ]);

            if (!session()->has('reset_email')) {
                Alert::error('Session Habis', 'Silakan ulangi proses forgot password.');
                return redirect()->route('auth.forgotPassword');
            }

            $user = User::where('email', session('reset_email'))
                ->where('nama', session('reset_nama'))
                ->first();

            if (!$user) {
                Alert::error('User Tidak Ditemukan', 'Email atau Nama tidak valid.');
                return back();
            }

            $user->forceFill([
                'password' => Hash::make($request->password),
            ])->save();

            session()->forget(['reset_email', 'reset_nama', 'reset_token']);

            Alert::success('Berhasil', 'Password berhasil diperbarui.');
            return redirect()->route('auth.login');
        } catch (\Throwable $th) {
            Alert::error('Terjadi Kesalahan', $th->getMessage());
            return back();
        }
    }




    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/login');
    }
}
