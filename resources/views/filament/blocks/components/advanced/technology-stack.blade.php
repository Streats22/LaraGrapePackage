{{-- @block id="technology-stack" label="Technology Stack" description="Showcase of technologies and tools used in development" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="tech-stack-block py-16 bg-primary-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4 text-primary-50" data-gjs-type="text" data-gjs-name="tech-stack-title">Our Technology Stack</h2>
            <p class="text-lg text-primary-200" data-gjs-type="text" data-gjs-name="tech-stack-subtitle">Cutting-edge technologies we use to build exceptional software solutions</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Frontend Technologies -->
            <div class="tech-category">
                <h3 class="text-2xl font-bold mb-6 text-center text-accent" data-gjs-type="text" data-gjs-name="frontend-title">Frontend Development</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-react">React</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-vue">Vue.js</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-angular">Angular</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-typescript">TypeScript</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-tailwind">Tailwind CSS</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-nextjs">Next.js</span>
                    </div>
                </div>
            </div>
            
            <!-- Backend Technologies -->
            <div class="tech-category">
                <h3 class="text-2xl font-bold mb-6 text-center text-accent" data-gjs-type="text" data-gjs-name="backend-title">Backend Development</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-laravel">Laravel</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-nodejs">Node.js</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-python">Python</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-postgresql">PostgreSQL</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-redis">Redis</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-docker">Docker</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="tech-stack-block py-16 bg-primary-900" data-gjs-type="default" data-gjs-draggable="true" data-gjs-droppable="false">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4 text-primary-50" data-gjs-type="text" data-gjs-name="tech-stack-title">Our Technology Stack</h2>
            <p class="text-lg text-primary-200" data-gjs-type="text" data-gjs-name="tech-stack-subtitle">Cutting-edge technologies we use to build exceptional software solutions</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Frontend Technologies -->
            <div class="tech-category">
                <h3 class="text-2xl font-bold mb-6 text-center text-accent" data-gjs-type="text" data-gjs-name="frontend-title">Frontend Development</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-react">React</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-vue">Vue.js</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-angular">Angular</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-typescript">TypeScript</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-tailwind">Tailwind CSS</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-nextjs">Next.js</span>
                    </div>
                </div>
            </div>
            
            <!-- Backend Technologies -->
            <div class="tech-category">
                <h3 class="text-2xl font-bold mb-6 text-center text-accent" data-gjs-type="text" data-gjs-name="backend-title">Backend Development</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-laravel">Laravel</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-nodejs">Node.js</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-python">Python</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-postgresql">PostgreSQL</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-redis">Redis</span>
                    </div>
                    <div class="tech-item text-center p-4 rounded-lg bg-primary-800" data-gjs-type="default" data-gjs-droppable="false">
                        <svg class="w-10 h-10 mx-auto text-accent" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary-100" data-gjs-type="text" data-gjs-name="tech-docker">Docker</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif 