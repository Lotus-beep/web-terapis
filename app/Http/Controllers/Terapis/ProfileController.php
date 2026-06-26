<?php

namespace App\Http\Controllers\Terapis;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Terapis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private function getTerapis(): ?Terapis
    {
        return Terapis::where('email', auth()->user()->email)->first();
    }

    public function ratings()
    {
        $terapisUser = $this->getTerapis();
        if (!$terapisUser) return redirect()->route('terapis.dashboard');

        $comments = Comment::with(['customer', 'booking'])
            ->where('id_terapis', $terapisUser->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('terapis.ratings.index', compact('comments', 'terapisUser'));
    }

    public function edit()
    {
        $user        = auth()->user();
        $terapisUser = $this->getTerapis();
        return view('terapis.profile.edit', compact('user', 'terapisUser'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'username'   => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat'     => 'nullable|string|max:500',
            'password'   => 'nullable|min:8|confirmed',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'username'   => $request->username,
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
        ];
        
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('profile_photos', 'public');
        }
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);

        // Update terapis table too
        $terapisUser = $this->getTerapis();
        if ($terapisUser) {
            $terapisUser->update([
                'username'   => $request->username,
                'no_telepon' => $request->no_telepon,
                'alamat'     => $request->alamat,
            ]);
        }

        return back()->with('success', 'Profil berhasil diupdate.');
    }
}
