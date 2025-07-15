{{-- @block id="grid" label="Grid Layout" description="A flexible grid layout with customizable columns" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="grid-layout bg-primary-50 dark:bg-primary-900 py-12 border-l-8 border-accent shadow-lg">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="grid-item bg-primary-50 dark:bg-primary-900 rounded-lg shadow-md p-6 border-2 border-accent">
                <h3 class="text-xl font-extrabold mb-4 text-primary-900 dark:text-primary-100">Grid Item 1</h3>
                <p class="text-primary-700 dark:text-primary-200">Add your content here. This grid item is fully editable and can contain any elements.</p>
            </div>
            <div class="grid-item bg-primary-50 dark:bg-primary-900 rounded-lg shadow-md p-6 border-2 border-accent">
                <h3 class="text-xl font-extrabold mb-4 text-primary-900 dark:text-primary-100">Grid Item 2</h3>
                <p class="text-primary-700 dark:text-primary-200">Add your content here. This grid item is fully editable and can contain any elements.</p>
            </div>
            <div class="grid-item bg-primary-50 dark:bg-primary-900 rounded-lg shadow-md p-6 border-2 border-accent">
                <h3 class="text-xl font-extrabold mb-4 text-primary-900 dark:text-primary-100">Grid Item 3</h3>
                <p class="text-primary-700 dark:text-primary-200">Add your content here. This grid item is fully editable and can contain any elements.</p>
            </div>
        </div>
    </div>
</div>
@else
<div class="grid-layout bg-primary-50 dark:bg-primary-900 py-12 border-l-8 border-accent shadow-lg">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="grid-item bg-primary-50 dark:bg-primary-900 rounded-lg shadow-md p-6 border-2 border-accent" data-gjs-type="default" data-gjs-droppable="true">
                <h3 class="text-xl font-extrabold mb-4 text-primary-900 dark:text-primary-100" data-gjs-type="text" data-gjs-name="grid-title-1">Grid Item 1</h3>
                <p class="text-primary-700 dark:text-primary-200" data-gjs-type="text" data-gjs-name="grid-content-1">Add your content here. This grid item is fully editable and can contain any elements.</p>
            </div>
            <div class="grid-item bg-primary-50 dark:bg-primary-900 rounded-lg shadow-md p-6 border-2 border-accent" data-gjs-type="default" data-gjs-droppable="true">
                <h3 class="text-xl font-extrabold mb-4 text-primary-900 dark:text-primary-100" data-gjs-type="text" data-gjs-name="grid-title-2">Grid Item 2</h3>
                <p class="text-primary-700 dark:text-primary-200" data-gjs-type="text" data-gjs-name="grid-content-2">Add your content here. This grid item is fully editable and can contain any elements.</p>
            </div>
            <div class="grid-item bg-primary-50 dark:bg-primary-900 rounded-lg shadow-md p-6 border-2 border-accent" data-gjs-type="default" data-gjs-droppable="true">
                <h3 class="text-xl font-extrabold mb-4 text-primary-900 dark:text-primary-100" data-gjs-type="text" data-gjs-name="grid-title-3">Grid Item 3</h3>
                <p class="text-primary-700 dark:text-primary-200" data-gjs-type="text" data-gjs-name="grid-content-3">Add your content here. This grid item is fully editable and can contain any elements.</p>
            </div>
        </div>
    </div>
</div>
@endif 