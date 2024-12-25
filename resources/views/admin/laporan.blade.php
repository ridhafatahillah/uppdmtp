<x-head>
    <x-slot:judul>
        Laporan
    </x-slot:judul>
</x-head>

<body>

    <x-header></x-header>
    {{-- buat x-sidebar dan kirimkan $users --}}
    <x-sidebar :users="$users" />
    <main id="main" class="main">
        <div class="pagetitle">
            <h1></h1>
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
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">

                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-tabs-bordered">
                                        <li class="nav-item ">
                                            <a href="{{ url('admin/laporan') }}"
                                                class="nav-link {{ request()->url() == url('admin/laporan') ? 'active' : '' }}">Perhari</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a href="{{ url('admin/laporan/perbulan') }}"
                                                class="nav-link {{ request()->url() == url('admin/laporan/perbulan') ? 'active' : '' }}">Perbulan</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a href="{{ url('admin/laporan/pertahun') }}"
                                                class="nav-link {{ request()->url() == url('admin/laporan/pertahun') ? 'active' : '' }}">Pertahun</a>
                                        </li>
                                    </ul>

                                    {{-- buat 2 kolom bersampingan --}}
                                    <div class="row">
                                        <div class="col-4">
                                            <h5 class="card-title
                                        ">Laporan
                                                Pemakaian SKPD {{ $judul }}
                                            </h5>
                                        </div>

                                        {{-- <div class="col-4 d-flex justify-content-center align-items-center mt-2 ">


                                        </div> --}}

                                        <div class="col-8 d-flex justify-content-end align-items-center ">
                                            @if (request()->is('admin/laporan'))
                                                <input type="date" class="form-control form-control-sm ms-2 "
                                                    style="width: 150px;" id="dateInput" value="{{ $selectedDate }}">
                                            @elseif (request()->is('admin/laporan/perbulan'))
                                                <input type="month" class="form-control form-control-sm ms-2 "
                                                    style="width: 150px;" id="dateInput" value="{{ $selectedDate }}">
                                            @else
                                                <select class="form-select form-select-sm " style="width: 150px;"
                                                    id="dateInput">
                                                    @for ($year = 2010; $year <= now()->year; $year++)
                                                        <option value="{{ $year }}"
                                                            {{ $year == $selectedDate->year ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            @endif


                                            <a class="float-end text-warning-subtle ms-2 fs-4" type="button"
                                                id='download'><i class="bi bi-file-earmark-spreadsheet-fill"></i></a>
                                        </div>
                                    </div>
                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Notice</th>
                                                <th scope="col"> No. Polisi</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col">Biaya Pajak</th>
                                                <th scope="col">Ket.</th>
                                                <th scope="col">Kasir</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center" id="tableBody">
                                            @foreach ($data as $event)
                                                @if ($event->kondisi == 'rusak')
                                                    @if ($event->baru == 'on')
                                                        <tr>
                                                            <td colspan="8"
                                                                class="bg-warning text-white fw-bold text-center">
                                                                NOTICE BARU
                                                            </td>
                                                            <td class="d-none"></td>
                                                            <td class="d-none"></td>
                                                            <td class="d-none"></td>
                                                            <td class="d-none"></td>
                                                            <td class="d-none"></td>
                                                            <td class="d-none"></td>


                                                        <tr>
                                                    @endif
                                                    <th scope="row">
                                                        <a href="#">{{ $event->no_notice }}</a>
                                                    </th>
                                                    <td colspan="5" class="bg-danger text-white text-center">
                                                        BATAL
                                                    </td>
                                                    <td class="d-none"></td>
                                                    <td class="d-none"></td>
                                                    <td class="d-none"></td>
                                                    <td class="d-none"></td>
                                                    <td class="d-none"></td>

                                                    </tr>
                                                @elseif ($event->baru == 'on')
                                                    <tr>
                                                        <td colspan="8"
                                                            class="bg-warning text-white fw-bold text-center">
                                                            NOTICE BARU
                                                        </td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>
                                                        <td class="d-none"></td>

                                                        {{-- <td class="d-none"></td>
                                                        <td class="d-none"></td> --}}
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">
                                                            <a href="#">{{ $event->no_notice }}</a>
                                                        </th>
                                                        <td>{{ $event->no_polisi }}</td>
                                                        <td>
                                                            {{ $event->nama }}
                                                        </td>
                                                        <td>{{ $event->alamat }}</td>
                                                        <td>
                                                            {{ formatrupiah($event->total_pajak) }}
                                                        </td>
                                                        <td>
                                                            {{ $event->keterangan }}
                                                        </td>
                                                        <td>
                                                            {{ $event->user->nama_kasir }}
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <th scope="row">
                                                            <a href="#">{{ $event->no_notice }}</a>
                                                        </th>
                                                        <td>{{ $event->no_polisi }}</td>
                                                        <td>
                                                            {{ $event->nama }}
                                                        </td>
                                                        <td>{{ $event->alamat }}</td>
                                                        <td>
                                                            {{ formatrupiah($event->total_pajak) }}
                                                        </td>
                                                        <td>
                                                            {{ $event->keterangan }}
                                                        </td>
                                                        <td>
                                                            {{ $event->user->nama_kasir }}
                                                        </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    {{-- <x-modal class="modal fade" id="modaltambah">
        <x-slot:notice>{{ $noticetambah }}</x-slot:notice>
        <x-slot:tanggal>{{ $selectedDate }}</x-slot:tanggal>
        @if (auth()->user()->role == 1)
            <x-slot:id>{{ $id }}</x-slot:id>
        @else
        @endif
    </x-modal> --}}
    <x-1 class="modal fade" id="modalEdit">

    </x-1>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Tambahkan di bagian <head> atau di bagian bawah sebelum </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function filterByDate() {
        var selectedDate = document.getElementById('dateInput').value;
        window.location.href = '?date=' + selectedDate;
    }

    function exportExcelByDate() {
        var selectedDate = document.getElementById('dateInput').value;
        window.location.href = '/admin/laporan/' + 'excel?date=' + selectedDate;
    }

    function exportExcelByMonth() {
        var selectedDate = document.getElementById('dateInput').value;
        window.location.href = '/admin/laporan/perbulan/' + 'excel?date=' + selectedDate;
    }

    function exportExcelByYear() {
        var selectedDate = document.getElementById('dateInput').value;
        window.location.href = '/admin/laporan/pertahun/' + 'excel?date=' + selectedDate;
    }

    // Mendeteksi perubahan pada input date dan menerapkan filter
    document.getElementById('dateInput').addEventListener('change', function() {
        filterByDate();
    });


    // Mendeteksi perubahan pada input date ketika tombol Enter ditekan
    document.getElementById('dateInput').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            filterByDate();
        }
    });
    $(document).keydown(function(event) {
        if (event.key === 'F2') {
            $('#modaltambah').modal('show');
        }
    });
    $('#modaltambah').on('shown.bs.modal', function() {
        $('#nopol').focus();
    });
</script>
@if (request()->is('admin/laporan'))
    <script>
        document.getElementById('download').addEventListener('click', function() {
            exportExcelByDate();
        });
    </script>
@elseif (request()->is('admin/laporan/perbulan'))
    <script>
        document.getElementById('download').addEventListener('click', function() {
            exportExcelByMonth();
        });
    </script>
@else
    <script>
        document.getElementById('download').addEventListener('click', function() {
            exportExcelByYear();
        });
    </script>
@endif
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif
<script>
    // buat sweet alert ketika tombol id=delete ditekan 
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        var link = $(this).attr('href');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        })
    });
</script>
