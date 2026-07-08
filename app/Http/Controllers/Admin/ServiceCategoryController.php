<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::with('images')
            ->orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        return view('admin.service_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.service_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|in:bekam,non-bekam',
            'header_content' => 'nullable|string|max:200',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $service = ServiceCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category' => $request->category,
            'header_content' => $request->header_content,
            'description' => $request->description,
            'price' => $request->price,
            'icon' => 'bi-heart-pulse-fill',
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        // Simpan multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('categories', 'public');
                ServiceImage::create([
                    'service_category_id' => $service->id,
                    'path' => $path,
                    'sort_order' => $index,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        $serviceCategory->load('images');
        return view('admin.service_categories.edit', compact('serviceCategory'));
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|in:bekam,non-bekam',
            'header_content' => 'nullable|string|max:200',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:3072',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:service_images,id',
        ]);

        $serviceCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category' => $request->category,
            'header_content' => $request->header_content,
            'description' => $request->description,
            'price' => $request->price,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        // Hapus gambar yang dipilih untuk dihapus
        if ($request->filled('delete_images')) {
            $toDelete = ServiceImage::whereIn('id', $request->delete_images)
                ->where('service_category_id', $serviceCategory->id)
                ->get();

            foreach ($toDelete as $img) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            }
        }

        // Tambah gambar baru
        if ($request->hasFile('images')) {
            $existingCount = $serviceCategory->images()->count();
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('categories', 'public');
                ServiceImage::create([
                    'service_category_id' => $serviceCategory->id,
                    'path' => $path,
                    'sort_order' => $existingCount + $index,
                    'is_primary' => $existingCount === 0 && $index === 0,
                ]);
            }
        }

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Layanan berhasil diupdate.');
    }

    // AJAX: hapus 1 gambar
    public function deleteImage(Request $request, ServiceImage $image)
    {
        // Pastikan gambar milik service yang valid
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return response()->json(['ok' => true]);
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        if ($serviceCategory->bookings()->count() > 0) {
            return back()->with(
                'error',
                'Layanan tidak bisa dihapus karena masih digunakan oleh ' .
                $serviceCategory->bookings()->count() . ' booking.'
            );
        }

        // Hapus semua gambar dari storage
        foreach ($serviceCategory->images as $img) {
            Storage::disk('public')->delete($img->path);
        }
        // Hapus gambar lama (kolom image)
        if ($serviceCategory->image) {
            Storage::disk('public')->delete($serviceCategory->image);
        }

        $serviceCategory->delete();

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
