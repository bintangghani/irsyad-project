@extends('layouts/dashboard')

@section('title', 'User - Tambah Jenis')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.buku.jenis.index') }}">Jenis</a>
            </li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>

    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Tambah Jenis Baru</h5>
                    <a href="{{ route('dashboard.buku.jenis.index') }}" class="btn btn-secondary">
                        <span class="d-none d-sm-inline-block">Kembali</span>
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard.buku.jenis.store') }}" method="POST" class="needs-validation">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Jenis</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                class="form-control @error('nama') is-invalid @enderror" required>
                            @error('nama')
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