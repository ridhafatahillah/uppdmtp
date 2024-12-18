<!DOCTYPE html>
<html lang="en">

<x-head><x-slot:judul>
        {{ $judul }}
    </x-slot:judul></x-head>

<body>


    <x-header>

    </x-header>
    <x-sidebar></x-sidebar>


    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Rekap Pemakaian Notes</h1>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Total Notes <span>| {{ $bulanIni }}</span>
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $jumlahData }} Notes</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card info-card pajak-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Total Pajak <span>| {{ $bulanIni }}</span>
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ formatRupiah($totalPajak) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card info-card rusak-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Notes Rusak <span>| {{ $bulanIni }}</span>
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-exclamation-triangle"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $noticeBatal }} Notes</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Sales -->
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="card-title
                                        ">Notes</h5>
                                        </div>
                                        <div class="col-6 d-flex justify-content-end align-items-center ">
                                            <input type="month" class="form-control form-control-sm ms-2 "
                                                style="width: 150px;" id="monthInput" value={{ $bulan }}>
                                            <a class="float-end text-warning-subtle ms-2 fs-4" type="button"
                                                id='download'><i class="bi bi-file-earmark-spreadsheet-fill"></i></a>
                                        </div>
                                    </div>
                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">Tanggal</th>
                                                <th scope="col" class="text-center">Notes Awal</th>
                                                <th scope="col" class="text-center">Notes Akhir</th>
                                                <th scope="col" class="text-center">Notes Rusak</th>
                                                <th scope="col" class="text-center">Total Notes</th>
                                                <th scope="col" class="text-center">Sisa Saldo</th>
                                                <th scope="col" class="text-center">No.Notes Rusak</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @foreach ($dataPerHari as $items)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ $items->tanggal }}</td>
                                                    <td class="text-center">{{ $items->notes_awal }}</td>
                                                    <td class="text-center">{{ $items->notes_akhir }}</td>
                                                    <td class="text-center">{{ $items->notes_batal }}</td>
                                                    <td class="text-center">{{ $items->total_notes }}</td>
                                                    <td class="text-center">{{ formatRupiah($items->total_pajak) }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ collect($items->no_notice_rusak)->implode(',') }}</td>
                                                </tr>
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
</body>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script>
    function filterByMonth() {
        var selectedMonth = document.getElementById('monthInput').value;
        window.location.href = '?month=' + selectedMonth;
    }
    document.getElementById('monthInput').addEventListener('change', function() {
        filterByMonth();
    });

    document.getElementById('download').addEventListener('click', function() {
        var selectedMonth = document.getElementById('monthInput').value;
        window.location.href = '/export_rekap?month=' + selectedMonth + '&id={{ auth()->user()->id }}';
    });
</script>
