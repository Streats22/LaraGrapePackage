{{-- @block id="text" label="Text Block" description="A text block with customizable styling" --}}
@php $isEditorPreview = $isEditorPreview ?? false; $attributes = $attributes ?? new \Illuminate\View\ComponentAttributeBag([]); $slot = $slot ?? 'Text block (edit me)'; @endphp
@if($isEditorPreview)
<div class="max-w-3xl mx-auto py-8 px-4 bg-primary-50 dark:bg-primary-900 rounded-xl shadow-md">
    <p class="text-primary-800 dark:text-primary-100 text-lg leading-relaxed font-medium">
        @if(!empty($highlight))
            <mark>{{ $slot }}</mark>
        @else
            {{ $slot }}
        @endif
    </p>
</div>
@else
<div class="max-w-3xl mx-auto py-8 px-4 bg-primary-50 dark:bg-primary-900 rounded-xl shadow-md"
     data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="false">
    <p class="text-primary-800 dark:text-primary-100 text-lg leading-relaxed font-medium"
       data-gjs-type="text" data-gjs-name="text-content">
        @if(!empty($highlight))
            <mark>{{ $slot }}</mark>
        @else
            {{ $slot }}
        @endif
    </p>
</div>
@endif 