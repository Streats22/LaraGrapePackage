{{-- @block id="section" label="Section Block" description="A layout section block" --}}
@php 
    $isEditorPreview = $isEditorPreview ?? false;
    $attributes = $attributes ?? collect();
    $slot = $slot ?? '';
@endphp
@if($isEditorPreview)
<div class="section-block py-12 md:py-20 border-l-8 border-accent shadow-lg">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-6 text-primary-900" data-gjs-type="text" data-gjs-name="section-title">Section Title</h2>
        <div class="prose prose-lg max-w-none" data-gjs-type="default" data-gjs-name="section-content">
            <p class="text-primary-700 mb-4">This is a sample section with customizable content. You can add any content here including text, images, and other components.</p>
            <p class="text-primary-700">Add more paragraphs or other elements to build out your section content.</p>
        </div>
    </div>
</div>
@else
<section {{ $attributes->merge(['class' => 'py-12 md:py-20']) }}>
    @if(!empty($title))
        <h2 class="text-3xl font-bold mb-6">{{ $title }}</h2>
    @endif 
    {{ $slot }}
</section>
@endif 