<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class BedController extends Controller
{
    public function index()
    {
        $beds = Bed::with('ruangan')->orderBy('nama_bed')->paginate(10);
        return view('admin.beds.index', compact('beds'));
    }

    public function create()
    {
        $ruangans = Ruangan::where('active', true)->orderBy('nama_ruangan')->get();
        return view('admin.beds.create', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'nama_bed'   => 'required|string|max:255|unique:beds,nama_bed,NULL,id,id_ruangan,' . $request->id_ruangan,
        ]);

        Bed::create([
            'id_ruangan' => $request->id_ruangan,
            'nama_bed'   => $request->nama_bed,
            'active'     => $request->has('active'),
        ]);

        return redirect()->back()->with('success', 'Bed berhasil ditambahkan.');
    }

    public function update(Request $request, Bed $bed)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'nama_bed'   => 'required|string|max:255|unique:beds,nama_bed,' . $bed->id . ',id,id_ruangan,' . $request->id_ruangan,
        ]);

        $bed->update([
            'id_ruangan' => $request->id_ruangan,
            'nama_bed'   => $request->nama_bed,
            'active'     => $request->has('active'),
        ]);

        return redirect()->back()->with('success', 'Bed berhasil diupdate.');
    }

    public function destroy(Bed $bed)
    {
        $ruanganId = $bed->id_ruangan;
        if ($bed->bookings()->whereNotIn('status_service', ['cancelled', 'completed'])->count() > 0) {
            return back()->with('error', 'Bed tidak bisa dihapus karena masih memiliki pemesanan aktif.');
        }
        $bed->delete();
        return redirect()->back()->with('success', 'Bed berhasil dihapus.');
    }
}
