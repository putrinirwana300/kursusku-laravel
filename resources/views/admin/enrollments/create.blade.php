@extends('layouts.app')

@section('title', 'Tambah Enrollment')

@section('content')
<div class="container py-4" style="max-width: 760px">
    <h1 class="h3 mb-3">Tambah Enrollment (Admin)</h1>

    <form method="POST" action="{{ route('admin.enrollments.store') }}" class="card card-body">
        @csrf

        <!-- Pilih Participant -->
        <div class="mb-3">
            <label for="participant_id" class="form-label">Participant</label>
            <select name="participant_id" id="participant_id" class="form-select" required>
                <option value="">-- Pilih Participant --</option>
                @foreach ($participants as $participant)
                    <option value="{{ $participant->id }}" @selected(old('participant_id') == $participant->id)>
                        {{ $participant->name }} - {{ $participant->email }}
                    </option>
                @endforeach
            </select>
            @error('participant_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <!-- Pilih Course -->
        <div class="mb-3">
            <label for="course_id" class="form-label">Course</label>
            <select name="course_id" id="course_id" class="form-select" required>
                <option value="">-- Pilih Course --</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
                        {{ $course->code }} - {{ $course->name }}
                    </option>
                @endforeach
            </select>
            @error('course_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Simpan Enrollment</button>
    </form>
</div>
@endsection