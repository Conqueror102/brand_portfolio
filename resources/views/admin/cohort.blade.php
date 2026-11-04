@php($v = fn ($k) => old($k, $values[$k]))
<x-admin-layout title="Mentorship cohort">
    <x-slot:actions><a class="link-arrow" href="{{ route('mentorship') }}" target="_blank" rel="noopener">View mentorship page <x-line-icon name="arrow-up-right" /></a></x-slot:actions>
    <div class="alert alert-info admin-flash"><x-line-icon name="eye" /> <span>The website currently shows: <strong>{{ mentorship_status_label() }}</strong>@if ($effective !== $values['mentorship_status']) (set by the application dates)@endif.</span></div>
    <form class="admin-form-grid" method="POST" action="{{ route('admin.cohort.update') }}">
        @csrf @method('PUT')
        <section class="admin-panel form">
            <h2 class="admin-subhead">Cohort details</h2>
            <div class="form-row">
                <x-field name="mentorship_cohort" label="Cohort name" :value="$v('mentorship_cohort')" required />
                <x-field name="mentorship_year" label="Year" optional :value="$v('mentorship_year')" />
            </div>
            <div class="form-row">
                <x-field name="mentorship_period" label="Programme period" optional :value="$v('mentorship_period')" placeholder="e.g. March to June" />
                <x-field name="mentorship_duration" label="Duration" optional :value="$v('mentorship_duration')" placeholder="e.g. 12 weeks" />
            </div>
            <div class="form-row">
                <x-field name="mentorship_opening" label="Opening session" optional :value="$v('mentorship_opening')" />
                <x-field name="mentorship_closing" label="Closing session" optional :value="$v('mentorship_closing')" />
            </div>
            <x-field name="mentorship_sessions" label="Session rhythm" optional :value="$v('mentorship_sessions')" placeholder="e.g. Fortnightly, Saturdays 10:00" />
            <div class="form-row">
                <x-field name="mentorship_timezone" label="Time zone" optional :value="$v('mentorship_timezone')" placeholder="e.g. WAT (UTC+1)" />
                <x-field name="mentorship_delivery" label="Delivery" optional :value="$v('mentorship_delivery')" placeholder="e.g. Virtual, with an in-person close" />
            </div>
            <div class="form-row">
                <x-field name="mentorship_fee" label="Fee" optional :value="$v('mentorship_fee')" placeholder="Leave blank to hide" />
                <x-field name="mentorship_capacity" label="Places" optional :value="$v('mentorship_capacity')" placeholder="e.g. 20 places" />
            </div>
        </section>
        <aside class="admin-form-side">
            <section class="admin-panel form">
                <fieldset class="field">
                    <legend>Availability</legend>
                    @foreach (['open' => 'Applications open', 'forthcoming' => 'Opening soon (waiting list)', 'in_progress' => 'Cohort in progress', 'closed' => 'Closed'] as $value => $label)
                        <label class="check"><input type="radio" name="mentorship_status" value="{{ $value }}" @checked($v('mentorship_status') === $value)> <span>{{ $label }}</span></label>
                    @endforeach
                </fieldset>
                <x-field name="applications_open_on" label="Applications open on" type="date" optional :value="$v('applications_open_on')" />
                <x-field name="applications_close_on" label="Applications close on" type="date" optional :value="$v('applications_close_on')" hint="With “Applications open”, the form shows only between these dates, then closes by itself." />
                <button class="btn" type="submit">Save cohort <span class="btn-icon"><x-line-icon name="check" /></span></button>
            </section>
            <a class="admin-panel admin-reply" href="{{ route('admin.applications.index') }}"><x-line-icon name="steps" /> Review applications</a>
        </aside>
    </form>
</x-admin-layout>
