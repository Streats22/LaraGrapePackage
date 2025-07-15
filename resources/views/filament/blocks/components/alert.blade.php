{{-- @block id="alert" label="Alert" description="A dismissible alert block" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="rounded-lg p-4 flex items-center gap-3 bg-primary-50 border-l-4 border-accent text-primary-900 shadow">
    <i class="fa fa-info-circle text-accent"></i>
    <span>This is an alert message.</span>
            </div>
@else
<div class="rounded-lg p-4 flex items-center gap-3 bg-primary-50 border-l-4 border-accent text-primary-900 shadow"
     data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="false">
    <i class="fa fa-info-circle text-accent"></i>
    <span data-gjs-type="text" data-gjs-name="alert-text">This is an alert message.</span>
            </div>
@endif 