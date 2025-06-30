{{-- @block id="container" label="Container" description="A container with customizable padding and background" --}}
<div class="container-block bg-purple-50 p-8 rounded-lg border-2 border-dashed border-purple-200" data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="true" data-gjs-name="container">
    <div class="text-center mb-4">
        <h3 class="text-lg font-semibold text-purple-800" data-gjs-type="text" data-gjs-name="container-title">Container Title</h3>
        <p class="text-purple-600 text-sm" data-gjs-type="text" data-gjs-name="container-description">Drop content here</p>
    </div>
    <div class="min-h-32 bg-white p-4 rounded border-2 border-dashed border-purple-300 flex items-center justify-center" data-gjs-droppable="true" data-gjs-name="container-content">
        <div class="text-center">
            <svg class="w-8 h-8 text-purple-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            <p class="text-sm text-purple-500">Drop blocks here</p>
        </div>
    </div>
</div> 