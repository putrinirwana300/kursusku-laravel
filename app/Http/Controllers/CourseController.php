<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Http\Request; 

class CourseController extends Controller
{
    public function index(Request $request) 
    {
        // 1. Ambil input search dan filter dari URL
        $search = trim((string) $request->query('q'));
        $status = trim((string) $request->query('status'));
        $allowedStatuses = ['open', 'closed', 'draft'];

        // 2. Query Database dengan Search, Filter, dan Pagination
        $courses = Course::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', '%' . $search . '%')
                      ->orWhere('name', 'like', '%' . $search . '%');
                });
            })
            ->when(in_array($status, $allowedStatuses, true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest() 
            ->paginate(10) 
            ->withQueryString(); 

        // 3. Tambahan Proyek: Dashboard Count
        $totalCourses = Course::count();
        $openCourses = Course::where('status', 'open')->count();

        // 4. TAMBAHAN BARU: Cek jika request berasal dari Ajax (Live Search)
        if ($request->boolean('partial')) {
            return view('courses._results', compact('courses'));
        }

        // 5. Kirim data ke view utama (Full Page)
        return view('courses.index', compact('courses', 'search', 'status', 'totalCourses', 'openCourses'));
    }

    public function create()
    {
        return view('courses.create');
    }
    
    public function store(StoreCourseRequest $request)
    {
        Course::create($request->validated());
        return to_route('courses.index')->with('success', 'Kursus berhasil ditambahkan.');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());
        return to_route('courses.show', $course)->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return to_route('courses.index')->with('success', 'Kursus berhasil dihapus.');
    }
}