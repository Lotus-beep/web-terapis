<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClinicSetting;
use Illuminate\Http\Request;

class ClinicSettingController extends Controller
{
    public function edit()
    {
        $settings = ClinicSetting::allAsArray();
        return view('admin.clinic_settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'clinic_name'    => 'required|string|max:200',
            'clinic_address' => 'required|string|max:500',
            'clinic_phone'   => 'nullable|string|max:50',
            'clinic_hours'   => 'nullable|string|max:200',
            'maps_embed_url' => 'nullable|string|max:2000',
            'maps_link'      => 'nullable|url|max:500',
        ]);

        ClinicSetting::setMany([
            'clinic_name'    => $request->clinic_name,
            'clinic_address' => $request->clinic_address,
            'clinic_phone'   => $request->clinic_phone,
            'clinic_hours'   => $request->clinic_hours,
            'maps_embed_url' => $request->maps_embed_url,
            'maps_link'      => $request->maps_link,
        ]);

        return back()->with('success', 'Informasi klinik berhasil disimpan.');
    }
}
