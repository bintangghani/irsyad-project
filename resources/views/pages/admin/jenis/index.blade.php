@extends('layouts/dashboard')

@section('title', 'User - jenis')

@section('content')
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
          <a href="{{ route('dashboard.index')  }}">Home</a>
        </li>
        <li class="breadcrumb-item active">jenis</li>
      </ol>
    </nav>
    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="card-title mb-0 fs-3">List jenis</h5>
                    <a href="{{ route('dashboard.jenis.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-2"></i>
                        <span class="d-none d-sm-inline-block">Tambah jenis Baru</span>
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-3 d-flex justify-content-between">
                        <div class="col-md-2">  
                            <label class="form-label">Show</label>
                            <form action="{{ route('dashboard.jenis.index') }}" method="GET" id="paginationForm">
                                <select class="form-select" name="per_page" onchange="document.getElementById('paginationForm').submit();">
                                    <option value="{{ $jenis->count() }}" {{ request('per_page') == $jenis->count() ? 'selected' : '' }}>{{ $jenis->count() < 10 ? $jenis->count() : 'Semua' }}</option>
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="75" {{ request('per_page') == 75 ? 'selected' : '' }}>75</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </form>
                        </div>

                        <form action="{{ route('dashboard.jenis.index') }}" method="GET" class="col-md-6 text-md-end mt-3 mt-md-0">
                            <label class="form-label">Search</label>
                            <div class="input-group">
                                <input type="search" name="search" class="form-control" placeholder="Cari jenis..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            @if ($jenis->count() > 0)
                                <thead class="table-light">
                                    <tr class="bg-primary">
                                        <th scope="col" class="text-center bg-primary text-white w-10">#</th>
                                        <th scope="col" class="bg-primary text-white w-60">Nama</th>
                                        <th scope="col" class="text-center bg-primary text-white max-w-[100px] w-30">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jenis as $key => $item)
                                        <tr>
                                            <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                            <td class="text-capitalize">
                                                <div class="editJenisSection">{{ $item->nama }}</div>
                                                <form action="{{ route('dashboard.jenis.update', ['id' => $item->id]) }}" method="POST" class="d-none editJenisInput">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="id_jenis" value="{{ $item->id_jenis }}">
                                                    <div class="input-group">
                                                        <input type="text" name="nama" class="form-control" value="{{ $item->nama }}">
                                                        <button type="submit" class="btn btn-warning">Update</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-warning editJenisBtn">Edit</button>
                                                <form action="{{ route('dashboard.jenis.destroy') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id_jenis" value="{{ $item->id_jenis }}">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data</td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <div class="col-md-12 d-flex justify-content-end">
                        {{ $jenis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection