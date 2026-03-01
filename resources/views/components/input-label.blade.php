@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-slate-heading']) }}>
    {{ $value ?? $slot }}
</label>