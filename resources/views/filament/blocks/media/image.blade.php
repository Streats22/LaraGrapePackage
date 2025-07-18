{{-- @block id="image" label="Image Block" description="A block for displaying images with optional caption" --}}
@php 
    $isEditorPreview = $isEditorPreview ?? false;
    $attributes = $attributes ?? collect();
@endphp
@if($isEditorPreview)
<div class="image-block w-full flex flex-col items-center border-l-8 border-accent shadow-lg p-4">
    <img src="https://placehold.co/600x400" alt="Sample image" class="rounded-lg shadow-md max-w-full h-auto" data-gjs-type="image" data-gjs-name="image" />
    <div class="text-sm text-gray-500 mt-2" data-gjs-type="text" data-gjs-name="caption">Image caption goes here</div>
</div>
@else
<div {{ $attributes->merge(['class' => 'w-full flex flex-col items-center']) }}>
    <img src="{{ $src ?? 'https://placehold.co/600x400' }}" alt="{{ $alt ?? '' }}" class="rounded-lg shadow-md max-w-full h-auto" />
    @if(!empty($caption))
        <div class="text-sm text-gray-500 mt-2">{{ $caption }}</div>
    @endif
</div>
@endif 