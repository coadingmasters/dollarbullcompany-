<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image_file'  => 'nullable|file|image|max:5120',
            'image_url'   => 'nullable|string|max:500',
            'badge'       => 'nullable|string|max:100',
            'headline'    => 'nullable|string|max:200',
            'highlight'   => 'nullable|string|max:200',
            'sub'         => 'nullable|string|max:500',
            'btn1_label'  => 'nullable|string|max:80',
            'btn1_url'    => 'nullable|string|max:255',
            'btn2_label'  => 'nullable|string|max:80',
            'btn2_url'    => 'nullable|string|max:255',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        // Resolve image: file upload takes priority over URL
        if ($request->hasFile('image_file')) {
            $image = $request->file('image_file')->store('images/sliders', 'public');
        } elseif (!empty($data['image_url'])) {
            $image = $data['image_url'];
        } else {
            return back()->withErrors(['image_file' => 'Please upload an image or provide an image URL.'])->withInput();
        }

        Slider::create([
            'image'      => $image,
            'badge'      => $data['badge']      ?? null,
            'headline'   => $data['headline']   ?? null,
            'highlight'  => $data['highlight']  ?? null,
            'sub'        => $data['sub']        ?? null,
            'btn1_label' => $data['btn1_label'] ?? null,
            'btn1_url'   => $data['btn1_url']   ?? null,
            'btn2_label' => $data['btn2_label'] ?? null,
            'btn2_url'   => $data['btn2_url']   ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slide added successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'image_file'  => 'nullable|file|image|max:5120',
            'image_url'   => 'nullable|string|max:500',
            'badge'       => 'nullable|string|max:100',
            'headline'    => 'nullable|string|max:200',
            'highlight'   => 'nullable|string|max:200',
            'sub'         => 'nullable|string|max:500',
            'btn1_label'  => 'nullable|string|max:80',
            'btn1_url'    => 'nullable|string|max:255',
            'btn2_label'  => 'nullable|string|max:80',
            'btn2_url'    => 'nullable|string|max:255',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        // Only change image if a new one is provided
        if ($request->hasFile('image_file')) {
            $image = $request->file('image_file')->store('images/sliders', 'public');
        } elseif (!empty($data['image_url'])) {
            $image = $data['image_url'];
        } else {
            $image = $slider->image; // keep existing
        }

        $slider->update([
            'image'      => $image,
            'badge'      => $data['badge']      ?? null,
            'headline'   => $data['headline']   ?? null,
            'highlight'  => $data['highlight']  ?? null,
            'sub'        => $data['sub']        ?? null,
            'btn1_label' => $data['btn1_label'] ?? null,
            'btn1_url'   => $data['btn1_url']   ?? null,
            'btn2_label' => $data['btn2_label'] ?? null,
            'btn2_url'   => $data['btn2_url']   ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slide updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        // Delete uploaded file if it's a storage path (not an external URL)
        if (!str_starts_with($slider->image, 'http')) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slide deleted.');
    }
}
