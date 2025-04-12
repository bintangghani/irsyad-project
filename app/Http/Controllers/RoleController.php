<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Repositories\PermissionRepository\PermissionRepositoryInterface;
use App\Repositories\RoleRepository\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function __construct(
        protected RoleRepositoryInterface $roleRepository,
        protected PermissionRepositoryInterface $permissionRepository
    ) {
    }

    public function index(Request $request)
    {


        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $roles = $this->roleRepository->getRolesWithPermissions($search, $perPage);

        return view('pages.admin.role.index', compact('roles'));
    }

    public function create()
    {
        if (!haveAccessTo('create_role')) {
            return redirect()->back();
        }

        $permissions = $this->permissionRepository->all();
        return view('pages.admin.role.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        if (!haveAccessTo('create_role')) {
            return redirect()->back();
        }

        try {
            DB::beginTransaction();

            $role = $this->roleRepository->create([
                'nama' => $request->nama
            ]);

            if ($request->has('permission')) {
                $this->roleRepository->syncPermissions($role, $request->permission);
            }

            DB::commit();

            Alert::success('Success', 'Role berhasil ditambah');
            return redirect()->route('dashboard.user.role.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Error', 'Nampaknya terjadi kesalahan');
            return redirect()->route('dashboard.user.role.index');
        }
    }

    public function edit($id)
    {
        if (!haveAccessTo('update_role')) {
            return redirect()->back();
        }

        $role = $this->roleRepository->getRoleWithPermissions($id);
        $permissions = $this->permissionRepository->all();
        $rolePermissions = $role->permissions->pluck('id_permission')->toArray();

        return view('pages.admin.role.edit', compact('role', 'permissions', 'rolePermissions'));
    }


    public function update(RoleRequest $request, $id)
    {
        if (!haveAccessTo('update_role')) {
            return redirect()->back();
        }
        
        try {
            DB::beginTransaction();

            $this->roleRepository->updateRoleWithPermissions($id, $request->only('nama'), $request->permission ?? []);

            DB::commit();

            Alert::success('Success', 'Role berhasil diperbarui');
            return redirect()->route('dashboard.user.role.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Error', 'Nampaknya terjadi kesalahan');
            return redirect()->route('dashboard.user.role.index');
        }
    }

    public function destroy($id)
    {
        if (!haveAccessTo('delete_role')) {
            return redirect()->back();
        }

        try {
            DB::beginTransaction();

            $this->roleRepository->delete($id);

            DB::commit();

            Alert::success('Success', 'Role berhasil dihapus');
            return redirect()->route('dashboard.user.role.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Error', 'Nampaknya terjadi kesalahan');
            return redirect()->route('dashboard.user.role.index');
        }
    }


    public function search(Request $request)
    {
        if (!haveAccessTo('view_role')) {
            return redirect()->back();
        }

        $role = $this->roleRepository->search($request->search);

        return view('pages.admin.role.index', compact('role'));
    }
}
