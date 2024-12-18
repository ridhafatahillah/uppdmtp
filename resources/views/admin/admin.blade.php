<x-head>
    <x-slot:judul>
        {{ $judul }}
    </x-slot:judul>
</x-head>

<body>

    <x-header></x-header>
    {{-- buat x-sidebar dan kirimkan $users --}}
    <x-sidebar :users="$users" />
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
        </div>


        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Total Notes
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $totalNotes }} Notes</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card info-card pajak-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Total Pajak
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6> {{ formatRupiah($totalPajak) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card info-card rusak-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Notes Rusak
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-exclamation-triangle"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $notesRusak }} Rusak</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    {{-- <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">Today</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">This Month</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">This Year</a>
                            </li>
                        </ul>
                    </div> --}}

                    <div class="card-body">
                        <h5 class="card-title">
                            Pendapatan <span>{{ date('F') }}</span>
                        </h5>

                        <!-- Line Chart -->
                        <div id="reportsChart"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#reportsChart"), {
                                    series: {!! json_encode($chartData) !!}, // Menggunakan data chart yang sudah disiapkan di controller
                                    chart: {
                                        height: 350,
                                        type: "area",
                                        toolbar: {
                                            show: false,
                                        },
                                    },
                                    markers: {
                                        size: 4,
                                    },
                                    colors: [
                                        "#4154f1",
                                        "#2eca6a",
                                        "#ff771d",
                                        "#f7b11b",
                                        "#ff4560",
                                        "#a626d9",
                                        "#50a5f1",
                                        "#e3e7ed",
                                        "#f7b11b",
                                    ],
                                    fill: {
                                        type: "gradient",
                                        gradient: {
                                            shadeIntensity: 1,
                                            opacityFrom: 0.3,
                                            opacityTo: 0.4,
                                            stops: [0, 90, 100],
                                        },
                                    },
                                    dataLabels: {
                                        enabled: false,
                                    },
                                    stroke: {
                                        curve: "smooth",
                                        width: 2,
                                    },
                                    xaxis: {
                                        type: "category", // Menggunakan 'category' untuk kategori berdasarkan tanggal
                                        categories: {!! json_encode($dates) !!}, // Menggunakan tanggal yang sudah disiapkan di controller
                                    },
                                    tooltip: {
                                        y: {
                                            formatter: function(value) {
                                                return "Rp. " + value
                                                    .toLocaleString(); // Menambahkan format "Rp." dan memformat angka dengan koma
                                            }
                                        },
                                        x: {
                                            format: "dd/MM/yy",
                                        },
                                    },
                                    yaxis: {
                                        labels: {
                                            formatter: function(value) {
                                                return "Rp. " + value
                                                    .toLocaleString(); // Menambahkan format "Rp." di label sumbu Y
                                            }
                                        }
                                    }
                                }).render();
                            });
                        </script>


                        <!-- End Line Chart -->
                    </div>
                </div>
            </div>
        </section>

</body>

<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

<!-- Tambahkan di bagian <head> atau di bagian bawah sebelum </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
