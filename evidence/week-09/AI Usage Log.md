# AI Usage Log - Pertemuan 9

**Apa yang saya tanyakan ke AI:**
Saya meminta bantuan AI untuk memperbaiki tampilan navbar di Laravel yang jaraknya melebar, serta menanyakan kenapa jQuery dan Ajax saya tidak jalan (Console menunjukkan "undefined").

**Saran AI yang saya terapkan:**
1. Menghapus `<div class="container">` di dalam tag `<nav>` agar menu bisa di tengah.
2. Menambahkan `@vite(...)` di file layout dan menjalankan `npm run build` agar file JavaScript masuk ke browser.
3. Menyesuaikan CSS manual agar ukuran font dan jarak navbar sama persis dengan prototype.

**Hasil Verifikasi:**
Setelah menjalankan `npm run build` dan refresh browser, jQuery aktif (Console menampilkan "function"). Saat saya memilih kursus "Web Dasar" di form, kotak abu-abu langsung berubah menjadi hijau dan menampilkan "18 kursi tersisa untuk Web Dasar" tanpa reload halaman.