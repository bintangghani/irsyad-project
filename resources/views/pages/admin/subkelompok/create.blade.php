@extends('layouts/dashboard')

@section('title', 'User - Tambah Sub Kelompok')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.buku.subkelompok.index') }}">Sub Kelompok</a>
            </li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>
    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Tambah Sub Kelompok Baru</h5>
                    <a href="{{ route('dashboard.buku.subkelompok.index') }}" class="btn btn-secondary">
                        <span class="d-none d-sm-inline-block">Kembali</span>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.buku.subkelompok.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Sub Kelompok</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                                class="form-control @error('nama') is-invalid @enderror">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="id_kelompok" class="form-label">Kelompok</label>
                            <select name="id_kelompok" id="id_kelompok" class="form-select @error('id_kelompok') is-invalid @enderror" required>
                                <option value="">Pilih Kelompok</option>
                                @foreach ($kelompok as $k)
                                    <option value="{{ $k->id_kelompok }}" {{ old('id_kelompok') == $k->id_kelompok ? 'selected' : '' }}>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                            @error('id_kelompok')
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
