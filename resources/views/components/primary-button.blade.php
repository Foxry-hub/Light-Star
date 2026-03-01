<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-cyan text-sm w-full text-center justify-center']) }}>
    <span>{{ $slot }}</span>
</button>