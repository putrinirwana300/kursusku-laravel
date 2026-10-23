<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

$coursesData = [
    1 => ['name' => 'Web Dasar', 'fee' => 200000, 'quota' => 30, 'registered' => 12],
    2 => ['name' => 'PHP Dasar', 'fee' => 250000, 'quota' => 30, 'registered' => 18],
    3 => ['name' => 'PHP Lanjutan', 'fee' => 300000, 'quota' => 25, 'registered' => 24],
    4 => ['name' => 'Laravel Fundamental', 'fee' => 350000, 'quota' => 25, 'registered' => 25],
    5 => ['name' => 'MySQL Dasar', 'fee' => 275000, 'quota' => 20, 'registered' => 0],
    6 => ['name' => 'UI Web Dasar', 'fee' => 225000, 'quota' => 35, 'registered' => 9],
];

Route::get('/pendaftaran', function () use ($coursesData) {
    return view('enrollments.create', ['courses' => $coursesData]);
})->name('enrollments.create');

Route::post('/pendaftaran/preview', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'min:3', 'max:100'],
        'email' => ['required', 'email'],
        'course_id' => ['required', 'integer'],
    ]);
    return back()->with('success', 'Form lolos validasi.')->withInput();
})->name('enrollments.preview');

Route::get('/courses/{course}/availability', function (int $course) use ($coursesData) {
    abort_unless(isset($coursesData[$course]), 404);
    $data = $coursesData[$course];
    $remaining = max(0, $data['quota'] - $data['registered']);
    return response()->json(['course' => $data['name'], 'remaining' => $remaining]);
})->name('courses.availability');