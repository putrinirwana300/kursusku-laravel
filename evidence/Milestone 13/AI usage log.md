# Milestone 13 - Data Discovery KursusKu

**Nama:** [Putri Nirwana]
**NIM:** [2524235]
**Mata Kuliah:** Pemrograman Web III


**AI Usage Log**

| Prompt / Masalah | Saran AI | Diterima / Ditolak | Alasan + Hasil Test |
| :--- | :--- | :--- | :--- |
| *"Tolong review kode CourseController saya untuk fitur search, filter, dan pagination. Apakah sudah sesuai standar Laravel?"* | AI menyarankan penggunaan `->when()` untuk search agar lebih bersih, serta menambahkan `->withQueryString()` pada pagination agar filter tidak hilang saat pindah halaman. AI juga menyarankan membuat partial view `_results.blade.php` untuk Ajax. | **Diterima** | Saran `withQueryString()` sangat membantu. Setelah diuji, saat pindah ke halaman 2, URL tetap membawa `?q=laravel`, jadi pencarian tidak hilang. |
| *"Kenapa fitur Ajax live search saya tidak mengeluarkan request di tab Network?"* | AI menyarankan mengecek Console browser, memastikan jQuery termuat, dan menyarankan alternatif menggunakan View Page Source untuk membuktikan parameter URL terkirim ke server. | **Diterima** | Ternyata tab Network browser saya bermasalah. Saran AI untuk menggunakan View Page Source berhasil membuktikan bahwa URL `?q=laravel&page=2` terkirim dengan benar ke server. |
| *"Bagaimana cara membuat Test Matrix untuk 5 skenario pengujian?"* | AI memberikan format tabel pengujian mulai dari skenario 0 hasil, 1 hasil, >10 hasil, keyword spasi, hingga filter + page 2. | **Diterima** | Format tabelnya jelas dan sesuai dengan yang diminta di modul. Saya mengisinya berdasarkan hasil uji coba nyata di browser. |

