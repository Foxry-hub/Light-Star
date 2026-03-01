@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'newsletter-input w-full text-sm']) }}>