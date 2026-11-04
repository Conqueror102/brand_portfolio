<x-admin-layout title="Application" :heading="$application->name">
    <x-slot:actions><a class="link-arrow" href="{{ route('admin.applications.index') }}">All applications <x-line-icon name="arrow" /></a></x-slot:actions>
    <div class="admin-form-grid">
        <section class="admin-panel">
            <div class="admin-detail-head">
                <x-admin-status :status="$application->status" :label="config('site.application_statuses.'.$application->status)" />
                <span>{{ $application->cohort }}</span>
                <small>Received {{ $application->created_at->format('j F Y, H:i') }}</small>
            </div>
            <dl class="admin-dl">
                <div><dt>Email</dt><dd><a href="mailto:{{ $application->email }}">{{ $application->email }}</a></dd></div>
                @if ($application->phone)<div><dt>Phone</dt><dd>{{ $application->phone }}</dd></div>@endif
                <div><dt>Role</dt><dd>{{ $application->role }}</dd></div>
                <div><dt>Location</dt><dd>{{ $application->location }}</dd></div>
                <div><dt>Thursday sessions</dt><dd>{{ ['consistently' => 'Yes, consistently', 'mostly' => 'Most weeks', 'unsure' => 'Not sure yet'][$application->availability] ?? $application->availability }}</dd></div>
                <div><dt>In-person sessions</dt><dd>{{ ['yes' => 'Yes', 'unsure' => 'Not sure yet', 'no' => 'No'][$application->in_person] ?? $application->in_person }}</dd></div>
                <div><dt>Marketing updates</dt><dd>{{ $application->marketing_consent ? 'Opted in' : 'No' }}</dd></div>
            </dl>
            @foreach (['goals' => 'Goals', 'outcomes' => 'Six-month outcomes', 'motivation' => 'Why now', 'support' => 'Support needed', 'commitment' => 'Commitment between sessions'] as $field => $label)
                @if (filled($application->$field))
                    <h2 class="admin-subhead">{{ $label }}</h2>
                    <div class="admin-message">{!! nl2br(e($application->$field)) !!}</div>
                @endif
            @endforeach
            <ol class="admin-flow" aria-label="Progress">
                @php($stage = ['submitted' => 0, 'reviewing' => 1, 'accepted' => 2, 'waitlisted' => 2, 'declined' => 2, 'onboarding' => 3, 'enrolled' => 4, 'withdrawn' => -1][$application->status] ?? 0)
                @foreach (['Submitted', 'Review', in_array($application->status, ['waitlisted', 'declined']) ? config('site.application_statuses.'.$application->status) : 'Accepted', 'Onboarding', 'Enrolled'] as $i => $label)
                    <li class="{{ $i === $stage ? 'is-current' : ($i < $stage ? 'is-done' : '') }}">{{ $label }}</li>
                @endforeach
            </ol>
            <p class="field-hint">Payment is tracked separately: {{ strtolower(config('site.payment_statuses.'.$application->payment_status)) }}.</p>
        </section>
        <aside class="admin-form-side">
            <form class="admin-panel form" method="POST" action="{{ route('admin.applications.update', $application) }}">
                @csrf @method('PUT')
                <label class="field"><span>Decision</span>
                    <select name="status">
                        @foreach (config('site.application_statuses') as $value => $label)<option value="{{ $value }}" @selected($application->status === $value)>{{ $label }}</option>@endforeach
                    </select>
                </label>
                <label class="field"><span>Payment</span>
                    <select name="payment_status">
                        @foreach (config('site.payment_statuses') as $value => $label)<option value="{{ $value }}" @selected($application->payment_status === $value)>{{ $label }}</option>@endforeach
                    </select>
                </label>
                <label class="field"><span>Assigned to</span>
                    <select name="assigned_to">
                        <option value="">Nobody yet</option>
                        @foreach ($team as $member)<option value="{{ $member->id }}" @selected(old('assigned_to', $application->assigned_to) == $member->id)>{{ $member->name }}</option>@endforeach
                    </select>
                </label>
                <x-field name="internal_notes" label="Summary for the team" type="textarea" optional :value="$application->internal_notes" />
                <p class="field-hint">Saving does not email the applicant. Send payment and onboarding details yourself once accepted.</p>
                <button class="btn" type="submit">Save <span class="btn-icon"><x-line-icon name="check" /></span></button>
            </form>
            <a class="admin-panel admin-reply" href="mailto:{{ $application->email }}?subject={{ rawurlencode('Your mentorship application') }}"><x-line-icon name="mail" /> Email applicant</a>
            @include('partials.admin-notes', ['action' => route('admin.applications.note', $application), 'notes' => $application->notes])
        </aside>
    </div>
</x-admin-layout>
