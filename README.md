# 🧩 Assessment Application — Laravel + Vue (Inertia.js)

Project ini merupakan aplikasi berbasis **Laravel**, **Vue 3**, dan **Inertia.js** yang dirancang untuk kebutuhan penilaian. Aplikasi berjalan sebagai SPA namun tetap menggunakan routing Laravel tanpa memisahkan backend dan frontend.

---

## 🚀 Arsitektur Project

### **Arsitektur Dipilih: Digabung (Laravel + Inertia.js + Vue)**

Saya memilih arsitektur **digabung** dengan alasan:

-   Mengurangi kompleksitas — tidak perlu membuat REST API secara terpisah.
-   Pengembangan lebih cepat karena data langsung dikirim dari controller ke component Vue menggunakan Inertia.
-   Mempertahankan pengalaman SPA dengan manajemen state yang lebih mudah.
-   Lebih efisien untuk dashboard/admin apps.

---

## 🛠️ Tech Stack

-   **Laravel 12**
-   **Vue 3 + Vite**
-   **Inertia.js**
-   **TailwindCSS**
-   **PostgreSQL**

---

## 📦 Instalasi & Menjalankan Project

### 1. Clone Repository

```bash
git clone https://github.com/Robin00046/test-solusindo.git
cd test-solusindo

```
### 2. Install Composer
```bash
composer install

```

### 3. Copy & Generate Environment
```bash
cp .env.example .env
php artisan key:generate

```

### 4. Jalankan Migration
```bash
php artisan migrate --seed

```
### 5. Install Dependency Frontend (Inertia + Vite)
```bash
npm install

```

### 6. Jalankan Vite

```bash
npm run dev
```
### 7. Jalankan Laravel dan setting envnya sesuaikan ke 127.0.0.1 portnya berapa

```bash
php artisan serve
```

untuk tabelnya aku sesuaikan sedikit karena ada 2 field kelas aku hanya ambil untuk di tabel siswa karena untuk meminimalisir salah input jika disimpan 2 2nya di tabel yang berbeda.



untuk Test Logika Aku gabungkan kedalam Project ini dengan file test1.php di root directory



