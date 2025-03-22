<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::with('permission');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $role->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->input('per_page', 10);
        
        if ($role->count() < 10) {
            $role = $role->orderBy('created_at', 'ASC')->paginate($role->count());
        } else {
            $role = $role->orderBy('created_at', 'ASC')->paginate($perPage);
        }

        return view('pages.admin.role.index', compact('role'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('created_at', 'ASC')->get();
        return view('pages.admin.role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'permission' => 'nullable|array'
            ]);

            $role = Role::create([
                'nama' => $request->nama
            ]);

            if ($request->permission) {
                foreach ($request->permission as $item) {
                    RolePermission::create([
                        'id_role' => $role->id_role,
                        'id_permission' => $item
                    ]);
                }
            }

            return redirect()->route('dashboard.user.role.index');
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

    public function search(Request $request)
    {
        $keyword = $request->search;
        $role = Role::where('nama', 'like', "%$keyword%")->get();

        return view('pages.admin.role.index', compact('role'));
    }
}
