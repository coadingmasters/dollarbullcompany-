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
            'image_file'        => 'nullable|file|image|max:5120',
            'image_url'         => 'nullable|string|max:500',
            'mobile_image_file' => 'nullable|file|image|max:5120',
            'mobile_image_url'  => 'nullable|string|max:500',
            'badge'             => 'nullable|string|max:100',
            'headline'          => 'nullable|string|max:200',
            'highlight'         => 'nullable|string|max:200',
            'sub'               => 'nullable|string|max:500',
            'btn1_label'        => 'nullable|string|max:80',
            'btn1_url'          => 'nullable|string|max:255',
            'btn2_label'        => 'nullable|string|max:80',
            'btn2_url'          => 'nullable|string|max:255',
            'sort_order'        => 'nullable|integer|min:0',
            'is_active'         => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $image = $request->file('image_file')->store('images/sliders', 'public');
        } elseif (!empty($data['image_url'])) {
            $image = $data['image_url'];
        } else {
            return back()->withErrors(['image_file' => 'Please upload a desktop image or provide an image URL.'])->withInput();
        }

        if ($request->hasFile('mobile_image_file')) {
            $mobileImage = $request->file('mobile_image_file')->store('images/sliders/mobile', 'public');
        } elseif (!empty($data['mobile_image_url'])) {
            $mobileImage = $data['mobile_image_url'];
        } else {
            $mobileImage = null;
        }

        Slider::create([
            'image'        => $image,
            'mobile_image' => $mobileImage,
            'badge'        => $data['badge']      ?? null,
            'headline'     => $data['headline']   ?? null,
            'highlight'    => $data['highlight']  ?? null,
            'sub'          => $data['sub']        ?? null,
            'btn1_label'   => $data['btn1_label'] ?? null,
            'btn1_url'     => $data['btn1_url']   ?? null,
            'btn2_label'   => $data['btn2_label'] ?? null,
            'btn2_url'     => $data['btn2_url']   ?? null,
            'sort_order'   => $data['sort_order'] ?? 0,
            'is_active'    => $request->boolean('is_active', true),
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
            'image_file'        => 'nullable|file|image|max:5120',
            'image_url'         => 'nullable|string|max:500',
            'mobile_image_file' => 'nullable|file|image|max:5120',
            'mobile_image_url'  => 'nullable|string|max:500',
            'remove_mobile'     => 'nullable|boolean',
            'badge'             => 'nullable|string|max:100',
            'headline'          => 'nullable|string|max:200',
            'highlight'         => 'nullable|string|max:200',
            'sub'               => 'nullable|string|max:500',
            'btn1_label'        => 'nullable|string|max:80',
            'btn1_url'          => 'nullable|string|max:255',
            'btn2_label'        => 'nullable|string|max:80',
            'btn2_url'          => 'nullable|string|max:255',
            'sort_order'        => 'nullable|integer|min:0',
            'is_active'         => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $image = $request->file('image_file')->store('images/sliders', 'public');
        } elseif (!empty($data['image_url'])) {
            $image = $data['image_url'];
        } else {
            $image = $slider->image;
        }

        if ($request->hasFile('mobile_image_file')) {
            if ($slider->mobile_image && !str_starts_with($slider->mobile_image, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($slider->mobile_image);
            }
            $mobileImage = $request->file('mobile_image_file')->store('images/sliders/mobile', 'public');
        } elseif (!empty($data['mobile_image_url'])) {
            $mobileImage = $data['mobile_image_url'];
        } elseif ($request->boolean('remove_mobile')) {
            if ($slider->mobile_image && !str_starts_with($slider->mobile_image, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($slider->mobile_image);
            }
            $mobileImage = null;
        } else {
            $mobileImage = $slider->mobile_image;
        }

        $slider->update([
            'image'        => $image,
            'mobile_image' => $mobileImage,
            'badge'        => $data['badge']      ?? null,
            'headline'     => $data['headline']   ?? null,
            'highlight'    => $data['highlight']  ?? null,
            'sub'          => $data['sub']        ?? null,
            'btn1_label'   => $data['btn1_label'] ?? null,
            'btn1_url'     => $data['btn1_url']   ?? null,
            'btn2_label'   => $data['btn2_label'] ?? null,
            'btn2_url'     => $data['btn2_url']   ?? null,
            'sort_order'   => $data['sort_order'] ?? 0,
            'is_active'    => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slide updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image && !str_starts_with($slider->image, 'http')) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($slider->image);
        }
        if ($slider->mobile_image && !str_starts_with($slider->mobile_image, 'http')) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($slider->mobile_image);
        }
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slide deleted.');
    }
}
