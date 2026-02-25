{{-- @block id="animated-portfolio" label="Animated Portfolio" description="Animated portfolio showcase with project cards" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="portfolio-block py-12 bg-primary-50 dark:bg-primary-900" data-laragrape-block="animated-portfolio">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4 text-center text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="portfolio-title">Our Projects</h2>
        <p class="text-center text-primary-600 dark:text-primary-300 mb-8" data-gjs-type="text" data-gjs-name="portfolio-subtitle">Some of our recent work</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Project 1 -->
            <div class="portfolio-item rounded-xl overflow-hidden bg-white dark:bg-primary-800 shadow-lg" data-gjs-type="default" data-gjs-droppable="false">
                <div class="h-48 bg-gradient-to-br from-accent to-primary-500 flex items-center justify-center">
                    <span class="text-6xl text-white" data-gjs-type="text" data-gjs-name="project-image-1">🖼️</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-primary-900 dark:text-primary-50 mb-2" data-gjs-type="text" data-gjs-name="project-title-1">E-Commerce Platform</h3>
                    <p class="text-primary-600 dark:text-primary-300 mb-4" data-gjs-type="text" data-gjs-name="project-description-1">A modern e-commerce solution built with React and Laravel</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-accent/20 dark:bg-accent/30 text-accent dark:text-accent border border-accent/30 dark:border-accent/50 rounded-full text-sm font-medium" data-gjs-type="text" data-gjs-name="project-tag-1-1">React</span>
                        <span class="px-3 py-1 bg-accent/20 dark:bg-accent/30 text-accent dark:text-accent border border-accent/30 dark:border-accent/50 rounded-full text-sm font-medium" data-gjs-type="text" data-gjs-name="project-tag-1-2">Laravel</span>
                    </div>
                    <a href="#" class="text-accent font-semibold hover:underline" data-gjs-type="text" data-gjs-name="project-link-1">View Project →</a>
                </div>
            </div>
            <!-- Project 2 -->
            <div class="portfolio-item rounded-xl overflow-hidden bg-white dark:bg-primary-800 shadow-lg" data-gjs-type="default" data-gjs-droppable="false">
                <div class="h-48 bg-gradient-to-br from-primary-500 to-accent flex items-center justify-center">
                    <span class="text-6xl text-white" data-gjs-type="text" data-gjs-name="project-image-2">🎨</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-primary-900 dark:text-primary-50 mb-2" data-gjs-type="text" data-gjs-name="project-title-2">Brand Identity Design</h3>
                    <p class="text-primary-600 dark:text-primary-300 mb-4" data-gjs-type="text" data-gjs-name="project-description-2">Complete brand identity and visual design system</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-accent/20 dark:bg-accent/30 text-accent dark:text-accent border border-accent/30 dark:border-accent/50 rounded-full text-sm font-medium" data-gjs-type="text" data-gjs-name="project-tag-2-1">Figma</span>
                        <span class="px-3 py-1 bg-accent/20 dark:bg-accent/30 text-accent dark:text-accent border border-accent/30 dark:border-accent/50 rounded-full text-sm font-medium" data-gjs-type="text" data-gjs-name="project-tag-2-2">Design</span>
                    </div>
                    <a href="#" class="text-accent font-semibold hover:underline" data-gjs-type="text" data-gjs-name="project-link-2">View Project →</a>
                </div>
            </div>
            <!-- Project 3 -->
            <div class="portfolio-item rounded-xl overflow-hidden bg-white dark:bg-primary-800 shadow-lg" data-gjs-type="default" data-gjs-droppable="false">
                <div class="h-48 bg-gradient-to-br from-accent to-primary-600 flex items-center justify-center">
                    <span class="text-6xl text-white" data-gjs-type="text" data-gjs-name="project-image-3">💼</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-primary-900 dark:text-primary-50 mb-2" data-gjs-type="text" data-gjs-name="project-title-3">Web Application</h3>
                    <p class="text-primary-600 dark:text-primary-300 mb-4" data-gjs-type="text" data-gjs-name="project-description-3">Custom web application with modern UI/UX</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-accent/20 dark:bg-accent/30 text-accent dark:text-accent border border-accent/30 dark:border-accent/50 rounded-full text-sm font-medium" data-gjs-type="text" data-gjs-name="project-tag-3-1">Vue.js</span>
                        <span class="px-3 py-1 bg-accent/20 dark:bg-accent/30 text-accent dark:text-accent border border-accent/30 dark:border-accent/50 rounded-full text-sm font-medium" data-gjs-type="text" data-gjs-name="project-tag-3-2">Node.js</span>
                    </div>
                    <a href="#" class="text-accent font-semibold hover:underline" data-gjs-type="text" data-gjs-name="project-link-3">View Project →</a>
                </div>
            </div>
        </div>
    </div>
</div>
@else
@php
    // Ensure dynamicData is always an array
    $dynamicData = $dynamicData ?? [];
    
    \Log::info('[Animated Portfolio] Rendering with dynamic data', [
        'has_dynamic_data' => !empty($dynamicData),
        'dynamic_data_keys' => array_keys($dynamicData),
        'has_projects' => isset($dynamicData['projects']),
        'projects_count' => isset($dynamicData['projects']) ? count($dynamicData['projects']) : 0,
        'title' => $dynamicData['title'] ?? 'not set',
        'subtitle' => $dynamicData['subtitle'] ?? 'not set',
    ]);
    
    // Default portfolio projects structure
    $defaultProjects = [
        [
            'title' => 'E-Commerce Platform',
            'description' => 'A modern e-commerce solution built with React and Laravel',
            'image' => '🖼️',
            'tags' => ['React', 'Laravel'],
            'link' => '#',
            'visible' => false,
            'delay' => 0
        ],
        [
            'title' => 'Brand Identity Design',
            'description' => 'Complete brand identity and visual design system',
            'image' => '🎨',
            'tags' => ['Figma', 'Design'],
            'link' => '#',
            'visible' => false,
            'delay' => 150
        ],
        [
            'title' => 'Web Application',
            'description' => 'Custom web application with modern UI/UX',
            'image' => '💼',
            'tags' => ['Vue.js', 'Node.js'],
            'link' => '#',
            'visible' => false,
            'delay' => 300
        ]
    ];
    
    // Use dynamic data if available
    $dynamicProjects = $dynamicData['projects'] ?? null;
    
    // Merge dynamic data with defaults
    if ($dynamicProjects && is_array($dynamicProjects)) {
        // Deduplicate before merging
        $seen = [];
        $uniqueProjects = [];
        foreach ($dynamicProjects as $project) {
            if (is_array($project)) {
                $key = md5(($project['title'] ?? '') . '|' . ($project['description'] ?? ''));
                if (!isset($seen[$key])) {
                    $seen[$key] = true;
                    $uniqueProjects[] = $project;
                }
            }
        }
        
        // Merge unique projects
        foreach ($uniqueProjects as $index => $dynamicProject) {
            if (isset($defaultProjects[$index]) && is_array($dynamicProject)) {
                $defaultProjects[$index]['title'] = $dynamicProject['title'] ?? $defaultProjects[$index]['title'];
                $defaultProjects[$index]['description'] = $dynamicProject['description'] ?? $defaultProjects[$index]['description'];
                $defaultProjects[$index]['image'] = $dynamicProject['image'] ?? $defaultProjects[$index]['image'];
                $defaultProjects[$index]['tags'] = $dynamicProject['tags'] ?? $defaultProjects[$index]['tags'];
                $defaultProjects[$index]['link'] = $dynamicProject['link'] ?? $defaultProjects[$index]['link'];
                // Preserve animation properties from defaults
            }
        }
        
        // Fill remaining slots if we have more projects
        for ($i = count($defaultProjects); $i < count($uniqueProjects) && $i < 9; $i++) {
            if (isset($uniqueProjects[$i])) {
                $defaultProjects[] = [
                    'title' => $uniqueProjects[$i]['title'] ?? 'Project ' . ($i + 1),
                    'description' => $uniqueProjects[$i]['description'] ?? 'Project description',
                    'image' => $uniqueProjects[$i]['image'] ?? '📦',
                    'tags' => $uniqueProjects[$i]['tags'] ?? [],
                    'link' => $uniqueProjects[$i]['link'] ?? '#',
                    'visible' => false,
                    'delay' => $i * 150
                ];
            }
        }
    }
    
    // Ensure we have at least 3 projects
    while (count($defaultProjects) < 3) {
        $index = count($defaultProjects);
        $defaultProjects[] = [
            'title' => 'Project ' . ($index + 1),
            'description' => 'Project description',
            'image' => '📦',
            'tags' => [],
            'link' => '#',
            'visible' => false,
            'delay' => $index * 150
        ];
    }
    
    // Limit to 9 projects max
    $defaultProjects = array_slice($defaultProjects, 0, 9);
    
    $title = $dynamicData['title'] ?? 'Our Projects';
    $subtitle = $dynamicData['subtitle'] ?? 'Some of our recent work';
@endphp
<div class="portfolio-block py-12 bg-primary-50 dark:bg-primary-900" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data='{ 
         "projects": @json($defaultProjects), 
         "animated": false
     }' 
     x-init="
         if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
             animated = true;
             projects.forEach(project => project.visible = true);
         } else {
             const observer = new IntersectionObserver((entries) => {
                 entries.forEach(entry => {
                     if (entry.isIntersecting && !animated) {
                         animated = true;
                         projects.forEach((project, index) => {
                             setTimeout(() => {
                                 project.visible = true;
                             }, project.delay);
                         });
                     }
                 });
             }, {
                 threshold: 0.1,
                 rootMargin: '0px 0px -50px 0px'
             });
             observer.observe($el);
         }
     ">
    
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4 text-center text-primary-900 dark:text-primary-50" 
            x-text="'<?php echo addslashes($title); ?>'"
            data-gjs-type="text" 
            data-gjs-name="portfolio-title"><?php echo e($title); ?></h2>
        <p class="text-center text-primary-600 dark:text-primary-300 mb-8" 
           x-text="'<?php echo addslashes($subtitle); ?>'"
           data-gjs-type="text" 
           data-gjs-name="portfolio-subtitle"><?php echo e($subtitle); ?></p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="(project, index) in projects" :key="index">
                <div class="portfolio-item rounded-xl overflow-hidden bg-white dark:bg-primary-800 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                     :class="project.visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     :style="project.visible ? 'transition: all 0.6s ease-out;' : 'transition: all 0.6s ease-out;'"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    <div class="h-48 bg-gradient-to-br from-accent to-primary-500 flex items-center justify-center">
                        <span class="text-6xl text-white" x-text="project.image" data-gjs-type="text" :data-gjs-name="'project-image-' + (index + 1)"></span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-primary-900 dark:text-primary-50 mb-2" x-text="project.title" data-gjs-type="text" :data-gjs-name="'project-title-' + (index + 1)"></h3>
                        <p class="text-primary-600 dark:text-primary-300 mb-4" x-text="project.description" data-gjs-type="text" :data-gjs-name="'project-description-' + (index + 1)"></p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <template x-for="(tag, tagIndex) in project.tags" :key="tagIndex">
                                <span class="px-3 py-1 bg-accent/20 dark:bg-accent/30 text-accent dark:text-accent border border-accent/30 dark:border-accent/50 rounded-full text-sm font-medium" 
                                      x-text="tag" 
                                      data-gjs-type="text" 
                                      :data-gjs-name="'project-tag-' + (index + 1) + '-' + (tagIndex + 1)"></span>
                            </template>
                        </div>
                        <a :href="project.link" class="text-accent font-semibold hover:underline" x-text="'View Project →'" data-gjs-type="text" :data-gjs-name="'project-link-' + (index + 1)"></a>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endif

