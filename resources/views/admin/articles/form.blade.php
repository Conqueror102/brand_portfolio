<x-admin-layout :title="$article->exists ? 'Edit article' : 'New article'">
    <x-slot:actions>
        @if ($article->exists)
            <a class="link-arrow" href="{{ route('admin.articles.preview', $article) }}" target="_blank" rel="noopener"><x-line-icon name="eye" /> Preview</a>
        @endif
        @if ($article->exists && $article->status === 'published')
            <a class="link-arrow" href="{{ route('insights.show', $article) }}" target="_blank" rel="noopener">View on site <x-line-icon name="arrow-up-right" /></a>
        @endif
        <a class="link-arrow" href="{{ route('admin.articles.index') }}">All articles <x-line-icon name="arrow" /></a>
    </x-slot:actions>
    <form class="admin-form-grid" method="POST" enctype="multipart/form-data" action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}">
        @csrf
        @if ($article->exists) @method('PUT') @endif
        <section class="admin-panel form">
            <x-field name="title" label="Title" :value="$article->title" required maxlength="200" />
            <x-field name="excerpt" label="Introduction" type="textarea" :value="$article->excerpt" required maxlength="400" hint="Shown on cards and at the top of the article. Up to 400 characters." />
            <label class="field">
                <span>Article</span>
                <textarea name="body" rows="18" class="admin-editor" required>{{ old('body', $article->body) }}</textarea>
                <small class="field-hint">Leave a blank line between paragraphs. Start a line with <code>## </code> for a heading, or <code>&gt; </code> for a pull quote.</small>
            </label>
            <x-field name="references" label="References and sources" type="textarea" rows="4" optional :value="$article->references" hint="One per line. Shown at the end of the article. Paste a full link to make it clickable." />
            <x-field name="external_url" label="External link" type="url" optional :value="$article->external_url" hint="Only for articles published elsewhere. Cards will open this link." />
        </section>
        <aside class="admin-form-side">
            <section class="admin-panel form">
                <label class="field"><span>Status</span>
                    <select name="status">
                        @foreach (['draft' => 'Draft (hidden)', 'published' => 'Published', 'archived' => 'Archived (hidden)'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $article->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <x-field name="published_at" label="Publish date" type="date" optional :value="$article->published_at?->format('Y-m-d')" hint="Set automatically when you publish." />
                <label class="field"><span>Category</span>
                    <select name="category">
                        @foreach (config('site.article_categories') as $value => $label)
                            <option value="{{ $value }}" @selected(old('category', $article->category) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $article->is_featured))> <span>Feature on the homepage</span></label>
                <button class="btn" type="submit">{{ $article->exists ? 'Save changes' : 'Create article' }} <span class="btn-icon"><x-line-icon name="check" /></span></button>
            </section>
            <section class="admin-panel form">
                <div class="field">
                    <span>Cover image</span>
                    @if ($article->coverUrl())
                        <img class="admin-cover-preview" src="{{ $article->coverUrl() }}" alt="">
                        <label class="check"><input type="checkbox" name="remove_cover" value="1"> <span>Remove cover</span></label>
                    @endif
                    <input class="admin-file" type="file" name="cover" accept="image/jpeg,image/png,image/webp">
                    <small class="field-hint">JPG, PNG or WebP, up to 4 MB. Wide images work best.</small>
                </div>
            </section>
            <section class="admin-panel form">
                <x-field name="slug" label="Web address" optional :value="$article->slug" hint="Created from the title if left empty." />
                <x-field name="seo_description" label="Search description" type="textarea" optional :value="$article->seo_description" maxlength="300" />
            </section>
        </aside>
    </form>
    @if ($article->exists)
        <form class="admin-danger" method="POST" action="{{ route('admin.articles.destroy', $article) }}" data-confirm="Delete this article permanently?">
            @csrf @method('DELETE')
            <button type="submit">Delete article</button>
        </form>
    @endif
</x-admin-layout>
