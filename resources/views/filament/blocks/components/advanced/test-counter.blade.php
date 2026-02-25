{{-- @block id="test-counter" label="Test Counter" description="A simple test counter to verify Alpine.js integration" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="test-counter-block py-8" style="background-color: var(--laralgrape-primary-50);">
    <div class="container mx-auto px-4 text-center">
        <h3 class="text-2xl font-bold mb-6" style="color: var(--laralgrape-primary-900);">Test Counter</h3>
        <div class="text-6xl font-bold mb-4" style="color: var(--laralgrape-accent);">0</div>
        <p class="text-primary-700">Click to increment</p>
    </div>
</div>
@else
<div class="test-counter-block py-8" 
     style="background-color: var(--laralgrape-primary-50);" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data="{ count: 0 }">
    <div class="container mx-auto px-4 text-center">
        <h3 class="text-2xl font-bold mb-6" style="color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="counter-title">Test Counter</h3>
        <div class="text-6xl font-bold mb-4 cursor-pointer hover:scale-110 transition-transform" 
             style="color: var(--laralgrape-accent);"
             data-gjs-type="default" 
             data-gjs-droppable="false"
             @click="count++"
             x-text="count">0</div>
        <p class="text-primary-700" data-gjs-type="text" data-gjs-name="counter-description">Click to increment</p>
    </div>
</div>
@endif 