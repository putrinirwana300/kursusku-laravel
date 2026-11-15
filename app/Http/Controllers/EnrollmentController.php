<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['participant', 'course'])
            ->latest()
            ->get();

        // Diperbaiki: Menambahkan 'admin.' di depan 'enrollments.index'
        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $participants = Participant::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();

        // Diperbaiki: Menambahkan 'admin.' di depan 'enrollments.create'
        return view('admin.enrollments.create', compact('participants', 'courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'participant_id' => ['required', 'exists:participants,id'],
            'course_id' => [
                'required',
                'exists:courses,id',
                Rule::unique('enrollments')->where(
                    fn ($query) => $query->where('participant_id', $request->participant_id)
                ),
            ],
        ], [
            'course_id.unique' => 'Participant ini sudah terdaftar pada course tersebut.',
        ]);

        $data['status'] = 'registered';
        Enrollment::create($data);

        // Diperbaiki: Redirect ke route 'admin.enrollments.index'
        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment berhasil disimpan.');
    }
}