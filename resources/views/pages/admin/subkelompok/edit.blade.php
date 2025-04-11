@extends('layouts/dashboard')

@section('title', 'subkelompok - Edit Pengguna')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.buku.subkelompok.index') }}">Subkelompok</a>
            </li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Edit Pengguna</h5>
                    <a href="{{ route('dashboard.buku.subkelompok.index') }}" class="btn btn-secondary">
                        <span class="d-none d-sm-inline-block">Kembali</span>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.buku.subkelompok.update', $subkelompok->id_sub_kelompok) }}" method="POST"
                        enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $subkelompok->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_kelompok" class="form-label">Kelompok</label>
                            <select name="id_kelompok" id="id_kelompok" class="form-select @error('id_kelompok') is-invalid @enderror"
                                required>
                                <option value="">Pilih Kelompok</option>
                                @foreach ($kelompok as $ke)
                                    <option value="{{ $ke->id_kelompok }}"
                                        {{ $subkelompok->id_kelompok == $ke->id_kelompok ? 'selected' : '' }}>{{ $ke->nama }}</option>
                                @endforeach
                            </select>
                            @error('id_kelompok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
