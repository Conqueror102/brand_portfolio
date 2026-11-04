@if (\App\Models\Content::previewing())
    <div class="preview-bar" role="status">
        <x-line-icon name="eye" /> <span>Preview: you are seeing unpublished changes. Visitors still see the live version.</span>
        <a href="{{ request()->fullUrlWithoutQuery('preview') }}">Exit preview</a>
    </div>
@endif
