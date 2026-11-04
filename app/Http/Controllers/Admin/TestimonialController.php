<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        return view('admin.testimonials.index', ['testimonials' => Testimonial::orderBy('sort_order')->latest()->paginate(20)]);
    }

    public function create(): View
    {
        return view('admin.testimonials.form', ['testimonial' => new Testimonial(['context' => 'general', 'is_published' => false])]);
    }

    public function store(Request $request): RedirectResponse
    {
        Testimonial::create($this->validated($request));

        return to_route('admin.testimonials.index')->with('status', 'Testimonial added.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update($this->validated($request, $testimonial));

        return to_route('admin.testimonials.index')->with('status', 'Testimonial saved.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        if ($testimonial->portrait) {
            Storage::disk('public')->delete($testimonial->portrait);
        }
        $testimonial->delete();

        return to_route('admin.testimonials.index')->with('status', 'Testimonial deleted.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, ?Testimonial $testimonial = null): array
    {
        $data = $request->validate([
            'quote' => ['required', 'string', 'max:1200'],
            'name' => ['required', 'string', 'max:150'],
            'role' => ['nullable', 'string', 'max:150'],
            'organisation' => ['nullable', 'string', 'max:150'],
            'context' => ['required', 'in:general,speaking,mentorship,coaching,book'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'portrait_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_sample'] = false;
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        if ($request->hasFile('portrait_file')) {
            if ($testimonial?->portrait) {
                Storage::disk('public')->delete($testimonial->portrait);
            }
            $data['portrait'] = $request->file('portrait_file')->store('testimonials', 'public');
        }
        unset($data['portrait_file']);

        return $data;
    }
}
