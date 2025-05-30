<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Models\Students;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentsController extends Controller
{
    public function index(): JsonResponse
    {

        $dataUser = Students::all();
        return response()->json($dataUser, 200);
    }
    // Menampilkan user berdasarkan ID
    public function show($id): JsonResponse
    {
        try {
            $user = Students::findOrFail($id);
            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    // Menambahkan user baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:8', // Validasi untuk password
            'nim' => 'required|string|max:255|unique:students,nim', // Menambahkan validasi nim
            'major' => 'required|string|max:255', // Menambahkan validasi major
            'enrollment_year' => 'required', // Validasi untuk tahun masuk harus 4 digit
        ]);

        $user = Students::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'nim' => $request->nim, // Menyimpan nim
            'major' => $request->major, // Menyimpan major
            'enrollment_year' => $request->enrollment_year, // Menyimpan tahun masuk
        ]);

        return response()->json([
            'message' => 'Akun pengguna berhasil ditambahkan.',
            'data' => $user
        ], 201);
    }

    // Mengupdate data user
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $user = Students::findOrFail($id);

            $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:students,email,' . $id,
                'username' => 'sometimes|string|max:255|unique:users,username,'.$id,
                'password' => 'sometimes|string|min:8',
            ]);

            // Hanya update field yang dikirim
            $data = $request->only(['name', 'email', 'password','username']);
            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            logger('Data yg dikirim', $data);
            $user->update($data);
            

            return response()->json([
                'message' => $user->wasChanged()
                    ? 'Akun pengguna berhasil diupdate.'
                    : 'Tidak ada perubahan pada data pengguna.',
                'data' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $user = Students::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'User berhasil dihapus.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }
    }
}
