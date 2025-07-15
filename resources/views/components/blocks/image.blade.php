{{-- @block id="image" label="Image" description="An image block with customizable styling" --}}
@php
    $attributes = $attributes ?? new \Illuminate\View\ComponentAttributeBag([]);
    $slot = $slot ?? '';
@endphp
<div class="w-full bg-primary-100 border-4 border-accent rounded-2xl overflow-hidden shadow-xl">
    <img src="{{ $src }}" alt="{{ $alt ?? '' }}" class="w-full h-auto object-cover transition-transform duration-300 hover:scale-105">
</div> 