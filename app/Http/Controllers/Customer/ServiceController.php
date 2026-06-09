<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['terapis', 'category'])
            ->where('is_active', true);

        if ($request->category) {
            $query->where('id_category', $request->category);
        }

        $services   = $query->orderBy('created_at', 'asc')->paginate(9);
        $categories = \App\Models\ServiceCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('customer.services.index', compact('services', 'categories'));
    }

    public function show(Service $service)
    {
        $service->load(['terapis', 'category']);
        return view('customer.services.show', compact('service'));
    }
}
