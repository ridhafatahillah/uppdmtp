<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class fetchApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // fetch ke api.test/api/plat dengan method get
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . '12|00lHMbmVHX1Y8iTkcMVan6yCNdJCH8plMgnws27I1722c6b3',
        ])->get('http://apiuppd.studiomuda.com/api/plat?plat=' . $request->plat);
        // buat header authorization
        // mengambil data dari response
        $data = $response->json();
        return response()->json($data, $response->status());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
