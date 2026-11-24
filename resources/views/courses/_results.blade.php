<div id="course-results">
    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Biaya</th>
                    <th>Kuota</th>
                    <th>Mulai</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courses as $course)
                    <tr>
                        <td class="align-middle">{{ $course->code }}</td>
                        <td class="align-middle">{{ $course->name }}</td>
                        <td class="align-middle">Rp {{ number_format($course->fee, 0, ',', '.') }}</td>
                        <td class="align-middle">{{ $course->quota }}</td>
                        <td class="align-middle">{{ $course->start_date->format('d/m/Y') }}</td>
                        <td class="align-middle">
                            <span class="badge bg-{{ $course->status == 'open' ? 'success' : ($course->status == 'closed' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-info">Detail</a>
                                <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Hapus kursus ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            Tidak ada kursus yang sesuai pencarian/filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted small">
            Menampilkan {{ $courses->firstItem() ?? 0 }} - {{ $courses->lastItem() ?? 0 }} dari {{ $courses->total() }} data
        </div>
        <div>
            {{ $courses->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>