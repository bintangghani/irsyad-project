@extends('layouts/dashboard')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
    @vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
    <div class="row">
        <div class="col-xxl-8 mb-6 order-0">
            <div class="card">
                <div class="d-flex align-items-start row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">Selamat Datang, Admin</h5>
                            <p class="mb-6">
                                Kelola sistem dengan mudah dan pantau aktivitas pengguna secara real-time.
                            </p>

                            <a href="/" class="btn btn-sm btn-outline-primary">Lihat Page Client</a>
                        </div>
                    </div>

                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-6">
                            <img src="{{ asset('assets/img/illustrations/man-with-laptop.png') }}" height="175"
                                class="scaleX-n1-rtl" alt="View Badge User">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="chart success"
                                        class="rounded">
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">User</p>
                            <h4 class="card-title mb-3">{{ $data['totalUsers'] }}</h4>
                            <small class="{{ $data['userTrend'] == 'up' ? 'text-success' : 'text-danger' }} fw-medium">
                                <i class='bx bx-{{ $data['userTrend'] == 'up' ? 'up' : 'down' }}-arrow-alt'></i>
                                {{ $data['userTrend'] == 'up' ? '+' : '-' }}{{ $data['userGrowth'] }}%
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}" alt="wallet info"
                                        class="rounded">
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Buku</p>
                            <h4 class="card-title mb-3">{{ $data['totalBuku'] }}</h4>
                            <small class="{{ $data['bukuTrend'] == 'up' ? 'text-success' : 'text-danger' }} fw-medium">
                                <i class='bx bx-{{ $data['bukuTrend'] == 'up' ? 'up' : 'down' }}-arrow-alt'></i>
                                {{ $data['bukuTrend'] == 'up' ? '+' : '-' }}{{ $data['bukuGrowth'] }}%
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xxl-8 order-2 order-md-3 order-xxl-2 mb-6">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-lg-8">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Total Baca</h5>
                            </div>
                        </div>
                        <div id="totalRevenueChart" class="px-3"></div>
                    </div>
                    <div class="col-lg-4 d-flex align-items-center">
                        <div class="card-body px-xl-9">
                            <div class="text-center mb-6">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary" id="selectedYear">
                                        {{ $selectedYear }}
                                    </button>
                                    <button type="button"
                                        class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @foreach ($years as $year)
                                            <li>
                                                <a class="dropdown-item year-option" href="javascript:void(0);"
                                                    data-year="{{ $year }}">{{ $year }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="text-center fw-medium my-6"></div>

                            <div class="d-flex gap-3 justify-content-between">
                                <div class="d-flex">
                                    <div class="avatar me-2">
                                        <span class="avatar-initial rounded-2 bg-label-info">
                                            <i class="bx bx-wallet bx-lg text-info"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small id="displaySelectedYear">{{ $selectedYear }}</small>
                                        <h6 class="mb-0" id="totalViewBuku">{{ $data['totalViewBuku'] }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-8 col-lg-12 col-xxl-4 order-3 order-md-2">
            <div class="row">
                <div class="col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/paypal.png') }}" alt="paypal"
                                        class="rounded">
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Instansi</p>
                            <h4 class="card-title mb-3">{{ $data['totalInstansi'] }}</h4>
                            <small
                                class="{{ $data['instansiTrend'] == 'up' ? 'text-success' : 'text-danger' }} fw-medium">
                                <i class='bx bx-{{ $data['instansiTrend'] == 'up' ? 'up' : 'down' }}-arrow-alt'></i>
                                {{ $data['instansiTrend'] == 'up' ? '+' : '-' }}{{ $data['instansiGrowth'] }}%
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/cc-primary.png') }}" alt="Credit Card"
                                        class="rounded">
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Total Download</p>
                            <h4 class="card-title mb-3">{{ $data['totalDownload'] }}</h4>
                            <small
                                class="{{ $data['downloadTrend'] == 'up' ? 'text-success' : 'text-danger' }} fw-medium">
                                <i class='bx bx-{{ $data['downloadTrend'] == 'up' ? 'up' : 'down' }}-arrow-alt'></i>
                                {{ $data['downloadTrend'] == 'up' ? '+' : '-' }}{{ $data['downloadGrowth'] }}%
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectedYearBtn = document.getElementById("selectedYear");
            const yearOptions = document.querySelectorAll(".year-option");

            yearOptions.forEach(option => {
                option.addEventListener("click", function() {
                    const selectedYear = this.getAttribute("data-year");
                    selectedYearBtn.textContent = selectedYear; // Update tombol

                    
                    const url = new URL(window.location.href);
                    url.searchParams.set('year', selectedYear);
                    window.history.pushState({}, '', url);

                    // Panggil fungsi untuk update chart sesuai tahun yang dipilih
                    loadChartData(selectedYear);
                });
            });

            function loadChartData(year) {
                fetch(`/chart-data?year=${year}`)
                    .then(response => response.json())
                    .then(data => {
                        const thisYearData = new Array(12).fill(0);
                        const lastYearData = new Array(12).fill(0);

                        Object.keys(data.thisYear).forEach(month => {
                            thisYearData[parseInt(month) - 1] = data.thisYear[month];
                        });

                        Object.keys(data.lastYear).forEach(month => {
                            lastYearData[parseInt(month) - 1] = data.lastYear[month];
                        });

                        totalRevenueChart.updateSeries([{
                                name: `${year}`,
                                data: thisYearData
                            },
                            {
                                name: `${year - 1}`,
                                data: lastYearData
                            }
                        ]);
                    })
                    .catch(error => console.error("Error loading chart data:", error));
            }

            // Muat data chart berdasarkan tahun dari URL saat pertama kali dibuka
            const initialYear = new URL(window.location.href).searchParams.get('year') || selectedYearBtn
                .textContent;
            loadChartData(initialYear);
        });
    </script>

@endsection
