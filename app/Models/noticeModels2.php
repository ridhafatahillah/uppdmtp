<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class noticeModels2 extends Model
{
    use HasFactory;
    protected $table = 'kasir2';
    protected $fillable = ['tanggal', 'no_notice', 'no_polisi', 'nama', 'alamat', 'total_pajak', 'keterangan'];
}
