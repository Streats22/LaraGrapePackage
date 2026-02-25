{{-- @block id="animated-stats" label="Animated Stats" description="Animated statistics with counting animations and hover effects" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="animated-stats-block py-16 bg-primary-50 dark:bg-primary-900" data-laragrape-block="animated-stats">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4 text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="stats-title">Our Impact</h2>
            <p class="text-lg text-primary-700 dark:text-primary-300" data-gjs-type="text" data-gjs-name="stats-subtitle">Numbers that speak for our success and expertise</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Stat 1 -->
            <div class="stat-card text-center p-6 rounded-lg bg-white dark:bg-primary-800 dark:border dark:border-primary-700 shadow-md dark:shadow-xl" data-gjs-type="default" data-gjs-droppable="false">
                <div class="stat-icon mb-4">
                    <svg class="w-12 h-12 mx-auto text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-number mb-2">
                    <span class="text-4xl font-bold text-accent" data-gjs-type="text" data-gjs-name="stat-number-1">150</span>
                    <span class="text-2xl font-bold text-accent" data-gjs-type="text" data-gjs-name="stat-suffix-1">+</span>
                </div>
                <div class="stat-label">
                    <span class="text-lg font-semibold text-primary-700 dark:text-primary-100" data-gjs-type="text" data-gjs-name="stat-label-1">Projects Completed</span>
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="stat-card text-center p-6 rounded-lg bg-white dark:bg-primary-50 dark:border dark:border-primary-700 shadow-md dark:shadow-xl" data-gjs-type="default" data-gjs-droppable="false">
                <div class="stat-icon mb-4">
                    <svg class="w-12 h-12 mx-auto text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-number mb-2">
                    <span class="text-4xl font-bold text-accent" data-gjs-type="text" data-gjs-name="stat-number-2">50</span>
                    <span class="text-2xl font-bold text-accent" data-gjs-type="text" data-gjs-name="stat-suffix-2">+</span>
                </div>
                <div class="stat-label">
                    <span class="text-lg font-semibold text-primary-700 dark:text-primary-200" data-gjs-type="text" data-gjs-name="stat-label-2">Happy Clients</span>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="stat-card text-center p-6 rounded-lg bg-white dark:bg-primary-800 dark:border dark:border-primary-700 shadow-md dark:shadow-xl" data-gjs-type="default" data-gjs-droppable="false">
                <div class="stat-icon mb-4">
                    <svg class="w-12 h-12 mx-auto text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-number mb-2">
                    <span class="text-4xl font-bold text-accent" data-gjs-type="text" data-gjs-name="stat-number-3">5</span>
                    <span class="text-2xl font-bold text-accent" data-gjs-type="text" data-gjs-name="stat-suffix-3">+</span>
                </div>
                <div class="stat-label">
                    <span class="text-lg font-semibold text-primary-700 dark:text-primary-100" data-gjs-type="text" data-gjs-name="stat-label-3">Years Experience</span>
                </div>
            </div>

            <!-- Stat 4 -->
            <div class="stat-card text-center p-6 rounded-lg bg-white dark:bg-primary-800 dark:border dark:border-primary-700 shadow-md dark:shadow-xl" data-gjs-type="default" data-gjs-droppable="false">
                <div class="stat-icon mb-4">
                    <svg class="w-12 h-12 mx-auto text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="stat-number mb-2">
                    <span class="text-4xl font-bold text-accent" data-gjs-type="text" data-gjs-name="stat-number-4">99</span>
                    <span class="text-2xl font-bold text-accent" data-gjs-type="text" data-gjs-name="stat-suffix-4">%</span>
                </div>
                <div class="stat-label">
                    <span class="text-lg font-semibold text-primary-700 dark:text-primary-100" data-gjs-type="text" data-gjs-name="stat-label-4">Client Satisfaction</span>
                </div>
            </div>
        </div>
    </div>
</div>
@else
@php
    // Ensure dynamicData is always an array
    $dynamicData = $dynamicData ?? [];

    // Default stats structure
    $defaultStats = [
        [
            'number' => 150,
            'suffix' => '+',
            'label' => 'Projects Completed',
            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
        ],
        [
            'number' => 50,
            'suffix' => '+',
            'label' => 'Happy Clients',
            'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
        ],
        [
            'number' => 5,
            'suffix' => '+',
            'label' => 'Years Experience',
            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
        ],
        [
            'number' => 99,
            'suffix' => '%',
            'label' => 'Client Satisfaction',
            'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'
        ]
    ];

    // Use dynamic data if available
    $dynamicStats = $dynamicData['stats'] ?? null;
    if ($dynamicStats && is_array($dynamicStats)) {
        foreach ($dynamicStats as $index => $dynamicStat) {
            if (isset($defaultStats[$index]) && is_array($dynamicStat)) {
                // Only update if we have valid values (don't overwrite with 0 or empty)
                if (isset($dynamicStat['number']) && $dynamicStat['number'] > 0) {
                    $defaultStats[$index]['number'] = $dynamicStat['number'];
                }
                if (isset($dynamicStat['suffix']) && !empty($dynamicStat['suffix'])) {
                    $defaultStats[$index]['suffix'] = $dynamicStat['suffix'];
                }
                if (isset($dynamicStat['label']) && !empty($dynamicStat['label']) && strlen($dynamicStat['label']) > 2) {
                    $defaultStats[$index]['label'] = $dynamicStat['label'];
                }
                if (isset($dynamicStat['icon']) && !empty($dynamicStat['icon'])) {
                    $defaultStats[$index]['icon'] = $dynamicStat['icon'];
                }
            }
        }
    }

    $title = $dynamicData['title'] ?? 'Our Impact';
    $subtitle = $dynamicData['subtitle'] ?? 'Numbers that speak for our success and expertise';
@endphp
<div class="animated-stats-block py-16 bg-primary-50 dark:bg-primary-900"
     data-gjs-type="default"
     data-gjs-draggable="true"
     data-gjs-droppable="false"
     x-data='{
         "stats": @json($defaultStats),
         "animated": false
     }'
     x-init="
         (() => {
             if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
                 animated = true;
             } else {
                 const observer = new IntersectionObserver((entries) => {
                     entries.forEach(entry => {
                         if (entry.isIntersecting && !animated) {
                             animated = true;
                             // Trigger animation on all stat cards
                             $el.querySelectorAll('.stat-card').forEach((card, index) => {
                                 if (card._x_dataStack && card._x_dataStack[0]) {
                                     const cardData = card._x_dataStack[0];
                                     if (cardData && !cardData.animated) {
                                         setTimeout(() => {
                                             if (cardData.startAnimation) {
                                                 cardData.startAnimation();
                                             }
                                         }, index * 100);
                                     }
                                 }
                             });
                         }
                     });
                 }, {
                     threshold: 0.1,
                     rootMargin: '0px 0px -50px 0px'
                 });
                 observer.observe($el);
             }
         })();
     ">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4 text-primary-900 dark:text-primary-50" data-gjs-type="text" data-gjs-name="stats-title">{{ $title }}</h2>
            <p class="text-lg text-primary-700 dark:text-primary-300" data-gjs-type="text" data-gjs-name="stats-subtitle">{{ $subtitle }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Stat 1 -->
            <div class="stat-card text-center p-6 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-2xl bg-white dark:bg-primary-900 dark:border dark:border-primary-700 shadow-md dark:shadow-xl dark:hover:shadow-2xl dark:hover:border-primary-600"
                 data-gjs-type="default"
                 data-gjs-droppable="false"
                 x-data="{
                     count: 0,
                     target: {{ $defaultStats[0]['number'] ?? 150 }},
                     suffix: '{{ $defaultStats[0]['suffix'] ?? '+' }}',
                     label: '{{ addslashes($defaultStats[0]['label'] ?? 'Projects Completed') }}',
                     icon: '{{ $defaultStats[0]['icon'] ?? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }}',
                     animated: false,
                     startAnimation() {
                         if (this.animated) return;
                         this.animated = true;
                         const duration = 2000;
                         const steps = 60;
                         const increment = this.target / steps;
                         let currentStep = 0;
                         const timer = setInterval(() => {
                             currentStep++;
                             this.count = Math.min(increment * currentStep, this.target);
                             if (currentStep >= steps || this.count >= this.target) {
                                 this.count = this.target;
                                 clearInterval(timer);
                             }
                         }, duration / steps);
                     }
                 }"
                 x-init="
                     (() => {
                         if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
                             count = target;
                             return;
                         }

                         // Find parent block
                         const parentEl = $el.closest('.animated-stats-block');
                         if (!parentEl) return;

                         // Watch parent block's animated state
                         const checkParent = setInterval(() => {
                             if (parentEl._x_dataStack && parentEl._x_dataStack[0] && parentEl._x_dataStack[0].animated && !animated) {
                                 const cardIndex = Array.from($el.parentElement.children).indexOf($el);
                                 setTimeout(() => {
                                     startAnimation();
                                 }, cardIndex * 100);
                                 clearInterval(checkParent);
                             }
                         }, 50);

                         // Also observe this card directly as fallback
                         const cardObserver = new IntersectionObserver((entries) => {
                             entries.forEach(entry => {
                                 if (entry.isIntersecting && !animated) {
                                     startAnimation();
                                     cardObserver.disconnect();
                                     clearInterval(checkParent);
                                 }
                             });
                         }, {
                             threshold: 0.1,
                             rootMargin: '0px'
                         });

                         setTimeout(() => {
                             cardObserver.observe($el);
                         }, 100);

                         // Cleanup
                         setTimeout(() => {
                             clearInterval(checkParent);
                             cardObserver.disconnect();
                         }, 10000);
                     })();
                 ">
                <div class="stat-icon mb-4">
                    <svg class="w-12 h-12 mx-auto transition-transform duration-300 hover:rotate-12 text-accent"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="icon"></path>
                    </svg>
                </div>
                <div class="stat-number mb-2">
                    <span class="text-4xl font-bold text-accent" x-text="Math.floor(count)"></span>
                    <span class="text-2xl font-bold text-accent" x-text="suffix"></span>
                </div>
                <div class="stat-label">
                    <span class="text-lg font-semibold text-primary-700 dark:text-primary-100" x-text="label"></span>
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="stat-card text-center p-6 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-2xl bg-white dark:bg-primary-50 dark:border dark:border-primary-700 shadow-md dark:shadow-xl dark:hover:shadow-2xl dark:hover:border-primary-600"
                 data-gjs-type="default"
                 data-gjs-droppable="false"
                 x-data="{
                     count: 0,
                     target: {{ $defaultStats[1]['number'] ?? 50 }},
                     suffix: '{{ $defaultStats[1]['suffix'] ?? '+' }}',
                     label: '{{ addslashes($defaultStats[1]['label'] ?? 'Happy Clients') }}',
                     icon: '{{ $defaultStats[1]['icon'] ?? 'M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}',
                     animated: false,
                     startAnimation() {
                         if (this.animated) return;
                         this.animated = true;
                         const duration = 2000;
                         const steps = 60;
                         const increment = this.target / steps;
                         let currentStep = 0;
                         const timer = setInterval(() => {
                             currentStep++;
                             this.count = Math.min(increment * currentStep, this.target);
                             if (currentStep >= steps || this.count >= this.target) {
                                 this.count = this.target;
                                 clearInterval(timer);
                             }
                         }, duration / steps);
                     }
                 }"
                 x-init="
                     (() => {
                         if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
                             count = target;
                             return;
                         }

                         // Find parent block
                         const parentEl = $el.closest('.animated-stats-block');
                         if (!parentEl) return;

                         // Watch parent block's animated state
                         const checkParent = setInterval(() => {
                             if (parentEl._x_dataStack && parentEl._x_dataStack[0] && parentEl._x_dataStack[0].animated && !animated) {
                                 const cardIndex = Array.from($el.parentElement.children).indexOf($el);
                                 setTimeout(() => {
                                     startAnimation();
                                 }, cardIndex * 100);
                                 clearInterval(checkParent);
                             }
                         }, 50);

                         // Also observe this card directly as fallback
                         const cardObserver = new IntersectionObserver((entries) => {
                             entries.forEach(entry => {
                                 if (entry.isIntersecting && !animated) {
                                     startAnimation();
                                     cardObserver.disconnect();
                                     clearInterval(checkParent);
                                 }
                             });
                         }, {
                             threshold: 0.1,
                             rootMargin: '0px'
                         });

                         setTimeout(() => {
                             cardObserver.observe($el);
                         }, 100);

                         // Cleanup
                         setTimeout(() => {
                             clearInterval(checkParent);
                             cardObserver.disconnect();
                         }, 10000);
                     })();
                 ">
                <div class="stat-icon mb-4">
                    <svg class="w-12 h-12 mx-auto transition-transform duration-300 hover:rotate-12 text-accent"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="icon"></path>
                    </svg>
                </div>
                <div class="stat-number mb-2">
                    <span class="text-4xl font-bold text-accent" x-text="Math.floor(count)"></span>
                    <span class="text-2xl font-bold text-accent" x-text="suffix"></span>
                </div>
                <div class="stat-label">
                    <span class="text-lg font-semibold text-primary-700 dark:text-primary-200" x-text="label"></span>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="stat-card text-center p-6 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-2xl bg-white dark:bg-primary-900 dark:border dark:border-primary-700 shadow-md dark:shadow-xl dark:hover:shadow-2xl dark:hover:border-primary-600"
                 data-gjs-type="default"
                 data-gjs-droppable="false"
                 x-data="{
                     count: 0,
                     target: {{ $defaultStats[2]['number'] ?? 5 }},
                     suffix: '{{ $defaultStats[2]['suffix'] ?? '+' }}',
                     label: '{{ addslashes($defaultStats[2]['label'] ?? 'Years Experience') }}',
                     icon: '{{ $defaultStats[2]['icon'] ?? 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' }}',
                     animated: false,
                     startAnimation() {
                         if (this.animated) return;
                         this.animated = true;
                         const duration = 2000;
                         const steps = 60;
                         const increment = this.target / steps;
                         let currentStep = 0;
                         const timer = setInterval(() => {
                             currentStep++;
                             this.count = Math.min(increment * currentStep, this.target);
                             if (currentStep >= steps || this.count >= this.target) {
                                 this.count = this.target;
                                 clearInterval(timer);
                             }
                         }, duration / steps);
                     }
                 }"
                 x-init="
                     (() => {
                         if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
                             count = target;
                             return;
                         }

                         // Find parent block
                         const parentEl = $el.closest('.animated-stats-block');
                         if (!parentEl) return;

                         // Watch parent block's animated state
                         const checkParent = setInterval(() => {
                             if (parentEl._x_dataStack && parentEl._x_dataStack[0] && parentEl._x_dataStack[0].animated && !animated) {
                                 const cardIndex = Array.from($el.parentElement.children).indexOf($el);
                                 setTimeout(() => {
                                     startAnimation();
                                 }, cardIndex * 100);
                                 clearInterval(checkParent);
                             }
                         }, 50);

                         // Also observe this card directly as fallback
                         const cardObserver = new IntersectionObserver((entries) => {
                             entries.forEach(entry => {
                                 if (entry.isIntersecting && !animated) {
                                     startAnimation();
                                     cardObserver.disconnect();
                                     clearInterval(checkParent);
                                 }
                             });
                         }, {
                             threshold: 0.1,
                             rootMargin: '0px'
                         });

                         setTimeout(() => {
                             cardObserver.observe($el);
                         }, 100);

                         // Cleanup
                         setTimeout(() => {
                             clearInterval(checkParent);
                             cardObserver.disconnect();
                         }, 10000);
                     })();
                 ">
                <div class="stat-icon mb-4">
                    <svg class="w-12 h-12 mx-auto transition-transform duration-300 hover:rotate-12 text-accent"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="icon"></path>
                    </svg>
                </div>
                <div class="stat-number mb-2">
                    <span class="text-4xl font-bold text-accent" x-text="Math.floor(count)"></span>
                    <span class="text-2xl font-bold text-accent" x-text="suffix"></span>
                </div>
                <div class="stat-label">
                    <span class="text-lg font-semibold text-primary-700 dark:text-primary-100" x-text="label"></span>
                </div>
            </div>

            <!-- Stat 4 -->
            <div class="stat-card text-center p-6 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-2xl bg-white dark:bg-primary-800 dark:border dark:border-primary-700 shadow-md dark:shadow-xl dark:hover:shadow-2xl dark:hover:border-primary-600"
                 data-gjs-type="default"
                 data-gjs-droppable="false"
                 x-data="{
                     count: 0,
                     target: {{ $defaultStats[3]['number'] ?? 99 }},
                     suffix: '{{ $defaultStats[3]['suffix'] ?? '%' }}',
                     label: '{{ addslashes($defaultStats[3]['label'] ?? 'Client Satisfaction') }}',
                     icon: '{{ $defaultStats[3]['icon'] ?? 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z' }}',
                     animated: false,
                     startAnimation() {
                         if (this.animated) return;
                         this.animated = true;
                         const duration = 2000;
                         const steps = 60;
                         const increment = this.target / steps;
                         let currentStep = 0;
                         const timer = setInterval(() => {
                             currentStep++;
                             this.count = Math.min(increment * currentStep, this.target);
                             if (currentStep >= steps || this.count >= this.target) {
                                 this.count = this.target;
                                 clearInterval(timer);
                             }
                         }, duration / steps);
                     }
                 }"
                 x-init="
                     (() => {
                         if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
                             count = target;
                             return;
                         }

                         // Find parent block
                         const parentEl = $el.closest('.animated-stats-block');
                         if (!parentEl) return;

                         // Watch parent block's animated state
                         const checkParent = setInterval(() => {
                             if (parentEl._x_dataStack && parentEl._x_dataStack[0] && parentEl._x_dataStack[0].animated && !animated) {
                                 const cardIndex = Array.from($el.parentElement.children).indexOf($el);
                                 setTimeout(() => {
                                     startAnimation();
                                 }, cardIndex * 100);
                                 clearInterval(checkParent);
                             }
                         }, 50);

                         // Also observe this card directly as fallback
                         const cardObserver = new IntersectionObserver((entries) => {
                             entries.forEach(entry => {
                                 if (entry.isIntersecting && !animated) {
                                     startAnimation();
                                     cardObserver.disconnect();
                                     clearInterval(checkParent);
                                 }
                             });
                         }, {
                             threshold: 0.1,
                             rootMargin: '0px'
                         });

                         setTimeout(() => {
                             cardObserver.observe($el);
                         }, 100);

                         // Cleanup
                         setTimeout(() => {
                             clearInterval(checkParent);
                             cardObserver.disconnect();
                         }, 10000);
                     })();
                 ">
                <div class="stat-icon mb-4">
                    <svg class="w-12 h-12 mx-auto transition-transform duration-300 hover:rotate-12 text-accent"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="icon"></path>
                    </svg>
                </div>
                <div class="stat-number mb-2">
                    <span class="text-4xl font-bold text-accent" x-text="Math.floor(count)"></span>
                    <span class="text-2xl font-bold text-accent" x-text="suffix"></span>
                </div>
                <div class="stat-label">
                    <span class="text-lg font-semibold text-primary-700 dark:text-primary-100" x-text="label"></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
