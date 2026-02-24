{{-- @block id="simple-test-counter" label="Simple Test Counter" description="A very simple test counter" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="simple-test-counter-block py-8 border-2 border-green-500">
    <div class="container mx-auto px-4 text-center">
        <h3 class="text-2xl font-bold mb-6 text-green-600">Simple Test</h3>
        <div class="text-6xl font-bold mb-4 text-green-500">0</div>
        <button class="px-4 py-2 bg-green-500 text-white rounded">Click Me</button>
    </div>
</div>
@else
<div class="simple-test-counter-block py-8 border-2 border-green-500" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data="{ count: 0 }">
    <div class="container mx-auto px-4 text-center">
        <h3 class="text-2xl font-bold mb-6 text-green-600" data-gjs-type="text" data-gjs-name="simple-title">Simple Test</h3>
        <div class="text-6xl font-bold mb-4 text-green-500" 
             data-gjs-type="default" 
             data-gjs-droppable="false"
             x-text="count">0</div>
        <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition-colors" 
                @click="count++"
                type="button"
                data-gjs-type="default" 
                data-gjs-droppable="false">
            Click Me
        </button>
    </div>
</div>
@endif 