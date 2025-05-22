<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $response = Http::get('http://localhost:8080/prodi');

        if ($response->successful()) {
            $prodi = collect($response->json())->sortBy('kode_prodi')->values();
            return view('Prodi', compact('prodi'));
        } else {
            return back()->with('error', 'Gagal mengambil data prodi');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('tambahprodi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $validate = $request->validate([
                'kode_prodi' => 'required',
                'nama_prodi' => 'required'
            ]);

            Http::asForm()->post('http://localhost:8080/prodi', $validate);

            return redirect()->route('Prodi.index')->with('success', 'Prodi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Prodi $prodi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($prodi)
    {
        //
        $response = Http::get("http://localhost:8080/prodi/$prodi");

        if ($response->successful() && !empty($response[0])) {
            $prodi = $response[0]; // karena CodeIgniter mengembalikan array berisi 1 data
            return view('editprodi', compact('prodi'));
        } else {
            return back()->with('error', 'Gagal mengambil data kelas');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $prodi)
    {
        //
        try {
            $validate = $request->validate([
                'kode_prodi' => 'required',
                'nama_prodi' => 'required'
            ]);

            Http::asForm()->put("http://localhost:8080/prodi/$prodi", $validate);

            return redirect()->route('Prodi.index')->with('success', 'Kelas berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($prodi)
    {
        
        Http::delete("http://localhost:8080/prodi/$prodi");
        return redirect()->route('Prodi.index');
    }
}
