{{-- @block id="button" label="Button" description="A clickable button with customizable styling" --}}
@php
    $attributes = $attributes ?? new \Illuminate\View\ComponentAttributeBag([]);
    $slot = $slot ?? 'Button Text';
@endphp
<button {{ $attributes->merge(['class' => 'bg-primary-600 dark:bg-primary-400 text-primary-50 dark:text-primary-900 font-semibold py-3 px-8 rounded-xl transition-all duration-200 shadow-lg hover:bg-primary-700 dark:hover:bg-primary-300 hover:text-primary-50 dark:hover:text-primary-900 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2']) }}>
    {{ $slot }}
</button> 