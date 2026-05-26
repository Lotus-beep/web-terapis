<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Service;
use App\Models\Terapis;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['terapis', 'location']);
        if ($request->search) {
            $query->where('name_service', 'like', '%'.$request->search.'%');
        }
        $services = $query->orderBy('date_service', 'desc')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $terapis   = Terapis::orderBy('username')->get();
        $locations = Location::orderBy('name_location')->get();
        return view('admin.services.create', compact('terapis', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_service'   => 'required|string|max:255',
            'date_service'   => 'required|date',
            'time_service'   => 'required',
            'price'          => 'required|numeric|min:0',
            'id_terapis'     => 'required|exists:terapis,id',
            'id_location'    => 'required|exists:location,id',
            'status_payment' => 'nullable|string|max:50',
        ]);

        Service::create([
            'name_service'   => $request->name_service,
            'date_service'   => $request->date_service,
            'time_service'   => $request->time_service,
            'price'          => $request->price,
            'id_terapis'     => $request->id_terapis,
            'id_location'    => $request->id_location,
            'status_payment' => $request->status_payment ?? 'active',
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        $terapis   = Terapis::orderBy('username')->get();
        $locations = Location::orderBy('name_location')->get();
        return view('admin.services.edit', compact('service', 'terapis', 'locations'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name_service'   => 'required|string|max:255',
            'date_service'   => 'required|date',
            'time_service'   => 'required',
            'price'          => 'required|numeric|min:0',
            'id_terapis'     => 'required|exists:terapis,id',
            'id_location'    => 'required|exists:location,id',
            'status_payment' => 'nullable|string|max:50',
        ]);

        $service->update($request->only([
            'name_service', 'date_service', 'time_service',
            'price', 'id_terapis', 'id_location', 'status_payment',
        ]));

        return redirect()->route('admin.services.index')->with('success', 'Service berhasil diupdate.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service berhasil dihapus.');
    }
}
