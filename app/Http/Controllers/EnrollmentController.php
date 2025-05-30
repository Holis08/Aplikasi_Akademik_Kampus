<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EnrollmentController extends Controller
{
    public function index(): JsonResponse
    {
        $enrollment = Enrollment::all();
        return response()->json($enrollment, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $enrollment = Enrollment::findOrFail($id);
            return response()->json($enrollment, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'enrollment tidak ditemukan'], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'student_id' => 'required|string|max:255|exists:students,id',
                'course_id' => 'required|string|max:255|exists:courses,id',
                'grade' => 'required|string|max:255',
                'attendance' => 'required|string|max:255',
                'status' => 'required|string|max:255',
            ]);

            // Menambahkan data course baru
            $enrollment = Enrollment::create([
                'student_id' => $request->student_id,
                'course_id' => $request->course_id,
                'grade' => $request->grade,
                'attendance' => $request->attendance,
                'status' => $request->status,
            ]);

            return response()->json([
                'message' => 'Enrollment berhasil ditambahkan.',
                'data' => $enrollment
            ], 201);
        }catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Enrollment tidak berhasil ditambahkan'], 404);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            // Mencari course berdasarkan id
            $enrollment = Enrollment::findOrFail($id);

            // Validasi input
            $request->validate([
                'student_id' => 'required|string|max:255|exists:studentslu,id',
                'course_id' => 'required|string|max:255|exists:courses,id',
                'grade' => 'required|string|max:255',
                'attendance' => 'required|string|max:255',
                'status' => 'required|string|max:255',
            ]);

            // Update hanya field yang dikirim
            $data = $request->only(['student_id', 'course_id', 'grade', 'attendance' , 'status']);
            $enrollment->update($data);

            return response()->json([
                'message' => $enrollment->wasChanged()
                    ? 'Data enrollment berhasil diupdate.'
                    : 'Tidak ada perubahan pada data enrollment.',
                'data' => $enrollment
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'enrollment tidak ditemukan'], 404);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $course = Enrollment::findOrFail($id);
            $course->delete();

            return response()->json(['message' => 'Data Enrollment berhasil dihapus.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Enrollment tidak ditemukan.'], 404);
        }
    }

}
