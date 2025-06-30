{{-- @block id="container" label="Container" description="A container block for grouping content" --}}
<div {{ $attributes->merge(['class' => 'container mx-auto px-4']) }}>
    {{ $slot }}
</div> 