<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'instansi' => ['required', 'string', 'max:255'],
        ]);

        // Cek apakah instansi sudah terdaftar
        if (User::where('instansi', $request->instansi)->exists()) {
            return back()->withErrors(['instansi' => 'Instansi ini sudah terdaftar, silakan pilih instansi lain.']);
        }

        // Jika validasi berhasil, buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'instansi' => $request->instansi,
        ]);

        // Memicu event pendaftaran
        event(new Registered($user));

        // Login otomatis setelah pendaftaran
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
