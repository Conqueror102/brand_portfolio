@props(['name'])
@php
    $icons = ['arrow-up-right' => 'arrow-up-right.png', 'menu' => 'menu.png'];
    $file = $icons[$name] ?? null;
@endphp
@if ($file)
    <img src="{{ asset('icons/'.$file) }}" alt="" aria-hidden="true" width="24" height="24" {{ $attributes->class(['icon']) }}>
@endif
