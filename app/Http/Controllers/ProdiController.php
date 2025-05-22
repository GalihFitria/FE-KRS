<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;

class ProdiController extends Controller
{
    
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

    
    public function create()
    {
        //
        return view('tambahprodi');
    }

   
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

    public function destroy($prodi)
    {
        
        Http::delete("http://localhost:8080/prodi/$prodi");
        return redirect()->route('Prodi.index');
    }

    public function exportPdf()
    {
        $response = Http::get('http://localhost:8080/prodi');
        if ($response->successful()) {
            $prodi = collect($response->json());
            $pdf = Pdf::loadView('pdf.cetak', compact('prodi')); // Ubah 'cetak.pdf' menjadi 'pdf.cetak'
            return $pdf->download('prodi.pdf');
        } else {
            return back()->with('error', 'Gagal mengambil data untuk PDF');
        }
    }
}
