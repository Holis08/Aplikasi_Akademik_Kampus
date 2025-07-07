<?php

namespace App\Http\Controllers;

use App\Models\CourseLecturer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseLecturerController extends Controller
{
    public function index(): JsonResponse
    {
        $courseLecturers = CourseLecturer::with(['course', 'lecturer'])->get();
        return response()->json($courseLecturers, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $courseLecturer = CourseLecturer::with(['course', 'lecturer'])->findOrFail($id);
            return response()->json($courseLecturer, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Course Lecturer tidak ditemukan.'], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lecturer_id' => 'required|exists:lecturers,id',
            'role' => 'required|integer|min:0',
        ]);

        $courseLecturer = CourseLecturer::create($request->only([
            'course_id', 'lecturer_id', 'role'
        ]));

        return response()->json([
            'message' => 'Course Lecturer berhasil ditambahkan.',
            'data' => $courseLecturer
        ], 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $courseLecturer = CourseLecturer::findOrFail($id);

            $request->validate([
                'course_id' => 'sometimes|exists:courses,id',
                'lecturer_id' => 'sometimes|exists:lecturers,id',
                'role' => 'sometimes|integer|min:0',
            ]);

            $courseLecturer->update($request->only([
                'course_id', 'lecturer_id', 'role'
            ]));

            return response()->json([
                'message' => $courseLecturer->wasChanged()
                    ? 'Course Lecturer berhasil diupdate.'
                    : 'Tidak ada perubahan pada data course lecturer.',
                'data' => $courseLecturer
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Course Lecturer tidak ditemukan.'], 404);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $courseLecturer = CourseLecturer::findOrFail($id);
            $courseLecturer->delete();

            return response()->json(['message' => 'Course Lecturer berhasil dihapus.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Course Lecturer tidak ditemukan.'], 404);
        }
    }
}
