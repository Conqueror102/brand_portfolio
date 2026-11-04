<x-admin-layout title="Pages" heading="Pages & content">
    <p class="admin-intro">Edit the words, images and buttons on every page. Changes are saved as drafts first, so you can preview them before they go live.</p>
    <div class="admin-tiles">
        @foreach ($groups as $key => $group)
            <a class="admin-tile" href="{{ route('admin.pages.edit', $key) }}">
                <span class="icon-chip"><x-line-icon :name="$group['icon']" /></span>
                <strong>{{ $group['label'] }}</strong>
                <span>{{ $group['description'] }}</span>
                @if ($drafts[$key] ?? 0)<x-admin-status status="draft" :label="$drafts[$key].' unpublished '.\Illuminate\Support\Str::plural('change', $drafts[$key])" />@endif
            </a>
        @endforeach
    </div>
</x-admin-layout>
