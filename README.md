# 🎓 Tutorial Frontend Laravel + Tailwind CSS (CRUD API Mahasiswa, Prodi, dan Kelas)
Proyek ini merupakan implementasi frontend Laravel dengan Tailwind CSS yang berkomunikasi dengan backend REST API (misal dari CodeIgniter) untuk mengelola entitas Mahasiswa, Prodi, dan Kelas.

🔗 [SI-KRS Backend (GitHub)](https://github.com/kristiandimasadiwicaksono/SI-KRS-Backend)

## 🧱 Teknologi yang Digunakan
- Laravel 10
- Tailwind CSS
- Laravel HTTP Client (untuk konsumsi API)
- REST API Backend (misal: CodeIgniter 4)
- Vite (build frontend asset Laravel)

## 📦 Instalasi & Setup
<h3>1. Clone Repository</h3>

```bash
git clone https://github.com/GalihFitria/FE-KRS.git
cd FE-KRS
```

<h3>2. Install Dependency Laravel</h3>

```bash
composer install
```
<h3>3. Copy File Environment</h3>

```bash
cp .env.example .env
```

<h3>4. Konfigurasi .env untuk Konsumsi API</h3>

```bash
APP_NAME=Laravel
APP_URL=http://localhost:8000
SESSION_DRIVER=file
```
> Tidak perlu konfigurasi DB karena semua data berasal dari API CodeIgniter.

<h3>5. </h3>
