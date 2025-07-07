<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EnrollmentController extends Controller
{
    // Menampilkan semua enrollment
    public function index(): JsonResponse
    {
        $enrollments = Enrollment::with(['student', 'course'])->get();
        return response()->json($enrollments, 200);
    }

    // Menampilkan enrollment berdasarkan ID
    public function show($id): JsonResponse
    {
        try {
            $enrollment = Enrollment::with(['student', 'course'])->findOrFail($id);
            return response()->json($enrollment, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Enrollment tidak ditemukan.'], 404);
        }
    }

    // Menambahkan enrollment baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|string|max:10',
            'attendance' => 'required|integer|min:0',
            'status' => 'required|string|max:255',
        ]);

        $enrollment = Enrollment::create($request->only([
            'student_id', 'course_id', 'grade', 'attendance', 'status'
        ]));

        return response()->json([
            'message' => 'Enrollment berhasil ditambahkan.',
            'data' => $enrollment
        ], 201);
    }

    // Mengupdate data enrollment
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $enrollment = Enrollment::findOrFail($id);

            $request->validate([
                'student_id' => 'sometimes|exists:students,id',
                'course_id' => 'sometimes|exists:courses,id',
                'grade' => 'sometimes|string|max:10',
                'attendance' => 'sometimes|integer|min:0',
                'status' => 'sometimes|string|max:255',
            ]);

            $enrollment->update($request->only([
                'student_id', 'course_id', 'grade', 'attendance', 'status'
            ]));

            return response()->json([
                'message' => $enrollment->wasChanged()
                    ? 'Enrollment berhasil diupdate.'
                    : 'Tidak ada perubahan pada data enrollment.',
                'data' => $enrollment
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Enrollment tidak ditemukan.'], 404);
        }
    }

    // Menghapus enrollment
    public function destroy($id): JsonResponse
    {
        try {
            $enrollment = Enrollment::findOrFail($id);
            $enrollment->delete();

            return response()->json(['message' => 'Enrollment berhasil dihapus.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Enrollment tidak ditemukan.'], 404);
        }
    }
}
