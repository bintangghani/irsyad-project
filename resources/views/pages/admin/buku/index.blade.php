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
                    <h5 class="card-title mb-0 fs-3">List Buku</h5>
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
                                    <option value="{{ $buku->count() }}" {{ request('per_page') == $buku->count() ? 'selected' : '' }}>
                                        {{ $buku->count() < 10 ? $buku->count() : 'Semua' }}
                                    </option>
                                    @foreach([10, 25, 50, 75, 100] as $value)
                                        <option value="{{ $value }}" {{ request('per_page') == $value ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <form action="{{ route('dashboard.buku.index') }}" method="GET" class="col-md-6 text-md-end mt-3 mt-md-0">
                            <label class="form-label">Search</label>
                            <div class="input-group">
                                <input type="search" name="search" class="form-control" placeholder="Cari buku..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            @if ($buku->count() > 0)
                                <thead class="table-light">
                                    <tr class="bg-primary align-middle">
                                        @foreach (['#', 'Penerbit', 'Alamat Penerbit', 'Judul', 'Tahun Terbit', 'Jumlah Halaman', 'Sampul', 'Upload', 'Sub Kelompok', 'Jenis', 'Deskripsi', 'Link Buku', 'Aksi'] as $col)
                                            <th class="text-center bg-primary text-white">{{ $col }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($buku as $key => $item)
                                        <tr>
                                            <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                            <td class="text-capitalize text-truncate" style="max-width: 250px;">{{ $item->penerbit }}</td>
                                            <td class="text-capitalize text-truncate">{{ $item->alamat_penerbit }}</td>
                                            <td class="text-capitalize text-truncate">{{ $item->judul }}</td>
                                            <td class="text-center text-capitalize text-truncate">{{ $item->tahun_terbit }}</td>
                                            <td class="text-center text-capitalize text-truncate">{{ $item->jumlah_halaman }}</td>
                                            <td class="text-center">
                                                @if ($item->sampul)
                                                    <img src="{{ asset('storage/' . $item->sampul) }}" alt="Sampul" class="img-thumbnail" width="50">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td class="text-capitalize text-truncate">{{ $item->uploaded->nama }}</td>
                                            <td class="text-capitalize text-truncate">{{ $item->sub_kelompok }}</td>
                                            <td class="text-capitalize text-truncate">{{ $item->jenis }}</td>
                                            <td class="text-capitalize text-truncate">{{ $item->deskripsi }}</td>
                                            <td class="text-center text-truncate">
                                                @if ($item->file_buku)
                                                    <a href="{{ asset('storage/' . $item->file_buku) }}" target="_blank" class="btn btn-primary btn-sm">Buka Buku</a>
                                                @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex flex-column gap-1 align-items-center">
                                                    <a href="{{ route('dashboard.buku.edit', $item->id_buku) }}" class="btn btn-warning btn-sm w-100">Edit</a>
                                                    <form action="{{ route('dashboard.buku.destroy', $item->id_buku) }}" method="POST" data-confirm-delete="true" class="w-100">
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
                                    <td colspan="13" class="text-center">Tidak ada data</td>
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
                    event.preventDefault();
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
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush