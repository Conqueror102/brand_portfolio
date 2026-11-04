<x-admin-layout title="Lists" heading="Lists">
    <p class="admin-intro">Topics, programmes, organisations, FAQs, episodes and every other repeating item on the website. Add, edit, reorder or hide them here.</p>
    @foreach ($groups as $group => $types)
        <h2 class="admin-subhead">{{ $group }}</h2>
        <div class="admin-tiles">
            @foreach ($types as $key => $type)
                <a class="admin-tile" href="{{ route('admin.items.index', $key) }}">
                    <span class="icon-chip"><x-line-icon :name="$type['icon'] ?? 'file'" /></span>
                    <strong>{{ $type['label'] }}</strong>
                    <span>{{ $counts[$key] ?? 0 }} {{ \Illuminate\Support\Str::plural('item', $counts[$key] ?? 0) }}</span>
                </a>
            @endforeach
        </div>
    @endforeach
</x-admin-layout>
