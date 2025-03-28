@extends('layouts/dashboard')

@section('title', 'instansi - Tambah Pengguna')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.instansi.index') }}">instansi</a>
            </li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>
    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Tambah Instansi</h5>
                    <a href="{{ route('dashboard.instansi.index') }}" class="btn btn-secondary">
                        <span class="d-none d-sm-inline-block">Kembali</span>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.instansi.store') }}" method="POST" enctype="multipart/form-data"
                        class="needs-validation" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="profile" class="form-label">Foto Profil</label>
                            <input type="file" name="profile" id="profile"
                                class="form-control @error('profile') is-invalid @enderror" accept="image/*" required>
                            @error('profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">alamat</label>
                            <input type="alamat" name="alamat" id="alamat"
                                class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}"
                                required>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">deskripsi</label>
                            <input type="deskripsi" name="deskripsi" id="deskripsi"
                                class="form-control @error('deskripsi') is-invalid @enderror" required>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="background" class="form-label">background</label>
                            <input type="background" name="background" id="background"
                                class="form-control @error('background') is-invalid @enderror" required>
                            @error('background')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
