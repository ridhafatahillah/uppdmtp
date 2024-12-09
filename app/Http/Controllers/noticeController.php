<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\noticeModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportData;

class noticeController extends Controller
{
    public function index(Request $request)
    {
        // Membuat instance model
        $model = new noticeModels();
        $userName = Auth::user()->name;

        // Mengatur nama tabel secara dinamis
        $model->setTable($userName);


        $selectedDate = $request->input('date', date('Y-m-d'));
        $selectedDates = Carbon::parse($selectedDate)->locale('id')->translatedFormat('d F Y');
        $noticetambahh = $model::whereDate('tanggal', $selectedDate)->max('no_notice');
        $data = $model::whereDate('tanggal', $selectedDate)->get();
        $jumlahdata = $model::whereDate('tanggal', $selectedDate)->count();
        $noticebatal = $model::whereDate('tanggal', $selectedDate)->where('kondisi', 'rusak')->count();
        $totalpajak = $model::whereDate('tanggal', $selectedDate)->sum('total_pajak');
        // dd($data);

        if ($noticetambahh) {
            // Increment nilai maksimum
            $noticetambah = str_pad((int)$noticetambahh + 1, strlen($noticetambahh), '0', STR_PAD_LEFT);
        } else {
            // Jika tidak ada nilai, mulai dari '00000001' atau format yang sesuai
            $noticetambah = str_pad(1, 8, '0', STR_PAD_LEFT); // Misalnya, 8 digit
        }

        return view(
            'dashboard',
            compact('data', 'jumlahdata', 'noticebatal', 'totalpajak', 'noticetambah', 'selectedDate', 'selectedDates')
        )->with('judul', 'Dashboard | SIPSKPD');
    }

    public function storeData(Request $request)
    {
        // Validasi input ketika no_notice sudah ada di tanggal yang sama
        $request->validate([
            'no_notice' => 'unique:App\Models\noticeModels,no_notice,NULL,id,tanggal,' . $request->tanggal,
        ]);

        // Membuat instance model
        $model = new noticeModels();
        $userName = Auth::user()->name;

        // Mengatur nama tabel secara dinamis
        $model->setTable($userName);

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
        ];
        // dd($data);

        $model::create($data);
        // redirect ke tanggal yang sama
        return redirect('/?date=' . $request->tanggal);
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
}
