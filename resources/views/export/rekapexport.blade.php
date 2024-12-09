<table>
    <thead>
        <tr>
            <th colspan="10" style="text-align: center; font-size: 16px; font-weight: bold">LAPORAN PEMAKAIAN SURAT
                KETETAPAN PAJAK DAERAH </th>
        </tr>
        <tr>
            <th colspan="10" style="text-align: center; font-size: 16px; font-weight: bold">UNIT PELAYANAN PENDAPATAN
                DAERAH MARTAPURA</th>
        </tr>
        <tr>
            <th colspan="10" style="text-align: center; font-size: 16px; font-weight: bold">TAHUN {{ date('Y') }}
            </th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="2" style="font-weight: bold; text-align: center;">{{ $bulanIni }}</th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight: bold; text-align: center;">{{ Auth::user()->nama }}</th>
            {{-- <th colspan="2"></th> --}}
        </tr>
        <tr>
            <th rowspan="2">
                NO
            </th>
            <th rowspan="2">
                TANGGAL
            </th>
            <th colspan="2">
                NO NOTES
            </th>
            <th rowspan="2">
                NOTES RUSAK
            </th>
            <th rowspan="2">
                TOTAL NOTES
            </th>
            <th rowspan="2">
                SISA SALDO
            </th>
            <th rowspan="2">
                KET.
            </th>
            <th rowspan="2">
                NO.NOTES RUSAK
            </th>
            <th rowspan="2">
                KET.NOTES RUSAK
            </th>
        </tr>
        <tr>
            <th>
                NOTES AWAL
            </th>
            <th>
                NOTES AKHIR
            </th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($dataPerHari as $items)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ formatTanggal($items->tanggal) }}</td>
                <td>{{ $items->notes_awal }}</td>
                <td>{{ $items->notes_akhir }}</td>
                <td>{{ $items->notes_batal }}</td>
                <td>{{ $items->total_notes }}</td>
                <td>{{ formatRupiah($items->total_pajak) }}</td>
                <td></td>
                <td class="text-center">
                    {{ collect($items->no_notice_rusak)->implode(',') }}</td>
                <td>N/A</td>

            </tr>
        @endforeach
        {{-- {{ dd($dataPerHari) }} --}}
    </tbody>
    {{-- {{ dd($dataPerHari) }} --}}
</table>
