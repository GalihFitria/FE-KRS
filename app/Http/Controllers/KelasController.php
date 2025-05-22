<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $response = Http::get('http://localhost:8080/kelas');

        if ($response->successful()) {
            $kelas = collect($response->json())->sortBy('id_kelas')->values();
            return view('Kelas', compact('kelas'));
        } else {
            return back()->with('error', 'Gagal mengambil data kelas');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('tambahkelas');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $validate = $request->validate([
                'id_kelas' => 'required',
                'nama_kelas' => 'required',
            ]);

            Http::asForm()->post('http://localhost:8080/kelas', $validate);

            return redirect()->route('Kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_kelas)
    {
        //

        $response = Http::get("http://localhost:8080/kelas/$id_kelas");

        if ($response->successful() && !empty($response[0])) {
            $kelas = $response[0]; // karena CodeIgniter mengembalikan array berisi 1 data
            return view('editkelas', compact('kelas'));
        } else {
            return back()->with('error', 'Gagal mengambil data kelas');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kelas)
    {
        //
        try {
            $validate = $request->validate([
                'id_kelas' => 'required',
                'nama_kelas' => 'required'
            ]);

            Http::asForm()->put("http://localhost:8080/kelas/$kelas", $validate);

            return redirect()->route('Kelas.index')->with('success', 'Kelas berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kelas)
    {
        //
        Http::delete("http://localhost:8080/kelas/$kelas");
        return redirect()->route('Kelas.index');
    }
}
