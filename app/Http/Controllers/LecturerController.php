<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LecturerController extends Controller
{
    // Menampilkan semua lecturer
    public function index(): JsonResponse
    {
        $lecturers = Lecturer::all();
        return response()->json($lecturers, 200);
    }

    // Menampilkan lecturer berdasarkan ID
    public function show($id): JsonResponse
    {
        try {
            $lecturer = Lecturer::findOrFail($id);
            return response()->json($lecturer, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Lecturer tidak ditemukan.'], 404);
        }
    }

    // Menambahkan lecturer baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'NIP' => 'required|string|max:255|unique:lecturers,NIP',
            'department' => 'required|string|max:255',
            'email' => 'required|email|unique:lecturers,email',
        ]);

        $lecturer = Lecturer::create([
            'name' => $request->name,
            'NIP' => $request->NIP,
            'department' => $request->department,
            'email' => $request->email,
        ]);

        return response()->json([
            'message' => 'Lecturer berhasil ditambahkan.',
            'data' => $lecturer
        ], 201);
    }

    // Mengupdate data lecturer
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $lecturer = Lecturer::findOrFail($id);

            $request->validate([
                'name' => 'sometimes|string|max:255',
                'NIP' => 'sometimes|string|max:255|unique:lecturers,NIP,' . $id,
                'department' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:lecturers,email,' . $id,
            ]);

            $lecturer->update($request->only(['name', 'NIP', 'department', 'email']));

            return response()->json([
                'message' => $lecturer->wasChanged()
                    ? 'Data lecturer berhasil diupdate.'
                    : 'Tidak ada perubahan pada data lecturer.',
                'data' => $lecturer
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Lecturer tidak ditemukan.'], 404);
        }
    }

    // Menghapus lecturer
    public function destroy($id): JsonResponse
    {
        try {
            $lecturer = Lecturer::findOrFail($id);
            $lecturer->delete();

            return response()->json(['message' => 'Lecturer berhasil dihapus.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Lecturer tidak ditemukan.'], 404);
        }
    }
}
