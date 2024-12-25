<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\noticeModels;
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

class ExportLaporanBulanan implements FromView, ShouldAutoSize, WithStyles, WithTitle
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
        $sheet->getStyle('A5:J' . ($sheet->getHighestRow()))
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
        $selectedDate = Request::input('date', date('Y-m'));
        $total = noticeModels::whereYear('tanggal', Carbon::parse($selectedDate)->year)
            ->whereMonth('tanggal', Carbon::parse($selectedDate)->month)
            ->sum('total_pajak');
        $data = noticeModels::whereYear('tanggal', Carbon::parse($selectedDate)->year)
            ->whereMonth('tanggal', Carbon::parse($selectedDate)->month)
            ->get();
        // dd($nama);
        // dd($data);

        return view('export.laporanbulanan', [
            'data' => $data,
            'total' => $total,
            'tanggal' => $selectedDate
        ]);
    }


    public function title(): string
    {
        $selectedDate = Request::input('date', date('d m Y'));;
        return  $selectedDate;
    }
}
