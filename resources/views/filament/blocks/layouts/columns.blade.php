{{-- @block id="columns" label="Columns" description="A two-column layout with customizable content" --}}
<div class="columns-block bg-white py-12 px-4" data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="true" data-gjs-name="columns">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-purple-900 mb-4" data-gjs-type="text" data-gjs-name="columns-title">Two Column Layout</h2>
            <p class="text-lg text-purple-700" data-gjs-type="text" data-gjs-name="columns-description">Add content to each column below</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="min-h-48 bg-purple-50 p-6 rounded-lg border-2 border-dashed border-purple-300 flex items-center justify-center" data-gjs-droppable="true" data-gjs-name="column-1">
                <div class="text-center">
                    <svg class="w-10 h-10 text-purple-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-purple-600 font-medium">Column 1</p>
                    <p class="text-sm text-purple-500 mt-1">Drop content here</p>
                </div>
            </div>
            <div class="min-h-48 bg-purple-50 p-6 rounded-lg border-2 border-dashed border-purple-300 flex items-center justify-center" data-gjs-droppable="true" data-gjs-name="column-2">
                <div class="text-center">
                    <svg class="w-10 h-10 text-purple-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-purple-600 font-medium">Column 2</p>
                    <p class="text-sm text-purple-500 mt-1">Drop content here</p>
                </div>
            </div>
        </div>
    </div>
</div> 