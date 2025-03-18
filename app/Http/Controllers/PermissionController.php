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
        return view('pages.permission.index', compact('permission'));
    }

    public function create()
    {
        return view('pages.permission.create');
    }

    public function store(PermissionRequest $request)
    {
        try {
            Permission::create($request->all());
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
                return response()->json('Data tidak ditemukan');
            }

            $permission->delete();

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
                return response()->json('Data tidak ditemukan');
            }

            $permission->update([
                'nama' => $request->nama
            ]);
            return redirect()->route('dashboard.permission.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
