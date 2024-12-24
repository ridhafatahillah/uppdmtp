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

class ExportLaporan implements FromView, ShouldAutoSize, WithStyles, WithTitle
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
        $sheet->getStyle('A5:I' . ($sheet->getHighestRow()))
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
        $total = noticeModels::whereDate('tanggal', $selectedDate)

            ->sum('total_pajak');
        $data = noticeModels::whereDate('tanggal', $selectedDate)
            ->get();
        // dd($nama);

        return view('export.laporanharian', [
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
