<?php
// Atur lokalitas ke bahasa Indonesia
setlocale(LC_TIME, 'id_ID');

// Mendapatkan nama bulan dalam bahasa Indonesia
function getIndonesianMonth($month)
{
    $months = [
        'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI',
        'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
    ];
    return $months[$month - 1];
}

function getIndonesianMonths($month)
{
    $months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    return $months[$month - 1];
}

// Contoh penggunaan
$bulan = date('n'); // Ambil angka bulan saat ini
$nama_bulan = getIndonesianMonth($bulan);

function formatTanggal($tanggal)
{
    $date = new DateTime($tanggal);
    $day = $date->format('j'); // Mendapatkan tanggal
    $month = getIndonesianMonths((int)$date->format('n')); // Mendapatkan bulan
    $year = $date->format('Y'); // Mendapatkan tahun
    return "$day $month $year";
}
