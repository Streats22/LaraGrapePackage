{{-- @block id="service-showcase" label="Service Showcase" description="Display your software development services with icons and descriptions" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="service-showcase-block py-16" style="background-color: var(--laralgrape-primary-50);">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4" style="color: var(--laralgrape-primary-900);">Our Services</h2>
            <p class="text-lg" style="color: var(--laralgrape-primary-700);">Comprehensive software development solutions tailored to your needs</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Web Development -->
            <div class="service-card p-6 rounded-lg shadow-lg transition-transform hover:scale-105" style="background-color: var(--laralgrape-primary-50); border-left: 4px solid var(--laralgrape-accent);">
                <div class="service-icon mb-4">
                    <svg class="w-12 h-12 mx-auto" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3" style="color: var(--laralgrape-primary-900);">Web Development</h3>
                <p class="mb-4" style="color: var(--laralgrape-primary-700);">Custom web applications built with modern technologies and best practices.</p>
                <button class="w-full py-2 px-4 rounded font-semibold transition-colors" style="background-color: var(--laralgrape-accent); color: var(--laralgrape-primary-900);" disabled>Learn More</button>
            </div>
            
            <!-- Mobile Development -->
            <div class="service-card p-6 rounded-lg shadow-lg transition-transform hover:scale-105" style="background-color: var(--laralgrape-primary-50); border-left: 4px solid var(--laralgrape-accent);">
                <div class="service-icon mb-4">
                    <svg class="w-12 h-12 mx-auto" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3" style="color: var(--laralgrape-primary-900);">Mobile Development</h3>
                <p class="mb-4" style="color: var(--laralgrape-primary-700);">Native and cross-platform mobile apps for iOS and Android platforms.</p>
                <button class="w-full py-2 px-4 rounded font-semibold transition-colors" style="background-color: var(--laralgrape-accent); color: var(--laralgrape-primary-900);" disabled>Learn More</button>
            </div>
            
            <!-- Cloud Solutions -->
            <div class="service-card p-6 rounded-lg shadow-lg transition-transform hover:scale-105" style="background-color: var(--laralgrape-primary-50); border-left: 4px solid var(--laralgrape-accent);">
                <div class="service-icon mb-4">
                    <svg class="w-12 h-12 mx-auto" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3" style="color: var(--laralgrape-primary-900);">Cloud Solutions</h3>
                <p class="mb-4" style="color: var(--laralgrape-primary-700);">Scalable cloud infrastructure and DevOps solutions for your business.</p>
                <button class="w-full py-2 px-4 rounded font-semibold transition-colors" style="background-color: var(--laralgrape-accent); color: var(--laralgrape-primary-900);" disabled>Learn More</button>
            </div>
        </div>
    </div>
</div>
@else
<div class="service-showcase-block py-16" style="background-color: var(--laralgrape-primary-50);" data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="false">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4" style="color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="services-title">Our Services</h2>
            <p class="text-lg" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="services-subtitle">Comprehensive software development solutions tailored to your needs</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Web Development -->
            <div class="service-card p-6 rounded-lg shadow-lg transition-transform hover:scale-105" style="background-color: var(--laralgrape-primary-50); border-left: 4px solid var(--laralgrape-accent);" data-gjs-type="default" data-gjs-droppable="false">
                <div class="service-icon mb-4">
                    <svg class="w-12 h-12 mx-auto" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3" style="color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="service-1-title">Web Development</h3>
                <p class="mb-4" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="service-1-description">Custom web applications built with modern technologies and best practices.</p>
                <button class="w-full py-2 px-4 rounded font-semibold transition-colors" style="background-color: var(--laralgrape-accent); color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="service-1-button">Learn More</button>
            </div>
            
            <!-- Mobile Development -->
            <div class="service-card p-6 rounded-lg shadow-lg transition-transform hover:scale-105" style="background-color: var(--laralgrape-primary-50); border-left: 4px solid var(--laralgrape-accent);" data-gjs-type="default" data-gjs-droppable="false">
                <div class="service-icon mb-4">
                    <svg class="w-12 h-12 mx-auto" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3" style="color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="service-2-title">Mobile Development</h3>
                <p class="mb-4" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="service-2-description">Native and cross-platform mobile apps for iOS and Android platforms.</p>
                <button class="w-full py-2 px-4 rounded font-semibold transition-colors" style="background-color: var(--laralgrape-accent); color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="service-2-button">Learn More</button>
            </div>
            
            <!-- Cloud Solutions -->
            <div class="service-card p-6 rounded-lg shadow-lg transition-transform hover:scale-105" style="background-color: var(--laralgrape-primary-50); border-left: 4px solid var(--laralgrape-accent);" data-gjs-type="default" data-gjs-droppable="false">
                <div class="service-icon mb-4">
                    <svg class="w-12 h-12 mx-auto" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3" style="color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="service-3-title">Cloud Solutions</h3>
                <p class="mb-4" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="service-3-description">Scalable cloud infrastructure and DevOps solutions for your business.</p>
                <button class="w-full py-2 px-4 rounded font-semibold transition-colors" style="background-color: var(--laralgrape-accent); color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="service-3-button">Learn More</button>
            </div>
        </div>
    </div>
</div>
@endif 