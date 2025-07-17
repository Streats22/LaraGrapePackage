{{-- @block id="heading" label="Heading" description="A heading with decorative underline" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="heading-block text-center py-12 md:py-16 border-b-4 border-accent shadow-lg">
    <h2 class="text-5xl md:text-6xl font-extrabold tracking-tight text-primary-900 dark:text-primary-50 mb-6 drop-shadow-lg">Your Heading Here</h2>
    <div class="w-32 h-2 mx-auto rounded-full bg-accent shadow-md mb-2"></div>
    <p class="text-lg text-primary-600 mt-4 max-w-2xl mx-auto">Add a subtitle or description for your section here.</p>
</div>
@else
<div class="heading-block text-center py-12 md:py-16 border-b-4 border-accent shadow-lg" data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="false">
    <h2 class="text-5xl md:text-6xl font-extrabold tracking-tight text-primary-900 dark:text-primary-50 mb-6 drop-shadow-lg" data-gjs-type="text" data-gjs-name="heading-text">Your Heading Here</h2>
    <div class="w-32 h-2 mx-auto rounded-full bg-accent shadow-md mb-2"></div>
    <p class="text-lg text-primary-600 mt-4 max-w-2xl mx-auto">Add a subtitle or description for your section here.</p>
</div>
@endif 