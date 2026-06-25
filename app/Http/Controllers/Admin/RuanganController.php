<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::withCount('beds')->orderBy('nama_ruangan')->paginate(10);
        return view('admin.ruangans.index', compact('ruangans'));
    }

    public function create()
    {
        return view('admin.ruangans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan',
            'gender'       => 'required|in:laki-laki,perempuan',
            'beds_list'    => 'nullable|string',
        ]);

        $ruangan = Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
            'gender'       => $request->gender,
            'active'       => $request->has('active'),
            'maximal'      => 0, // dynamic capacity from beds
        ]);

        if ($request->beds_list) {
            $beds = explode("\n", str_replace("\r", "", $request->beds_list));
            foreach ($beds as $bedName) {
                $bedName = trim($bedName);
                if ($bedName !== '') {
                    \App\Models\Bed::create([
                        'id_ruangan' => $ruangan->id,
                        'nama_bed'   => $bedName,
                        'active'     => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.ruangans.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function show(Ruangan $ruangan)
    {
        $ruangan->load('beds');
        return view('admin.ruangans.show', compact('ruangan'));
    }

    public function edit(Ruangan $ruangan)
    {
        return view('admin.ruangans.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan,' . $ruangan->id,
            'gender'       => 'required|in:laki-laki,perempuan',
        ]);

        $ruangan->update([
            'nama_ruangan' => $request->nama_ruangan,
            'gender'       => $request->gender,
            'active'       => $request->has('active'),
        ]);

        return redirect()->route('admin.ruangans.index')->with('success', 'Ruangan berhasil diupdate.');
    }

    public function destroy(Ruangan $ruangan)
    {
        if ($ruangan->bookings()->whereNotIn('status_service', ['cancelled', 'completed'])->count() > 0) {
            return back()->with('error', 'Ruangan tidak bisa dihapus karena masih memiliki pemesanan aktif.');
        }
        $ruangan->delete();
        return redirect()->route('admin.ruangans.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
