@extends('layouts/dashboard')

@section('title', 'User - Edit Buku')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.buku.index') }}">Buku</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>

    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-md-row flex-column align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Edit Buku</h5>
                    <a href="{{ route('dashboard.buku.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard.buku.update', $buku->id_buku) }}" method="POST"
                        enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- Informasi Buku --}}
                        <h5 class="mb-3">Informasi Buku</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="judul" class="form-label">Judul Buku</label>
                                <input type="text" name="judul" id="judul" value="{{ old('judul', $buku->judul) }}"
                                    required class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="penulis" class="form-label">Penulis</label>
                                <input type="text" name="penulis" id="penulis"
                                    value="{{ old('penulis', $buku->penulis) }}" required class="form-control">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="penerbit" class="form-label">Penerbit</label>
                                <input type="text" name="penerbit" id="penerbit"
                                    value="{{ old('penerbit', $buku->penerbit) }}" required class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="no_isbn" class="form-label">No. ISBN</label>
                                <input type="text" name="no_isbn" id="no_isbn"
                                    value="{{ old('no_isbn', $buku->no_isbn) }}" class="form-control">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="alamat_penerbit" class="form-label">Alamat Penerbit</label>
                            <textarea name="alamat_penerbit" id="alamat_penerbit" rows="3" required class="form-control">{{ old('alamat_penerbit', $buku->alamat_penerbit) }}</textarea>
                        </div>

                        {{-- Tahun & Halaman --}}
                        <h5 class="mb-3">Tahun & Halaman</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" id="tahun_terbit"
                                    value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="jumlah_halaman" class="form-label">Jumlah Halaman</label>
                                <input type="number" name="jumlah_halaman" id="jumlah_halaman"
                                    value="{{ old('jumlah_halaman', $buku->jumlah_halaman) }}" required
                                    class="form-control">
                            </div>
                        </div>

                        {{-- Sampul & File Buku --}}
                        <h5 class="mb-3">File Buku</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="sampul" class="form-label">Sampul Buku</label>
                                <input type="file" name="sampul" id="sampul" class="form-control" accept="image/*">
                                @if ($buku->sampul)
                                    <img src="{{ asset('storage/' . $buku->sampul) }}" alt="Sampul Buku"
                                        class="mt-2 img-thumbnail" width="100">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="file_buku" class="form-label">File Buku (PDF)</label>
                                <input type="file" name="file_buku" id="file_buku" class="form-control"
                                    accept="application/pdf">
                                @if ($buku->file_buku)
                                    <a href="{{ asset('storage/' . $buku->file_buku) }}" target="_blank"
                                        class="btn btn-info mt-2">Lihat Buku</a>
                                @endif
                            </div>
                        </div>

                        {{-- Kategori Buku --}}
                        <h5 class="mb-3">Kategori Buku</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="sub_kelompok" class="form-label">Sub Kelompok</label>
                                <select name="sub_kelompok" id="sub_kelompok" required class="form-select">
                                    @foreach ($subkelompok as $sub)
                                        <option value="{{ $sub->id_sub_kelompok }}"
                                            {{ $buku->sub_kelompok == $sub->id_sub_kelompok ? 'selected' : '' }}>
                                            {{ $sub->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select name="jenis" id="jenis" required class="form-select">
                                    @foreach ($jenis as $j)
                                        <option value="{{ $j->id_jenis }}"
                                            {{ $buku->jenisBuku->id_jenis == $j->id_jenis ? 'selected' : '' }}>
                                            {{ $j->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Deskripsi Buku --}}
                        <h5 class="mb-3">Deskripsi</h5>
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" required class="form-control" rows="3">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                        </div>

                        <input type="hidden" name="uploaded_by" value="{{ $buku->uploaded_by }}">

                        {{-- Tombol Simpan --}}
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
