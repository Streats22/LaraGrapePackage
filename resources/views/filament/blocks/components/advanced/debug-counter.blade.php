{{-- @block id="debug-counter" label="Debug Counter" description="A debug counter to troubleshoot Alpine.js integration" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="debug-counter-block py-8 border-2 border-red-500">
    <div class="container mx-auto px-4 text-center">
        <h3 class="text-2xl font-bold mb-6 text-red-600">Debug Counter</h3>
        <div class="text-6xl font-bold mb-4 text-red-500">0</div>
        <p class="text-red-600">Click to test Alpine.js</p>
        <div class="text-sm text-gray-500 mt-2">Check console for debug info</div>
    </div>
</div>
@else
<div class="debug-counter-block py-8 border-2 border-red-500" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data="{ 
         count: 0,
         initialized: false,
         init() {
             this.initialized = true;
         }
     }" 
     x-init="init()">
    <div class="container mx-auto px-4 text-center">
        <h3 class="text-2xl font-bold mb-6 text-red-600" data-gjs-type="text" data-gjs-name="debug-title">Debug Counter</h3>
        <div class="text-6xl font-bold mb-4 cursor-pointer hover:scale-110 transition-transform text-red-500" 
             data-gjs-type="default" 
             data-gjs-droppable="false"
             @click="count++"
             x-text="count">0</div>
        <p class="text-red-600" data-gjs-type="text" data-gjs-name="debug-description">Click to test Alpine.js</p>
        <div class="text-sm text-gray-500 mt-2" x-text="'Initialized: ' + initialized">Initialized: false</div>
        <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors" 
                @click.prevent="count++"
                type="button"
                data-gjs-type="default" 
                data-gjs-droppable="false">
            Test Alpine.js (+1)
        </button>
    </div>
</div>
@endif 