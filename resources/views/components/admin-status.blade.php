@props(['status', 'label' => null])
@php($tone = match ($status) {
    'new', 'submitted', 'draft', 'pending' => 'amber',
    'reviewing', 'awaiting_info', 'waitlisted', 'onboarding' => 'blue',
    'approved', 'accepted', 'scheduled', 'enrolled', 'published', 'confirmed', 'completed' => 'green',
    'declined', 'withdrawn' => 'red',
    default => 'grey',
})
<span class="admin-status admin-status-{{ $tone }}">{{ $label ?? ucfirst(str_replace('_', ' ', $status)) }}</span>
