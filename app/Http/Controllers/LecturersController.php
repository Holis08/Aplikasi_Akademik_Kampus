<?php

namespace App\Http\Controllers;

use App\Models\Lecturers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LecturersController extends Controller
{
    public function index(): JsonResponse
    {
        $lecturers = Lecturers::all();
        return response()->json($lecturers, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $lecturers = Lecturers::findOrFail($id);
            return response()->json($lecturers, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'lecturers tidak ditemukan'], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'nip' => 'required|string|max:255',
                'dapartment' => 'required|string|max:255',
                'email' => 'required|string|max:255',
            ]);

            $lecturers = Lecturers::create([
                'name' => $request->name,
                'nip' => $request->nip,
                'dapartment' => $request->dapartment,
                'email' => $request->email,
            ]);

            return response()->json([
                'message' => 'Lecturers berhasil ditambahkan.',
                'data' => $lecturers
            ], 201);
        }catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Lecturers tidak berhasil ditambahkan'], 404);
        }
    }



    public function update(Request $request, $id): JsonResponse
    {
        try {
            $lecturers = Lecturers::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'nip' => 'required|string|max:255',
                'dapartment' => 'required|string|max:255',
                'email' => 'required|string|max:255',
            ]);

            // Update hanya field yang dikirim
            $data = $request->only(['name', 'nip' , 'dapartment', 'email']);
            $lecturers->update($data);

            return response()->json([
                'message' => $lecturers->wasChanged()
                    ? 'Data lecturers berhasil diupdate.'
                    : 'Tidak ada perubahan pada data lecturers.',
                'data' => $lecturers
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Lecturers tidak ditemukan'], 404);
        }
    }

    
    public function destroy($id): JsonResponse
    {
        try {
            $course = Lecturers::findOrFail($id);
            $course->delete();

            return response()->json(['message' => 'Data Lecturers berhasil dihapus.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Lecturers tidak ditemukan.'], 404);
        }
    }
}
