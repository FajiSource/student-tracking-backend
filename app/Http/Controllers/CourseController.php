<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //

    public function index()
    {
        $course = Course::all();
        return response()->json($course);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'courseName' => 'required|string|max:255'
        ]);

        $course = Course::create([
            'courseName' => $validated['courseName']
        ]);

        return response()->json([
            'message' => 'Course created successfully',
            'course' => $course
        ], 201);
    }
}
