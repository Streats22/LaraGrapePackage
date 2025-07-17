{{-- @block id="image" label="Image Block" description="A block for displaying images with optional caption" --}}
<div {{ $attributes->merge(['class' => 'w-full flex flex-col items-center']) }}>
    <img src="{{ $src ?? 'https://placehold.co/600x400' }}" alt="{{ $alt ?? '' }}" class="rounded-lg shadow-md max-w-full h-auto" />
    @if(!empty($caption))
        <div class="text-sm text-gray-500 mt-2">{{ $caption }}</div>
    @endif
</div> 