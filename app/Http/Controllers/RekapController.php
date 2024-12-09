<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Exports\ExportRekap;
use App\Models\noticeModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class RekapController extends Controller
{
    public function index(Request $request)
    {
        $model = new noticeModels();
        $userName = Auth::user()->name;

        // Mengatur nama tabel secara dinamis
        $model->setTable($userName);

        $bulan = $request->input('month', date('Y-m'));
        $bulanIni = Carbon::parse($bulan)->locale('id')->translatedFormat('F Y');
        $dataPerHari = $model::selectRaw('tanggal, sum(total_pajak) as total_pajak, count(*) as total_notes, 
        max(no_notice) as notes_akhir, min(no_notice) as notes_awal, count(case when kondisi = "rusak" then 1 end) as notes_batal')
            ->whereYear('tanggal', Carbon::parse($bulan)->year)
            ->whereMonth('tanggal', Carbon::parse($bulan)->month)
            ->groupBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        // dd($dataPerHari);
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
            'rekap',
            compact('data', 'jumlahData', 'noticeBatal', 'totalPajak', 'dataPerHari', 'bulanIni', 'bulan')
        )->with('judul', 'Rekap | SIPSKPD',);
    }
    public function export_rekap(Request $request)
    {
        $selectedmonth = $request->input('month', date('Y-m'));
        $bulan = getIndonesianMonth(Carbon::parse($selectedmonth)->format('m'));
        return Excel::download(new ExportRekap, 'REKAP' . $bulan . '.xlsx');
    }
    //     $data = $model::whereYear('tanggal', Carbon::parse($bulan)->year)
    //         ->whereMonth('tanggal', Carbon::parse($bulan)->month)
    //         ->get();
    //     // dd($data);
    //     $jumlahData = $data->count();
    //     $noticeBatal = $data->whereNull('nama')->count();
    //     $totalPajak = $data->sum('total_pajak');

    //     return view(
    //         'rekap',
    //         compact('data', 'jumlahData', 'noticeBatal', 'totalPajak', 'dataPerHari')
    //     )->with('judul', 'Rekapitulasi Data',);
    // }
}
