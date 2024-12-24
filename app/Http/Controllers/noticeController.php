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

        $userId = Auth::user()->id;
        $userName = Auth::user()->name;


        $selectedDate = $request->input('date', date('Y-m-d'));
        $selectedDates = Carbon::parse($selectedDate)->locale('id')->translatedFormat('d F Y');


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

        if ($noticetambahh) {
            $noticetambah = str_pad((int) $noticetambahh + 1, strlen($noticetambahh), '0', STR_PAD_LEFT);
        } else {
            $noticetambah = str_pad(1, 8, '0', STR_PAD_LEFT);
        }

        return view(
            'dashboard',
            compact('data', 'jumlahdata', 'noticebatal', 'totalpajak', 'noticetambah', 'selectedDate', 'selectedDates')
        )->with('judul', 'Dashboard | SIPSKPD');
    }

    public function storeData(Request $request)
    {

        $request->validate([
            'no_notice' => [
                'required',
                Rule::unique('kasir')->where(function ($query) use ($request) {
                    return $query->where('tanggal', $request->tanggal)
                        ->where('users_id', $request->user_id  ?? Auth::user()->id);;
                }),
            ],
            'total_pajak' => 'numeric|min:0',
        ]);

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
            'users_id' => $request->user_id ?? Auth::user()->id,
        ];
        // dd($data);

        noticeModels::create($data);
        if (Auth::user()->role == 0) {
            return redirect('/?date=' . $request->tanggal)->with('success', 'Notes berhasil disimpan.');
        } else {
            return redirect('/admin/kasir/' . $request->user_id . '?date=' . $request->tanggal)->with('success', 'Notes berhasil disimpan.');
        }
    }

    public function export_excel(Request $request)
    {
        $selectedDate = $request->input('date', date('Y-m-d'));
        $dateConvert = Carbon::parse($selectedDate)->format('d') . ' ' . getIndonesianMonth(Carbon::parse($selectedDate)->format('m'));
        return Excel::download(new ExportData, $dateConvert . '.xlsx');
    }

    public function updateData(Request $request)
    {

        $model = new noticeModels();
        $userName = Auth::user()->name;


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

        return redirect()->back()->with('success', 'Data berhasil diubah.');
    }
    public function deleteData($id, Request $request)
    {

        $model = new noticeModels();
        $userName = Auth::user()->name;


        $model->setTable($userName);

        $model::where('id', $request->id)->delete();

        // dd($request->all());


        return redirect()->back()->with('success', 'Data berhasil dihapus.');
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
