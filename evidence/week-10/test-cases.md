# Test Cases - Pertemuan 10

Dokumen ini berisi hasil pengujian manual untuk fitur **Create** dan **Read** pada tabel `courses` di aplikasi KursusKu.

## Tabel Pengujian

| No | Skenario | Input Utama | Hasil yang Diharapkan | Status |
|:---:|:---|:---|:---|:---:|
| 1 | **Simpan data valid** | Semua field valid (Kode unik, Nama, Biaya, Kuota, Tanggal, Status) | Data tersimpan, redirect ke index, pesan sukses tampil | ✅ Lulus |
| 2 | **Kode kosong** | `code` kosong | Validasi gagal, data tidak tersimpan, muncul pesan error | ✅ Lulus |
| 3 | **Kode duplikat** | `code` = `WEB-101` (kode yang sudah ada) | Ditolak oleh rule unique, muncul pesan *"The code has already been taken."* | ✅ Lulus |
| 4 | **Nama kosong** | `name` kosong | Validasi gagal, muncul pesan *"The name field is required."* | ✅ Lulus |
| 5 | **Biaya negatif** | `fee` = `-1000` | Ditolak karena aturan `min:0`, muncul pesan error | ✅ Lulus |
| 6 | **Kuota 0** | `quota` = `0` | Ditolak karena aturan `min:1`, muncul pesan error | ✅ Lulus |
| 7 | **Status tidak valid** | `status` = `active` (diubah manual via inspect element) | Ditolak karena hanya boleh `draft`, `open`, atau `closed` | ✅ Lulus |
| 8 | **Daftar tampil ulang** | Reload halaman `/courses` | Data tetap ada karena berasal dari MySQL (Eloquent) | ✅ Lulus |

---

## Catatan Pengujian

*   **Test 1 (Valid):** Dibuktikan dengan screenshot `04-index-8-data.png` (data muncul di tabel) dan `02-courses-structure.png` (data masuk ke MySQL).
*   **Test 3 (Duplikat):** Dibuktikan dengan screenshot `05-validation-error.png` (pesan error merah muncul).
*   **Test 8 (Read):** Halaman `/courses` mengambil data langsung dari database via Eloquent (`Course::latest()->get()`), sehingga data persisten meskipun halaman di-refresh.