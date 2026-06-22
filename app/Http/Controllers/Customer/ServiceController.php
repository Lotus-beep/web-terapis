<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceCategory::where('is_active', true);

        if ($request->category) {
            $query->where('id', $request->category);
        }

        $services   = $query->orderBy('sort_order')->orderBy('name')->paginate(9);
        $categories = ServiceCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('customer.services.index', compact('services', 'categories'));
    }

    public function show(ServiceCategory $service)
    {
        return view('customer.services.show', compact('service'));
    }
}
