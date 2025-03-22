@extends('layouts/dashboard')

@section('title', 'User - Tambah Role')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index')  }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.user.role.index')  }}">Role</a>
            </li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>
    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Tambah role baru</h5>
                    <a href="{{ route('dashboard.user.role.index') }}" class="btn btn-secondary">
                        <span class="d-none d-sm-inline-block">Kembali</span>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.user.role.store') }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Role</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                                class="form-control @error('nama') is-invalid @enderror">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @php
                            $groupedPermissions = [];
                            foreach ($permissions as $item) {
                                $name = str_replace('_', ' ', $item->nama);
                                $nameParts = explode(' ', $name);
                                $category = ucwords(end($nameParts));
                                $groupedPermissions[$category][] = $item;
                            }
                        @endphp

                        @foreach ($groupedPermissions as $category => $items)
                            <div class="row gy-6">
                                <div class="col-md">
                                    <small class="text-light fw-medium">{{ $category }}</small>
                                    @foreach ($items as $item)
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" value="{{ $item->id_permission }}"
                                                id="check{{ $item->id_permission }}" name="permission[]" />
                                            <label class="form-check-label" for="check{{ $item->id_permission }}">
                                                {{ ucwords(str_replace('_', ' ', $item->nama)) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>
@endsection