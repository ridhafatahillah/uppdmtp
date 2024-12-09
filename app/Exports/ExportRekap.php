<?php

namespace App\Exports;

use App\Models\noticeModels;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportRekap implements FromView, ShouldAutoSize, WithStyles
{
    public function styles(Worksheet $sheet)
    {
        // Apply borders to the entire range of data
        $sheet->getStyle('A7:J' . ($sheet->getHighestRow()))
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ])->getAlignment()->setHorizontal('center')->setVertical('center');

        return [];
        // buat th rata tengah horizontal dan vertical
    }


    public function view(): View
    {
        $model = new noticeModels();
        $userName = Auth::user()->name;

        // Mengatur nama tabel secara dinamis
        $model->setTable($userName);

        $bulan = Request::input('month', date('Y-m'));
        $bulanIni = Carbon::parse($bulan)->locale('id')->translatedFormat('F Y');
        $dataPerHari = $model::selectRaw('tanggal, sum(total_pajak) as total_pajak, count(*) as total_notes, 
        max(no_notice) as notes_akhir, min(no_notice) as notes_awal, count(case when kondisi = "rusak" then 1 end) as notes_batal')
            ->whereYear('tanggal', Carbon::parse($bulan)->year)
            ->whereMonth('tanggal', Carbon::parse($bulan)->month)
            ->groupBy('tanggal')
            ->get()
            ->keyBy('tanggal');


        $data = $model::whereYear('tanggal', Carbon::parse($bulan)->year)
            ->whereMonth('tanggal', Carbon::parse($bulan)->month)
            ->get();
        $rusakData = $model::select('tanggal', 'no_notice')
            ->where('kondisi', 'rusak')
            ->whereYear('tanggal', Carbon::parse($bulan)->year)
            ->whereMonth('tanggal', Carbon::parse($bulan)->month)
            ->get()
            ->groupBy('tanggal');
        // dd($dataPerHari);
        // dd($data);
        $jumlahData = $data->count();
        $noNoticeRusak = $data->where('kondisi', 'rusak')->pluck('no_notice');
        $noticeBatal = $data->where('kondisi', 'rusak')->count();
        $totalPajak = $data->sum('total_pajak');
        $dataPerHari->transform(function ($item) use ($rusakData) {
            $tanggal = $item->tanggal;

            // Ambil no_notice rusak untuk tanggal yang sesuai
            $noNoticeRusak = $rusakData->get($tanggal, collect())->pluck('no_notice');

            // Tambahkan no_notice rusak ke data agregat
            $item->no_notice_rusak = $noNoticeRusak;

            return $item;
        });
        // dd($dataPerHari);
        return view(
            'export.rekapexport',
            compact('data', 'jumlahData', 'noticeBatal', 'totalPajak', 'dataPerHari', 'bulanIni')
        );
    }
}
