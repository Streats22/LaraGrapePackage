{{-- @block id="project-portfolio" label="Project Portfolio" description="Showcase of completed projects with descriptions and technologies" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="project-portfolio-block py-16 bg-primary-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4 text-primary-900" data-gjs-type="text" data-gjs-name="portfolio-title">Our Projects</h2>
            <p class="text-lg text-primary-700" data-gjs-type="text" data-gjs-name="portfolio-subtitle">Discover our latest software development projects and success stories</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Project 1 -->
            <div class="project-card p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 bg-primary-50" data-gjs-type="default" data-gjs-droppable="false">
                <div class="w-full h-48 bg-accent rounded-lg mb-4 flex items-center justify-center">
                    <span class="text-4xl text-primary-900">🛒</span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-primary-900" data-gjs-type="text" data-gjs-name="project-1-title">E-Commerce Platform</h3>
                <p class="mb-4 text-primary-700" data-gjs-type="text" data-gjs-name="project-1-description">A modern e-commerce solution with advanced inventory management and payment processing.</p>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-1-tag-1">React</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-1-tag-2">Laravel</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-1-tag-3">PostgreSQL</span>
                </div>
                <button class="w-full py-2 px-4 rounded font-semibold transition-colors bg-accent text-primary-900" disabled>View Project</button>
            </div>

            <!-- Project 2 -->
            <div class="project-card p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 bg-primary-50" data-gjs-type="default" data-gjs-droppable="false">
                <div class="w-full h-48 bg-accent rounded-lg mb-4 flex items-center justify-center">
                    <span class="text-4xl text-primary-900">🏦</span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-primary-900" data-gjs-type="text" data-gjs-name="project-2-title">Mobile Banking App</h3>
                <p class="mb-4 text-primary-700" data-gjs-type="text" data-gjs-name="project-2-description">Secure mobile banking application with biometric authentication and real-time transactions.</p>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-2-tag-1">React Native</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-2-tag-2">Node.js</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-2-tag-3">MongoDB</span>
                </div>
                <button class="w-full py-2 px-4 rounded font-semibold transition-colors bg-accent text-primary-900" disabled>View Project</button>
            </div>

            <!-- Project 3 -->
            <div class="project-card p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 bg-primary-50" data-gjs-type="default" data-gjs-droppable="false">
                <div class="w-full h-48 bg-accent rounded-lg mb-4 flex items-center justify-center">
                    <span class="text-4xl text-primary-900">🤖</span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-primary-900" data-gjs-type="text" data-gjs-name="project-3-title">AI Analytics Platform</h3>
                <p class="mb-4 text-primary-700" data-gjs-type="text" data-gjs-name="project-3-description">Machine learning platform for business intelligence and predictive analytics.</p>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-3-tag-1">Python</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-3-tag-2">TensorFlow</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-3-tag-3">Docker</span>
                </div>
                <button class="w-full py-2 px-4 rounded font-semibold transition-colors bg-accent text-primary-900" disabled>View Project</button>
            </div>
        </div>
    </div>
</div>
@else
<div class="project-portfolio-block py-16 bg-primary-50" data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="false">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4 text-primary-900" data-gjs-type="text" data-gjs-name="portfolio-title">Our Projects</h2>
            <p class="text-lg text-primary-700" data-gjs-type="text" data-gjs-name="portfolio-subtitle">Discover our latest software development projects and success stories</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Project 1 -->
            <div class="project-card p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 bg-primary-50" data-gjs-type="default" data-gjs-droppable="false">
                <div class="w-full h-48 bg-accent rounded-lg mb-4 flex items-center justify-center">
                    <span class="text-4xl text-primary-900">🛒</span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-primary-900" data-gjs-type="text" data-gjs-name="project-1-title">E-Commerce Platform</h3>
                <p class="mb-4 text-primary-700" data-gjs-type="text" data-gjs-name="project-1-description">A modern e-commerce solution with advanced inventory management and payment processing.</p>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-1-tag-1">React</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-1-tag-2">Laravel</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-1-tag-3">PostgreSQL</span>
                </div>
                <button class="w-full py-2 px-4 rounded font-semibold transition-colors bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-1-button">View Project</button>
            </div>

            <!-- Project 2 -->
            <div class="project-card p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 bg-primary-50" data-gjs-type="default" data-gjs-droppable="false">
                <div class="w-full h-48 bg-accent rounded-lg mb-4 flex items-center justify-center">
                    <span class="text-4xl text-primary-900">🏦</span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-primary-900" data-gjs-type="text" data-gjs-name="project-2-title">Mobile Banking App</h3>
                <p class="mb-4 text-primary-700" data-gjs-type="text" data-gjs-name="project-2-description">Secure mobile banking application with biometric authentication and real-time transactions.</p>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-2-tag-1">React Native</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-2-tag-2">Node.js</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-2-tag-3">MongoDB</span>
                </div>
                <button class="w-full py-2 px-4 rounded font-semibold transition-colors bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-2-button">View Project</button>
            </div>

            <!-- Project 3 -->
            <div class="project-card p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 bg-primary-50" data-gjs-type="default" data-gjs-droppable="false">
                <div class="w-full h-48 bg-accent rounded-lg mb-4 flex items-center justify-center">
                    <span class="text-4xl text-primary-900">🤖</span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-primary-900" data-gjs-type="text" data-gjs-name="project-3-title">AI Analytics Platform</h3>
                <p class="mb-4 text-primary-700" data-gjs-type="text" data-gjs-name="project-3-description">Machine learning platform for business intelligence and predictive analytics.</p>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-3-tag-1">Python</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-3-tag-2">TensorFlow</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-3-tag-3">Docker</span>
                </div>
                <button class="w-full py-2 px-4 rounded font-semibold transition-colors bg-accent text-primary-900" data-gjs-type="text" data-gjs-name="project-3-button">View Project</button>
            </div>
        </div>
    </div>
</div>
@endif 