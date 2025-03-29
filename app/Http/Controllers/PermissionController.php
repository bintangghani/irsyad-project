<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $permission = Permission::with('role');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $permission->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->input('per_page', 10);

        if ($permission->count() < 10) {
            $permission = $permission->orderBy('created_at', 'ASC')->paginate($permission->count());
        } else {
            $permission = $permission->orderBy('created_at', 'ASC')->paginate($perPage);
        }

        return view('pages.admin.permission.index', compact('permission'));
    }

    public function create()
    {
        $role = Role::all();
        return view('pages.admin.permission.create', compact('role'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:permission,nama'
            ]);

            Permission::create([
                'nama' => $request->nama
            ]);

            Alert::success('Success', 'Permission berhasil ditambah');

            return redirect()->route('dashboard.permission.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $role = Role::all();

        // dd([$permission, $role]);

        return view('pages.admin.permission.edit', compact('permission', 'role'));
    }

    public function update(Request $request, $id)
    {
        try {
            $permission = Permission::findOrFail($id);

            $request->validate([
                'nama' => 'required|string|max:255',
                // 'role' => 'required|exists:role,id_role',
            ]);

            $updated = $permission->update([
                'nama' => $request->nama,
                // 'id_role' => $request->role,
            ]);

            if (!$updated) {
                return back()->with('error', 'Gagal memperbarui permission.');
            }

            Alert::success('Success', 'Permission berhasil diperbarui');

            return redirect()->route('dashboard.permission.index')->with('success', 'Permission berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Update Permission Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $permission = Permission::find($request->id_permission);

            if (!$permission) {
                return response()->json('Permission tidak ditemukan');
            }

            $permission->delete();

            return redirect()->route('dashboard.permission.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $permission = Permission::where('nama', 'like', "%$keyword%")->get();

        return view('pages.admin.permission.index', compact('permission'));
    }
}
