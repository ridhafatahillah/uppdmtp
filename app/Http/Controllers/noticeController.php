<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Exports\ExportData;
use App\Models\noticeModels;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class noticeController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan user ID dan nama
        $userId = Auth::user()->id;
        $userName = Auth::user()->name;

        // Mengatur tanggal yang dipilih atau default ke hari ini
        $selectedDate = $request->input('date', date('Y-m-d'));
        $selectedDates = Carbon::parse($selectedDate)->locale('id')->translatedFormat('d F Y');

        // Query berdasarkan tanggal dan user ID
        $noticetambahh = noticeModels::where('users_id', $userId)
            ->whereDate('tanggal', $selectedDate)
            ->max('no_notice');

        $data = noticeModels::where('users_id', $userId)
            ->whereDate('tanggal', $selectedDate)
            ->get();

        $jumlahdata = noticeModels::where('users_id', $userId)
            ->whereDate('tanggal', $selectedDate)
            ->count();

        $noticebatal = noticeModels::where('users_id', $userId)
            ->whereDate('tanggal', $selectedDate)
            ->where('kondisi', 'rusak')
            ->count();

        $totalpajak = noticeModels::where('users_id', $userId)
            ->whereDate('tanggal', $selectedDate)
            ->sum('total_pajak');

        // Menentukan nilai increment untuk no_notice
        if ($noticetambahh) {
            $noticetambah = str_pad((int) $noticetambahh + 1, strlen($noticetambahh), '0', STR_PAD_LEFT);
        } else {
            $noticetambah = str_pad(1, 8, '0', STR_PAD_LEFT); // Misalnya, 8 digit
        }

        return view(
            'dashboard',
            compact('data', 'jumlahdata', 'noticebatal', 'totalpajak', 'noticetambah', 'selectedDate', 'selectedDates')
        )->with('judul', 'Dashboard | SIPSKPD');
    }

    public function storeData(Request $request)
    {
        // Validasi input untuk memastikan `no_notice` unik pada tanggal dan users_id yang sama
        $request->validate([
            'no_notice' => [
                'required',
                Rule::unique('kasir')->where(function ($query) use ($request) {
                    return $query->where('tanggal', $request->tanggal)
                        ->where('users_id', Auth::user()->id);
                }),
            ],
        ]);

        // Data yang akan disimpan
        $data = [
            'tanggal' => $request->tanggal,
            'no_notice' => $request->no_notice,
            'no_polisi' => $request->nopol,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'total_pajak' => $request->total_pajak,
            'keterangan' => $request->keterangan,
            'kondisi' => $request->kondisi,
            'baru' => $request->baru,
            'users_id' => Auth::user()->id,
        ];

        // Simpan data menggunakan model `noticeModels`
        noticeModels::create($data);

        // Redirect ke tanggal yang sama
        return redirect('/?date=' . $request->tanggal)->with('success', 'Data berhasil disimpan.');
    }

    public function export_excel(Request $request)
    {
        $selectedDate = $request->input('date', date('Y-m-d'));
        $dateConvert = Carbon::parse($selectedDate)->format('d') . ' ' . getIndonesianMonth(Carbon::parse($selectedDate)->format('m'));
        return Excel::download(new ExportData, $dateConvert . '.xlsx');
    }

    public function updateData(Request $request)
    {
        // Validasi input


        // Membuat instance model
        $model = new noticeModels();
        $userName = Auth::user()->name;

        // Mengatur nama tabel secara dinamis
        $model->setTable($userName);

        $data = [
            'id' => $request->id,
            'tanggal' => $request->tanggal,
            'no_notice' => $request->no_notice,
            'no_polisi' => $request->nopol,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'total_pajak' => $request->total_pajak,
            'keterangan' => $request->keterangan,
            'kondisi' => $request->kondisi,
            'baru' => $request->baru,
        ];
        // dd($data);

        $model::where('id', $request->id)->update($data);

        return redirect('/?date=' . $request->tanggal);
    }
    public function deleteData(Request $request)
    {
        // Membuat instance model
        $model = new noticeModels();
        $userName = Auth::user()->name;

        // Mengatur nama tabel secara dinamis
        $model->setTable($userName);

        $model::where('id', $request->id)->delete();


        return redirect('/?date=' . $request->tanggal);
    }

    public function admin()
    {
        $data = noticeModels::all();
        return view('admin', compact('data'))->with('judul', 'Admin | SIPSKPD');
    }

    public function profile()
    {
        return view('profile')->with('judul', 'Profile | SIPSKPD');
    }

    public function profileEdit(Request $request)
    {

        $user = auth()->user();
        if (password_verify($request->password, $user->password)) {
            $user->nama_kasir = $request->nama_kasir;
            $user->save();

            return redirect()->back()->with('success', 'Profil berhasil diperbarui');
        } else {
            // Jika password tidak cocok
            return redirect()->back()->with('error', 'Password salah');
        }
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
