# AI Usage Log - Pertemuan 12

Dokumen ini mencatat penggunaan AI selama pengerjaan Praktikum Pemrograman Web III Pertemuan 12 (Relasi Database).

| Prompt / pertanyaan | Saran AI | Dipakai? | Alasan |
| :--- | :--- | :---: | :--- |
| Kenapa muncul error `Table 'courses' already exists` saat menjalankan `php artisan migrate`? | AI menyarankan untuk menjalankan migration secara spesifik dengan `--path` untuk tabel `participants` dan `enrollments` saja, agar tidak bentrok dengan tabel `courses` yang sudah ada. | **Ya** | Karena menjalankan `migrate` biasa akan mencoba membuat ulang tabel `courses`. |
| Kenapa muncul error `View [enrollments.index] not found` setelah memindahkan file ke folder `admin`? | AI menyarankan untuk menambahkan awalan `admin.` pada pemanggilan `view()` dan `redirect()->route()` di `EnrollmentController.php`. | **Ya** | Folder view sudah dipindah ke `admin/enrollments`, jadi pemanggilannya harus disesuaikan. |
| Kenapa form enrollment yang muncul malah form pendaftaran user yang panjang? | AI menyarankan untuk menghapus isi file `admin/enrollments/create.blade.php` dan menggantinya dengan kode form yang hanya berisi 2 dropdown (Participant dan Course). | **Ya** | File tersebut tidak sengaja terisi kode dari form user. |
| Bagaimana cara menguji efek *Cascade Delete* pada database? | AI memberikan contoh perintah Tinker untuk membuat data dummy, menghapus Course/Participant, lalu memeriksa apakah data Enrollment ikut terhapus. | **Ya** | Sesuai dengan panduan halaman 18-19. |

## Catatan Penting

*   Seluruh kode yang disarankan oleh AI telah **diuji secara manual** di terminal dan browser.
*   Saya dapat **menjelaskan alur logika** dari setiap kode yang diterapkan (misalnya cara kerja Foreign Key, relasi `hasMany`/`belongsTo`, dan aturan `cascadeOnDelete`).
*   AI digunakan sebagai **tutor** untuk membantu *debugging* dan memberikan referensi sintaks, bukan untuk membuat seluruh aplikasi secara otomatis.