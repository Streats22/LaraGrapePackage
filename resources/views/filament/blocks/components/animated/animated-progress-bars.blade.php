{{-- @block id="animated-progress-bars" label="Animated Progress Bars" description="Animated progress bars with interactive features and smooth animations" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="progress-block py-12 bg-primary-50 dark:bg-primary-900" data-laragrape-block="animated-progress-bars">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="progress-title">Our Skills & Expertise</h2>
        <div class="max-w-4xl mx-auto space-y-8">
            <!-- Progress Bar 1 -->
            <div class="progress-item" data-gjs-type="default" data-gjs-droppable="false">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold text-primary-900 dark:text-primary-100" data-gjs-type="text" data-gjs-name="skill-name-1">Web Development</h3>
                    <span class="text-sm font-medium text-primary-600 dark:text-primary-300" data-gjs-type="text" data-gjs-name="skill-percentage-1">95%</span>
                </div>
                <div class="w-full bg-primary-200 dark:bg-primary-700 rounded-full h-3">
                    <div class="bg-accent h-3 rounded-full transition-all duration-1000 ease-out" style="width: 95%"></div>
                </div>
            </div>

            <!-- Progress Bar 2 -->
            <div class="progress-item" data-gjs-type="default" data-gjs-droppable="false">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold text-primary-900 dark:text-primary-100" data-gjs-type="text" data-gjs-name="skill-name-2">UI/UX Design</h3>
                    <span class="text-sm font-medium text-primary-600 dark:text-primary-300" data-gjs-type="text" data-gjs-name="skill-percentage-2">88%</span>
                </div>
                <div class="w-full bg-primary-200 dark:bg-primary-700 rounded-full h-3">
                    <div class="bg-accent h-3 rounded-full transition-all duration-1000 ease-out" style="width: 88%"></div>
                </div>
            </div>

            <!-- Progress Bar 3 -->
            <div class="progress-item" data-gjs-type="default" data-gjs-droppable="false">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold text-primary-900 dark:text-primary-100" data-gjs-type="text" data-gjs-name="skill-name-3">Mobile Development</h3>
                    <span class="text-sm font-medium text-primary-600 dark:text-primary-300" data-gjs-type="text" data-gjs-name="skill-percentage-3">92%</span>
                </div>
                <div class="w-full bg-primary-200 dark:bg-primary-700 rounded-full h-3">
                    <div class="bg-accent h-3 rounded-full transition-all duration-1000 ease-out" style="width: 92%"></div>
                </div>
            </div>

            <!-- Progress Bar 4 -->
            <div class="progress-item" data-gjs-type="default" data-gjs-droppable="false">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold text-primary-900 dark:text-primary-100" data-gjs-type="text" data-gjs-name="skill-name-4">DevOps & Cloud</h3>
                    <span class="text-sm font-medium text-primary-600 dark:text-primary-300" data-gjs-type="text" data-gjs-name="skill-percentage-4">85%</span>
                </div>
                <div class="w-full bg-primary-200 dark:bg-primary-700 rounded-full h-3">
                    <div class="bg-accent h-3 rounded-full transition-all duration-1000 ease-out" style="width: 85%"></div>
                </div>
            </div>
        </div>
        
        <!-- Summary -->
        <div class="mt-12 text-center">
            <p class="text-lg text-primary-700 dark:text-primary-300 mb-4" data-gjs-type="text" data-gjs-name="progress-summary">We're experts in modern web technologies and always learning new skills.</p>
            <button class="px-8 py-3 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" data-gjs-type="text" data-gjs-name="progress-button">View Our Work</button>
        </div>
    </div>
</div>
@else
@php
    // Ensure dynamicData is always an array
    $dynamicData = $dynamicData ?? [];
    
    \Log::info('[Animated Progress Bars] Rendering with dynamic data', [
        'has_dynamic_data' => !empty($dynamicData),
        'dynamic_data_keys' => array_keys($dynamicData),
        'has_skills' => isset($dynamicData['skills']),
        'skills_count' => isset($dynamicData['skills']) && is_array($dynamicData['skills']) ? count($dynamicData['skills']) : 0,
        'dynamic_data_sample' => array_slice($dynamicData, 0, 3, true),
    ]);
    
    // Default skills structure
    $defaultSkills = [
        [
            'name' => 'Web Development',
            'percentage' => 95
        ],
        [
            'name' => 'UI/UX Design',
            'percentage' => 88
        ],
        [
            'name' => 'Mobile Development',
            'percentage' => 92
        ],
        [
            'name' => 'DevOps & Cloud',
            'percentage' => 85
        ]
    ];
    
    // Use dynamic data if available
    $dynamicSkills = $dynamicData['skills'] ?? null;
    if ($dynamicSkills && is_array($dynamicSkills)) {
        foreach ($dynamicSkills as $index => $dynamicSkill) {
            if (isset($defaultSkills[$index]) && is_array($dynamicSkill)) {
                if (isset($dynamicSkill['name']) && !empty($dynamicSkill['name']) && strlen($dynamicSkill['name']) > 2) {
                    $defaultSkills[$index]['name'] = $dynamicSkill['name'];
                }
                if (isset($dynamicSkill['percentage']) && $dynamicSkill['percentage'] > 0 && $dynamicSkill['percentage'] <= 100) {
                    $defaultSkills[$index]['percentage'] = (int)$dynamicSkill['percentage'];
                }
            }
        }
    }
    
    $title = $dynamicData['title'] ?? 'Our Skills & Expertise';
    $summary = $dynamicData['summary'] ?? "We're experts in modern web technologies and always learning new skills.";
    $buttonText = $dynamicData['buttonText'] ?? 'View Our Work';
    
    \Log::info('[Animated Progress Bars] Final data', [
        'title' => $title,
        'summary' => $summary,
        'button_text' => $buttonText,
        'skills' => $defaultSkills,
    ]);
@endphp
<div class="progress-block py-12 bg-primary-50 dark:bg-primary-900" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data='{ 
         skills: @json($defaultSkills),
         animated: false
     }' 
     x-init="
         (() => {
         if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
             animated = true;
                     }
         })();
     ">
    
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="progress-title">{{ $title }}</h2>
        <div class="max-w-4xl mx-auto space-y-8">
            <template x-for="(skill, index) in skills" :key="index">
                <div class="progress-item transform transition-all duration-700 ease-out" 
                     x-data="{ 
                         animated: false,
                         currentPercentage: 0,
                         get targetPercentage() { return skill.percentage; },
                         delay: index * 200,
                         startAnimation() {
                             if (this.animated) {
                                 return;
                             }
                             this.animated = true;
                             const target = this.targetPercentage;
                             const duration = 2000;
                             const steps = 60;
                             const increment = target / steps;
                             let currentStep = 0;
                             const timer = setInterval(() => {
                                 currentStep++;
                                 this.currentPercentage = Math.min(increment * currentStep, target);
                                 if (currentStep >= steps || this.currentPercentage >= target) {
                                     this.currentPercentage = target;
                                     clearInterval(timer);
                                 }
                             }, duration / steps);
                         },
                         init() {
                             if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
                                 this.animated = true;
                                 this.currentPercentage = this.targetPercentage;
                                 return;
                             }
                             
                             // Check if element is already visible
                             const checkVisibility = () => {
                                 const rect = $el.getBoundingClientRect();
                                 const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
                                 return isVisible;
                             };
                             
                             // Simple IntersectionObserver approach
                             const observer = new IntersectionObserver((entries) => {
                                 entries.forEach(entry => {
                                     if (entry.isIntersecting && !this.animated) {
                                         setTimeout(() => {
                                             this.startAnimation();
                                         }, this.delay);
                                         observer.disconnect();
                                     }
                                 });
                             }, {
                                 threshold: 0.1,
                                 rootMargin: '0px'
                             });
                             
                             // Wait a bit for Alpine to fully initialize
                             setTimeout(() => {
                                 // If already visible, start animation immediately
                                 if (checkVisibility() && !this.animated) {
                                     setTimeout(() => {
                                         this.startAnimation();
                                     }, this.delay);
                                 } else {
                                     // Otherwise observe for when it becomes visible
                                     observer.observe($el);
                                 }
                             }, 200);
                         }
                     }"
                     :class="animated ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-semibold text-primary-900 dark:text-primary-100" x-text="skill.name"></h3>
                        <span class="text-sm font-medium text-primary-600 dark:text-primary-300" x-text="Math.floor(currentPercentage) + '%'"></span>
                    </div>
                    <div class="w-full bg-primary-200 dark:bg-primary-700 rounded-full h-3 overflow-hidden">
                        <div class="bg-accent h-3 rounded-full transition-all duration-1000 ease-out transform origin-left" 
                             :style="'width: ' + currentPercentage + '%'">
                        </div>
                    </div>
                </div>
            </template>
        </div>
        
        <!-- Summary -->
        <div class="mt-12 text-center">
            <p class="text-lg text-primary-700 dark:text-primary-300 mb-4" data-gjs-type="text" data-gjs-name="progress-summary">{{ $summary }}</p>
            <button class="px-8 py-3 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" 
                    data-gjs-type="text" 
                    data-gjs-name="progress-button">
                {{ $buttonText }}
            </button>
        </div>
    </div>
</div>
@endif 