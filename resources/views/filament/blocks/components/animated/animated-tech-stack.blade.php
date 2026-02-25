{{-- @block id="animated-tech-stack" label="Animated Tech Stack" description="Animated tech stack showcase with logos and animations" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="tech-stack-block py-12 bg-primary-50 dark:bg-primary-900" data-laragrape-block="animated-tech-stack">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4 text-center text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="tech-stack-title">Our Tech Stack</h2>
        <p class="text-center text-primary-600 dark:text-primary-300 mb-8" data-gjs-type="text" data-gjs-name="tech-stack-subtitle">Technologies we work with</p>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <!-- Tech Item 1 -->
            <div class="tech-item p-4 rounded-xl bg-white dark:bg-primary-800 shadow-md text-center" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-4xl mb-2" data-gjs-type="text" data-gjs-name="tech-icon-1">⚛️</div>
                <h4 class="font-semibold text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="tech-name-1">React</h4>
            </div>
            <!-- Tech Item 2 -->
            <div class="tech-item p-4 rounded-xl bg-white dark:bg-primary-800 shadow-md text-center" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-4xl mb-2" data-gjs-type="text" data-gjs-name="tech-icon-2">🐘</div>
                <h4 class="font-semibold text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="tech-name-2">Laravel</h4>
            </div>
            <!-- Tech Item 3 -->
            <div class="tech-item p-4 rounded-xl bg-white dark:bg-primary-800 shadow-md text-center" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-4xl mb-2" data-gjs-type="text" data-gjs-name="tech-icon-3">🎨</div>
                <h4 class="font-semibold text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="tech-name-3">Figma</h4>
            </div>
            <!-- Tech Item 4 -->
            <div class="tech-item p-4 rounded-xl bg-white dark:bg-primary-800 shadow-md text-center" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-4xl mb-2" data-gjs-type="text" data-gjs-name="tech-icon-4">💎</div>
                <h4 class="font-semibold text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="tech-name-4">Vue.js</h4>
            </div>
            <!-- Tech Item 5 -->
            <div class="tech-item p-4 rounded-xl bg-white dark:bg-primary-800 shadow-md text-center" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-4xl mb-2" data-gjs-type="text" data-gjs-name="tech-icon-5">⚡</div>
                <h4 class="font-semibold text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="tech-name-5">Node.js</h4>
            </div>
            <!-- Tech Item 6 -->
            <div class="tech-item p-4 rounded-xl bg-white dark:bg-primary-800 shadow-md text-center" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-4xl mb-2" data-gjs-type="text" data-gjs-name="tech-icon-6">🎯</div>
                <h4 class="font-semibold text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="tech-name-6">TypeScript</h4>
            </div>
        </div>
    </div>
</div>
@else
@php
    // Ensure dynamicData is always an array
    $dynamicData = $dynamicData ?? [];
    
    \Log::info('[Animated Tech Stack] Rendering with dynamic data', [
        'has_dynamic_data' => !empty($dynamicData),
        'dynamic_data_keys' => array_keys($dynamicData),
        'has_techItems' => isset($dynamicData['techItems']),
        'techItems_count' => isset($dynamicData['techItems']) ? count($dynamicData['techItems']) : 0,
        'title' => $dynamicData['title'] ?? 'not set',
        'subtitle' => $dynamicData['subtitle'] ?? 'not set',
    ]);
    
    // Default tech stack structure
    $defaultTechItems = [
        [
            'name' => 'React',
            'icon' => '⚛️',
            'visible' => false,
            'delay' => 0
        ],
        [
            'name' => 'Laravel',
            'icon' => '🐘',
            'visible' => false,
            'delay' => 100
        ],
        [
            'name' => 'Figma',
            'icon' => '🎨',
            'visible' => false,
            'delay' => 200
        ],
        [
            'name' => 'Vue.js',
            'icon' => '💎',
            'visible' => false,
            'delay' => 300
        ],
        [
            'name' => 'Node.js',
            'icon' => '⚡',
            'visible' => false,
            'delay' => 400
        ],
        [
            'name' => 'TypeScript',
            'icon' => '🎯',
            'visible' => false,
            'delay' => 500
        ]
    ];
    
    // Use dynamic data if available
    $dynamicTechItems = $dynamicData['techItems'] ?? null;
    
    // Merge dynamic data with defaults
    if ($dynamicTechItems && is_array($dynamicTechItems)) {
        // Deduplicate before merging
        $seen = [];
        $uniqueTechItems = [];
        foreach ($dynamicTechItems as $item) {
            if (is_array($item)) {
                $key = md5(($item['name'] ?? '') . '|' . ($item['icon'] ?? ''));
                if (!isset($seen[$key])) {
                    $seen[$key] = true;
                    $uniqueTechItems[] = $item;
                }
            }
        }
        
        // Merge unique items
        foreach ($uniqueTechItems as $index => $dynamicItem) {
            if (isset($defaultTechItems[$index]) && is_array($dynamicItem)) {
                $defaultTechItems[$index]['name'] = $dynamicItem['name'] ?? $defaultTechItems[$index]['name'];
                $defaultTechItems[$index]['icon'] = $dynamicItem['icon'] ?? $defaultTechItems[$index]['icon'];
                // Preserve animation properties from defaults
            }
        }
        
        // Fill remaining slots if we have more items
        for ($i = count($defaultTechItems); $i < count($uniqueTechItems) && $i < 12; $i++) {
            if (isset($uniqueTechItems[$i])) {
                $defaultTechItems[] = [
                    'name' => $uniqueTechItems[$i]['name'] ?? 'Tech ' . ($i + 1),
                    'icon' => $uniqueTechItems[$i]['icon'] ?? '🔧',
                    'visible' => false,
                    'delay' => $i * 100
                ];
            }
        }
    }
    
    // Ensure we have at least 6 items
    while (count($defaultTechItems) < 6) {
        $index = count($defaultTechItems);
        $defaultTechItems[] = [
            'name' => 'Tech ' . ($index + 1),
            'icon' => '🔧',
            'visible' => false,
            'delay' => $index * 100
        ];
    }
    
    // Limit to 12 items max
    $defaultTechItems = array_slice($defaultTechItems, 0, 12);
    
    $title = $dynamicData['title'] ?? 'Our Tech Stack';
    $subtitle = $dynamicData['subtitle'] ?? 'Technologies we work with';
@endphp
<div class="tech-stack-block py-12 bg-primary-50 dark:bg-primary-900" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data='{ 
         "techItems": @json($defaultTechItems), 
         "animated": false
     }' 
     x-init="
         if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
             animated = true;
             techItems.forEach(item => item.visible = true);
         } else {
             const observer = new IntersectionObserver((entries) => {
                 entries.forEach(entry => {
                     if (entry.isIntersecting && !animated) {
                         animated = true;
                         techItems.forEach((item, index) => {
                             setTimeout(() => {
                                 item.visible = true;
                             }, item.delay);
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
            data-gjs-name="tech-stack-title"><?php echo e($title); ?></h2>
        <p class="text-center text-primary-600 dark:text-primary-300 mb-8" 
           x-text="'<?php echo addslashes($subtitle); ?>'"
           data-gjs-type="text" 
           data-gjs-name="tech-stack-subtitle"><?php echo e($subtitle); ?></p>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <template x-for="(item, index) in techItems" :key="index">
                <div class="tech-item p-4 rounded-xl bg-white dark:bg-primary-800 shadow-md hover:shadow-lg text-center transition-all duration-300 transform hover:scale-105"
                     :class="item.visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                     :style="item.visible ? 'transition: all 0.5s ease-out;' : 'transition: all 0.5s ease-out;'"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    <div class="text-4xl mb-2" x-text="item.icon" data-gjs-type="text" :data-gjs-name="'tech-icon-' + (index + 1)"></div>
                    <h4 class="font-semibold text-primary-900 dark:text-primary-50" x-text="item.name" data-gjs-type="text" :data-gjs-name="'tech-name-' + (index + 1)"></h4>
                </div>
            </template>
        </div>
    </div>
</div>
@endif

