# 🐑 Aplikasi Penukaran Kupon Kurban (IT Mada Wikri)

Aplikasi berbasis web yang dirancang khusus untuk memfasilitasi panitia kurban dan tim HRD dalam melakukan manajemen, pendataan, dan penukaran kupon daging kurban bagi karyawan di perusahaan.

Aplikasi ini dilengkapi dengan fitur pencarian data secara langsung (*live-search*), manajemen data karyawan berbasis *Excel*, serta pemantauan statistik penukaran secara aktual (*real-time*).

## ✨ Fitur Utama

*   **🔍 Live Search Karyawan:** Pencarian data karyawan dengan cepat berdasarkan NIK atau Nama menggunakan Alpine.js.
*   **📊 Dashboard & Statistik Real-time:** Menampilkan laporan jumlah karyawan yang sudah menukar, menunggu, dan belum menukar kupon. Dilengkapi dengan grafik tren penukaran tiap 2 jam (dari 12 PM - 12 AM).
*   **🏢 Multi-Plant Management:** Dukungan pembagian Hak Akses Admin berdasarkan lokasi Plant. Superadmin dapat melihat semua Plant.
*   **📝 Pendaftaran Manual (Walk-in):** Karyawan yang tidak ada di daftar (database) dapat didaftarkan secara manual oleh tim HRD/IT di tempat.
*   **📥 Import Data Excel:** Memudahkan proses penginputan data karyawan secara massal ke dalam sistem hanya dengan mengunggah file Excel.
*   **⚡ Modern UI/UX:** Antarmuka responsif dan ramah pengguna dengan desain *clean* menggunakan **Tailwind CSS**.

## 🛠️ Teknologi yang Digunakan

*   **Backend:** [Laravel 11](https://laravel.com/) (PHP)
*   **Frontend:** HTML, Vanilla CSS, [Tailwind CSS](https://tailwindcss.com/)
*   **Interactivity:** [Alpine.js](https://alpinejs.dev/)
*   **Database:** MySQL
*   **Library Tambahan:** PhpSpreadsheet (Untuk ekspor/impor Excel)

## 🚀 Panduan Instalasi (Local Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di komputer lokal Anda:

1. **Clone repository ini**
   ```bash
   git clone https://github.com/IT-MadaWikri/kupon.git
   cd kupon
   ```

2. **Install dependensi PHP & Node.js**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`, lalu atur konfigurasi database Anda.
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Jalankan Migrasi & Seeder Database**
   Perintah ini akan membuat struktur tabel beserta akun Admin standar.
   ```bash
   php artisan migrate --seed
   ```

6. **Kompilasi Aset Frontend**
   ```bash
   npm run build
   # atau jika dalam tahap pengembangan: npm run dev
   ```

7. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Aplikasi sekarang dapat diakses melalui `http://localhost:8000`.

## 🧑‍💻 Hak Akses (Role)

Aplikasi ini menggunakan 2 jenis level akses untuk panel administrasi:
*   **Superadmin:** Memiliki kendali penuh ke seluruh sistem, termasuk mengekspor laporan dan memantau semua data dari setiap *Plant*.
*   **Admin Plant:** Hanya memiliki akses untuk melakukan pemindaian (konfirmasi penukaran) dan melihat data karyawan yang berada di *Plant* yang sama dengan *Admin* tersebut.

---
© 2026 Tim IT Mada Wikri. All rights reserved.
