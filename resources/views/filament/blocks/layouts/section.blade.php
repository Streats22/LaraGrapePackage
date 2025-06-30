{{-- @block id="section" label="Section" description="A content section with customizable background and padding" --}}
<div class="section-block bg-white py-12 px-4" data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="true" data-gjs-name="section">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-purple-900 mb-4" data-gjs-type="text" data-gjs-name="section-title">Section Title</h2>
            <p class="text-lg text-purple-700 max-w-2xl mx-auto" data-gjs-type="text" data-gjs-name="section-description">Section description goes here. You can edit this text and add content below.</p>
        </div>
        <div class="min-h-40 bg-purple-50 p-6 rounded-lg border-2 border-dashed border-purple-300 flex items-center justify-center" data-gjs-droppable="true" data-gjs-name="section-content">
            <div class="text-center">
                <svg class="w-12 h-12 text-purple-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <p class="text-purple-600 font-medium">Drop content here</p>
                <p class="text-sm text-purple-500 mt-1">Add blocks, text, images, and more</p>
            </div>
        </div>
    </div>
</div> 