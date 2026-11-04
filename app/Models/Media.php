<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * A file in the media library. Pages and items store the file's path, so the library is the single place to add alt text.
 *
 * @property int $id
 * @property string $path
 * @property string $filename
 * @property string $mime_type
 * @property int $size
 * @property int|null $width
 * @property int|null $height
 * @property string|null $alt
 * @property string|null $caption
 */
#[Fillable(['path', 'filename', 'mime_type', 'size', 'width', 'height', 'alt', 'caption', 'uploaded_by'])]
class Media extends Model
{
    public const IMAGE_TYPES = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    public const DOCUMENT_TYPES = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip'];

    public static function upload(UploadedFile $file, ?string $alt = null, ?string $caption = null): self
    {
        $path = $file->store('library', 'public');
        $dimensions = str_starts_with((string) $file->getMimeType(), 'image/') ? @getimagesize($file->getRealPath()) : false;

        return static::create([
            'path' => $path,
            'filename' => mb_substr($file->getClientOriginalName(), 0, 250),
            'mime_type' => (string) $file->getMimeType(),
            'size' => (int) $file->getSize(),
            'width' => $dimensions[0] ?? null,
            'height' => $dimensions[1] ?? null,
            'alt' => $alt,
            'caption' => $caption,
            'uploaded_by' => auth()->id(),
        ]);
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function url(): string
    {
        return media_url($this->path);
    }

    public function humanSize(): string
    {
        return $this->size >= 1048576 ? round($this->size / 1048576, 1).' MB' : max(1, round($this->size / 1024)).' KB';
    }

    /** Where this file is referenced, so editors know what deleting it would affect. @return list<string> */
    public function usage(): array
    {
        $uses = [];
        foreach (Content::where('value', $this->path)->orWhere('draft', $this->path)->pluck('key') as $key) {
            $field = Content::field($key);
            $uses[] = 'Page: '.($field ? config('content.groups.'.$field['group'].'.label').' → '.$field['label'] : $key);
        }
        foreach (Item::where('image', $this->path)->orWhere('file', $this->path)->get() as $item) {
            $uses[] = (config('collections.'.$item->type.'.label') ?? $item->type).': '.$item->title;
        }
        foreach (Article::where('cover_image', $this->path)->pluck('title') as $title) {
            $uses[] = 'Article: '.$title;
        }
        foreach (Testimonial::where('portrait', $this->path)->pluck('name') as $name) {
            $uses[] = 'Testimonial: '.$name;
        }

        return $uses;
    }

    protected static function booted(): void
    {
        static::deleted(fn (Media $media) => Storage::disk('public')->delete($media->path));
    }
}
