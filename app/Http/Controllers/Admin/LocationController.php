<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::withCount('services')->orderBy('name_location')->paginate(10);
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name_location' => 'required|string|max:255|unique:location,name_location']);
        Location::create(['name_location' => $request->name_location]);
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate(['name_location' => 'required|string|max:255|unique:location,name_location,'.$location->id]);
        $location->update(['name_location' => $request->name_location]);
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil diupdate.');
    }

    public function destroy(Location $location)
    {
        if ($location->services()->count() > 0) {
            return back()->with('error', 'Lokasi tidak bisa dihapus karena masih memiliki service.');
        }
        $location->delete();
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}
