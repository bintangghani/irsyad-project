<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::with('role', 'instansi');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $user->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%$search%");
                $q->where('role', 'LIKE', "%$search%");
                $q->where('instansi', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->input('per_page', 10);

        if ($user->count() < 10) {
            $user = $user->orderBy('created_at', 'ASC')->paginate($user->count());
        } else {
            $rouserle = $user->orderBy('created_at', 'ASC')->paginate($perPage);
        }

        return view('pages.admin.user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::all();
        $instansi = Instansi::all();
        return view('pages.admin.user.create', compact('role', 'instansi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:8|max:255',
                'profile' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'moto' => 'required|string|min:3|max:255',
                'role' => 'required|exists:role,id_role',
                'instansi' => 'required|exists:instansi,id_instansi'
            ]);

            $profilePath = $request->file('profile')->store('profiles', 'public');

            User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'profile' => $profilePath,
                'moto' => $request->moto,
                'id_role' => $request->role,
                'id_instansi' => $request->instansi,
            ]);

            Alert::success('Success', 'User berhasil ditambah');

            return redirect()->route('dashboard.user.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role = Role::all();
        $instansi = Instansi::all();
        return view('pages.admin.user.edit', compact('user', 'role', 'instansi'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $id . ',id_user',
                'password' => 'nullable|string|min:8|max:255',
                'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'moto' => 'required|string|min:3|max:255',
                'role' => 'required|exists:role,id_role',
                'instansi' => 'required|exists:instansi,id_instansi'
            ]);

            if ($request->hasFile('profile')) {
                if ($user->profile) {
                    Storage::disk('public')->delete($user->profile);
                }
                $profilePath = $request->file('profile')->store('profiles', 'public');
            } else {
                $profilePath = $user->profile;
            }

            $updated = $user->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'profile' => $profilePath,
                'moto' => $request->moto,
                'id_role' => $request->role,
                'id_instansi' => $request->instansi,
            ]);

            if (!$updated) {
                return back()->with('error', 'Gagal memperbarui user.');
            }

            Alert::success('Success', 'User berhasil diperbarui');

            return redirect()->route('dashboard.user.index')->with('success', 'User berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Update User Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $user = User::find($request->id_user);

            if (!$user) {
                return response()->json('User tidak ditemukan');
            }

            $user->delete();

            return redirect()->route('dashboard.user.index')->with('success', 'User berhasil dihapus');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $user = User::where('nama', 'like', "%$keyword%")->get();

        return view('pages.admin.user.index', compact('user'));
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);
        return view('pages.admin.profile.index', compact('user'));
    }
}
