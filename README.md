# 🎓 Tutorial Frontend Laravel + Tailwind CSS (CRUD API Mahasiswa, Prodi, dan Kelas)
Proyek ini merupakan implementasi frontend Laravel dengan Tailwind CSS yang berkomunikasi dengan backend REST API (misal dari CodeIgniter) untuk mengelola entitas Mahasiswa, Prodi, dan Kelas.

🔗 [SI-KRS Backend (GitHub)](https://github.com/kristiandimasadiwicaksono/SI-KRS-Backend)

## 🧱 Teknologi yang Digunakan
- Laravel 10
- Tailwind CSS
- Laravel HTTP Client (untuk konsumsi API)
- REST API Backend (misal: CodeIgniter 4)
- Vite (build frontend asset Laravel)

## 📦 BACKEND
<h3>1. Clone Repository BE</h3>

```bash
git clone https://github.com/kristiandimasadiwicaksono/SI-KRS-Backend.git
cd SI-KRS-Backend
```

<h3>2. Install Dependency CodeIgniter</h3>

```bash
composer install
```
<h3>3. Copy File Environment</h3>

```bash
cp .env.example .env
```
<h3>4. Menjalankan CodeIgniter</h3>

```bash
php spark serve
```

<h3>5. Cek EndPoint menggunakan Postman</h3>
<h3>Kelas :</h3>

- GET → http://localhost:8080/kelas / http://localhost:8080/kelas/{id}
- POST → http://localhost:8080/kelas
- PUT → http://localhost:8080/kelas/{id}
- DELETE → http://localhost:8080/kelas/{id}

<h3>Prodi</h3>

- GET → http://localhost:8080/prodi / http://localhost:8080/prodi/{id}
- POST → http://localhost:8080/prodi
- PUT → http://localhost:8080/prodi/{id}
- DELETE → http://localhost:8080/prodi/{id}

<h3>Mahasiswa</h3>

- GET → http://localhost:8080/mahasiswa / http://localhost:8080/mahasiswa/{id}
- POST → http://localhost:8080/mahasiswa
- PUT → http://localhost:8080/mahasiswa/{id}
- DELETE → http://localhost:8080/mahasiswa/{id}

## 🎨 FRONTEND
<h3>1. Clone Repository FE</h3>

```bash
git clone https://github.com/GalihFitria/FE-KRS.git
cd FE-KRS
```

<h3>2. Install Laravel </h3>
<h3>Melalui Terminal/CMD</h3>

```
composer create-priject laravel/laravel (nama-projek)
```

<h3>Laragon</h3>

- Buka Laragon
- Klik kanan Quick app
- Laravel

<h3>3. Install Dependency Laravel</h3>

```bash
composer install
```

## 📁 Routing 
Di routes/web.php :

```bash
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;

Route::get('/', [DashboardController::class, 'index'])->name('Dashboard.index');
Route::resource('Mahasiswa', MahasiswaController::class);
Route::resource('Prodi', ProdiController::class);
Route::resource('Kelas', KelasController::class);
```

## 🧑‍💻 Controller
<h3>Generate Controller</h3>

```bash
php artisan make:controller MahasiswaController
php artisan make:controller KelasController
php artisan make:controller ProdiController
```
<h3>Contoh MahasiswaController.php</h3>

```bash
<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class MahasiswaController extends Controller
{
    
    public function index()
    {
        //
        $response = Http::get('http://localhost:8080/mahasiswa');


        if ($response->successful()) {
            $mahasiswa = collect($response->json())->sortBy('npm')->values();

            return view('Mahasiswa', compact('mahasiswa'));
        } else {
            return back()->with('error', 'Gagal mengambil data mahasiswa');
        }
    }

    
    public function create()
    {
        //
        $respon_kelas = Http::get('http://localhost:8080/kelas');
        $kelas = collect($respon_kelas->json())->sortBy('id_kelas')->values();

        $respon_prodi = Http::get('http://localhost:8080/prodi');
        $prodi = collect($respon_prodi->json())->sortBy('kode_prodi')->values();

        return view('tambahmahasiswa', [
            'kelas' => $kelas,
            'prodi' => $prodi
        ]);
    }

   
    public function store(Request $request)
    {
        //
        try {
            $validate = $request->validate([
                'npm' => 'required|unique:mahasiswa,npm',
                'nama_mahasiswa' => 'required',
                'id_kelas' => 'required',
                'kode_prodi' => 'required'
            ]);

            Http::asForm()->post('http://localhost:8080/mahasiswa', $validate);

            return redirect()->route('Mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($mahasiswa)
    {
        //
        $mahasiswaResponse = Http::get("http://localhost:8080/mahasiswa/$mahasiswa");
        $kelas = Http::get("http://localhost:8080/kelas")->json();
        $prodi = Http::get("http://localhost:8080/prodi")->json();

        if ($mahasiswaResponse->successful() && !empty($mahasiswaResponse[0])) {
            $mahasiswa = $mahasiswaResponse[0];

            // Tambahkan pencocokan manual ID berdasarkan nama
            foreach ($kelas as $k) {
                if ($k['nama_kelas'] === $mahasiswa['nama_kelas']) {
                    $mahasiswa['id_kelas'] = $k['id_kelas'];
                    break;
                }
            }

            foreach ($prodi as $p) {
                if ($p['nama_prodi'] === $mahasiswa['nama_prodi']) {
                    $mahasiswa['kode_prodi'] = $p['kode_prodi'];
                    break;
                }
            }

            return view('editmahasiswa', compact('mahasiswa', 'kelas', 'prodi'));
        } else {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
    }


    public function update(Request $request, $mahasiswa)
    {
        //
        try {
            $validate = $request->validate([
                'npm' => 'required',
                'nama_mahasiswa' => 'required',
                'id_kelas' => 'required',
                'kode_prodi' => 'required'

            ]);

            Http::asForm()->put("http://localhost:8080/mahasiswa/$mahasiswa", $validate);

            return redirect()->route('Mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }


    public function destroy($mahasiswa)
    {
        //
        Http::delete("http://localhost:8080/mahasiswa/$mahasiswa");
        return redirect()->route('Mahasiswa.index');
    }
}
```

<h3>Contoh KelasController.php</h3>

```bash
<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KelasController extends Controller
{
    
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

  
    public function create()
    {
        //
        return view('tambahkelas');
    }

    
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

  
    public function destroy($kelas)
    {
        //
        Http::delete("http://localhost:8080/kelas/$kelas");
        return redirect()->route('Kelas.index');
    }
}
```

<h3>Contoh ProdiController.php</h3>

```bash
<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
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
}
```
