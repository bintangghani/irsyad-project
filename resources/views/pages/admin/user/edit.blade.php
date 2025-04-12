@extends('layouts/dashboard')

@section('title', 'User - Edit Pengguna')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.user.index') }}">User</a>
            </li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Edit Pengguna</h5>
                    <a href="{{ route('dashboard.user.index') }}" class="btn btn-secondary">
                        <span class="d-none d-sm-inline-block">Kembali</span>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.user.update', $user->id_user) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password (kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="profile" class="form-label">Foto Profil</label>
                            <input type="file" name="profile" id="profile" class="form-control @error('profile') is-invalid @enderror" accept="image/*">
                            @if ($user->profile)
                                <img src="{{ asset('storage/' . $user->profile) }}" alt="Profile Picture" class="img-thumbnail mt-2" width="100">
                            @endif
                            @error('profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="moto" class="form-label">Moto</label>
                            <input type="text" name="moto" id="moto" class="form-control @error('moto') is-invalid @enderror" value="{{ old('moto', $user->moto) }}">
                            @error('moto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_role" class="form-label">Role</label>
                                    <select name="id_role" id="id_role" class="form-select @error('id_role') is-invalid @enderror" required>
                                        <option value="">Pilih Role</option>
                                        @foreach($role as $ro)
                                            <option value="{{ $ro->id_role }}" {{ $user->id_role == $ro->id_role ? 'selected' : '' }}>{{ $ro->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_instansi" class="form-label">Instansi</label>
                                    <select name="id_instansi" id="id_instansi" class="form-select @error('id_instansi') is-invalid @enderror">
                                        <option value="">Pilih Instansi</option>
                                        @foreach($instansi as $ins)
                                            <option value="{{ $ins->id_instansi }}" {{ $user->id_instansi == $ins->id_instansi ? 'selected' : '' }}>{{ $ins->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_instansi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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