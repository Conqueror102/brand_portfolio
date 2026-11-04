<x-admin-layout :title="$definition['label']">
    <x-slot:actions>
        <a class="link-arrow" href="{{ route('admin.items.overview') }}">All lists <x-line-icon name="arrow" /></a>
        <a class="btn" href="{{ route('admin.items.create', $type) }}">Add <span class="btn-icon"><x-line-icon name="plus" /></span></a>
    </x-slot:actions>
    @if (! empty($definition['help']))<p class="admin-intro">{{ $definition['help'] }}</p>@endif
    <section class="admin-panel admin-table-panel">
        @if ($items->isEmpty())
            <p class="admin-empty">Nothing here yet. <a href="{{ route('admin.items.create', $type) }}">Add the first one</a>.</p>
        @else
            <table class="admin-table admin-list-table">
                <thead><tr><th>Order</th><th>{{ $definition['fields']['title'] ?? 'Item' }}</th>@if (isset($definition['categories']))<th>Type</th>@endif<th>Status</th><th><span class="sr-only">Actions</span></th></tr></thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td class="admin-move">
                            <form method="POST" action="{{ route('admin.items.move', [$type, $item->id]) }}">@csrf<input type="hidden" name="direction" value="up"><button type="submit" aria-label="Move up" @disabled($loop->first)>↑</button></form>
                            <form method="POST" action="{{ route('admin.items.move', [$type, $item->id]) }}">@csrf<input type="hidden" name="direction" value="down"><button type="submit" aria-label="Move down" @disabled($loop->last)>↓</button></form>
                        </td>
                        <td>
                            <a class="admin-cell-title" href="{{ route('admin.items.edit', [$type, $item->id]) }}">
                                @if ($item->image)<span class="admin-thumb"><img src="{{ $item->imageUrl() }}" alt=""></span>@elseif ($item->icon)<span class="icon-chip"><x-line-icon :name="$item->icon" /></span>@endif
                                <span><strong>{{ \Illuminate\Support\Str::limit($item->title, 90) }}</strong>@if ($item->subtitle)<small>{{ \Illuminate\Support\Str::limit($item->subtitle, 90) }}</small>@elseif ($item->date)<small>{{ $item->date->format('j M Y') }}</small>@endif</span>
                            </a>
                        </td>
                        @if (isset($definition['categories']))<td>{{ $definition['categories'][$item->category] ?? '—' }}</td>@endif
                        <td><x-admin-status :status="$item->is_published ? 'published' : 'draft'" :label="$item->is_published ? 'Visible' : 'Hidden'" /></td>
                        <td class="admin-row-actions">
                            @if (! empty($definition['pages']) && $item->is_published)<a href="{{ route('podcast.show', $item) }}" target="_blank" rel="noopener">View</a>@endif
                            <a href="{{ route('admin.items.edit', [$type, $item->id]) }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>
</x-admin-layout>
