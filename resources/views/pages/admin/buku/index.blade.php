@extends('layouts/dashboard')

@section('title', 'Buku')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Buku</li>
        </ol>
    </nav>
    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="card-title mb-0 fs-3">List buku</h5>
                    <a href="{{ route('dashboard.buku.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-2"></i>
                        <span class="d-none d-sm-inline-block">Tambah Buku</span>
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-3 d-flex justify-content-between">
                        <div class="col-md-2">
                            <label class="form-label">Show</label>
                            <form action="{{ route('dashboard.buku.index') }}" method="GET" id="paginationForm">
                                <select class="form-select" name="per_page"
                                    onchange="document.getElementById('paginationForm').submit();">
                                    <option value="{{ $buku->count() }}"
                                        {{ request('per_page') == $buku->count() ? 'selected' : '' }}>
                                        {{ $buku->count() < 10 ? $buku->count() : 'Semua' }}</option>
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="75" {{ request('per_page') == 75 ? 'selected' : '' }}>75</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </form>
                        </div>

                        <form action="{{ route('dashboard.buku.index') }}" method="GET"
                            class="col-md-6 text-md-end mt-3 mt-md-0">
                            <label class="form-label">Search</label>
                            <div class="input-group">
                                <input type="search" name="search" class="form-control" placeholder="Cari buku..."
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            @if ($buku->count() > 0)
                                <thead class="table-light">
                                    <tr class="bg-primary">
                                        <th scope="col" class="text-center bg-primary text-white w-10">#</th>
                                        <th scope="col" class="bg-primary text-white w-60">Penerbit</th>
                                        <th scope="col" class="bg-primary text-white w-60">Alamat Penerbit</th>
                                        <th scope="col" class="bg-primary text-white w-60">Judul</th>
                                        <th scope="col" class="bg-primary text-white w-60">Tahun Terbit</th>
                                        <th scope="col" class="bg-primary text-white w-60">Jumlah Halaman</th>
                                        <th scope="col" class="bg-primary text-white w-60">Sampul</th>
                                        <th scope="col" class="bg-primary text-white w-60">Upload</th>
                                        <th scope="col" class="bg-primary text-white w-60">Sub Kelompok</th>
                                        <th scope="col" class="bg-primary text-white w-60">Jenis</th>
                                        <th scope="col" class="bg-primary text-white w-60">Deskripsi</th>
                                        <th scope="col" class="bg-primary text-white w-60">Link Buku </th>
                                        <th scope="col" class="text-center bg-primary text-white max-w-[100px] w-30">Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($buku as $key => $item)
                                        <tr>
                                            <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                            <td class="text-capitalize">{{ $item->penerbit }}</td>
                                            <td class="text-capitalize">{{ $item->alamat_penerbit }}</td>
                                            <td class="text-capitalize">{{ $item->judul }}</td>
                                            <td class="text-capitalize">{{ $item->tahun_terbit }}</td>
                                            <td class="text-capitalize">{{ $item->jumlah_halaman }}</td>
                                            <td class="text-center">
                                                @if ($item->sampul)
                                                    <img src="{{ asset('storage/' . $item->sampul) }}" alt="Profile"
                                                        class="img-thumbnail" width="50">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td class="text-capitalize">
                                                <div>{{ $item->uploaded->nama }}</div>
                                            </td>
                                            <td class="text-capitalize">
                                                <div>{{ $item->sub_kelompok->nama ?? 'KEBACANYA UUID'}}</div>
                                            </td>
                                            <td class="text-capitalize">
                                                <div>{{ $item->jenis }}</div>
                                            </td>
                                            <td class="text-capitalize">
                                                <div>{{ $item->deskripsi }}</div>
                                            </td>
                                            <td class="text-center">
                                                @if ($item->file_buku)
                                                    <a href="{{ asset('storage/' . $item->file_buku) }}" target="_blank"
                                                        class="btn btn-primary btn-sm">
                                                        Buka Buku
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('dashboard.buku.edit', $item->id_buku) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <form action="{{ route('dashboard.buku.destroy', $item->id_buku) }}" class="d-inline"
                                                    method="POST" data-confirm-delete="true">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger">Delete</button>
                                                </form>
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
                        {{ $buku->links() }}
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
