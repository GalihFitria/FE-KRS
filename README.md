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

