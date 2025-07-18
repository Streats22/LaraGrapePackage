{{-- @block id="image" label="Image Block" description="A block for displaying images with optional caption" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="w-full flex flex-col items-center">
    <img src="{{ $src ?? 'https://placehold.co/600x400' }}" alt="{{ $alt ?? '' }}" class="rounded-lg shadow-md max-w-full h-auto" />
    @if(!empty($caption))
        <div class="text-sm text-gray-500 mt-2">{{ $caption }}</div>
    @endif
</div>
@else
<div class="w-full flex flex-col items-center" data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="false">
    <img src="{{ $src ?? 'https://placehold.co/600x400' }}" 
         alt="{{ $alt ?? '' }}" 
         class="rounded-lg shadow-md max-w-full h-auto"
         data-gjs-type="image" 
         data-gjs-name="image-src" />
    @if(!empty($caption))
        <div class="text-sm text-gray-500 mt-2" data-gjs-type="text" data-gjs-name="image-caption">{{ $caption }}</div>
    @endif
</div>
@endif 