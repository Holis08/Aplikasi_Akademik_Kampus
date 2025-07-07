<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentController extends Controller
{
    // Menampilkan semua student
    public function index(): JsonResponse
    {
        $dataStudent = Student::all();
        return response()->json($dataStudent, 200);
    }

    // Menampilkan student berdasarkan ID
    public function show($id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            return response()->json($student, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }

    // Menambahkan student baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'NIM' => 'required|string|max:255|unique:students,NIM',
            'password' => 'required|string|min:8',
            'major' => 'nullable|string|max:255',
            'enrollment_year' => 'nullable|date',
        ]);

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'NIM' => $request->NIM,
            'password' => bcrypt($request->password),
            'major' => $request->major,
            'enrollment_year' => $request->enrollment_year,
        ]);

        return response()->json([
            'message' => 'Akun student berhasil ditambahkan.',
            'data' => $student
        ], 201);
    }

    // Mengupdate data student
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);

            $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:students,email,' . $id,
                'NIM' => 'sometimes|string|max:255|unique:students,NIM,' . $id,
                'password' => 'sometimes|string|min:8',
                'major' => 'nullable|string|max:255',
                'enrollment_year' => 'nullable|date',
            ]);

            $data = $request->only(['name', 'email', 'NIM', 'password', 'major', 'enrollment_year']);

            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            $student->update($data);

            return response()->json([
                'message' => $student->wasChanged()
                    ? 'Akun student berhasil diupdate.'
                    : 'Tidak ada perubahan pada data student.',
                'data' => $student
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student tidak ditemukan.'], 404);
        }
    }

    // Menghapus student
    public function destroy($id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();

            return response()->json(['message' => 'Student berhasil dihapus.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student tidak ditemukan.'], 404);
        }
    }
}
