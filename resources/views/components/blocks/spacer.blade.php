{{-- @block id="spacer" label="Spacer" description="A spacer block for adding vertical space" --}}
@php
    $attributes = $attributes ?? new \Illuminate\View\ComponentAttributeBag([]);
    $slot = $slot ?? '';
@endphp
<div class="h-{{ $height ?? '16' }} bg-gradient-to-r from-primary-100 via-accent to-secondary/20 border-2 border-dashed border-primary-300 flex items-center justify-center rounded-xl shadow">
    <span class="text-primary-600 text-sm font-medium">Spacer ({{ ($height ?? 16) * 4 }}px)</span>
</div> 