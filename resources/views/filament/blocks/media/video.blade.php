{{-- @block id="video" label="Video Block" description="A video block for embedding YouTube, Vimeo, or other videos" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="video-block py-8 border-l-8 border-accent shadow-lg">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h3 class="text-2xl font-extrabold mb-6 text-center text-primary-900">Video Title</h3>
            <div class="relative w-full" style="padding-bottom: 56.25%;">
                <iframe 
                    class="absolute top-0 left-0 w-full h-full rounded-lg shadow-lg border-4 border-accent"
                    src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                    title="Video"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    disabled></iframe>
            </div>
            <p class="text-primary-700 mt-4 text-center">
                Add a description for your video here. Explain what viewers can expect to learn or see.
            </p>
        </div>
    </div>
</div>
@else
<div class="video-block py-8 border-l-8 border-accent shadow-lg">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h3 class="text-2xl font-extrabold mb-6 text-center text-primary-900" data-gjs-type="text" data-gjs-name="video-title">Video Title</h3>
            <div class="relative w-full" style="padding-bottom: 56.25%;">
                <iframe 
                    class="absolute top-0 left-0 w-full h-full rounded-lg shadow-lg border-4 border-accent"
                    src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                    title="Video"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    data-gjs-type="default"
                    data-gjs-name="video-iframe">
                </iframe>
            </div>
            <p class="text-primary-700 mt-4 text-center" data-gjs-type="text" data-gjs-name="video-description">
                Add a description for your video here. Explain what viewers can expect to learn or see.
            </p>
        </div>
    </div>
</div> 
@endif 