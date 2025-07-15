{{-- @block id="columns" label="Columns" description="A two-column layout with customizable content" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="columns-block bg-primary-50 dark:bg-primary-900 py-12 px-4 border-l-8 border-accent shadow-lg">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-primary-900 dark:text-primary-100 mb-4">Two Column Layout</h2>
            <p class="text-lg text-primary-700 dark:text-primary-200">Add content to each column below</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="min-h-48 bg-primary-50 dark:bg-primary-900 p-6 rounded-lg border-2 border-dashed border-accent flex items-center justify-center shadow-md">
                <div class="text-center">
                    <svg class="w-10 h-10 text-accent mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-primary-700 dark:text-primary-200 font-semibold">Column 1</p>
                    <p class="text-sm text-primary-500 dark:text-primary-200 mt-1">Drop content here</p>
                </div>
            </div>
            <div class="min-h-48 bg-primary-50 dark:bg-primary-900 p-6 rounded-lg border-2 border-dashed border-accent flex items-center justify-center shadow-md">
                <div class="text-center">
                    <svg class="w-10 h-10 text-accent mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-primary-700 dark:text-primary-200 font-semibold">Column 2</p>
                    <p class="text-sm text-primary-500 dark:text-primary-200 mt-1">Drop content here</p>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="columns-block bg-primary-50 dark:bg-primary-900 py-12 px-4 border-l-8 border-accent shadow-lg" data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="true" data-gjs-name="columns">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-primary-900 dark:text-primary-100 mb-4" data-gjs-type="text" data-gjs-name="columns-title">Two Column Layout</h2>
            <p class="text-lg text-primary-700 dark:text-primary-200" data-gjs-type="text" data-gjs-name="columns-description">Add content to each column below</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="min-h-48 bg-primary-50 dark:bg-primary-900 p-6 rounded-lg border-2 border-dashed border-accent flex items-center justify-center shadow-md" data-gjs-droppable="true" data-gjs-name="columns-content-1">
                <div class="text-center">
                    <svg class="w-10 h-10 text-accent mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-primary-700 dark:text-primary-200 font-semibold">Column 1</p>
                    <p class="text-sm text-primary-500 dark:text-primary-200 mt-1">Drop content here</p>
                </div>
            </div>
            <div class="min-h-48 bg-primary-50 dark:bg-primary-900 p-6 rounded-lg border-2 border-dashed border-accent flex items-center justify-center shadow-md" data-gjs-droppable="true" data-gjs-name="columns-content-2">
                <div class="text-center">
                    <svg class="w-10 h-10 text-accent mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-primary-700 dark:text-primary-200 font-semibold">Column 2</p>
                    <p class="text-sm text-primary-500 dark:text-primary-200 mt-1">Drop content here</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif 