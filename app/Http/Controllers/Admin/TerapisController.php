<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Terapis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TerapisController extends Controller
{
    public function index(Request $request)
    {
        $query = Terapis::query();
        if ($request->search) {
            $query->where('username', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
        }
        $terapis = $query->orderBy('rating', 'desc')->paginate(10);
        return view('admin.terapis.index', compact('terapis'));
    }

    public function create()
    {
        return view('admin.terapis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username'   => 'required|string|max:255',
            'email'      => 'required|email|unique:terapis,email|unique:users,email',
            'password'   => 'required|min:8|confirmed',
            'no_telepon' => 'nullable|string|max:20',
            'alamat'     => 'nullable|string|max:500',
            'gender'     => 'required|in:laki-laki,perempuan',
        ]);

        Terapis::create([
            'username'   => $request->username,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
            'gender'     => $request->gender,
            'rating'     => 0,
        ]);

        User::create([
            'username'   => $request->username,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
            'gender'     => $request->gender,
            'role_users' => 'terapis',
        ]);

        return redirect()->route('admin.terapis.index')->with('success', 'Terapis berhasil ditambahkan.');
    }

    public function edit(Terapis $terapi)
    {
        return view('admin.terapis.edit', compact('terapi'));
    }

    public function update(Request $request, Terapis $terapi)
    {
        $request->validate([
            'username'   => 'required|string|max:255',
            'email'      => ['required', 'email', Rule::unique('terapis')->ignore($terapi->id)],
            'no_telepon' => 'nullable|string|max:20',
            'alamat'     => 'nullable|string|max:500',
            'password'   => 'nullable|min:8|confirmed',
            'gender'     => 'required|in:laki-laki,perempuan',
        ]);

        $data = [
            'username'   => $request->username,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
            'gender'     => $request->gender,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $terapi->update($data);

        // Update user account juga
        User::where('email', $terapi->email)->update([
            'username'   => $request->username,
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
        ]);

        return redirect()->route('admin.terapis.index')->with('success', 'Terapis berhasil diupdate.');
    }

    public function destroy(Terapis $terapi)
    {
        User::where('email', $terapi->email)->delete();
        $terapi->delete();
        return redirect()->route('admin.terapis.index')->with('success', 'Terapis berhasil dihapus.');
    }
}
