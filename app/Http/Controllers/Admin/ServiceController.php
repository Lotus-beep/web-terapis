<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Service;
use App\Models\Terapis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['terapis']);
        if ($request->search) {
            $query->where('name_service', 'like', '%'.$request->search.'%');
        }
        if ($request->category) {
            $query->where('category', $request->category);
        }
        $services = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $terapis    = Terapis::orderBy('username')->get();
        $locations  = Location::orderBy('name_location')->get();
        $categories = \App\Models\ServiceCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.services.create', compact('terapis', 'locations', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_service' => 'required|string|max:255',
            'id_category'  => 'nullable|exists:service_categories,id',
            'description'  => 'nullable|string|max:1000',
            'price'        => 'required|numeric|min:0',
            'id_terapis'   => 'required|exists:terapis,id',
            'id_location'  => 'required|exists:location,id',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'    => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
        }

        Service::create([
            'name_service' => $request->name_service,
            'id_category'  => $request->id_category,
            'description'  => $request->description,
            'price'        => $request->price,
            'id_terapis'   => $request->id_terapis,
            'id_location'  => $request->id_location,
            'image'        => $imagePath,
            'is_active'    => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        $terapis    = Terapis::orderBy('username')->get();
        $locations  = Location::orderBy('name_location')->get();
        $categories = \App\Models\ServiceCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.services.edit', compact('service', 'terapis', 'locations', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name_service' => 'required|string|max:255',
            'id_category'  => 'nullable|exists:service_categories,id',
            'description'  => 'nullable|string|max:1000',
            'price'        => 'required|numeric|min:0',
            'id_terapis'   => 'required|exists:terapis,id',
            'id_location'  => 'required|exists:location,id',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'    => 'nullable|boolean',
        ]);

        $data = [
            'name_service' => $request->name_service,
            'id_category'  => $request->id_category,
            'description'  => $request->description,
            'price'        => $request->price,
            'id_terapis'   => $request->id_terapis,
            'id_location'  => $request->id_location,
            'is_active'    => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('image')) {
            if ($service->image) Storage::disk('public')->delete($service->image);
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service berhasil diupdate.');
    }

    public function destroy(Service $service)
    {
        if ($service->image) Storage::disk('public')->delete($service->image);
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service berhasil dihapus.');
    }
}
