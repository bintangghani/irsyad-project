<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\Instansi;
use App\Models\Role;
use App\Models\User;
use App\Repositories\InstansiRepository\InstansiRepositoryInterface;
use App\Repositories\RoleRepository\RoleRepositoryInterface;
use App\Repositories\UserRepository\UserRepositoryInterface;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected RoleRepositoryInterface $roleRepository,
        protected InstansiRepositoryInterface $instansiRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!haveAccessTo('view_user')) {
            return redirect()->back();
        }

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $users = $this->userRepository->getUsersWithRole($search, $perPage);

        return view('pages.admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!haveAccessTo('create_user')) {
            return redirect()->back();
        }

        $role = $this->roleRepository->all();
        $instansi = $this->instansiRepository->all();
        return view('pages.admin.user.create', compact('role', 'instansi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            if (!haveAccessTo('create_user')) {
                return redirect()->back();
            }

            DB::beginTransaction();
            if ($request->file('profile')) {
                $profilePath = $request->file('profile')->store('profiles', 'public');
            } else {
                $profilePath = 'assets/img/avatars/1.png';
            }

            $this->userRepository->store($request->all(), $profilePath);
            DB::commit();

            Alert::success('Success', 'User berhasil ditambah');

            return redirect()->route('dashboard.user.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Error', 'Nampaknya terjadi kesalahan');
            return redirect()->back();
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
        if (!haveAccessTo('update_user')) {
            return redirect()->back();
        }

        $user = $this->userRepository->findByIdWithRoleAndInstansi($id);
        $role = $this->roleRepository->all();
        $instansi = $this->instansiRepository->all();
        return view('pages.admin.user.edit', compact('user', 'role', 'instansi'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            if (!haveAccessTo('update_user')) {
                return redirect()->back();
            }

            DB::beginTransaction();

            $user = $this->userRepository->findByIdWithRoleAndInstansi($id);

            if ($request->hasFile('profile')) {
                if ($user->profile != 'assets/img/avatars/1.png') {
                    Storage::disk('public')->delete($user->profile);
                }
                $profilePath = $request->file('profile')->store('profiles', 'public');
            } else {
                $profilePath = $user->profile;
            }

            $this->userRepository->updateAll($request->all(), $profilePath, $user);

            DB::commit();

            Alert::success('Success', 'User berhasil diperbarui');

            return redirect()->route('dashboard.user.index')->with('success', 'User berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Nampaknya terjadi kesalahan');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            //code...
            if (!haveAccessTo('delete_user')) {
                return redirect()->back();
            }
            DB::beginTransaction();
    
            $this->userRepository->delete($id);
    
            DB::commit();
    
            Alert::success('Success', 'User berhasil dihapus');
            return redirect()->route('dashboard.user.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Alert::error('Error', 'Nampaknya terjadi kesalahan');
            return redirect()->back();
        }
    }

    public function search(Request $request)
    {
        if (!haveAccessTo('view_user')) {
            return redirect()->back();
        }

        $user = $this->userRepository->search($request->search);

        return view('pages.admin.user.index', compact('user'));
    }

    public function profile($id)
    {
        if (!haveAccessTo('update_profile')) {
            return redirect()->back();
        }

        $user = $this->userRepository->findByIdWithRoleAndInstansi($id);
        return view('pages.admin.profile.index', compact('user'));
    }
}
