@extends('layouts/dashboard')

@section('title', 'User - Tambah Buku')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.buku.index') }}">Buku</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>

    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-md-row flex-column align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Tambah Buku</h5>
                    <a href="{{ route('dashboard.buku.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard.buku.store') }}" method="POST" enctype="multipart/form-data"
                        class="needs-validation" novalidate>
                        @csrf

                        {{-- Informasi Buku --}}
                        <h5 class="mb-3">Informasi Buku</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="judul" class="form-label">Judul Buku</label>
                                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required
                                    class="form-control @error('judul') is-invalid @enderror">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="penerbit" class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit') }}" required
                                    class="form-control @error('penerbit') is-invalid @enderror">
                                @error('penerbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="alamat_penerbit" class="form-label">Alamat Penerbit</label>
                            <input type="text" name="alamat_penerbit" id="alamat_penerbit"
                                value="{{ old('alamat_penerbit') }}" required
                                class="form-control @error('alamat_penerbit') is-invalid @enderror">
                            @error('alamat_penerbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tahun & Halaman --}}
                        <h5 class="mb-3">Tahun & Halaman</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" id="tahun_terbit"
                                    value="{{ old('tahun_terbit') }}" required
                                    class="form-control @error('tahun_terbit') is-invalid @enderror">
                                @error('tahun_terbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="jumlah_halaman" class="form-label">Jumlah Halaman</label>
                                <input type="number" name="jumlah_halaman" id="jumlah_halaman"
                                    value="{{ old('jumlah_halaman') }}" required
                                    class="form-control @error('jumlah_halaman') is-invalid @enderror">
                                @error('jumlah_halaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Sampul & File Buku --}}
                        <h5 class="mb-3">File Buku</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="sampul" class="form-label">Sampul Buku</label>
                                <input type="file" name="sampul" id="sampul"
                                    class="form-control @error('sampul') is-invalid @enderror" accept="image/*" required>
                                @error('sampul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="file_buku" class="form-label">File Buku (PDF)</label>
                                <input type="file" name="file_buku" id="file_buku"
                                    class="form-control @error('file_buku') is-invalid @enderror" accept="application/pdf">
                                @error('file_buku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Kategori Buku --}}
                        <h5 class="mb-3">Kategori Buku</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="sub_kelompok" class="form-label">Sub Kelompok</label>
                                <select name="sub_kelompok" id="sub_kelompok" required
                                    class="form-select @error('sub_kelompok') is-invalid @enderror">
                                    <option value="">Pilih Sub Kelompok</option>
                                    @foreach ($subkelompok as $sub)
                                        <option value="{{ $sub->id_sub_kelompok }}"
                                            {{ old('sub_kelompok') == $sub->id_sub_kelompok ? 'selected' : '' }}>
                                            {{ $sub->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sub_kelompok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select name="jenis" id="jenis" required
                                    class="form-select @error('jenis') is-invalid @enderror">
                                    <option value="">Pilih Jenis</option>
                                    @foreach ($jenis as $j)
                                        <option value="{{ $j->id_jenis }}"
                                            {{ old('jenis') == $j->id_jenis ? 'selected' : '' }}>
                                            {{ $j->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi Buku --}}
                        <h5 class="mb-3">Deskripsi</h5>
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" required class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="uploaded_by" value="{{ auth()->id() }}">

                        {{-- Tombol Simpan --}}
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection