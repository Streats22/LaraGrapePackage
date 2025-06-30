{{-- @block id="text" label="Text Block" description="A text block with customizable styling" --}}
<div {{ $attributes->merge(['class' => 'max-w-3xl mx-auto py-6']) }}>
    {{ $slot }}
</div> 