<?php

// namespace App\Models;

// use App\Models\User;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Support\Facades\Auth;

// class noticeModels extends Model
// {

//     use HasFactory;

//     protected $table = Auth::user()->name;
//     protected $fillable = ['tanggal', 'no_notice', 'no_polisi', 'nama', 'alamat', 'total_pajak', 'keterangan'];
// }



namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class noticeModels extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = "kasir";

    protected $fillable = [
        'tanggal',
        'no_notice',
        'no_polisi',
        'nama',
        'alamat',
        'total_pajak',
        'keterangan',
        'kondisi',
        'baru',
        'users_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
