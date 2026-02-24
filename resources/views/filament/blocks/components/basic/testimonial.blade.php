{{-- @block id="testimonial" label="Testimonial" description="A testimonial block with quote and author" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="max-w-lg mx-auto rounded-xl shadow-lg overflow-hidden border-2 border-accent bg-primary-50 dark:bg-primary-900">
    <div class="p-6">
        <blockquote class="italic mb-4 text-primary-700 dark:text-primary-200">“This product changed my life!”</blockquote>
        <div class="font-semibold text-primary-900 dark:text-primary-50">Jane Doe</div>
    </div>
</div>
@else
<div class="max-w-lg mx-auto rounded-xl shadow-lg overflow-hidden border-2 border-accent bg-primary-50 dark:bg-primary-900"
     data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="false">
    <div class="p-6">
        <blockquote class="italic mb-4 text-primary-700 dark:text-primary-200" data-gjs-type="text" data-gjs-name="testimonial-quote">“This product changed my life!”</blockquote>
        <div class="font-semibold text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="testimonial-author">Jane Doe</div>
    </div>
</div>
@endif 