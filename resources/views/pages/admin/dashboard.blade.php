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

        <div class="col-xxl-12 mb-6 order-0">
            <div class="card">
                <div class="d-flex align-items-start row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3 text-capitalize">Selamat Datang,
                                {{ Auth::user()->role->nama . ' ' . Auth::user()->nama }}
                            </h5>
                            <p class="mb-6">
                                Kelola sistem dengan mudah dan pantau aktivitas pengguna secara real-time.
                            </p>
                            {{-- <a href="/" class="btn btn-sm btn-outline-primary">Lihat Website</a> --}}
                            <div class="d-flex gap-2">
                                <a href="/" class="btn btn-sm btn-outline-primary">Lihat Website</a>
                                <a href="{{ route('dashboard.buku.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-plus me-1"></i> Tambah Buku
                                </a>
                            </div>
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
        <div class="col-xxl-4 col-12 order-2">
            <div class="row">
                @if ($role !== 'client' && $role !== 'admin instansi')
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                                            alt="chart success" class="rounded">
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
                @endif
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
                            <h4 class="card-title mb-3">{{ $data['totalBukuInstansi'] }}</h4>
                            <small class="{{ $data['bukuTrend'] == 'up' ? 'text-success' : 'text-danger' }} fw-medium">
                                <i class='bx bx-{{ $data['bukuTrend'] == 'up' ? 'up' : 'down' }}-arrow-alt'></i>
                                {{ $data['bukuTrend'] == 'up' ? '+' : '-' }}{{ $data['bukuGrowth'] }}%
                            </small>
                        </div>
                    </div>
                </div>
                @if ($role !== 'client' && $role !== 'admin instansi')
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
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
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/img/icons/unicons/cc-primary.png') }}"
                                            alt="Credit Card" class="rounded">
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
        <!-- Total Baca -->
        <!-- Total Baca -->
        <div class="col-12 col-xxl-8 order-1 order-md-1 order-xxl-1 mb-6">
            <div class="card h-100">
                <div class="row row-bordered g-0 h-100">
                    <div class="col-lg-12">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Total Users</h5>
                            </div>
                            @if (count($years) > 0)
                                <div class="card-body px-3 d-flex justify-content-end align-items-center gap-5 gap-lg-10">
                                    <div class="d-flex gap-3 justify-content-end">
                                        <div class="d-flex">
                                            <div class="avatar me-2">
                                                <span class="avatar-initial rounded-2 bg-label-info">
                                                    <i class="bx bx-wallet bx-lg text-info"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <small id="displaySelectedYear">{{ $selectedYear }}</small>
                                                <h6 class="mb-0" id="totalUsers"></h6>
                                            </div>
                                        </div>
                                    </div>

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
                                                        data-year="{{ $year }}">
                                                        {{ $year }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-end align-items-center w-100">
                                    <div class="card-body px-3">
                                        <p class="mb-0">Belum ada data</p>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div id="userRegistrationsChart" class="px-3"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectedYearBtn = document.getElementById("selectedYear");
            const yearOptions = document.querySelectorAll(".year-option");
            const selectedYearInfo = document.getElementById("displaySelectedYear");
            const totalUsers = document.getElementById("totalUsers");

            var userRegistrationsChart = new ApexCharts(document.querySelector("#userRegistrationsChart"), {
                chart: {
                    type: 'area',
                    height: 290,
                    animations: {
                        enabled: true,
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false,
                },
                series: [{
                    name: 'Registrations',
                    data: []
                }],
                stroke: {
                    curve: 'smooth',
                    colors: ['#696cff']
                },
                fill: {
                    colors: '#696cff'
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                        'Nov', 'Dec'
                    ]
                }
            });

            userRegistrationsChart.render();

            yearOptions.forEach(option => {
                option.addEventListener("click", function() {
                    const selectedYear = this.getAttribute("data-year");
                    selectedYearBtn.textContent = selectedYear; // Update tombol
                    selectedYearInfo.textContent = selectedYear;


                    const url = new URL(window.location.href);
                    url.searchParams.set('year', selectedYear);
                    window.history.pushState({}, '', url);

                    // Panggil fungsi untuk update chart sesuai tahun yang dipilih
                    loadChartData(selectedYear);
                });
            });

            function loadChartData(year) {
                fetch(`/dashboard/chart-data?year=${year}`)
                    .then(response => response.json())
                    .then(data => {
                        const userData = new Array(12).fill(0);

                        Object.keys(data.registrations).forEach(month => {
                            userData[parseInt(month) - 1] = data.registrations[month];
                        });

                        totalUsers.textContent = data.dataUser;

                        userRegistrationsChart.updateSeries([{
                            name: `${year}`,
                            data: userData
                        }]);
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
