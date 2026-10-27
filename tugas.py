from reportlab.lib import colors
from reportlab.lib.enums import TA_CENTER, TA_LEFT
from reportlab.lib.pagesizes import A4
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.units import cm
from reportlab.platypus import (
    SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, PageBreak,
    KeepTogether, ListFlowable, ListItem
)
from reportlab.pdfbase.ttfonts import TTFont
from reportlab.pdfbase import pdfmetrics
from reportlab.lib.colors import HexColor
import os, re, sys, subprocess

# ============================================================
# 1. PATH OUTPUT (otomatis, aman untuk Windows/Mac/Linux)
# ============================================================
# File PDF akan disimpan di folder yang sama dengan script ini.
BASE_DIR = os.path.dirname(os.path.abspath(__file__)) if "__file__" in globals() else os.getcwd()
out = os.path.join(BASE_DIR, "Materi_Evaluasi_Pendidikan_TIK_Topik_2-7.pdf")

# ============================================================
# 2. REGISTER FONT (auto-detect untuk Windows/Mac/Linux)
# ============================================================
font_regular = "Helvetica"
font_bold = "Helvetica-Bold"

FONT_CANDIDATES = [
    # Windows
    ("C:/Windows/Fonts/arial.ttf", "C:/Windows/Fonts/arialbd.ttf"),
    ("C:/Windows/Fonts/segoeui.ttf", "C:/Windows/Fonts/segoeuib.ttf"),
    ("C:/Windows/Fonts/calibri.ttf", "C:/Windows/Fonts/calibrib.ttf"),
    # macOS
    ("/Library/Fonts/Arial.ttf", "/Library/Fonts/Arial Bold.ttf"),
    ("/System/Library/Fonts/Supplemental/Arial.ttf",
     "/System/Library/Fonts/Supplemental/Arial Bold.ttf"),
    # Linux
    ("/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf",
     "/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf"),
    ("/usr/share/fonts/truetype/liberation2/LiberationSans-Regular.ttf",
     "/usr/share/fonts/truetype/liberation2/LiberationSans-Bold.ttf"),
]

for reg_path, bold_path in FONT_CANDIDATES:
    if os.path.exists(reg_path) and os.path.exists(bold_path):
        try:
            pdfmetrics.registerFont(TTFont("DocSans", reg_path))
            pdfmetrics.registerFont(TTFont("DocSans-Bold", bold_path))
            font_regular, font_bold = "DocSans", "DocSans-Bold"
            print(f"[INFO] Font Unicode digunakan: {reg_path}")
            break
        except Exception as e:
            print(f"[WARN] Gagal mendaftarkan font {reg_path}: {e}")

if font_regular == "Helvetica":
    print("[INFO] Menggunakan font default Helvetica (fallback).")

# ============================================================
# 3. STYLES
# ============================================================
styles = getSampleStyleSheet()
styles.add(ParagraphStyle(name="CoverTitle", fontName=font_bold, fontSize=23, leading=30, alignment=TA_CENTER, textColor=HexColor("#174A7E"), spaceAfter=14))
styles.add(ParagraphStyle(name="CoverSub", fontName=font_regular, fontSize=13, leading=19, alignment=TA_CENTER, textColor=HexColor("#3F5F78"), spaceAfter=10))
styles.add(ParagraphStyle(name="H1x", fontName=font_bold, fontSize=16, leading=21, textColor=HexColor("#174A7E"), spaceBefore=7, spaceAfter=9, keepWithNext=True))
styles.add(ParagraphStyle(name="H2x", fontName=font_bold, fontSize=12, leading=16, textColor=HexColor("#176B78"), spaceBefore=8, spaceAfter=5, keepWithNext=True))
styles.add(ParagraphStyle(name="H3x", fontName=font_bold, fontSize=10.5, leading=14, textColor=HexColor("#354B5E"), spaceBefore=6, spaceAfter=3, keepWithNext=True))
styles.add(ParagraphStyle(name="Bodyx", fontName=font_regular, fontSize=9, leading=13.2, spaceAfter=5))
styles.add(ParagraphStyle(name="Smallx", fontName=font_regular, fontSize=7.8, leading=10.2, spaceAfter=2))
styles.add(ParagraphStyle(name="Bulletx", fontName=font_regular, fontSize=8.8, leading=12.4, leftIndent=12, firstLineIndent=-7, spaceAfter=3))
styles.add(ParagraphStyle(name="TableHeadx", fontName=font_bold, fontSize=7.6, leading=9.2, textColor=colors.white, alignment=TA_LEFT))
styles.add(ParagraphStyle(name="TableCellx", fontName=font_regular, fontSize=7.4, leading=9.4))
styles.add(ParagraphStyle(name="Calloutx", fontName=font_bold, fontSize=9, leading=13, textColor=HexColor("#174A7E"), backColor=HexColor("#EAF3FA"), borderPadding=7, spaceBefore=4, spaceAfter=8))
styles.add(ParagraphStyle(name="CodeX", fontName="Courier", fontSize=8, leading=11, leftIndent=12, spaceBefore=3, spaceAfter=6))

def P(txt, style="Bodyx"):
    return Paragraph(txt, styles[style])

def bullets(items):
    return [Paragraph("• " + x, styles["Bulletx"]) for x in items]

def table(headers, rows, widths, repeatRows=1):
    data = [[P(str(h), "TableHeadx") for h in headers]]
    for row in rows:
        data.append([P(str(cell), "TableCellx") for cell in row])
    t = Table(data, colWidths=widths, repeatRows=repeatRows, hAlign="LEFT")
    t.setStyle(TableStyle([
        ("BACKGROUND", (0,0), (-1,0), HexColor("#245B83")),
        ("TEXTCOLOR", (0,0), (-1,0), colors.white),
        ("GRID", (0,0), (-1,-1), 0.35, HexColor("#B9C9D5")),
        ("VALIGN", (0,0), (-1,-1), "TOP"),
        ("LEFTPADDING", (0,0), (-1,-1), 5),
        ("RIGHTPADDING", (0,0), (-1,-1), 5),
        ("TOPPADDING", (0,0), (-1,-1), 5),
        ("BOTTOMPADDING", (0,0), (-1,-1), 5),
        ("ROWBACKGROUNDS", (0,1), (-1,-1), [colors.white, HexColor("#F4F8FB")]),
    ]))
    return t

# ============================================================
# 4. ISI DOKUMEN
# ============================================================
story = []
# Cover
story += [Spacer(1, 3.1*cm), P("MATERI EVALUASI<br/>PENDIDIKAN TIK", "CoverTitle"),
          P("Topik 2–7 • Semester 5", "CoverSub"),
          Spacer(1, 0.5*cm),
          P("Konsep Dasar Evaluasi Pembelajaran TIK • Prinsip Penilaian dan Pengenalan Tes • Ciri-Ciri Tes yang Baik • Taksonomi Hasil Belajar • Bentuk dan Jenis Tes • Penyusunan Kisi-Kisi Tes", "CoverSub"),
          Spacer(1, 2.2*cm),
          P("Ringkasan belajar yang dilengkapi definisi, tabel perbandingan, contoh dalam pembelajaran Informatika, langkah kerja, latihan, dan referensi.", "CoverSub"),
          Spacer(1, 4*cm),
          P("Catatan: contoh CP/TP dan kisi-kisi di dalam dokumen ini bersifat ilustratif. Sesuaikan dengan dokumen kurikulum dan tujuan pembelajaran yang digunakan di sekolah.", "Calloutx"),
          PageBreak()]

# Table of contents
story += [P("DAFTAR ISI", "H1x")]
for item in [
    "Topik 2. Konsep Dasar Evaluasi Pembelajaran TIK",
    "Topik 3. Prinsip Penilaian dan Pengenalan Tes",
    "Topik 4. Ciri-Ciri Tes yang Baik",
    "Topik 5. Taksonomi Hasil Belajar",
    "Topik 6. Bentuk dan Jenis Tes",
    "Topik 7. Penyusunan Kisi-Kisi Tes",
    "Latihan Evaluasi dan Kunci Jawaban",
    "Daftar Referensi"
]:
    story.append(P("• " + item, "Bodyx"))
story += [Spacer(1, 8), P("Peta hubungan konsep", "H2x"),
          P("Tujuan pembelajaran → pengukuran/pengumpulan bukti → penilaian dan interpretasi → evaluasi/keputusan → tindak lanjut. Prinsip penilaian, kualitas tes, taksonomi hasil belajar, bentuk tes, dan kisi-kisi membantu memastikan proses tersebut terarah dan dapat dipertanggungjawabkan.", "Bodyx"),
          PageBreak()]

# Topic 2
story += [P("TOPIK 2. KONSEP DASAR EVALUASI PEMBELAJARAN TIK", "H1x"),
          P("2.1 Pengukuran, penilaian, dan evaluasi", "H2x"),
          P("<b>Pengukuran</b> adalah proses memperoleh informasi kuantitatif tentang karakteristik atau hasil belajar, misalnya skor 8 dari 10 soal. <b>Penilaian</b> adalah proses mengumpulkan, mengolah, dan menafsirkan informasi untuk mengetahui pencapaian belajar. <b>Evaluasi</b> adalah proses menilai informasi tersebut untuk membuat keputusan tentang pembelajaran atau program.", "Bodyx"),
          table(["Istilah","Pertanyaan kunci","Contoh dalam TIK"], [
              ["Pengukuran","Berapa hasil/skornya?","Siswa menjawab benar 8 dari 10 soal tentang spreadsheet."],
              ["Penilaian","Apa arti hasil tersebut?","Skor 8/10 menunjukkan sebagian besar konsep sudah dikuasai; kesalahan pada rumus perlu diperiksa."],
              ["Evaluasi","Keputusan apa yang diambil?","Guru memberi latihan penguatan rumus kepada siswa yang masih kesulitan."]
          ], [3.0*cm, 4.1*cm, 9.0*cm]),
          P("2.2 Bagan proses evaluasi pembelajaran", "H2x"),
          P("Menetapkan tujuan → menentukan bukti yang dibutuhkan → menyusun instrumen → melaksanakan pengukuran/pengumpulan bukti → mengolah data → menafsirkan hasil → mengambil keputusan → melakukan tindak lanjut.", "Calloutx"),
          P("Contoh: guru ingin mengetahui kemampuan siswa menggunakan rumus Excel. Guru menetapkan tujuan, membuat tugas atau tes yang sesuai, mengumpulkan hasil, memeriksa jawaban, menafsirkan kesalahan, lalu memutuskan apakah perlu pengajaran ulang atau tugas lanjutan.", "Bodyx"),
          P("2.3 Tiga bentuk informasi kuantitatif yang sering digunakan", "H2x"),
          bullets([
              "<b>Skor mentah:</b> hasil langsung dari pengerjaan, misalnya 16 jawaban benar.",
              "<b>Nilai/persentase:</b> skor yang diubah ke skala tertentu. Contoh: 16/20 × 100 = 80.",
              "<b>Skor standar atau hasil konversi:</b> skor yang diubah menggunakan aturan tertentu agar dapat dibandingkan atau ditafsirkan sesuai tujuan. Penggunaan dan rumusnya bergantung pada sistem penilaian."
          ]),
          P("2.4 Tujuan dan fungsi evaluasi", "H2x"),
          bullets([
              "<b>Tujuan umum:</b> mengetahui pencapaian tujuan pembelajaran, mengidentifikasi kesulitan, memperbaiki pembelajaran, serta menjadi dasar keputusan yang adil.",
              "<b>Fungsi diagnostik:</b> menemukan kekuatan, kelemahan, atau penyebab kesulitan belajar.",
              "<b>Fungsi formatif:</b> memberikan informasi selama pembelajaran agar guru dan siswa dapat memperbaiki proses.",
              "<b>Fungsi sumatif:</b> merangkum pencapaian pada akhir unit, semester, atau program.",
              "<b>Fungsi penempatan:</b> membantu menentukan tingkat atau kelompok pembelajaran yang sesuai jika diperlukan.",
              "<b>Fungsi psikologis:</b> memberi umpan balik tentang kemajuan, mendukung motivasi, dan membantu siswa memahami perkembangan dirinya. Hasil harus disampaikan secara konstruktif.",
              "<b>Fungsi didaktis bagi siswa:</b> mendorong refleksi, perbaikan strategi belajar, dan peningkatan prestasi.",
              "<b>Fungsi bagi pendidik:</b> diagnostik, penempatan, selektif bila relevan, bimbingan, dan instruksional/perbaikan pengajaran.",
              "<b>Fungsi administratif:</b> menyediakan dokumentasi hasil, pelaporan perkembangan, dan informasi untuk keputusan sekolah sesuai kebijakan."
          ]),
          P("Ingat: pengukuran menghasilkan data, penilaian memberi makna pada data, sedangkan evaluasi menggunakan hasil penilaian untuk mengambil keputusan.", "Calloutx"),
          PageBreak()]

# Topic 3
story += [P("TOPIK 3. PRINSIP PENILAIAN DAN PENGENALAN TES", "H1x"),
          P("3.1 Prinsip-prinsip penilaian", "H2x"),
          table(["Prinsip","Makna","Contoh"], [
              ["Objektif","Berdasarkan kriteria dan bukti, bukan kesukaan pribadi.","Jawaban dinilai menggunakan kunci atau rubrik yang sama."],
              ["Adil","Memberi kesempatan yang setara dan mempertimbangkan kebutuhan yang relevan.","Instruksi jelas dan akomodasi diberikan sesuai ketentuan."],
              ["Transparan","Kriteria, prosedur, dan cara penilaian diketahui.","Siswa mengetahui rubrik proyek sebelum mengerjakan."],
              ["Sistematis","Direncanakan dengan tujuan, indikator, dan prosedur yang jelas.","Guru menyusun kisi-kisi sebelum membuat soal."],
              ["Berkesinambungan","Dilakukan pada waktu yang sesuai selama proses belajar.","Guru menggunakan kuis, observasi, dan tugas proyek."],
              ["Edukatif","Hasil membantu siswa belajar lebih baik.","Umpan balik menunjukkan bagian yang sudah baik dan yang perlu diperbaiki."],
              ["Terpadu","Terhubung dengan proses pembelajaran dan tujuan yang ditetapkan.","Tugas menilai kompetensi yang benar-benar diajarkan."]
          ], [2.5*cm, 6.2*cm, 7.4*cm]),
          P("3.2 Assessment for, as, dan of learning", "H2x"),
          table(["Jenis","Fokus","Contoh"], [
              ["Assessment for learning","Penilaian untuk membantu pembelajaran saat proses berlangsung.","Kuis singkat untuk mengetahui konsep yang belum dipahami."],
              ["Assessment as learning","Siswa memantau dan merefleksikan pembelajarannya sendiri.","Siswa menggunakan checklist untuk memeriksa kode yang dibuat."],
              ["Assessment of learning","Penilaian untuk merangkum pencapaian pada akhir periode.","Tes akhir unit tentang algoritma."]
          ], [3.2*cm, 6.0*cm, 6.9*cm]),
          P("3.3 Pengertian dan fungsi tes", "H2x"),
          P("Tes adalah instrumen atau prosedur yang berisi tugas/pertanyaan terencana untuk memperoleh sampel perilaku atau kemampuan peserta didik berdasarkan aturan pengerjaan dan penilaian tertentu. Tes merupakan salah satu alat penilaian, tetapi tidak semua penilaian harus berbentuk tes.", "Bodyx"),
          bullets([
              "Mengukur penguasaan pengetahuan atau kemampuan tertentu.",
              "Membantu diagnosis kesulitan belajar.",
              "Memantau kemajuan dan pencapaian tujuan.",
              "Mendukung keputusan pembelajaran berdasarkan bukti."
          ]),
          P("3.4 Tujuan tes dan contoh", "H2x"),
          table(["Tujuan","Contoh"], [
              ["Diagnostik","Tes awal untuk mengetahui konsep dasar jaringan yang belum dikuasai."],
              ["Formatif","Kuis setelah pembelajaran struktur percabangan."],
              ["Sumatif","Tes akhir unit atau semester."],
              ["Penempatan","Tes untuk menentukan kelompok belajar sesuai tingkat kesiapan, jika dibutuhkan."]
          ], [3.0*cm, 13.1*cm]),
          P("3.5 Langkah awal menyusun tes", "H2x"),
          P("Tentukan tujuan → tentukan kompetensi dan materi → buat kisi-kisi → susun butir soal → siapkan kunci/rubrik → telaah soal → laksanakan tes → analisis hasil → tindak lanjut.", "Calloutx"),
          PageBreak()]

# Topic 4
story += [P("TOPIK 4. CIRI-CIRI TES YANG BAIK", "H1x"),
          P("Tes yang baik menghasilkan informasi yang cukup akurat, konsisten, adil, dapat dilaksanakan, dan berguna untuk tujuan penilaian. Lima karakteristik utama yang sering dibahas adalah validitas, reliabilitas, objektivitas, praktikalitas, dan ekonomis.", "Bodyx"),
          table(["Karakteristik","Pengertian","Contoh/hal yang diperhatikan"], [
              ["Validitas","Sejauh mana bukti mendukung interpretasi dan penggunaan skor untuk tujuan tertentu.","Jika mengukur kemampuan membuat spreadsheet, tugas perlu menilai keterampilan yang relevan, bukan hanya hafalan istilah."],
              ["Reliabilitas","Konsistensi hasil pengukuran dalam kondisi yang sesuai.","Petunjuk, kondisi pengerjaan, dan penskoran dibuat konsisten."],
              ["Objektivitas","Hasil penilaian tidak bergantung secara tidak semestinya pada penilai.","Gunakan kunci jawaban dan rubrik yang jelas."],
              ["Praktikalitas","Tes dapat dilaksanakan dengan sumber daya, waktu, dan fasilitas yang tersedia.","Tugas praktik sesuai jumlah komputer dan waktu pelajaran."],
              ["Ekonomis","Tes menggunakan waktu, biaya, dan tenaga secara efisien tanpa mengorbankan mutu.","Instrumen mudah dikelola dan diperiksa."]
          ], [2.4*cm, 6.2*cm, 7.4*cm]),
          P("4.1 Kualitas butir soal", "H2x"),
          bullets([
              "<b>Tingkat kesukaran:</b> menunjukkan seberapa mudah atau sukar butir bagi kelompok peserta. Untuk soal objektif, indeks sederhana dapat dihitung dengan jumlah peserta yang menjawab benar dibagi jumlah seluruh peserta.",
              "<b>Daya pembeda:</b> menunjukkan kemampuan butir membedakan peserta dengan tingkat penguasaan relatif tinggi dan rendah. Butir yang baik umumnya lebih banyak dijawab benar oleh kelompok berkemampuan lebih tinggi.",
              "<b>Fungsi pengecoh:</b> pada pilihan ganda, opsi salah sebaiknya masuk akal bagi siswa yang belum menguasai materi dan tidak menyesatkan secara ambigu."
          ]),
          P("4.2 Contoh analisis sederhana", "H2x"),
          P("Sebuah soal dijawab benar oleh 18 dari 30 siswa. Indeks kesukaran sederhana p = 18/30 = 0,60. Ini menunjukkan 60% siswa menjawab benar. Angka tersebut tidak otomatis menyatakan soal baik atau buruk; guru perlu mempertimbangkan tujuan, kelompok siswa, daya pembeda, dan kualitas opsi.", "Bodyx"),
          P("4.3 Contoh tes baik dan kurang baik", "H2x"),
          table(["Kurang baik","Lebih baik"], [
              ["Pertanyaan ambigu dengan dua jawaban yang sama-sama tampak benar.","Rumusan jelas, satu jawaban terbaik, dan sesuai materi."],
              ["Penilaian proyek hanya berdasarkan kesan umum.","Gunakan rubrik dengan kriteria seperti ketepatan fungsi, keterbacaan kode, dan dokumentasi."],
              ["Tes mengukur hafalan padahal tujuan menuntut praktik.","Gunakan tugas kinerja atau proyek sesuai kompetensi."]
          ], [7.8*cm, 8.2*cm]),
          P("Catatan penting: validitas dan reliabilitas bukan sifat mutlak yang melekat pada instrumen untuk semua keadaan. Bukti perlu dipertimbangkan sesuai interpretasi skor dan penggunaan yang direncanakan.", "Calloutx"),
          PageBreak()]

# Topic 5
story += [P("TOPIK 5. TAKSONOMI HASIL BELAJAR", "H1x"),
          P("Taksonomi hasil belajar mengelompokkan tujuan atau capaian pembelajaran ke dalam ranah dan tingkat kemampuan. Dalam konteks pendidikan, tiga ranah yang sering dibahas adalah kognitif, afektif, dan psikomotor.", "Bodyx"),
          P("5.1 Ranah kognitif: Taksonomi Bloom revisi", "H2x"),
          table(["Level","Proses","Contoh Informatika"], [
              ["C1 Mengingat","Mengingat fakta, istilah, atau prosedur.","Menyebutkan fungsi RAM."],
              ["C2 Memahami","Menjelaskan atau menafsirkan konsep.","Menjelaskan perbedaan RAM dan penyimpanan."],
              ["C3 Menerapkan","Menggunakan prosedur dalam situasi tertentu.","Menggunakan rumus SUM pada spreadsheet."],
              ["C4 Menganalisis","Menguraikan bagian dan hubungan, menemukan kesalahan.","Menganalisis kesalahan logika dalam pseudocode."],
              ["C5 Mengevaluasi","Membuat penilaian berdasarkan kriteria.","Membandingkan dua solusi algoritmik berdasarkan kriteria tertentu."],
              ["C6 Mencipta","Menghasilkan rancangan atau produk baru.","Merancang algoritma untuk menyelesaikan masalah."]
          ], [2.4*cm, 6.0*cm, 7.6*cm]),
          P("5.2 Ranah afektif", "H2x"),
          P("Ranah afektif berkaitan dengan sikap, nilai, minat, dan respons peserta didik. Kerangka Krathwohl yang umum diringkas memiliki lima tingkat:", "Bodyx"),
          bullets([
              "<b>A1 Menerima:</b> bersedia memperhatikan. Contoh: menyimak aturan keselamatan digital.",
              "<b>A2 Merespons:</b> berpartisipasi. Contoh: aktif berdiskusi tentang etika digital.",
              "<b>A3 Menilai:</b> menunjukkan penghargaan terhadap nilai tertentu. Contoh: menghargai hak cipta karya digital.",
              "<b>A4 Mengorganisasi:</b> menyusun nilai ke dalam sistem prioritas. Contoh: menyeimbangkan kolaborasi dan tanggung jawab individual.",
              "<b>A5 Menghayati/karakterisasi:</b> nilai tercermin konsisten dalam perilaku. Contoh: secara konsisten mencantumkan sumber aset digital."
          ]),
          P("Pengukuran afektif dapat menggunakan observasi, jurnal refleksi, angket, atau penilaian diri/teman sebaya. Hindari menyimpulkan sikap seseorang dari satu kejadian saja.", "Bodyx"),
          P("5.3 Ranah psikomotor", "H2x"),
          P("Ranah psikomotor berhubungan dengan keterampilan melakukan tindakan atau prosedur. Salah satu kerangka yang sering digunakan adalah Dave:", "Bodyx"),
          bullets([
              "<b>P1 Imitasi:</b> meniru contoh. Contoh: mengikuti demonstrasi membuat folder.",
              "<b>P2 Manipulasi:</b> melakukan langkah berdasarkan instruksi. Contoh: mengatur format sel sesuai panduan.",
              "<b>P3 Presisi:</b> melakukan keterampilan dengan akurat. Contoh: memasukkan rumus dengan referensi sel yang tepat.",
              "<b>P4 Artikulasi:</b> menggabungkan beberapa keterampilan. Contoh: mengolah data, membuat grafik, dan memformat laporan.",
              "<b>P5 Naturalisasi:</b> melakukan keterampilan kompleks secara lancar dan konsisten. Contoh: menyelesaikan rangkaian tugas aplikasi secara efisien."
          ]),
          P("5.4 Memilih teknik penilaian sesuai ranah", "H2x"),
          table(["Ranah","Teknik yang sesuai","Contoh bukti"], [
              ["Kognitif","Tes tertulis/lisan, kuis, soal pemecahan masalah.","Jawaban, alasan, analisis, rancangan algoritma."],
              ["Afektif","Observasi terencana, angket, refleksi, penilaian diri/teman.","Catatan perilaku, refleksi, respons terhadap kriteria."],
              ["Psikomotor","Tes praktik, observasi kinerja, checklist, rubrik produk/proyek.","Hasil kerja, langkah kerja, akurasi, produk digital."]
          ], [2.5*cm, 6.3*cm, 7.2*cm]),
          PageBreak()]

# Topic 6
story += [P("TOPIK 6. BENTUK DAN JENIS TES", "H1x"),
          P("6.1 Berdasarkan cara pelaksanaan", "H2x"),
          table(["Bentuk","Ciri","Contoh"], [
              ["Tes tertulis","Jawaban diberikan secara tertulis atau melalui sistem digital.","Pilihan ganda tentang keamanan siber."],
              ["Tes lisan","Siswa menjawab pertanyaan secara langsung.","Menjelaskan cara kerja algoritma."],
              ["Tes praktik/kinerja","Siswa menunjukkan keterampilan melalui tindakan atau produk.","Membuat tabel dan grafik dalam spreadsheet."]
          ], [3.0*cm, 6.4*cm, 6.6*cm]),
          P("6.2 Jenis butir tes tertulis", "H2x"),
          table(["Jenis soal","Kelebihan","Hal yang perlu dijaga"], [
              ["Pilihan ganda","Pemeriksaan efisien dan cakupan materi dapat luas.","Pengecoh harus masuk akal; hindari petunjuk jawaban."],
              ["Pilihan ganda kompleks","Dapat mengukur beberapa pernyataan/opsi yang benar.","Aturan memilih jawaban harus sangat jelas."],
              ["Benar-salah","Ringkas dan mudah diperiksa.","Peluang menebak tinggi; pernyataan harus tidak ambigu."],
              ["Menjodohkan","Efisien untuk pasangan istilah dan fungsi.","Gunakan materi yang homogen dan petunjuk yang jelas."],
              ["Jawaban singkat","Mengukur ingatan atau jawaban ringkas.","Tentukan bentuk jawaban yang dapat diterima."],
              ["Uraian/esai","Dapat mengukur penalaran dan argumentasi lebih mendalam.","Memerlukan rubrik agar penskoran konsisten."]
          ], [3.0*cm, 6.2*cm, 6.8*cm]),
          P("6.3 Objektif dan subjektif", "H2x"),
          P("<b>Soal objektif</b> memiliki aturan jawaban dan penskoran yang relatif tegas, misalnya pilihan ganda atau benar-salah. <b>Soal uraian</b> memberi ruang bagi jawaban yang dikembangkan siswa sehingga membutuhkan pedoman penskoran atau rubrik yang jelas. Istilah objektif/subjektif merujuk pada karakteristik penskoran, bukan berarti salah satu selalu lebih baik.", "Bodyx"),
          P("6.4 Berdasarkan tujuan penggunaan", "H2x"),
          bullets([
              "<b>Diagnostik:</b> mengenali kemampuan awal atau kesulitan tertentu.",
              "<b>Formatif:</b> memberi informasi untuk memperbaiki pembelajaran selama proses berlangsung.",
              "<b>Sumatif:</b> merangkum pencapaian pada akhir unit atau periode.",
              "<b>Seleksi:</b> membantu memilih peserta berdasarkan kriteria yang ditetapkan, jika sesuai tujuan dan kebijakan."
          ]),
          P("6.5 Memilih bentuk tes sesuai kompetensi", "H2x"),
          table(["Kompetensi","Bentuk yang disarankan","Alasan"], [
              ["Mengingat istilah","Pilihan ganda/jawaban singkat","Efisien untuk memeriksa pengetahuan dasar."],
              ["Menjelaskan konsep","Uraian singkat atau lisan","Memberi kesempatan siswa menjelaskan dengan kata sendiri."],
              ["Menganalisis kode","Pilihan ganda berbasis kasus atau uraian","Memerlukan penalaran terhadap konteks/kode."],
              ["Membuat program","Tes praktik/proyek dengan rubrik","Kompetensi utama berupa keterampilan menghasilkan produk."]
          ], [4.0*cm, 5.8*cm, 6.2*cm]),
          PageBreak()]

# Topic 7
story += [P("TOPIK 7. PENYUSUNAN KISI-KISI TES", "H1x"),
          P("7.1 Pengertian dan fungsi", "H2x"),
          P("Kisi-kisi tes adalah matriks atau tabel yang menjadi pedoman dalam menyusun soal berdasarkan kompetensi/tujuan, materi, indikator, level kognitif, bentuk soal, dan nomor atau jumlah soal. Kisi-kisi dibuat sebelum butir soal agar tes terarah dan sesuai tujuan pembelajaran.", "Bodyx"),
          bullets([
              "Menjadi cetak biru atau pedoman penulisan soal.",
              "Menjaga kesesuaian antara soal, materi, dan tujuan pembelajaran.",
              "Membantu memastikan cakupan materi terwakili.",
              "Membantu merencanakan bentuk soal dan tingkat kemampuan yang diukur."
          ]),
          P("7.2 Komponen kisi-kisi", "H2x"),
          table(["Komponen","Isi"], [
              ["Identitas","Mata pelajaran, kelas/fase, semester, materi, bentuk tes."],
              ["CP/kompetensi dan TP","Capaian atau tujuan yang menjadi dasar penilaian; gunakan dokumen kurikulum yang berlaku."],
              ["Materi","Pokok bahasan yang diujikan."],
              ["Indikator soal","Kemampuan spesifik yang harus ditunjukkan siswa."],
              ["Level kognitif","C1–C6 atau klasifikasi yang digunakan."],
              ["Bentuk soal","Pilihan ganda, uraian, praktik, dan sebagainya."],
              ["Nomor/jumlah soal","Penempatan indikator dalam nomor dan distribusi butir."]
          ], [4.0*cm, 12.0*cm]),
          P("7.3 Merumuskan indikator yang baik", "H2x"),
          P("Indikator yang baik menjelaskan perilaku yang dapat diamati, materi/konteks yang relevan, dan kondisi yang diperlukan. Hindari indikator terlalu umum seperti “siswa memahami algoritma”.", "Bodyx"),
          P("<b>Kurang jelas:</b> Siswa memahami algoritma.<br/><b>Lebih jelas:</b> Disajikan pseudocode sederhana, siswa dapat menentukan keluaran program dengan benar.", "Calloutx"),
          P("Kata kerja yang sering digunakan: C1 menyebutkan/mengidentifikasi; C2 menjelaskan/menafsirkan; C3 menerapkan/menghitung; C4 menganalisis/menemukan kesalahan; C5 menilai/membandingkan berdasarkan kriteria; C6 merancang/mengembangkan. Level ditentukan oleh proses berpikir yang diperlukan, bukan kata kerja saja.", "Bodyx"),
          P("7.4 Langkah penyusunan kisi-kisi", "H2x"),
          bullets([
              "Tentukan identitas tes dan tujuan penilaian.",
              "Pelajari CP/kompetensi dan tetapkan TP yang akan diukur.",
              "Pilih materi yang relevan dan sudah dipelajari.",
              "Rumuskan indikator soal yang spesifik dan dapat diukur.",
              "Tentukan level kognitif berdasarkan tuntutan berpikir.",
              "Pilih bentuk soal dan jumlah butir yang proporsional.",
              "Tentukan nomor soal dan periksa seluruh kesesuaian.",
              "Susun soal, kunci jawaban, dan pedoman penskoran berdasarkan kisi-kisi."
          ]),
          P("7.5 Contoh kisi-kisi tes Informatika", "H2x"),
          P("Identitas ilustratif: Informatika kelas XI, materi algoritma dan pemrograman, tes pilihan ganda dan uraian, 5 butir.", "Bodyx"),
          table(["No.","Materi","Indikator soal","Level","Bentuk"], [
              ["1","Konsep algoritma","Siswa dapat mengidentifikasi definisi algoritma yang tepat.","C1","Pilihan ganda"],
              ["2","Urutan instruksi","Disajikan urutan langkah, siswa dapat menjelaskan fungsi urutan instruksi.","C2","Pilihan ganda"],
              ["3","Pseudocode","Disajikan pseudocode sederhana, siswa dapat menentukan keluaran program.","C3","Pilihan ganda"],
              ["4","Percabangan","Disajikan pseudocode yang mengandung kesalahan logika, siswa dapat menemukan kesalahan dan alasannya.","C4","Uraian"],
              ["5","Pemecahan masalah","Siswa dapat merancang algoritma untuk menentukan bilangan terbesar dari tiga bilangan.","C6","Uraian"]
          ], [0.8*cm, 2.6*cm, 7.5*cm, 1.2*cm, 3.7*cm]),
          P("7.6 Contoh soal dari kisi-kisi", "H2x"),
          P("<b>Indikator C3:</b> Disajikan pseudocode sederhana, siswa dapat menentukan keluaran program.<br/><br/><font name='Courier'>x ← 4<br/>y ← 3<br/>z ← x + y<br/>Tampilkan z</font><br/><br/>Pertanyaan: Berapakah keluaran program? Jawaban: 7.", "Bodyx"),
          P("<b>Indikator C4:</b> Diberikan pseudocode: jika nilai ≥ 75 maka tampilkan “Belum Lulus”, selain itu tampilkan “Lulus”. Jika batas kelulusan adalah 75, jelaskan kesalahan logika dan perbaikannya.<br/><b>Garis besar jawaban:</b> pesan kelulusan terbalik; kondisi nilai ≥ 75 seharusnya menampilkan “Lulus”.", "Bodyx"),
          P("7.7 Kesalahan umum", "H2x"),
          bullets([
              "Indikator terlalu umum atau tidak dapat diamati.",
              "Soal tidak mengukur indikator yang ditulis.",
              "Level kognitif tidak sesuai dengan proses berpikir yang dibutuhkan.",
              "Ada tujuan penting yang tidak terwakili dalam tes.",
              "Distribusi jumlah soal tidak mempertimbangkan tujuan dan cakupan