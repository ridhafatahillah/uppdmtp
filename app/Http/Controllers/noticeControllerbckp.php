<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Exports\ExportData;
use App\Models\noticeModels;
use Illuminate\Http\Request;
use App\Models\noticeModels2;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\TestStatus\Notice;

class noticeController extends Controller
{
    public function index(Request $request)
    {

        $noticetambah = noticeModels::max('no_notice') + 1;
        $selectedDate = $request->input('date', date('Y-m-d'));
        $data = noticeModels::whereDate('tanggal', $selectedDate)->get();
        $jumlahdata = noticeModels::whereDate('tanggal', $selectedDate)->count();
        $noticebatal = noticeModels::whereDate('tanggal', $selectedDate)->whereNull('nama')->count();
        $totalpajak = noticeModels::whereDate('tanggal', $selectedDate)->sum('total_pajak');
        // }
        // dd nama user yang sedang login;
        return view(
            'dashboard',
            compact('data', 'jumlahdata', 'noticebatal', 'totalpajak', 'noticetambah', 'selectedDate'),
            ['judul' => 'Samsat Martapura - Dashboard']
        );
    }

    public function storeData(Request $request)
    {
        $request->validate([
            'no_notice' => 'required',
        ]);
        $data = [
            'tanggal' => $request->tanggal,
            'no_notice' => $request->no_notice,
            'no_polisi' => $request->nopol,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'total_pajak' => $request->total_pajak,
            'keterangan' => $request->keterangan,
        ];
        noticeModels::create($data);

        return redirect('/')->with('status', 'Data berhasil ditambahkan!')->withErrors($request);
    }

    function export_excel(Request $request)
    {
        $selectedDate = $request->input('date', date('Y m d'));
        $dateConvert = Carbon::parse($selectedDate)->format('d') . ' ' . getIndonesianMonth(Carbon::parse($selectedDate)->format('m'));
        return Excel::download(new ExportData,  $dateConvert . '.xlsx');
    }

    function updateData(Request $request)
    {
        $data = [
            'tanggal' => $request->tanggal,
            'no_notice' => $request->no_notice,
            'no_polisi' => $request->nopol,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'total_pajak' => $request->total_pajak,
            'keterangan' => $request->keterangan,
            'baru' => $request->baru,
        ];
        noticeModels::where('no_notice', $request->no_notice)->update($data);
        return redirect('/')->with('status', 'Data berhasil diubah!');
    }
    function admin()
    {
        $data = noticeModels::all();
        return view('admin', compact('data'), ['judul' => 'Samsat Martapura - Admin']);
    }

    // function exportview(Request $request)
    // {
    //     $selectedDate = $request->input('date', date('Y-m-d'));
    //     return Excel::download(new ExportData, 'Notice' . $selectedDate . '.xlsx');
    // }
}
