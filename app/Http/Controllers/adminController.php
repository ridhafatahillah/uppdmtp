<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Exports\ExportData;
use App\Exports\ExportRekap;
use App\Models\noticeModels;
use Illuminate\Http\Request;
use App\Exports\ExportLaporan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportLaporanBulanan;
use App\Exports\ExportLaporanTahunan;

class adminController extends Controller
{
    public function index()
    {
        $judul = "Admin | SIPSPKD";
        $users = User::where('role', 0)
            ->orderBy('name', 'asc')
            ->get();
        $totalNotes = noticeModels::count();
        $totalPajak = noticeModels::sum('total_pajak');
        $notesRusak = noticeModels::where('kondisi', 'rusak')->count();
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now();
        $kasirPerHari = noticeModels::selectRaw('users_id, tanggal, sum(total_pajak) as total_pajak')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('users_id', 'tanggal')
            ->with('user')
            ->get()
            ->groupBy('users_id');


        $dates = [];
        foreach ($startDate->daysUntil($endDate) as $date) {
            $dates[] = $date->format('Y-m-d');
        }


        $chartData = [];
        foreach ($kasirPerHari as $usersID => $items) {
            $userData = [
                'name' => $items->first()->user->name,
                'data' => [],
            ];


            foreach ($dates as $date) {
                $pajakPerHari = $items->firstWhere('tanggal', $date);
                $userData['data'][] = $pajakPerHari ? (float) $pajakPerHari->total_pajak : 0;
            }

            $chartData[] = $userData;
        }

        return view('admin/admin', compact('judul', 'users', 'totalNotes', 'totalPajak', 'notesRusak', 'dates', 'kasirPerHari', 'chartData'));
    }

    public function laporan(Request $request)
    {
        $judul = "Perhari";
        $selectedDate = $request->input('date', date('Y-m-d'));
        $selectedDates = Carbon::parse($selectedDate)->locale('id')->translatedFormat('d F Y');

        $users = User::where('role', 0)
            ->orderBy('name', 'asc')
            ->get();

        $data = noticeModels::whereDate('tanggal', $selectedDate)->with('user')->get();
        $kasir = User::all();
        $totalNotes = noticeModels::whereDate('tanggal', $selectedDate)
            ->count();
        $totalPajak = noticeModels::whereDate('tanggal', $selectedDate)
            ->sum('total_pajak');
        $notesRusak = noticeModels::whereDate('tanggal', $selectedDate)
            ->where('kondisi', 'rusak')->count();
        $noticetambahh = noticeModels::whereDate('tanggal', $selectedDate)
            ->max('no_notice');
        if ($noticetambahh) {
            $noticetambah = str_pad((int) $noticetambahh + 1, strlen($noticetambahh), '0', STR_PAD_LEFT);
        } else {
            $noticetambah = str_pad(1, 8, '0', STR_PAD_LEFT);
        }

        return view('admin/laporan', compact('judul', 'users', 'data', 'kasir', 'totalNotes', 'totalPajak', 'notesRusak', 'selectedDate', 'selectedDates', 'noticetambah'));
    }

    public function laporan_perbulan(Request $request)
    {
        $judul = "Perbulan";
        $selectedDate = $request->input('date', date('Y-m'));
        $selectedDates = Carbon::parse($selectedDate)->locale('id')->translatedFormat('F Y');

        $users = User::where('role', 0)
            ->orderBy('name', 'asc')
            ->get();

        $data = noticeModels::whereYear('tanggal', Carbon::parse($selectedDate)->year)
            ->whereMonth('tanggal', Carbon::parse($selectedDate)->month)
            ->with('user')
            ->get();
        $kasir = User::all();
        $totalNotes = noticeModels::whereYear('tanggal', Carbon::parse($selectedDate)->year)
            ->whereMonth('tanggal', Carbon::parse($selectedDate)->month)
            ->count();
        $totalPajak = noticeModels::whereYear('tanggal', Carbon::parse($selectedDate)->year)
            ->whereMonth('tanggal', Carbon::parse($selectedDate)->month)
            ->sum('total_pajak');
        $notesRusak = noticeModels::whereYear('tanggal', Carbon::parse($selectedDate)->year)
            ->whereMonth('tanggal', Carbon::parse($selectedDate)->month)
            ->where('kondisi', 'rusak')->count();

        return view('admin/laporan', compact('judul', 'users', 'data', 'kasir', 'totalNotes', 'totalPajak', 'notesRusak', 'selectedDate', 'selectedDates'));
    }

    public function laporan_pertahun(Request $request)
    {
        $judul = "Pertahun";

        $selectedDate = $request->input('date', date('Y'));

        $selectedDate = Carbon::createFromFormat('Y', $selectedDate);

        $selectedDates = $selectedDate->locale('id')->translatedFormat('Y');


        $year = $selectedDate->year;


        $users = User::where('role', 0)
            ->orderBy('name', 'asc')
            ->get();

        // Ambil data notices yang sesuai dengan tahun yang dipilih
        $data = noticeModels::whereYear('tanggal', $year)
            ->with('user') // Load relasi 'user' untuk data notices
            ->get();

        // Ambil data kasir (semua pengguna)
        $kasir = User::all();

        // Total jumlah notices untuk tahun yang dipilih
        $totalNotes = noticeModels::whereYear('tanggal', $year)
            ->count();

        // Total pajak untuk tahun yang dipilih
        $totalPajak = noticeModels::whereYear('tanggal', $year)
            ->sum('total_pajak');

        // Jumlah notices rusak untuk tahun yang dipilih
        $notesRusak = noticeModels::whereYear('tanggal', $year)
            ->where('kondisi', 'rusak')
            ->count();
        return view('admin/laporan', compact('judul', 'users', 'data', 'kasir', 'totalNotes', 'totalPajak', 'notesRusak', 'selectedDate', 'selectedDates'));
    }

    public function kasir($id, Request $request)
    {
        // dd($id);
        $judul = "Admin";
        $selectedDate = $request->input('date', date('Y-m-d'));
        $selectedDates = Carbon::parse($selectedDate)->locale('id')->translatedFormat('d F Y');

        $users = User::where('role', 0)
            ->orderBy('name', 'asc')
            ->get();

        $data = noticeModels::where('users_id', $id)->whereDate('tanggal', $selectedDate)->get();
        $kasir = User::where('id', $id)->first();
        $totalNotes = noticeModels::where('users_id', $id)
            ->whereDate('tanggal', $selectedDate)
            ->count();
        $totalPajak = noticeModels::where('users_id', $id)
            ->whereDate('tanggal', $selectedDate)
            ->sum('total_pajak');
        $notesRusak = noticeModels::where('users_id', $id)
            ->whereDate('tanggal', $selectedDate)
            ->where('kondisi', 'rusak')->count();
        $noticetambahh = noticeModels::where('users_id', $id)
            ->whereDate('tanggal', $selectedDate)
            ->max('no_notice');
        if ($noticetambahh) {
            $noticetambah = str_pad((int) $noticetambahh + 1, strlen($noticetambahh), '0', STR_PAD_LEFT);
        } else {
            $noticetambah = str_pad(1, 8, '0', STR_PAD_LEFT);
        }
        return view('admin/adminkasir', compact('judul', 'id', 'users', 'data', 'kasir', 'totalNotes', 'totalPajak', 'notesRusak', 'selectedDate', 'selectedDates', 'noticetambah'));
    }

    public function rekap(Request $request)
    {

        $modelRaw = new noticeModels();
        $id = $request->input('id');
        $kasir = User::where('id', $id)->first();
        // dd($kasir);
        $users = User::where('role', 0)
            ->orderBy('name', 'asc')
            ->get();
        $bulan = $request->input('month', date('Y-m'));
        $bulanIni = Carbon::parse($bulan)->locale('id')->translatedFormat('F Y');
        $dataPerHari = $modelRaw::selectRaw('tanggal, sum(total_pajak) as total_pajak, count(*) as total_notes, 
        max(no_notice) as notes_akhir, min(no_notice) as notes_awal, count(case when kondisi = "rusak" then 1 end) as notes_batal')
            ->whereYear('tanggal', Carbon::parse($bulan)->year)
            ->whereMonth('tanggal', Carbon::parse($bulan)->month)
            ->groupBy('tanggal')
            ->where('users_id', $id)
            ->get()
            ->keyBy('tanggal');


        $data = $modelRaw::whereYear('tanggal', Carbon::parse($bulan)->year)
            ->whereMonth('tanggal', Carbon::parse($bulan)->month)
            ->where('users_id', $id)
            ->get();
        $rusakData = $modelRaw::select('tanggal', 'no_notice')
            ->where('kondisi', 'rusak')
            ->where('users_id', $id)
            ->whereYear('tanggal', Carbon::parse($bulan)->year)
            ->whereMonth('tanggal', Carbon::parse($bulan)->month)
            ->get()
            ->groupBy('tanggal');
        $jumlahData = $data->count();
        $noNoticeRusak = $data->where('kondisi', 'rusak')->pluck('no_notice');
        $noticeBatal = $data->where('kondisi', 'rusak')->count();
        $totalPajak = $data->sum('total_pajak');
        $dataPerHari->transform(function ($item) use ($rusakData) {
            $tanggal = $item->tanggal;

            $noNoticeRusak = $rusakData->get($tanggal, collect())->pluck('no_notice');

            $item->no_notice_rusak = $noNoticeRusak;

            return $item;
        });

        return view(
            'admin/adminrekap',
            compact('data', 'jumlahData', 'noticeBatal', 'totalPajak', 'kasir', 'dataPerHari', 'bulanIni', 'bulan', 'users')
        )->with('judul', 'Rekap | SIPSKPD',);
    }

    public function akun()
    {
        $judul = "Admin";
        $usersAkun = User::all()->sortBy('name');
        $users = User::where('role', 0)
            ->orderBy('name', 'asc')
            ->get();
        $kasirCount = User::where('role', 0)->count();
        $adminCount = User::where('role', 1)->count();
        $all = User::all()->count();
        return view('admin/akun', compact('judul', 'users', 'kasirCount', 'adminCount', 'all', 'usersAkun'));
    }

    public function tambahAkun(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => [
                'required',
                'unique:users,name',
            ],
            'password' => 'required',
        ]);

        $hashedPassword = bcrypt($request->password);
        $dataa = [
            'nama' => $request->nama,
            'name' => $request->username,
            'nama_kasir' => $request->nama_kasir,
            'password' => $hashedPassword,
            'role' => 0,
        ];

        $user = User::create($dataa);
        if ($user) {
            return redirect()->back()->with('success', 'Akun berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Akun gagal ditambahkan');
        }
    }
    public function editAkun(Request $request)
    {
        $data = [
            'nama' => $request->namaEdit,
            'name' => $request->usernameEdit,
            'nama_kasir' => $request->nama_kasirEdit,
            'role' => 0,
        ];



        $user = User::where('id', $request->idEdit)->update($data);
        if ($user) {
            return redirect()->back()->with('success', 'Akun berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Akun gagal diubah');
        }
    }

    public function hapusAkun($id)
    {

        noticeModels::where('users_id', $id)->delete();


        $user = User::where('id', $id)->delete();
        if ($user) {
            return redirect()->back()->with('success', 'Akun berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Akun gagal dihapus');
        }
    }


    public function gantiPassword(Request $request, $id)
    {

        $user = User::findOrFail($id);


        $user->password = bcrypt($request->password);
        $user->save();


        return response()->json(['message' => 'Password berhasil diperbarui!'], 200);
    }


    public function admin_excel(Request $request)
    {
        $nama_kasir = User::where('id', $request->id)->first()->nama;
        $selectedDate = $request->input('date', date('Y m d'));
        $dateConvert = Carbon::parse($selectedDate)->format('d') . ' ' . getIndonesianMonth(Carbon::parse($selectedDate)->format('m'));
        return Excel::download(new ExportData, $nama_kasir . '-' .  $dateConvert . '.xlsx');
    }

    public function rekap_excel(Request $request)
    {
        // dd($request->all());
        $nama_kasir = User::where('id', $request->id)->first()->nama;
        $selectedmonth = $request->input('month', date('Y-m'));
        $bulan = getIndonesianMonth(Carbon::parse($selectedmonth)->format('m'));
        return Excel::download(new ExportRekap, $nama_kasir . ' ' . 'REKAP ' . $bulan . '.xlsx');
    }

    public function laporan_excel(Request $request)
    {
        $selectedDate = $request->input('date', date('Y-m-d'));
        $dateConvert = Carbon::parse($selectedDate)->format('d') . ' ' . getIndonesianMonth(Carbon::parse($selectedDate)->format('m'));
        return Excel::download(new ExportLaporan, 'Laporan ' . $dateConvert . '.xlsx');
    }

    public function laporan_excel_perbulan(Request $request)
    {
        $selectedDate = $request->input('date', date('Y-m'));
        $dateConvert = getIndonesianMonth(Carbon::parse($selectedDate)->format('m')) . ' ' . Carbon::parse($selectedDate)->format('Y');
        return Excel::download(new ExportLaporanBulanan, 'Laporan ' . $dateConvert . '.xlsx');
    }

    public function laporan_excel_pertahun(Request $request)
    {
        $selectedDate = $request->input('date', date('Y'));
        $dateConvert = Carbon::parse($selectedDate)->format('Y');
        return Excel::download(new ExportLaporanTahunan, 'Laporan ' . $dateConvert . '.xlsx');
    }





    public function profile()
    {
        $judul = "Admin";
        $users = User::where('role', 0)
            ->orderBy('name', 'asc')
            ->get();
        return view('admin/profile', compact('judul', 'users'));
    }

    public function changePassword(Request $request)
    {

        $request->validate([
            'password' => 'required',
            'newpassword' => 'required',
            'renewpassword' => 'required|same:newpassword',
        ], [
            'password.required' => 'Password lama harus diisi',
            'newpassword.required' => 'Password baru harus diisi',
            'renewpassword.required' => 'Konfirmasi password baru harus diisi',
            'renewpassword.same' => 'Password baru dan konfirmasi password baru harus sama',
        ]);
        $user = User::where('id', $request->id)->first();
        if (password_verify($request->password, $user->password)) {
            $user->password = bcrypt($request->newpassword);
            $user->save();
            return redirect()->back()->with('success', 'Password berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Password lama salah');
        }
    }
}
