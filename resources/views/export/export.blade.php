<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>

<table>
    <thead>
        <tr>
            <th colspan="8" style="text-align: center; font-size: 16px; font-weight: bold">LAPORAN PEMAKAIAN SKPD </th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center; font-size: 16px; font-weight: bold">UPPD MARTAPURA</th>
        </tr>
        <tr></tr>
        <tr>
            <th style="text-align: center;">No</th>
            <th style="text-align: center;">Notice</th>
            <th colspan="2" style="text-align: center;"> No. Polisi</th>
            <th style="text-align: center;">Nama</th>
            <th style="text-align: center;">Alamat</th>
            <th style="text-align: center;">Biaya Pajak</th>
            <th style="text-align: center;">Ket.</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $event)
            @if ($event->kondisi == 'rusak')
                @if ($event->baru == 'on')
                    <tr>
                        <td colspan="8"
                            style="text-align: center; background-color: #ffc107; font-weight: bold; color: white;">
                            BARU
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ str_pad($event->no_notice, 7, '0', STR_PAD_LEFT) }}</td>
                    <td colspan="6"
                        style="text-align: center; background-color: #dc3545; font-weight: bold; color: white;">
                        BATAL
                    </td>
                </tr>
            @elseif ($event->baru == 'on')
                <tr>
                    <td colspan="8"
                        style="text-align: center; background-color: #ffc107; font-weight: bold; color: white;">
                        BARU
                    </td>
                </tr>
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $event->no_notice }}</td>
                    <td>DA</td>
                    <td>{{ $event->no_polisi }}</td>
                    <td>{{ $event->nama }}</td>
                    <td>{{ $event->alamat }}</td>
                    <td>
                        {{ formatRupiah($event->total_pajak) }}
                    </td>
                    <td>
                        {{ $event->keterangan }}
                    </td>
                </tr>
            @else
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ str_pad($event->no_notice, 7, '0', STR_PAD_LEFT) }}</td>
                    <td>DA</td>
                    <td>{{ $event->no_polisi }}</td>
                    <td>{{ $event->nama }}</td>
                    <td>{{ $event->alamat }}</td>
                    <td>
                        {{ formatRupiah($event->total_pajak) }}
                    </td>
                    <td>
                        {{ $event->keterangan }}
                    </td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td colspan="6" style="text-align: right; font-weight: bold;  text-align: center;">Total</td>
            <td style="font-weight: bold;">{{ formatrupiah($total) }}</td>
            <td></td>
        </tr>
    </tbody>
</table>
