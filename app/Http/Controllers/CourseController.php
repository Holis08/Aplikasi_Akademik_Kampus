<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index()
    {
        return response()->json(Course::all());
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code',
            'credits' => 'required|string|max:10',
            'semester' => 'required|string|max:10',
        ]);

        $course = Course::create($validated);

        return response()->json($course, 201);
    }

    /**
     * Display the specified course.
     */
    public function show(string $id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:50|unique:courses,code,' . $course->id,
            'credits' => 'sometimes|required|string|max:10',
            'semester' => 'sometimes|required|string|max:10',
        ]);

        $course->update($validated);

        return response()->json($course);
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Course deleted successfully.']);
    }
}
