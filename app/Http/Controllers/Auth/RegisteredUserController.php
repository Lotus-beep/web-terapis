<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username'   => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'   => ['required', 'confirmed', Rules\Password::min(8)->letters()->numbers()],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'alamat'     => ['nullable', 'string', 'max:500'],
            'gender'     => ['required', 'in:laki-laki,perempuan'],
        ]);

        $user = User::create([
            'username'   => $request->username,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
            'gender'     => $request->gender,
            'role_users' => 'customer',
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('customer.dashboard');
    }
}
