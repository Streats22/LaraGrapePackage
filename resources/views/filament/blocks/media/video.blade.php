{{-- @block id="video" label="Video Block" description="A video block for embedding YouTube, Vimeo, or other videos" --}}
<div class="video-block py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h3 class="text-2xl font-bold mb-6 text-center" data-gjs-type="text" data-gjs-name="video-title">Video Title</h3>
            <div class="relative w-full" style="padding-bottom: 56.25%;">
                <iframe 
                    class="absolute top-0 left-0 w-full h-full rounded-lg shadow-lg"
                    src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                    title="Video"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    data-gjs-type="default"
                    data-gjs-name="video-iframe">
                </iframe>
            </div>
            <p class="text-gray-600 mt-4 text-center" data-gjs-type="text" data-gjs-name="video-description">
                Add a description for your video here. Explain what viewers can expect to learn or see.
            </p>
        </div>
    </div>
</div> 