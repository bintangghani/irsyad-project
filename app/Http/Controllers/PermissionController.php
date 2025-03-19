<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::all();
        return view('pages.admin.permission.index', compact('permission'));
    }

    public function create()
    {
        return view('pages.admin.permission.create');
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

            return redirect()->route('dashboard.permission.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
    public function update(Request $request)
    {
        try {
            $permission = Permission::find($request->id_permission);

            if (!$permission) {
                return response()->json('Permission tidak ditemukan');
            }

            $permission->update([
                'nama' => $request->nama
            ]);
            return redirect()->route('dashboard.permission.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
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

}
