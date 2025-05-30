<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Students;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . Students::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nim' => 'required|string|max:255|unique:' . Students::class, // Menambahkan validasi nim
            'major' => 'required|string|max:255', // Menambahkan validasi major
            'enrollment_year' => 'required', // Validasi tahun masuk harus 4 digit
        ]);

        $user = Students::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim' => $request->nim, // Menyimpan nim
            'major' => $request->major, // Menyimpan major
            'enrollment_year' => $request->enrollment_year, // Menyimpan tahun masuk
        ]);


        event(new Registered($user));

        Auth::login($user);

        return to_route('dashboard');
    }
}
