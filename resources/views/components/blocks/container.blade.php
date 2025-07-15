{{-- @block id="container" label="Container" description="A container block for grouping content" --}}
@php
    $attributes = $attributes ?? new \Illuminate\View\ComponentAttributeBag([]);
    $slot = $slot ?? '';
@endphp
<div class="container mx-auto px-6 py-8 bg-primary-50 dark:bg-primary-900 border-2 border-primary-200 rounded-2xl shadow-xl">
    {{ $slot }}
</div> 