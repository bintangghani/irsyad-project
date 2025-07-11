@extends('layouts/dashboard')

@section('title', 'Import Buku')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Import</li>
        </ol>
    </nav>

    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fs-3">Import Data Buku</h5>
                    <a href="{{ asset('assets/template/template_import_buku.xlsx') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-download me-1"></i> Download Template
                    </a>
                </div>

                <div class="card-body">
                    <p class="mb-4 text-muted">
                        Unggah file Excel (.xlsx, .xls, .csv) sesuai dengan format template yang telah disediakan.
                    </p>

                    <form action="{{ route('dashboard.buku.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label fw-semibold">Pilih File Excel</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" name="file"
                                id="file" required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload me-1"></i> Import Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
