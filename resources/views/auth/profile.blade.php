@extends('layouts.app')

@section('title', 'Profil Saya - KursusKu')

@section('content')
<div class="container py-5">

    <!-- POP-UP BERHASIL LOGIN -->
    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
    <!-- ----------------------- -->

    <div class="row">
        <!-- ========================================== -->
        <!-- KOLOM KIRI: Identitas & Kontak             -->
        <!-- ========================================== -->
        <div class="col-md-7">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <!-- Header Profil -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-light rounded-circle p-3 me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <span class="fs-5 fw-bold text-secondary">A</span>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Identitas & Kontak</h5>
                            <small class="text-muted">Role tidak dapat diubah dari halaman profil publik.</small>
                        </div>
                    </div>

                    <!-- Form Identitas -->
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Nama Lengkap *</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Email Login *</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Nomor HP</label>
                                <input type="text" class="form-control" placeholder="Contoh: 081234567890">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Jabatan</label>
                                <input type="text" class="form-control" value="Administrator Sistem">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Alamat</label>
                            <textarea class="form-control" rows="2" placeholder="Alamat lengkap..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Bio Singkat</label>
                            <textarea class="form-control" rows="2" placeholder="Bio singkat...">CEO</textarea>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-success" style="background-color: #0f766e;">Simpan Profil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- KOLOM KANAN: Akses & Keamanan              -->
        <!-- ========================================== -->
        <div class="col-md-5">
            <!-- Informasi Akses -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-muted mb-3">ACCOUNT ACCESS</h6>
                    <h5 class="fw-bold mb-3">Informasi akses</h5>
                    <div class="mb-2">
                        <small class="text-muted d-block">Role</small>
                        <span class="badge bg-dark">Admin</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge bg-success">Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-muted mb-3">SECURITY</h6>
                    <h5 class="fw-bold mb-3">Ganti Password</h5>
                    <p class="text-muted small mb-3">Password baru minimal 8 karakter serta mengandung huruf besar, kecil, angka, dan simbol.</p>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small">Password Saat Ini</label>
                        <input type="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Password Baru</label>
                        <input type="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control">
                    </div>
                    <button type="button" class="btn btn-outline-secondary w-100">Perbarui Password</button>
                </div>
            </div>
            
            <!-- Tombol Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
        </div>
    </div>
</div>
@endsection