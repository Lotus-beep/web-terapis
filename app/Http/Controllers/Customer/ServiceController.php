<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('kategori'); // 'bekam', 'non-bekam', atau null (semua)

        $query = ServiceCategory::where('is_active', true)
            ->orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('name');

        if ($filter && in_array($filter, ['bekam', 'non-bekam'])) {
            $query->where('category', $filter);
        }

        $services = $query->get();

        return view('customer.services.index', compact('services', 'filter'));
    }

    public function show(ServiceCategory $service)
    {
        return view('customer.services.show', compact('service'));
    }
}
