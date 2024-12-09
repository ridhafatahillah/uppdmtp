<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\noticeModels;

class EventController extends Controller
{
    public function getSortedData(Request $request)
    {
        $date = $request->input('date');

        // Mengambil data berdasarkan tanggal yang dipilih
        $events = noticeModels::whereDate('tanggal', $date)->orderBy('event_date')->get();

        // Mengembalikan data dalam format HTML
        $html = view('partials.events_table', ['events' => $events])->render();

        return response()->json(['html' => $html]);
    }
}
