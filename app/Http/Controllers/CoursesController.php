<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CoursesController extends Controller
{
    public function index(): JsonResponse
    {
        $dataCourses = Courses::all();
        return response()->json($dataCourses, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $course = Courses::findOrFail($id);
            return response()->json($course, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Course tidak ditemukan'], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        // Validasi input
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'credits' => 'required|integer|min:1',
                'semester' => 'required|string|max:50',
            ]);

            // Menambahkan data course baru
            $course = Courses::create([
                'name' => $request->name,
                'code' => $request->code,
                'credits' => $request->credits,
                'semester' => $request->semester,
            ]);

            return response()->json([
                'message' => 'Course berhasil ditambahkan.',
                'data' => $course
            ], 201);
        }catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Course tidak berhasil ditambahkan'], 404);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            // Mencari course berdasarkan id
            $course = Courses::findOrFail($id);

            // Validasi input
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'code' => 'sometimes|string|max:255',
                'credits' => 'sometimes|integer|min:1',
                'semester' => 'sometimes|string|max:50',
            ]);

            // Update hanya field yang dikirim
            $data = $request->only(['name', 'code', 'credits', 'semester']);
            $course->update($data);

            return response()->json([
                'message' => $course->wasChanged()
                    ? 'Data course berhasil diupdate.'
                    : 'Tidak ada perubahan pada data course.',
                'data' => $course
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Course tidak ditemukan'], 404);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            // Mencari dan menghapus course berdasarkan id
            $course = Courses::findOrFail($id);
            $course->delete();

            return response()->json(['message' => 'Data course berhasil dihapus.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Course tidak ditemukan.'], 404);
        }
    }
}
