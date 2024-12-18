<?php

namespace App\Exports;

use App\Models\noticeModels;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportData implements FromView, ShouldAutoSize, WithStyles, WithTitle
{
    // public function columnWidths(): array
    // {
    //     return [
    //         'D' => 70,
    //     ];
    // }

    public function styles(Worksheet $sheet)
    {
        // Apply borders to the entire range of data
        $sheet->getStyle('A6:H' . ($sheet->getHighestRow()))
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);

        return [
            // You can return additional styles here if needed
        ];
    }

    public function view(): View
    {
        $selectedDate = Request::input('date', date('d m Y'));
        $selectedKasir = Request::input('id', Auth::user()->id);
        $total = noticeModels::whereDate('tanggal', $selectedDate)
            ->where('users_id', $selectedKasir)
            ->sum('total_pajak');
        $data = noticeModels::whereDate('tanggal', $selectedDate)
            ->where('users_id', $selectedKasir)
            ->get();
        $kasir = User::where('id', $selectedKasir)->first();
        $nama = $kasir->nama;
        $nama_kasir = $kasir->nama_kasir;

        // dd($nama);

        return view('export.export', [
            'data' => $data,
            'total' => $total,
            'nama' => $nama,
            'nama_kasir' => $nama_kasir
        ]);
    }


    public function title(): string
    {
        $selectedDate = Request::input('date', date('d m Y'));;
        return  $selectedDate;
    }
}
