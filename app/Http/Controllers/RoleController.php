<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();
        return view('pages.admin.role.index', compact('role'));
    }

    public function create()
    {
        return view('pages.admin.role.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255'
            ]);

            Role::create([
                'nama' => $request->nama
            ]);

            return redirect()->route('dashboard.role.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $role = Role::find($request->id_role);
            
            if (!$role) {
                return response()->json('Role tidak ditemukan');
            }

            $role->update([
                'nama' => $request->nama
            ]);

            return redirect()->route('dashboard.role.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $role = Role::find($request->id_role);
            
            if (!$role) {
                return response()->json('Role tidak ditemukan');
            }

            $role->delete();

            return redirect()->route('dashboard.role.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
