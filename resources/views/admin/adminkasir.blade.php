<x-head>
    <x-slot:judul>
        {{ $kasir->nama }} | Notes
    </x-slot:judul>
</x-head>

<body>

    <x-header></x-header>
    {{-- buat x-sidebar dan kirimkan $users --}}
    <x-sidebar :users="$users" />
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ $kasir->nama }}</h1>
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

                                    {{-- buat 2 kolom bersampingan --}}
                                    <div class="row">
                                        <div class="col-4">
                                            <h5 class="card-title
                                        ">Kasir :
                                                {{ $kasir->nama_kasir }}</h5>
                                        </div>

                                        <div class="col-4 d-flex justify-content-center align-items-center mt-2 ">
                                            {{-- @if ($errors->any())
                                                <div class="alert alert-danger" style="width : 200px; height : 50px">
                                                    @foreach ($errors->all() as $error)
                                                        <p>No notice sudah ada</p>
                                                    @endforeach
                                                </div>
                                            @endif --}}

                                        </div>

                                        <div class="col-4 d-flex justify-content-end align-items-center ">
                                            <input type="date" class="form-control form-control-sm ms-2 "
                                                style="width: 150px;" id="dateInput" value={{ $selectedDate }}>
                                            @if ($selectedDate == date('Y-m-d'))
                                                <a class="float-end text-warning ms-2 fs-4" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#modaltambah"><i
                                                        class="bi bi-plus-square-fill"></i></a>
                                                <x-modal class="modal fade" id="modaltambah">
                                                    <x-slot:notice>{{ $noticetambah }}</x-slot:notice>
                                                    <x-slot:tanggal>{{ $selectedDate }}</x-slot:tanggal>
                                                    @if (auth()->user()->role == 1)
                                                        <x-slot:id>{{ $id }}</x-slot:id>
                                                    @else
                                                    @endif
                                                </x-modal>
                                            @else
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
                                                <th scope="col">Edit</th>
                                                <th scope="col">Hapus</th>


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
                                                    <td class="text-center">
                                                        <a type="button" data-bs-toggle="modal"
                                                            data-bs-target="#modalEdit"
                                                            update="updateData/{{ $event->id }}"
                                                            id1 = "{{ $event->id }}"
                                                            tanggal="{{ $event->tanggal }}"
                                                            no-notice="{{ $event->no_notice }}"
                                                            no-polisi="{{ $event->no_polisi }}"
                                                            nama="{{ $event->nama }}" alamat="{{ $event->alamat }}"
                                                            ket="{{ $event->keterangan }}"
                                                            total-pajak="{{ $event->total_pajak }}"
                                                            kondisi="{{ $event->kondisi }}"
                                                            baru="{{ $event->baru }}"><i
                                                                class="bi bi-pencil-square"></i></a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a type="button"
                                                            href="delete/{{ $event->id }}/{{ $event->tanggal }}"
                                                            id="delete"><i class="bi bi-trash text-dark"></i></a>
                                                    </td>
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
                                                        <td class="d-none"></td>

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
                                                        <td class="text-center">
                                                            <a type="button" data-bs-toggle="modal"
                                                                data-bs-target="#modalEdit"
                                                                update="updateData/{{ $event->id }}"
                                                                id1 = "{{ $event->id }}"
                                                                no-notice="{{ $event->no_notice }}"
                                                                no-polisi="{{ $event->no_polisi }}"
                                                                tanggal="{{ $event->tanggal }}"
                                                                nama="{{ $event->nama }}"
                                                                alamat="{{ $event->alamat }}"
                                                                ket="{{ $event->keterangan }}"
                                                                total-pajak="{{ $event->total_pajak }}"
                                                                kondisi="{{ $event->kondisi }}"
                                                                baru="{{ $event->baru }}"><i
                                                                    class="bi bi-pencil-square"></i></a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a type="button"
                                                                href="delete/{{ $event->id }}/{{ $event->tanggal }}"
                                                                id="delete"><i
                                                                    class="bi bi-trash text-dark"></i></a>
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
                                                        <td class="text-center">
                                                            <a type="button" data-bs-toggle="modal"
                                                                data-bs-target="#modalEdit"
                                                                update="updateData/{{ $event->id }}"
                                                                id1 = "{{ $event->id }}"
                                                                tanggal="{{ $event->tanggal }}"
                                                                no-notice="{{ $event->no_notice }}"
                                                                no-polisi="{{ $event->no_polisi }}"
                                                                nama="{{ $event->nama }}"
                                                                alamat="{{ $event->alamat }}"
                                                                ket="{{ $event->keterangan }}"
                                                                total-pajak="{{ $event->total_pajak }}"
                                                                kondisi="{{ $event->kondisi }}"
                                                                baru="{{ $event->baru }}"><i
                                                                    class="bi bi-pencil-square"></i></a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a type="button"
                                                                href="delete/{{ $event->id }}/{{ $event->tanggal }}"
                                                                id="delete"><i
                                                                    class="bi bi-trash text-dark"></i></a>
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
        window.location.href = '/admin/' + 'excel?date=' + selectedDate + '&id=' + {{ $kasir->id }};
    }

    // Mendeteksi perubahan pada input date dan menerapkan filter
    document.getElementById('dateInput').addEventListener('change', function() {
        filterByDate();
    });

    document.getElementById('download').addEventListener('click', function() {
        exportExcelByDate();
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
@if ($errors->has('no_notice'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No Notes sudah ada!',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif
@if ($errors->has('total_pajak'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Biaya pajak tidak boleh minus',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif
