<?php

namespace App\Http\Controllers;

use App\Models\Course_Lecturers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseLecturersController extends Controller
{
    public function index(): JsonResponse
    {
        $course__lecturers = Course_Lecturers::all();
        return response()->json($course__lecturers, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $course__lecturers = Course_Lecturers::findOrFail($id);
            return response()->json($course__lecturers, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'course__lecturers tidak ditemukan'], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'course_id' => 'required|string|max:255|exists:courses,id',
                'lecturer_id' => 'required|string|exists:lecturers,id',
                'role' => 'required|string|max:255',
            ]);

            $course__lecturers = Course_Lecturers::create([
                'course_id' => $request->course_id,
                'lecturer_id' => $request->lecturer_id,
                'role' => $request->role,
            ]);

            return response()->json([
                'message' => 'Course_Lecturers berhasil ditambahkan.',
                'data' => $course__lecturers
            ], 201);
        }catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Course_Lecturers tidak berhasil ditambahkan'], 404);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {

            $course__lecturers = Course_Lecturers::findOrFail($id);

            $request->validate([
                'course_id' => 'required|string|max:255|exists:courses,id',
                'lecturer_id' => 'required|string|max:255|exists:lecturers,id',
                'role' => 'required|string|max:255',
            ]);

            // Update hanya field yang dikirim
            $data = $request->only(['course_id', 'lecturer_id' , 'role']);
            $course__lecturers->update($data);

            return response()->json([
                'message' => $course__lecturers->wasChanged()
                    ? 'Data lecturers berhasil diupdate.'
                    : 'Tidak ada perubahan pada data lecturers.',
                'data' => $course__lecturers
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Course_Lecturers tidak ditemukan'], 404);
        }
    }


    public function destroy($id): JsonResponse
    {
        try {
            $course = Course_Lecturers::findOrFail($id);
            $course->delete();

            return response()->json(['message' => 'Data Course_Lecturers berhasil dihapus.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Course_Lecturers tidak ditemukan.'], 404);
        }
    }
}
