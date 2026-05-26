<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Service;
use App\Models\Terapis;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['terapis', 'location'])
            ->where('status_payment', 'active');

        if ($request->id_location) {
            $query->where('id_location', $request->id_location);
        }
        if ($request->id_terapis) {
            $query->where('id_terapis', $request->id_terapis);
        }

        $services  = $query->orderBy('date_service', 'asc')->paginate(9);
        $locations = Location::orderBy('name_location')->get();
        $terapis   = Terapis::orderBy('username')->get();

        return view('customer.services.index', compact('services', 'locations', 'terapis'));
    }
}
