<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.service_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.service_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'header_content' => 'nullable|string|max:200',
            'description'    => 'nullable|string|max:500',
            'icon'           => 'nullable|string|max:100',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'      => 'nullable|boolean',
            'sort_order'     => 'nullable|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        ServiceCategory::create([
            'name'           => $request->name,
            'slug'           => Str::slug($request->name),
            'header_content' => $request->header_content,
            'description'    => $request->description,
            'icon'           => $request->icon ?? 'bi-heart-pulse-fill',
            'image'          => $imagePath,
            'is_active'      => $request->boolean('is_active', true),
            'sort_order'     => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        return view('admin.service_categories.edit', compact('serviceCategory'));
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'header_content' => 'nullable|string|max:200',
            'description'    => 'nullable|string|max:500',
            'icon'           => 'nullable|string|max:100',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'      => 'nullable|boolean',
            'sort_order'     => 'nullable|integer|min:0',
        ]);

        $data = [
            'name'           => $request->name,
            'slug'           => Str::slug($request->name),
            'header_content' => $request->header_content,
            'description'    => $request->description,
            'icon'           => $request->icon ?? 'bi-heart-pulse-fill',
            'is_active'      => $request->boolean('is_active', true),
            'sort_order'     => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('image')) {
            if ($serviceCategory->image) {
                Storage::disk('public')->delete($serviceCategory->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $serviceCategory->update($data);

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        // Cek apakah ada service yang pakai kategori ini
        if ($serviceCategory->services()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh ' . $serviceCategory->services()->count() . ' layanan.');
        }

        if ($serviceCategory->image) {
            Storage::disk('public')->delete($serviceCategory->image);
        }

        $serviceCategory->delete();

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
