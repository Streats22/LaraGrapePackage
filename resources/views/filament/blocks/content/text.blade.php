{{-- @block id="text" label="Text Block" description="A text block with customizable styling" --}}
@php
    $attributes = $attributes ?? new \Illuminate\View\ComponentAttributeBag([]);
    $slot = $slot ?? 'Text block (edit me)';
@endphp
<div {{ $attributes->merge(['class' => 'max-w-3xl mx-auto py-8 px-4 bg-primary-50 dark:bg-primary-900 rounded-xl shadow-md']) }}>
    <p class="text-primary-800 dark:text-primary-100 text-lg leading-relaxed font-medium">
        @if(!empty($highlight))
            <mark>{{ $slot }}</mark>
        @else
            {{ $slot }}
        @endif
    </p>
</div> 