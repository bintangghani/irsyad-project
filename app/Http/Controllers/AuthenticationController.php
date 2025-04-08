<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use App\Repositories\RoleRepository\RoleRepositoryInterface;
use App\Repositories\UserRepository\UserRepositoryInterface;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AuthenticationController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected RoleRepositoryInterface $roleRepository
    ) {
    }

    public function login()
    {
        return view('pages.auth.login');
    }

    public function loginAction(LoginRequest $request)
    {
        try {
            $remember_me = $request->has('remember-me');

            if (Auth::attempt($request->only('email', 'password'), $remember_me)) {
                if (Auth::user()->role->nama === 'superadmin') {
                    Alert::success('Success', 'Login Berhasil');
                    return redirect()->to('dashboard');
                } else {
                    Alert::success('Success', 'Login Berhasil');
                    return redirect()->to('/');
                }
            } else {
                Alert::error('Error', 'Kata sandi salah');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Error', 'Nampaknya terjadi kesalahan');
            return response()->json($th->getMessage());
        }
    }

    public function register()
    {
        $id_role = $this->roleRepository->findByName('client')->id_role;
        return view('pages.auth.register', compact('id_role'));
    }

    public function registerAction(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->userRepository->create($request->only('nama', 'email', 'profile', 'password', 'id_role'));
            
            DB::commit();
            Alert::success('Success', 'Registrasi Berhasil');
            return redirect()->to('auth/login');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Alert::error('Error', 'Nampaknya terjadi kesalahan');
            return response()->json($th->getMessage());
        }
    }

    public function forgotPassword()
    {
        return view('pages.auth.forgotPassword');
    }

    public function forgotPasswordAction(ForgotPasswordRequest $request)
    {
        try {
            $user = $this->userRepository->findOneByEmail($request->email);

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
            if (!session()->has('reset_email')) {
                Alert::error('Session Habis', 'Silakan ulangi proses forgot password.');
                return redirect()->route('auth.forgotPassword');
            }

            $user = $this->userRepository->findOneByEmailAndName(session('reset_email'), session('reset_nama'));

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

    public function logoutAction(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::logout();

        return redirect('/auth/login');
    }
}
