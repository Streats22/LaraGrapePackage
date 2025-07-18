{{-- @block id="section" label="Section Block" description="A layout section block" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<section class="py-12 md:py-20 bg-primary-50 dark:bg-primary-900">
    @if(!empty($title))
        <h2 class="text-3xl font-bold mb-6 text-primary-900 dark:text-primary-50">{{ $title }}</h2>
    @endif
    <div class="container mx-auto px-4">
        <div class="text-center">
            <p class="text-lg text-primary-700 dark:text-primary-200">Section content goes here</p>
        </div>
    </div>
</section>
@else
<section class="py-12 md:py-20 bg-primary-50 dark:bg-primary-900" 
         data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="true" data-gjs-name="section">
    @if(!empty($title))
        <h2 class="text-3xl font-bold mb-6 text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="section-title">{{ $title }}</h2>
    @endif
    <div class="container mx-auto px-4" data-gjs-droppable="true" data-gjs-name="section-content">
        <div class="text-center">
            <p class="text-lg text-primary-700 dark:text-primary-200" data-gjs-type="text" data-gjs-name="section-text">Section content goes here</p>
        </div>
    </div>
</section>
@endif 