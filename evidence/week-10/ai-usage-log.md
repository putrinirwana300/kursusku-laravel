# AI Usage Log - Pertemuan 10

 mencatat penggunaan AI (Large Language Model) selama proses pengerjaan Praktikum Pemrograman Web III Pertemuan 10.

## Ringkasan Penggunaan

| Tanggal | Tujuan / Masalah | Saran AI | Keputusan & Alasan | Hasil Test |
| :--- | :--- | :--- | :--- | :--- |
| 31/10/2026 | Halaman `/courses/create` menampilkan layar kosong (blank putih). | AI menyarankan untuk mengecek `CourseController.php` dan memastikan method `create()` mengembalikan `view('courses.create')`. | **Diterima.** Ternyata method `create()` masih kosong (`//`). Saya mengisi method tersebut sesuai panduan. | Halaman form berhasil muncul. |
| 31/10/2026 | Muncul error `419 Page Expired` saat menyimpan form. | AI menyarankan untuk memastikan `@csrf` ada di dalam tag `<form>` dan menjalankan `php artisan optimize:clear`. | **Diterima.** Saya menambahkan `@csrf` yang sempat terhapus dan membersihkan cache. | Form berhasil disimpan tanpa error. |
| 31/10/2026 | Error `Table 'courses' already exists` saat menjalankan migrate. | AI menyarankan untuk memeriksa file migration dan memastikan tidak ada duplikasi pembuatan tabel `courses`. | **Diterima.** Saya memperbaiki file migration cache yang salah isi. | `php artisan migrate` berhasil dijalankan. |
| 01/11/2026 | Ingin merapikan tampilan form Create agar sesuai dengan desain Bootstrap. | AI memberikan contoh kode HTML/CSS form dengan class Bootstrap (`form-control`, `btn-primary`, `card`, dll). | **Diterima.** Saya menerapkan kode tersebut di `create.blade.php`. | Tampilan form menjadi rapi dan responsif. |
| 01/11/2026 | Ingin membuat file laporan pengujian (`test-cases.md`). | AI memberikan template tabel Markdown berisi 8 skenario pengujian. | **Diterima.** Saya menyesuaikan template tersebut dengan hasil pengujian aktual yang saya lakukan. | File laporan siap dikumpulkan. |

## Catatan Penting

*   Seluruh kode yang disarankan oleh AI telah **diuji secara manual** di browser dan terminal sebelum diterima.
*   Saya dapat **menjelaskan alur logika** dari setiap kode yang diterapkan (misalnya alur Route -> Controller -> View, atau cara kerja validasi `unique`).
*   AI digunakan sebagai **tutor** untuk membantu *debugging* dan memberikan referensi sintaks, bukan untuk membuat seluruh aplikasi secara otomatis.