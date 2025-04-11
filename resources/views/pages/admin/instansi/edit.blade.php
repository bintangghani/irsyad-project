@extends('layouts/dashboard')

@section('title', 'instansi - Edit Pengguna')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.user.instansi.index') }}">instansi</a>
            </li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Edit Pengguna</h5>
                    <a href="{{ route('dashboard.user.instansi.index') }}" class="btn btn-secondary">
                        <span class="d-none d-sm-inline-block">Kembali</span>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.user.instansi.update', $instansi->id_instansi) }}" method="POST"
                        enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="profile" class="form-label">Foto Profil</label>
                            <input type="file" name="profile" id="profile"
                                class="form-control @error('profile') is-invalid @enderror" accept="image/*">
                            @if ($instansi->profile)
                                <img src="{{ asset('storage/' . $instansi->profile) }}" alt="Profile Picture"
                                    class="img-thumbnail mt-2" width="100">
                            @endif
                            @error('profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $instansi->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror"
                                required>{{ old('alamat', $instansi->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror"
                                required>{{ old('deskripsi', $instansi->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="background" class="form-label">Background</label>
                            <input type="text" name="background" id="background"
                                class="form-control @error('background') is-invalid @enderror"
                                value="{{ old('background', $instansi->background) }}" required>
                            @error('background')
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
