@extends('layouts.app')

@section('title', 'Daftar Kursus')

@section('content')
<div class="container py-4">
    <!-- Header: Judul dan Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Daftar Kursus</h1>
            <p class="text-muted mb-0">Data diambil dari MySQL melalui Eloquent.</p>
        </div>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">+ Tambah Kursus</a>
    </div>

    <!-- Dashboard Count: Dibuat sejajar dan rapi -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body py-2">
                    <h6 class="mb-0">Total Kursus: {{ $totalCourses ?? 0 }}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body py-2">
                    <h6 class="mb-0">Kursus Open: {{ $openCourses ?? 0 }}</h6>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Search & Filter: DITAMBAHKAN ID live-search & status-filter -->
    <div class="card shadow-sm mb-3">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('courses.index') }}" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <!-- TAMBAHAN: id="live-search" -->
                    <input type="search" id="live-search" name="q" value="{{ $search ?? '' }}" class="form-control" placeholder="Cari kode atau nama kursus...">
                </div>
                <div class="col-md-3">
                    <!-- TAMBAHAN: id="status-filter" -->
                    <select name="status" id="status-filter" class="form-select">
                        <option value="">Semua status</option>
                        <option value="open" @selected(($status ?? '') === 'open')>Open</option>
                        <option value="closed" @selected(($status ?? '') === 'closed')>Closed</option>
                        <option value="draft" @selected(($status ?? '') === 'draft')>Draft</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data: DIGANTI MENJADI PARTIAL VIEW -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <!-- TAMBAHAN: Memanggil file _results.blade.php -->
            @include('courses._results')
        </div>
    </div>

</div>

<!-- TAMBAHAN: Script jQuery untuk Ajax Live Search -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let searchTimer;

    function loadCourses(url = '{{ route('courses.index') }}') {
        const q = $('#live-search').val();
        const status = $('#status-filter').val();
        
        // Kirim request Ajax dengan parameter partial=1
        $.get(url, { q: q, status: status, partial: 1 })
        .done(function (html) {
            // Ganti isi tabel dengan hasil baru
            $('#course-results').replaceWith(html);
        })
        .fail(function () {
            console.error('Gagal memuat hasil course.');
        });
    }

    // 1. Event saat mengetik (Debounce 300ms)
    $(document).on('input', '#live-search', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            loadCourses();
        }, 300);
    });

    // 2. Event saat ganti filter status
    $(document).on('change', '#status-filter', function () {
        loadCourses();
    });

    // 3. Event saat klik pagination
    $(document).on('click', '#course-results .pagination a', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        loadCourses(url);
    });
</script>
@endsection