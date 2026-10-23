@extends('layouts.app')

@section('title', 'Pendaftaran Kursus')

@section('content')
<section class="section">
    <div class="container" style="max-width: 600px;">
        <div style="background:white; padding:32px; border-radius:16px; border:1px solid #ddd;">
            <h1 style="margin-top:0;">Pendaftaran Kursus</h1>
            <p style="color:#666;">Gunakan data pribadi. Field bertanda wajib harus diisi.</p>
            
            <form method="POST" action="{{ route('enrollments.preview') }}">
                @csrf
                
                <!-- 1. NAMA -->
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-weight:bold; margin-bottom:8px;">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                </div>
                
                <!-- 2. EMAIL -->
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-weight:bold; margin-bottom:8px;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                </div>

                <!-- 3. NOMOR HP (BARU) -->
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-weight:bold; margin-bottom:8px;">Nomor HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                </div>

                <!-- 4. PROGRAM STUDI (BARU) -->
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-weight:bold; margin-bottom:8px;">Program Studi</label>
                    <input type="text" name="prodi" value="{{ old('prodi') }}" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                </div>
                
                <!-- 5. PILIH KURSUS (BAWAAN LARAVEL) -->
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-weight:bold; margin-bottom:8px;">Pilih Kursus</label>
                    <select id="course_id" name="course_id" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                        <option value="">-- Pilih Kursus --</option>
                        @foreach ($courses as $id => $course)
                            <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>{{ $course['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 6. METODE BELAJAR (BARU) -->
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-weight:bold; margin-bottom:8px;">Metode Belajar</label>
                    <select name="metode" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                        <option value="">-- Pilih metode --</option>
                        <option value="Online" {{ old('metode') == 'Online' ? 'selected' : '' }}>Online</option>
                        <option value="Offline" {{ old('metode') == 'Offline' ? 'selected' : '' }}>Offline</option>
                    </select>
                </div>

                <!-- 7. JENIS PESERTA (BARU) -->
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-weight:bold; margin-bottom:8px;">Jenis Peserta</label>
                    <div style="display:flex; gap:15px;">
                        <label style="font-weight:normal;"><input type="radio" name="peserta" value="Mahasiswa" {{ old('peserta') == 'Mahasiswa' ? 'checked' : '' }} required> Mahasiswa</label>
                        <label style="font-weight:normal;"><input type="radio" name="peserta" value="Umum" {{ old('peserta') == 'Umum' ? 'checked' : '' }}> Umum</label>
                        <label style="font-weight:normal;"><input type="radio" name="peserta" value="Guru" {{ old('peserta') == 'Guru' ? 'checked' : '' }}> Guru</label>
                    </div>
                </div>

                <!-- 8. MINAT TAMBAHAN (BARU) -->
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-weight:bold; margin-bottom:8px;">Minat Tambahan</label>
                    <div style="display:flex; gap:15px;">
                        <label style="font-weight:normal;"><input type="radio" name="minat" value="UI/UX" {{ old('minat') == 'UI/UX' ? 'checked' : '' }}> UI/UX</label>
                        <label style="font-weight:normal;"><input type="radio" name="minat" value="Database" {{ old('minat') == 'Database' ? 'checked' : '' }}> Database</label>
                        <label style="font-weight:normal;"><input type="radio" name="minat" value="Backend" {{ old('minat') == 'Backend' ? 'checked' : '' }}> Backend</label>
                        <label style="font-weight:normal;"><input type="radio" name="minat" value="Frontend" {{ old('minat') == 'Frontend' ? 'checked' : '' }}> Frontend</label>
                    </div>
                </div>

                <!-- 9. CATATAN (BARU) -->
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-weight:bold; margin-bottom:8px;">Catatan</label>
                    <textarea name="catatan" rows="3" placeholder="Tuliskan kebutuhan belajar Anda (opsional)" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">{{ old('catatan') }}</textarea>
                </div>

                <!-- Kotak Ajax Sisa Kursi (Bawaan Laravel) -->
                <div id="availability" style="padding:12px; background:#e2e8f0; border-radius:6px; margin-bottom:16px; color:#333;">
                    Pilih kursus untuk melihat sisa kursi.
                </div>

                <!-- KOTAK FASILITAS (BARU) -->
                <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; margin-bottom: 24px; background-color: #fff;">
                    <h3 style="margin-top: 0; margin-bottom: 12px; font-size: 16px; color: #333;">Fasilitas</h3>
                    <ul style="margin: 0; padding-left: 20px; color: #444; line-height: 1.6;">
                        <li>Modul digital</li>
                        <li>Sertifikat penyelesaian</li>
                        <li>Forum diskusi kelas</li>
                    </ul>
                </div>

                <!-- TOMBOL SUBMIT -->
                <button type="submit" class="button" style="width:100%; border:none; cursor:pointer;">
                    Proses Pendaftaran
                </button>
            </form>
        </div>
    </div>
</section>
@endsection