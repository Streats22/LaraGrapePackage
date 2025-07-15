{{-- @block id="heading" label="Heading" description="A heading block with customizable styling" --}}
<div {{ $attributes->merge(['class' => 'text-center py-8']) }}>
    <h2 class="text-4xl font-bold text-primary-900 mb-4">{{ $slot }}</h2>
    <div class="w-24 h-1 bg-primary-600 mx-auto rounded-full"></div>
</div> 