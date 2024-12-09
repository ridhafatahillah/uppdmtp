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

    // Nama tabel tidak didefinisikan di sini

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
    ];

    public function __construct(array $attributes = [])
    {
        // Set table name dynamically based on the authenticated user's name
        $userName = Auth::user()->name;
        $this->setTable($userName);

        parent::__construct($attributes);
    }
}
