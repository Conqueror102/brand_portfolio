<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $media = Media::query()
            ->when($request->query('kind') === 'images', fn ($q) => $q->where('mime_type', 'like', 'image/%'))
            ->when($request->query('kind') === 'documents', fn ($q) => $q->where('mime_type', 'not like', 'image/%'))
            ->when($request->query('q'), fn ($q, $term) => $q->where(fn ($q) => $q->where('filename', 'like', "%{$term}%")->orWhere('alt', 'like', "%{$term}%")->orWhere('caption', 'like', "%{$term}%")))
            ->latest()
            ->paginate(36)
            ->withQueryString();

        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'files' => ['required', 'array', 'max:20'],
            'files.*' => ['file', 'mimes:'.implode(',', [...Media::IMAGE_TYPES, ...Media::DOCUMENT_TYPES]), 'max:20480'],
        ], ['files.*.mimes' => 'Upload images (JPG, PNG, WebP, GIF) or documents (PDF, Word, PowerPoint, ZIP).']);

        $uploaded = collect($request->file('files'))->map(fn ($file) => Media::upload($file));

        if ($uploaded->count() === 1) {
            return to_route('admin.media.edit', $uploaded->first())->with('status', 'Uploaded. Add a description for screen readers and search.');
        }

        return to_route('admin.media.index')->with('status', $uploaded->count().' files uploaded. Add descriptions to the images.');
    }

    public function edit(Media $media): View
    {
        return view('admin.media.edit', ['media' => $media, 'usage' => $media->usage()]);
    }

    public function update(Request $request, Media $media): RedirectResponse
    {
        $media->update($request->validate([
            'alt' => ['nullable', 'string', 'max:300'],
            'caption' => ['nullable', 'string', 'max:500'],
        ]));

        return to_route('admin.media.edit', $media)->with('status', 'Saved.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        if ($usage = $media->usage()) {
            return back()->withErrors(['media' => 'This file is still used ('.implode('; ', $usage).'). Replace it there first.']);
        }
        $media->delete();

        return to_route('admin.media.index')->with('status', 'File deleted.');
    }
}
