@extends('layouts/dashboard')

@section('title', 'Laporan')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan</li>
        </ol>
    </nav>

    <main class="container-wrapper">
        <div class="container-xxl py-4 px-0">
            <div class="card shadow-sm">
                <div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
                    <h5 class="card-title mb-0 fs-3">Laporan</h5>
                    <div class="d-flex align-items-center gap-3">
                        <!-- Tombol Export -->
                        <a href="{{ route('dashboard.laporan.export', request()->all()) }}" class="btn btn-secondary">
                            <i class="bx bx-export me-2"></i>
                            <span class="d-none d-sm-inline-block">Export</span>
                        </a>

                        <!-- Dropdown Filter -->
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle d-flex align-items-center gap-1" type="button"
                                id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="menu-icon tf-icons bx bx-filter"></i>
                                <span class="d-none d-md-inline">Filter</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 350px; border: none;"
                                aria-labelledby="filterDropdown">
                                <form method="GET" action="{{ route('dashboard.laporan.index') }}">
                                    <div class="mb-3">
                                        <label for="tahun_terbit" class="form-label fw-semibold">Tahun Terbit</label>
                                        <input type="text" id="tahun_terbit" name="tahun_terbit" class="form-control"
                                            placeholder="Masukkan tahun terbit" value="{{ request('tahun_terbit') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Sub Kelompok</label>
                                        <div
                                            style="max-height: 150px; overflow-y: auto; background-color: transparent; padding: 0;">
                                            @foreach ($subKelompoks as $sk)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="sub_kelompok[]"
                                                        id="sub_kelompok_{{ $sk->id_sub_kelompok }}"
                                                        value="{{ $sk->id_sub_kelompok }}"
                                                        {{ is_array(request('sub_kelompok')) && in_array($sk->id_sub_kelompok, request('sub_kelompok')) ? 'checked' : '-' }}>
                                                    <label class="form-check-label"
                                                        for="sub_kelompok_{{ $sk->id_sub_kelompok }}">{{ $sk->nama }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Kelompok</label>
                                        <div
                                            style="max-height: 150px; overflow-y: auto; background-color: transparent; padding: 0;">
                                            @foreach ($kelompoks as $kelompok)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="id_kelompok[]"
                                                        id="id_kelompok_{{ $kelompok->id_kelompok }}"
                                                        value="{{ $kelompok->id_kelompok }}"
                                                        {{ is_array(request('id_kelompok')) && in_array($kelompok->id_kelompok, request('id_kelompok')) ? 'checked' : '-' }}>
                                                    <label class="form-check-label"
                                                        for="id_kelompok_{{ $kelompok->id_kelompok }}">{{ $kelompok->nama }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Jenis</label>
                                        <div
                                            style="max-height: 150px; overflow-y: auto; background-color: transparent; padding: 0;">
                                            @foreach ($jenisBuku as $jenis)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="jenis[]"
                                                        id="jenis{{ $jenis->id_jenis }}" value="{{ $jenis->id_jenis }}"
                                                        {{ is_array(request('jenis')) && in_array($jenis->id_jenis, request('jenis')) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="jenis{{ $jenis->id_jenis }}">{{ $jenis->nama }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Instansi</label>
                                        <div
                                            style="max-height: 150px; overflow-y: auto; background-color: transparent; padding: 0;">
                                            @foreach ($instansis as $instansi)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="id_instansi[]"
                                                        id="id_instansi_{{ $instansi->id_instansi }}"
                                                        value="{{ $instansi->id_instansi }}"
                                                        {{ is_array(request('id_instansi')) && in_array($instansi->id_instansi, request('id_instansi')) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="id_instansi_{{ $instansi->id_instansi }}">{{ $instansi->nama }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="min_total_read" class="form-label fw-semibold">Min. Jumlah
                                                Kunjungan</label>
                                            <input type="number" id="min_total_read" name="min_total_read"
                                                class="form-control" placeholder="Min kunjungan"
                                                value="{{ request('min_total_read') }}" step="1">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="max_total_read" class="form-label fw-semibold">Maks. Jumlah
                                                Kunjungan</label>
                                            <input type="number" id="max_total_read" name="max_total_read"
                                                class="form-control" placeholder="Maks kunjungan"
                                                value="{{ request('max_total_read') }}" step="1">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('dashboard.laporan.index') }}"
                                            class="btn btn-outline-secondary">Reset</a>
                                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <div class="table-responsive" style="min-width: 1000px;">
                        @if (request('tahun_terbit') ||
                                request('sub_kelompok') ||
                                request('id_kelompok') ||
                                request('jenis') ||
                                request('id_instansi') ||
                                request('min_total_read') ||
                                request('max_total_read'))
                            <table class="table table-bordered table-hover align-middle text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr class="align-middle text-center">
                                        @foreach (['#', 'Penerbit', 'Alamat Penerbit', 'Judul', 'Tahun Terbit', 'Jumlah Halaman', 'Sampul', 'Uploader', 'Instansi', 'Sub Kelompok', 'Jenis', 'Deskripsi', 'Total Baca', 'Link Buku'] as $col)
                                            <th class="bg-primary text-white">{{ $col }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($buku as $key => $item)
                                        <tr>
                                            <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                            <td class="text-capitalize text-truncate" style="max-width: 120px;"
                                                title="{{ $item->penerbit }}">
                                                {{ $item->penerbit }}
                                            </td>
                                            <td class="text-capitalize text-truncate" style="max-width: 150px;"
                                                title="{{ $item->alamat_penerbit }}">
                                                {{ $item->alamat_penerbit ?? '-' }}
                                            </td>
                                            <td class="text-capitalize text-truncate" style="max-width: 180px;"
                                                title="{{ $item->judul }}">
                                                {{ $item->judul }}
                                            </td>
                                            <td class="text-center">{{ $item->tahun_terbit }}</td>
                                            <td class="text-center">{{ $item->jumlah_halaman }}</td>
                                            <td class="text-center">
                                                @if ($item->sampul)
                                                    <img src="{{ asset('storage/' . $item->sampul) }}" alt="Sampul"
                                                        class="img-thumbnail" width="50" height="70"
                                                        style="object-fit: cover;">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td class="text-capitalize" title="{{ $item->uploaded->nama ?? '-' }}">
                                                {{ Str::limit($item->uploaded->nama ?? '-', 20) }}
                                            </td>
                                            <td class="text-capitalize"
                                                title="{{ $item->uploaded->instansi->nama ?? '-' }}">
                                                {{ Str::limit($item->uploaded->instansi->nama ?? '-', 20) }}
                                            </td>
                                            <td class="text-capitalize" title="{{ $item->subKelompok->nama ?? '-' }}">
                                                {{ Str::limit($item->subKelompok->nama ?? '-', 20) }}
                                            </td>
                                            <td class="text-capitalize" title="{{ $item->jenisBuku->nama ?? '-' }}">
                                                {{ Str::limit($item->jenisBuku->nama ?? '-', 20) }}
                                            </td>
                                            <td class="text-truncate" style="max-width: 200px;"
                                                title="{{ $item->deskripsi  }}">
                                                {{ Str::limit($item->deskripsi ?? '-', 60) }}
                                            </td>
                                            <td class="text-center">{{ $item->total_read }}</td>
                                            <td class="text-center">
                                                @if ($item->file_buku)
                                                    <a href="{{ asset('storage/' . $item->file_buku) }}" target="_blank"
                                                        class="btn btn-sm btn-primary">Buka Buku</a>
                                                @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="13" class="text-center text-muted">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @else
                            <div class="text-center text-muted py-5">
                                <p class="fs-5">Silakan gunakan filter untuk menampilkan data laporan buku.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var filterDropdown = document.getElementById('filterDropdown');
            new bootstrap.Dropdown(filterDropdown, {
                popperConfig: {
                    modifiers: [{
                            name: 'flip',
                            options: {
                                fallbackPlacements: []
                            }
                        },
                        {
                            name: 'preventOverflow',
                            options: {
                                boundary: 'viewport',
                                altAxis: false
                            }
                        }
                    ]
                }
            });
        });
    </script>
@endsection
