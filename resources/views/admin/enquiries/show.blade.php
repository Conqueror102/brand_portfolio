<x-admin-layout title="Enquiry" :heading="$enquiry->name">
    <x-slot:actions><a class="link-arrow" href="{{ route('admin.enquiries.index') }}">All enquiries <x-line-icon name="arrow" /></a></x-slot:actions>
    <div class="admin-form-grid">
        <section class="admin-panel">
            <div class="admin-detail-head">
                <x-admin-status :status="$enquiry->status" :label="config('site.enquiry_statuses.'.$enquiry->status)" />
                <span>{{ $enquiry->typeLabel() }}</span>
                <small>Received {{ $enquiry->created_at->format('j F Y, H:i') }}</small>
            </div>
            <dl class="admin-dl">
                <div><dt>Email</dt><dd><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></dd></div>
                @foreach (['phone' => 'Phone', 'organisation' => 'Organisation', 'proposed_date' => 'Proposed date', 'location' => 'Location or format', 'audience' => 'Audience', 'participants' => 'Participants'] as $field => $label)
                    @if (filled($enquiry->$field))<div><dt>{{ $label }}</dt><dd>{{ $enquiry->$field }}</dd></div>@endif
                @endforeach
            </dl>
            <h2 class="admin-subhead">Message</h2>
            <div class="admin-message">{!! nl2br(e($enquiry->message)) !!}</div>
            <ol class="admin-flow" aria-label="Progress">
                @foreach (['new' => 'Received', 'reviewing' => 'Review', 'follow_up' => 'Follow-up', 'approved' => 'Approved', 'scheduled' => 'Scheduled', 'completed' => 'Completed'] as $step => $label)
                    @php($order = array_keys(config('site.enquiry_statuses')))
                    <li class="{{ $enquiry->status === $step ? 'is-current' : (array_search($step, $order) < array_search($enquiry->status, $order) && ! in_array($enquiry->status, ['declined', 'archived']) ? 'is-done' : '') }}">{{ $label }}</li>
                @endforeach
            </ol>
        </section>
        <aside class="admin-form-side">
            <form class="admin-panel form" method="POST" action="{{ route('admin.enquiries.update', $enquiry) }}">
                @csrf @method('PUT')
                <label class="field"><span>Status</span>
                    <select name="status">
                        @foreach (config('site.enquiry_statuses') as $value => $label)<option value="{{ $value }}" @selected($enquiry->status === $value)>{{ $label }}</option>@endforeach
                    </select>
                </label>
                <label class="field"><span>Assigned to</span>
                    <select name="assigned_to">
                        <option value="">Nobody yet</option>
                        @foreach ($team as $member)<option value="{{ $member->id }}" @selected(old('assigned_to', $enquiry->assigned_to) == $member->id)>{{ $member->name }}</option>@endforeach
                    </select>
                </label>
                <div class="form-row">
                    <x-field name="follow_up_on" label="Follow up on" type="date" optional :value="$enquiry->follow_up_on?->format('Y-m-d')" />
                    <x-field name="scheduled_for" label="Scheduled for" type="date" optional :value="$enquiry->scheduled_for?->format('Y-m-d')" />
                </div>
                <x-field name="internal_notes" label="Summary for the team" type="textarea" optional :value="$enquiry->internal_notes" hint="Only visible to the team. Use notes below for the running history." />
                <button class="btn" type="submit">Save <span class="btn-icon"><x-line-icon name="check" /></span></button>
            </form>
            <a class="admin-panel admin-reply" href="mailto:{{ $enquiry->email }}?subject={{ rawurlencode('Re: your enquiry') }}"><x-line-icon name="mail" /> Reply by email</a>
            @include('partials.admin-notes', ['action' => route('admin.enquiries.note', $enquiry), 'notes' => $enquiry->notes])
        </aside>
    </div>
</x-admin-layout>
