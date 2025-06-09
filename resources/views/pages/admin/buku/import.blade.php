@extends('layouts/dashboard')

@section('title', 'Import Instansi')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Import</li>
        </ol>
    </nav>

    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0 fs-3">Import Data Buku</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.buku.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih file Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" class="form-control" name="file" id="file" required>
                            @error('file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection