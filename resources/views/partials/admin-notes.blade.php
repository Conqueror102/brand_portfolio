{{-- Activity and follow-up notes for an enquiry or application. --}}
<section class="admin-panel admin-notes">
    <h2 class="admin-subhead">Notes &amp; activity</h2>
    <form class="form admin-note-form" method="POST" action="{{ $action }}">
        @csrf
        <label class="field"><span class="sr-only">Add a note</span>
            <textarea name="body" rows="3" required maxlength="5000" placeholder="Add a follow-up note: a call, a decision, what happens next…"></textarea>
        </label>
        @error('body')<span class="field-error">{{ $message }}</span>@enderror
        <button class="btn btn-plain btn-outline" type="submit">Add note</button>
    </form>
    @if ($notes->isEmpty())
        <p class="admin-empty">No activity yet.</p>
    @else
        <ol class="admin-timeline">
            @foreach ($notes as $note)
                <li class="{{ $note->is_system ? 'is-system' : '' }}">
                    <span class="admin-timeline-dot"></span>
                    <div>
                        <p>{!! nl2br(e($note->body)) !!}</p>
                        <small>{{ $note->user?->name ?? 'System' }} · {{ $note->created_at->format('j M Y, H:i') }}</small>
                    </div>
                </li>
            @endforeach
        </ol>
    @endif
</section>
