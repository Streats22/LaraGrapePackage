{{-- @block id="spacer" label="Spacer" description="Add vertical space between elements" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="spacer-block">
    <div class="h-16 bg-primary-100 border-2 border-dashed border-primary-300 flex items-center justify-center rounded-lg">
        <span class="text-primary-600 text-sm font-medium">Spacer (64px)</span>
    </div>
</div>
@else
<div class="spacer-block" data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="false">
    <div class="h-16 bg-primary-100 border-2 border-dashed border-primary-300 flex items-center justify-center rounded-lg">
        <span class="text-primary-600 text-sm font-medium">Spacer (64px)</span>
    </div>
</div>
@endif 