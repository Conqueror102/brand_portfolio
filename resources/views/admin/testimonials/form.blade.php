<x-admin-layout :title="$testimonial->exists ? 'Edit testimonial' : 'Add testimonial'">
    <x-slot:actions><a class="link-arrow" href="{{ route('admin.testimonials.index') }}">All testimonials <x-line-icon name="arrow" /></a></x-slot:actions>
    <form class="admin-form-grid" method="POST" enctype="multipart/form-data" action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}">
        @csrf
        @if ($testimonial->exists) @method('PUT') @endif
        <section class="admin-panel form">
            <x-field name="quote" label="Testimonial" type="textarea" :value="$testimonial->quote" required maxlength="1200" />
            <div class="form-row">
                <x-field name="name" label="Reviewer name" :value="$testimonial->name" required />
                <x-field name="role" label="Role" optional :value="$testimonial->role" />
            </div>
            <x-field name="organisation" label="Organisation" optional :value="$testimonial->organisation" />
        </section>
        <aside class="admin-form-side">
            <section class="admin-panel form">
                <label class="field"><span>Where it relates</span>
                    <select name="context">
                        @foreach (['general' => 'General', 'speaking' => 'Speaking', 'mentorship' => 'Mentorship', 'coaching' => 'Coaching', 'book' => 'Book'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('context', $testimonial->context) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <x-field name="sort_order" label="Order" type="number" min="0" optional :value="$testimonial->sort_order ?? 0" hint="Lower numbers show first." />
                <label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $testimonial->is_published))> <span>Approved and visible on the website</span></label>
                <label class="check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $testimonial->is_featured))> <span>Show on the homepage</span></label>
                <button class="btn" type="submit">{{ $testimonial->exists ? 'Save changes' : 'Add testimonial' }} <span class="btn-icon"><x-line-icon name="check" /></span></button>
            </section>
            <section class="admin-panel form">
                <div class="field">
                    <span>Portrait <em>optional</em></span>
                    @if ($testimonial->portraitUrl())<img class="admin-portrait-preview" src="{{ $testimonial->portraitUrl() }}" alt="">@endif
                    <input class="admin-file" type="file" name="portrait_file" accept="image/jpeg,image/png,image/webp">
                    <small class="field-hint">Only with the reviewer’s approval. Up to 2 MB.</small>
                </div>
            </section>
        </aside>
    </form>
    @if ($testimonial->exists)
        <form class="admin-danger" method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" data-confirm="Delete this testimonial?">
            @csrf @method('DELETE')
            <button type="submit">Delete testimonial</button>
        </form>
    @endif
</x-admin-layout>
