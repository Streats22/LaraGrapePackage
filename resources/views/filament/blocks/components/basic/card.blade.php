{{-- @block id="card" label="Card" description="A card component with image, title, and description" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="max-w-sm mx-auto rounded-xl shadow-lg overflow-hidden border-2 border-accent bg-primary-50 dark:bg-primary-900">
    <img src="https://via.placeholder.com/400x200/8b5cf6/ffffff?text=Card+Image" alt="Card image" class="w-full h-48 object-cover"/>
    <div class="p-6">
        <h3 class="text-xl font-extrabold mb-2 text-primary-900 dark:text-primary-50">Card Title</h3>
        <p class="mb-4 text-primary-700 dark:text-primary-200">Card description goes here. You can edit this text to add your content.</p>
        <button class="px-4 py-2 rounded-lg font-semibold transition-colors bg-accent text-primary-900 dark:text-primary-50 hover:bg-primary-600 hover:text-primary-50 shadow dark:bg-accent dark:hover:bg-primary-700 dark:hover:text-primary-100" disabled>Learn More</button>
    </div>
</div>
@else
<div class="max-w-sm mx-auto rounded-xl shadow-lg overflow-hidden border-2 border-accent bg-primary-50 dark:bg-primary-900"
     data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="false">
    <img src="https://via.placeholder.com/400x200/8b5cf6/ffffff?text=Card+Image" alt="Card image" class="w-full h-48 object-cover" data-gjs-type="image" data-gjs-name="card-image"/>
    <div class="p-6">
        <h3 class="text-xl font-extrabold mb-2 text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="card-title">Card Title</h3>
        <p class="mb-4 text-primary-700 dark:text-primary-200" data-gjs-type="text" data-gjs-name="card-description">Card description goes here. You can edit this text to add your content.</p>
        <button class="px-4 py-2 rounded-lg font-semibold transition-colors bg-accent text-primary-900 dark:text-primary-50 hover:bg-primary-600 hover:text-primary-50 shadow dark:bg-accent dark:hover:bg-primary-700 dark:hover:text-primary-100"
                data-gjs-type="text" data-gjs-name="card-button">Learn More</button>
    </div>
</div>
@endif 