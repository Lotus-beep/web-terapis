<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('customer.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'username'        => 'required|string|max:255',
            'email'           => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'no_telepon'      => 'nullable|string|max:20',
            'alamat'          => 'nullable|string|max:500',
            'current_password'=> 'nullable|string',
            'password'        => 'nullable|min:8|confirmed',
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
            }
        }

        $data = [
            'username'   => $request->username,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return back()->with('success', 'Profil berhasil diupdate.');
    }
}
