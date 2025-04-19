# 📝 WPS Intern - Log Harian

Proyek ini adalah aplikasi manajemen log harian untuk pegawai. Aplikasi ini memungkinkan pegawai untuk mencatat aktivitas harian mereka, sementara manajer dapat memverifikasi, menyetujui, atau menolak log tersebut.

---

## 🚀 Fitur

- ✏️ Input dan edit log harian pegawai
- 📋 Verifikasi log oleh manajer (setujui atau tolak)
- 🔎 Filter log
- 🔔 Notifikasi lonceng ketika log disetujui/ditolak
- 🔐 Role-based access control (Staff, Manager, Direktur)

---

## ⚙️ Prasyarat

Pastikan sistem kamu sudah terpasang:

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL / MariaDB

---

## 📦 Instalasi Proyek

### 1. Clone Repository

<pre><code>git clone https://github.com/muhamadandy/wps_intern_muhamad-andy.git</code></pre>

### 2. Masuk ke Direktori Proyek

<pre><code>cd wps_intern_muhamad-andy</code></pre>

### 3. Install Dependency Backend

<pre><code>composer install</code></pre>

### 4. Install Dependency Frontend

<pre><code>npm install && npm run dev</code></pre>

### 5. Setup Environment

<pre><code>cp .env.example .env
php artisan key:generate
</code></pre>

### 6. Konfigurasi Database

Edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=
DB_PASSWORD=

---

## 🌱 Migrasi & Seeder

Jalankan migrasi database:

<pre><code>php artisan migrate</code></pre>

(Opsional) Isi database dengan data dummy:

<pre><code>php artisan db:seed</code></pre>

---

## ▶️ Menjalankan Aplikasi

Jalankan frontend (Vite):

<pre><code>npm run dev</code></pre>

Jalankan backend (Laravel):

<pre><code>php artisan serve</code></pre>
---
