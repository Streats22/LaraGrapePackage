{{-- @block id="hero" label="Hero Block" description="A hero section with background image support" --}}
@php 
    $isEditorPreview = $isEditorPreview ?? false;
    $attributes = $attributes ?? collect();
@endphp
@if($isEditorPreview)
<div class="hero-block py-24 md:py-36 flex items-center justify-center text-center bg-primary-50 dark:bg-primary-900 relative border-l-8 border-accent shadow-lg">
    <div class="relative z-10">
        <h1 class="text-4xl md:text-6xl font-extrabold text-primary-900 mb-6" data-gjs-type="text" data-gjs-name="hero-title">Welcome to Our Site</h1>
        <p class="text-xl md:text-2xl text-primary-700 mb-8 max-w-3xl mx-auto" data-gjs-type="text" data-gjs-name="hero-subtitle">Create stunning hero sections with customizable content and beautiful styling.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center" data-gjs-type="default" data-gjs-name="hero-buttons">
            <button class="bg-accent hover:bg-primary-700 text-primary-900 font-bold py-3 px-8 rounded-lg shadow-lg transition-colors" data-gjs-type="default" data-gjs-name="primary-button">Get Started</button>
            <button class="bg-transparent border-2 border-accent text-accent hover:bg-accent hover:text-primary-900 font-bold py-3 px-8 rounded-lg shadow-lg transition-colors" data-gjs-type="default" data-gjs-name="secondary-button">Learn More</button>
        </div>
    </div>
    <div class="absolute inset-0 bg-black/30 dark:bg-black/50 z-0"></div>
</div>
@else
<section {{ $attributes->merge(['class' => 'relative py-24 md:py-36 flex items-center justify-center text-center bg-primary-50 dark:bg-primary-900']) }} @if(!empty($background)) style="background-image: url('{{ $background }}'); background-size: cover; background-position: center;" @endif>
    <div class="relative z-10">
        {{ $slot }}
    </div>
    <div class="absolute inset-0 bg-black/30 dark:bg-black/50 z-0"></div>
</section>
@endif 