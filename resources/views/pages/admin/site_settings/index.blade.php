@extends('layouts/dashboard')

@section('title', 'setting')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Site</li>
        </ol>
    </nav>
    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="card-title mb-0 fs-3">Site Settings</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            @if ($setting)
                                <thead class="table-light">
                                    <tr class="bg-primary">
                                        <th scope="col" class="text-center bg-primary text-white w-10">#</th>
                                        <th scope="col" class="text-center bg-primary text-white w-30">Icon</th>
                                        <th scope="col" class="text-center bg-primary text-white w-30">Title</th>
                                        <th scope="col" class="text-center bg-primary text-white w-30">Brand</th>
                                        <th scope="col" class="text-center bg-primary text-white w-30">Deskripsi</th>
                                        <th scope="col" class="text-center bg-primary text-white">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" class="text-center">1</th>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . $setting->icon) }}" width="40" alt="Icon">
                                        </td>
                                        <td class="text-capitalize">{{ $setting->title }}</td>
                                        <td class="text-capitalize">{{ $setting->brand }}</td>
                                        <td class="text-capitalize">{{ $setting->deskripsi }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('dashboard.site.edit', $setting->id_site_settings) }}" class="btn btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                </tbody>
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection