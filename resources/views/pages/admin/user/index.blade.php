@extends('layouts/dashboard')

@section('title', 'User')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">User</li>
        </ol>
    </nav>
    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="card-title mb-0 fs-3">List User</h5>
                    <a href="{{ route('dashboard.user.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-2"></i>
                        <span class="d-none d-sm-inline-block">Tambah User Baru</span>
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-3 d-flex justify-content-between">
                        <div class="col-md-2">
                            <label class="form-label">Show</label>
                            <form action="{{ route('dashboard.user.index') }}" method="GET" id="paginationForm">
                                <select class="form-select" name="per_page"
                                    onchange="document.getElementById('paginationForm').submit();">
                                    <option value="{{ $users->count() }}"
                                        {{ request('per_page') == $users->count() ? 'selected' : '' }}>
                                        {{ $users->count() < 10 ? $users->count() : 'Semua' }}</option>
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="75" {{ request('per_page') == 75 ? 'selected' : '' }}>75</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </form>
                        </div>

                        <form action="{{ route('dashboard.user.index') }}" method="GET"
                            class="col-md-6 text-md-end mt-3 mt-md-0">
                            <label class="form-label">Search</label>
                            <div class="input-group">
                                <input type="search" name="search" class="form-control" placeholder="Cari User..."
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            @if ($users->count() > 0)
                                <thead class="table-light">
                                    <tr class="bg-primary">
                                        <th scope="col" class="text-center bg-primary text-white w-10">#</th>
                                        <th scope="col" class="text-center bg-primary text-white max-w-[100px] w-30">Profile</th>
                                        <th scope="col" class="text-center bg-primary text-white max-w-[100px] w-30">Nama</th>
                                        <th scope="col" class="text-center bg-primary text-white max-w-[100px] w-30">Email</th>
                                        <th scope="col" class="text-center bg-primary text-white max-w-[100px] w-30">Moto</th>
                                        <th scope="col" class="text-center bg-primary text-white max-w-[100px] w-30">Role</th>
                                        <th scope="col" class="text-center bg-primary text-white max-w-[100px] w-30">Instansi</th>
                                        <th scope="col" class="text-center bg-primary text-white max-w-[100px] w-30">Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $item)
                                        <tr>
                                            <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                            <td class="text-center">
                                                @if ($item->profile)
                                                    <img src="{{ asset('storage/' . $item->profile) }}" alt="Profile"
                                                        class="img-thumbnail" width="50">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td class="text-capitalize">{{ $item->nama }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td class="text-capitalize text-truncate">{{ $item->moto ?? '-' }}</td>
                                            <td class="text-capitalize text-truncate">{{ $item->role->nama ?? 'Tidak ada' }}</td>
                                            <td class="text-capitalize text-truncate">{{ $item->instansi->nama ?? 'Belum Terdaftar'}}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex flex-column gap-1 align-items-center">
                                                    <a href="{{ route('dashboard.user.edit', $item->id_user) }}" class="btn btn-warning btn-sm w-100">Edit</a>
                                                    <form action="{{ route('dashboard.user.destroy', $item->id_user) }}" method="POST" data-confirm-delete="true" class="w-100">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("form[data-confirm-delete]").forEach(function(form) {
                form.addEventListener("submit", function(event) {
                    event.preventDefault(); // Mencegah form submit langsung

                    Swal.fire({
                        title: "Yakin ingin menghapus?",
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit form jika user menekan "Ya, hapus!"
                        }
                    });
                });
            });
        });
    </script>
@endpush
