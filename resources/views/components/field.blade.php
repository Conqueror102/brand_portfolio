@props(['name', 'label', 'type' => 'text', 'optional' => false, 'value' => null, 'hint' => null])
<label class="field">
    <span>{{ $label }}@if ($optional)<em>optional</em>@endif</span>
    @if ($type === 'textarea')
        <textarea name="{{ $name }}" rows="{{ $attributes->get('rows', 4) }}" @error($name) aria-invalid="true" @enderror {{ $attributes->except('rows') }}>{{ old($name, $value) }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}" @error($name) aria-invalid="true" @enderror {{ $attributes }}>
    @endif
    @if ($hint)<small class="field-hint">{{ $hint }}</small>@endif
    @error($name)<span class="field-error">{{ $message }}</span>@enderror
</label>
