{{-- @block id="hero" label="Hero Block" description="A hero section with background image support" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<section class="relative py-24 md:py-36 flex items-center justify-center text-center bg-primary-50 dark:bg-primary-900" @if(!empty($background)) style="background-image: url('{{ $background }}'); background-size: cover; background-position: center;" @endif>
    <div class="relative z-10">
        <h1 class="text-4xl md:text-6xl font-extrabold text-primary-50 mb-6 drop-shadow-lg">Hero Title</h1>
        <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">Add your hero subtitle or description here.</p>
        <button class="bg-accent text-primary-900 px-8 py-3 rounded-lg font-semibold hover:bg-primary-100 transition-colors" disabled>Get Started</button>
    </div>
    <div class="absolute inset-0 bg-black/30 dark:bg-black/50 z-0"></div>
</section>
@else
<section class="relative py-24 md:py-36 flex items-center justify-center text-center bg-primary-50 dark:bg-primary-900" 
         @if(!empty($background)) style="background-image: url('{{ $background }}'); background-size: cover; background-position: center;" @endif
         data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="true" data-gjs-name="hero">
    <div class="relative z-10">
        <h1 class="text-4xl md:text-6xl font-extrabold text-primary-50 mb-6 drop-shadow-lg" data-gjs-type="text" data-gjs-name="hero-title">Hero Title</h1>
        <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto" data-gjs-type="text" data-gjs-name="hero-subtitle">Add your hero subtitle or description here.</p>
        <button class="bg-accent text-primary-900 px-8 py-3 rounded-lg font-semibold hover:bg-primary-100 transition-colors" data-gjs-type="text" data-gjs-name="hero-button">Get Started</button>
    </div>
    <div class="absolute inset-0 bg-black/30 dark:bg-black/50 z-0"></div>
</section>
@endif 