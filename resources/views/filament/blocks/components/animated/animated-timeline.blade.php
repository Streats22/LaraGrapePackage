{{-- @block id="animated-timeline" label="Animated Timeline" description="Interactive timeline showing the development process with animations" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<!-- BLOCK: animated-timeline START -->
<div class="animated-timeline-block py-16 bg-primary-50" x-data="{ 
    steps: [
        { 
            title: 'Discovery & Planning', 
            description: 'We analyze your requirements and create a detailed project roadmap.',
            icon: 'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            duration: '1-2 weeks'
        },
        { 
            title: 'Design & Prototyping', 
            description: 'Our designers create wireframes and interactive prototypes for your approval.',
            icon: 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z',
            duration: '2-3 weeks'
        },
        { 
            title: 'Development', 
            description: 'Our development team builds your solution using modern technologies and best practices.',
            icon: 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
            duration: '4-8 weeks'
        },
        { 
            title: 'Testing & QA', 
            description: 'Comprehensive testing ensures your application is bug-free and performs optimally.',
            icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            duration: '1-2 weeks'
        },
        { 
            title: 'Deployment & Launch', 
            description: 'We deploy your application and provide ongoing support and maintenance.',
            icon: 'M5 13l4 4L19 7',
            duration: '1 week'
        }
    ],
    activeStep: 0
}" x-init="
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let stepIndex = 0;
                const interval = setInterval(() => {
                    if (stepIndex < steps.length) {
                        activeStep = stepIndex;
                        stepIndex++;
                    } else {
                        clearInterval(interval);
                    }
                }, 800);
            }
        });
    });
    observer.observe($el);
">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4 text-primary-900" data-gjs-type="text" data-gjs-name="timeline-title">Our Development Process</h2>
            <p class="text-lg text-primary-700" data-gjs-type="text" data-gjs-name="timeline-subtitle">A proven methodology that ensures successful project delivery</p>
        </div>
        
        <div class="relative">
            <!-- Timeline Line -->
            <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-primary-300"></div>
            
            <!-- Timeline Steps -->
            <div class="space-y-12">
                <!-- Timeline Step 1 -->
                <div class="timeline-step relative left-0" 
                     x-data="{ 
                         isVisible: false,
                         stepIndex: 0,
                         step: steps[0]
                     }"
                     x-init="
                         setTimeout(() => {
                             isVisible = activeStep >= 0;
                         }, 0 * 200);
                     "
                     :style="isVisible ? 'opacity: 1; transform: translateY(0) translateX(0) scale(1);' : 'opacity: 0; transform: translateY(30px) translateX(-20px) scale(0.96);'"
                     style="transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    
                    <div class="flex items-center flex-row">
                        <!-- Content -->
                        <div class="w-5/12 p-6 rounded-lg shadow-lg transition-all duration-300 hover:scale-105 bg-primary-50 border-l-4 border-accent mr-8">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 transition-all duration-300 bg-accent"
                                     :class="activeStep >= 0 ? 'scale-110' : 'scale-100'">
                                    <svg class="w-6 h-6 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="steps[0].icon"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-primary-900" x-text="steps[0].title" data-gjs-type="text" data-gjs-name="timeline-title-1">Discovery & Planning</h3>
                                    <span class="text-sm font-semibold text-accent" x-text="steps[0].duration" data-gjs-type="text" data-gjs-name="timeline-duration-1">1-2 weeks</span>
                                </div>
                            </div>
                            <p class="text-base text-primary-700" x-text="steps[0].description" data-gjs-type="text" data-gjs-name="timeline-description-1">We analyze your requirements and create a detailed project roadmap.</p>
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="relative z-10">
                            <div class="w-6 h-6 rounded-full transition-all duration-500 bg-accent border-4 border-primary-50"
                                 :class="activeStep >= 0 ? 'scale-150' : 'scale-100'"></div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Step 2 -->
                <div class="timeline-step relative right-0" 
                     x-data="{ 
                         isVisible: false,
                         stepIndex: 1,
                         step: steps[1]
                     }"
                     x-init="
                         setTimeout(() => {
                             isVisible = activeStep >= 1;
                         }, 1 * 200);
                     "
                     :style="isVisible ? 'opacity: 1; transform: translateY(0) translateX(0) scale(1);' : 'opacity: 0; transform: translateY(30px) translateX(-20px) scale(0.96);'"
                     style="transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    
                    <div class="flex items-center flex-row-reverse">
                        <!-- Content -->
                        <div class="w-5/12 p-6 rounded-lg shadow-lg transition-all duration-300 hover:scale-105 bg-primary-50 border-l-4 border-accent ml-8">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 transition-all duration-300 bg-accent"
                                     :class="activeStep >= 1 ? 'scale-110' : 'scale-100'">
                                    <svg class="w-6 h-6 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="steps[1].icon"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-primary-900" x-text="steps[1].title" data-gjs-type="text" data-gjs-name="timeline-title-2">Design & Prototyping</h3>
                                    <span class="text-sm font-semibold text-accent" x-text="steps[1].duration" data-gjs-type="text" data-gjs-name="timeline-duration-2">2-3 weeks</span>
                                </div>
                            </div>
                            <p class="text-base text-primary-700" x-text="steps[1].description" data-gjs-type="text" data-gjs-name="timeline-description-2">Our designers create wireframes and interactive prototypes for your approval.</p>
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="relative z-10">
                            <div class="w-6 h-6 rounded-full transition-all duration-500 bg-accent border-4 border-primary-50"
                                 :class="activeStep >= 1 ? 'scale-150' : 'scale-100'"></div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Step 3 -->
                <div class="timeline-step relative left-0" 
                     x-data="{ 
                         isVisible: false,
                         stepIndex: 2,
                         step: steps[2]
                     }"
                     x-init="
                         setTimeout(() => {
                             isVisible = activeStep >= 2;
                         }, 2 * 200);
                     "
                     :style="isVisible ? 'opacity: 1; transform: translateY(0) translateX(0) scale(1);' : 'opacity: 0; transform: translateY(30px) translateX(-20px) scale(0.96);'"
                     style="transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    
                    <div class="flex items-center flex-row">
                        <!-- Content -->
                        <div class="w-5/12 p-6 rounded-lg shadow-lg transition-all duration-300 hover:scale-105 bg-primary-50 border-l-4 border-accent mr-8">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 transition-all duration-300 bg-accent"
                                     :class="activeStep >= 2 ? 'scale-110' : 'scale-100'">
                                    <svg class="w-6 h-6 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="steps[2].icon"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-primary-900" x-text="steps[2].title" data-gjs-type="text" data-gjs-name="timeline-title-3">Development</h3>
                                    <span class="text-sm font-semibold text-accent" x-text="steps[2].duration" data-gjs-type="text" data-gjs-name="timeline-duration-3">4-8 weeks</span>
                                </div>
                            </div>
                            <p class="text-base text-primary-700" x-text="steps[2].description" data-gjs-type="text" data-gjs-name="timeline-description-3">Our development team builds your solution using modern technologies and best practices.</p>
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="relative z-10">
                            <div class="w-6 h-6 rounded-full transition-all duration-500 bg-accent border-4 border-primary-50"
                                 :class="activeStep >= 2 ? 'scale-150' : 'scale-100'"></div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Step 4 -->
                <div class="timeline-step relative right-0" 
                     x-data="{ 
                         isVisible: false,
                         stepIndex: 3,
                         step: steps[3]
                     }"
                     x-init="
                         setTimeout(() => {
                             isVisible = activeStep >= 3;
                         }, 3 * 200);
                     "
                     :style="isVisible ? 'opacity: 1; transform: translateY(0) translateX(0) scale(1);' : 'opacity: 0; transform: translateY(30px) translateX(-20px) scale(0.96);'"
                     style="transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    
                    <div class="flex items-center flex-row-reverse">
                        <!-- Content -->
                        <div class="w-5/12 p-6 rounded-lg shadow-lg transition-all duration-300 hover:scale-105 bg-primary-50 border-l-4 border-accent ml-8">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 transition-all duration-300 bg-accent"
                                     :class="activeStep >= 3 ? 'scale-110' : 'scale-100'">
                                    <svg class="w-6 h-6 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="steps[3].icon"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-primary-900" x-text="steps[3].title" data-gjs-type="text" data-gjs-name="timeline-title-4">Testing & QA</h3>
                                    <span class="text-sm font-semibold text-accent" x-text="steps[3].duration" data-gjs-type="text" data-gjs-name="timeline-duration-4">1-2 weeks</span>
                                </div>
                            </div>
                            <p class="text-base text-primary-700" x-text="steps[3].description" data-gjs-type="text" data-gjs-name="timeline-description-4">Comprehensive testing ensures your application is bug-free and performs optimally.</p>
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="relative z-10">
                            <div class="w-6 h-6 rounded-full transition-all duration-500 bg-accent border-4 border-primary-50"
                                 :class="activeStep >= 3 ? 'scale-150' : 'scale-100'"></div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Step 5 -->
                <div class="timeline-step relative left-0" 
                     x-data="{ 
                         isVisible: false,
                         stepIndex: 4,
                         step: steps[4]
                     }"
                     x-init="
                         setTimeout(() => {
                             isVisible = activeStep >= 4;
                         }, 4 * 200);
                     "
                     :style="isVisible ? 'opacity: 1; transform: translateY(0) translateX(0) scale(1);' : 'opacity: 0; transform: translateY(30px) translateX(-20px) scale(0.96);'"
                     style="transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    
                    <div class="flex items-center flex-row">
                        <!-- Content -->
                        <div class="w-5/12 p-6 rounded-lg shadow-lg transition-all duration-300 hover:scale-105 bg-primary-50 border-l-4 border-accent mr-8">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 transition-all duration-300 bg-accent"
                                     :class="activeStep >= 4 ? 'scale-110' : 'scale-100'">
                                    <svg class="w-6 h-6 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="steps[4].icon"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-primary-900" x-text="steps[4].title" data-gjs-type="text" data-gjs-name="timeline-title-5">Deployment & Launch</h3>
                                    <span class="text-sm font-semibold text-accent" x-text="steps[4].duration" data-gjs-type="text" data-gjs-name="timeline-duration-5">1 week</span>
                                </div>
                            </div>
                            <p class="text-base text-primary-700" x-text="steps[4].description" data-gjs-type="text" data-gjs-name="timeline-description-5">We deploy your application and provide ongoing support and maintenance.</p>
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="relative z-10">
                            <div class="w-6 h-6 rounded-full transition-all duration-500 bg-accent border-4 border-primary-50"
                                 :class="activeStep >= 4 ? 'scale-150' : 'scale-100'"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BLOCK: animated-timeline END -->
@else
@php
    // Ensure dynamicData is always an array
    $dynamicData = $dynamicData ?? [];
    
    // Default timeline steps structure
    $defaultSteps = [
        [
            'title' => 'Discovery & Planning',
            'description' => 'We analyze your requirements and create a detailed project roadmap.',
            'icon' => 'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'duration' => '1-2 weeks'
        ],
        [
            'title' => 'Design & Prototyping',
            'description' => 'Our designers create wireframes and interactive prototypes for your approval.',
            'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z',
            'duration' => '2-3 weeks'
        ],
        [
            'title' => 'Development',
            'description' => 'Our development team builds your solution using modern technologies and best practices.',
            'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
            'duration' => '4-8 weeks'
        ],
        [
            'title' => 'Testing & QA',
            'description' => 'Comprehensive testing ensures your application is bug-free and performs optimally.',
            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'duration' => '1-2 weeks'
        ],
        [
            'title' => 'Deployment & Launch',
            'description' => 'We deploy your application and provide ongoing support and maintenance.',
            'icon' => 'M5 13l4 4L19 7',
            'duration' => '1 week'
        ]
    ];
    
    // Use dynamic data if available (from component_data extraction)
    $dynamicSteps = $dynamicData['steps'] ?? null;
    
    // Merge dynamic data with defaults - prioritize extracted data
    if ($dynamicSteps && is_array($dynamicSteps)) {
        foreach ($dynamicSteps as $index => $dynamicStep) {
            if (isset($defaultSteps[$index]) && is_array($dynamicStep)) {
                $defaultSteps[$index]['title'] = $dynamicStep['title'] ?? $defaultSteps[$index]['title'];
                $defaultSteps[$index]['description'] = $dynamicStep['description'] ?? $defaultSteps[$index]['description'];
                $defaultSteps[$index]['duration'] = $dynamicStep['duration'] ?? $defaultSteps[$index]['duration'];
                // Preserve icon from defaults
            }
        }
    }
    
    // Ensure $defaultSteps is always an array
    if (!isset($defaultSteps) || !is_array($defaultSteps)) {
        $defaultSteps = [];
    }
@endphp
<div class="animated-timeline-block py-16 bg-primary-50" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data='{ 
         "steps": @json($defaultSteps), 
         "activeStep": 0
     }' 
     x-init="
         const observer = new IntersectionObserver((entries) => {
             entries.forEach(entry => {
                 if (entry.isIntersecting) {
                     let stepIndex = 0;
                     const interval = setInterval(() => {
                         if (stepIndex < steps.length) {
                             activeStep = stepIndex;
                             stepIndex++;
                         } else {
                             clearInterval(interval);
                         }
                     }, 800);
                 }
             });
         });
         observer.observe($el);
     ">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4 text-primary-900" data-gjs-type="text" data-gjs-name="timeline-title">Our Development Process</h2>
            <p class="text-lg text-primary-700" data-gjs-type="text" data-gjs-name="timeline-subtitle">A proven methodology that ensures successful project delivery</p>
        </div>
        
        <div class="relative">
            <!-- Timeline Line -->
            <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-primary-300"></div>
            
            <!-- Timeline Steps -->
            <div class="space-y-12">
                <!-- Timeline Step 1 -->
                <div class="timeline-step relative left-0" 
                     x-data="{ 
                         isVisible: false,
                         stepIndex: 0,
                         get step() {
                             const parent = $el.closest('.animated-timeline-block');
                             if (parent && parent._x_dataStack && parent._x_dataStack[0] && parent._x_dataStack[0].steps) {
                                 return parent._x_dataStack[0].steps[0];
                             }
                             return { title: 'Discovery & Planning', description: 'We analyze your requirements and create a detailed project roadmap.', duration: '1-2 weeks', icon: 'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2' };
                         }
                     }"
                     x-init="
                         const checkVisibility = () => {
                             const parent = $el.closest('.animated-timeline-block');
                             if (parent && parent._x_dataStack && parent._x_dataStack[0]) {
                                 const parentActiveStep = parent._x_dataStack[0].activeStep;
                                 if (parentActiveStep >= 0 && !isVisible) {
                                     setTimeout(() => {
                                         isVisible = true;
                                     }, 0 * 200);
                                 }
                             }
                         };
                         const interval = setInterval(() => {
                             checkVisibility();
                             if (isVisible) {
                                 clearInterval(interval);
                             }
                         }, 50);
                         checkVisibility();
                     "
                     x-show="isVisible"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 transform translate-y-10 translate-x-[-30px] scale-90"
                     x-transition:enter-end="opacity-100 transform translate-y-0 translate-x-0 scale-100"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    <div class="flex items-center flex-row">
                        <!-- Content -->
                        <div class="w-5/12 p-6 rounded-lg shadow-md transition-all duration-500 ease-out hover:shadow-lg bg-primary-50 border-l-4 border-accent mr-8"
                             :class="isVisible ? 'shadow-lg' : 'shadow-md'">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 transition-all duration-500 ease-out bg-accent"
                                     :class="isVisible ? 'scale-105 shadow-md' : 'scale-100'">
                                    <svg class="w-6 h-6 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="step.icon"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-primary-900" x-text="step.title" data-gjs-type="text" data-gjs-name="timeline-title-1"></h3>
                                    <span class="text-sm font-semibold text-accent" x-text="step.duration" data-gjs-type="text" data-gjs-name="timeline-duration-1"></span>
                                </div>
                            </div>
                            <p class="text-base text-primary-700" x-text="step.description" data-gjs-type="text" data-gjs-name="timeline-description-1"></p>
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="relative z-10">
                            <div class="w-6 h-6 rounded-full transition-all duration-500 ease-out bg-accent border-4 border-primary-50 shadow-md"
                                 :class="isVisible ? 'scale-125' : 'scale-100'"></div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Step 2 -->
                <div class="timeline-step relative right-0" 
                     x-data="{ 
                         isVisible: false,
                         stepIndex: 1,
                         get step() {
                             const parent = $el.closest('.animated-timeline-block');
                             if (parent && parent._x_dataStack && parent._x_dataStack[0] && parent._x_dataStack[0].steps) {
                                 return parent._x_dataStack[0].steps[1];
                             }
                             return { title: 'Design & Prototyping', description: 'Our designers create wireframes and interactive prototypes for your approval.', duration: '2-3 weeks', icon: 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z' };
                         }
                     }"
                     x-init="
                         const checkVisibility = () => {
                             const parent = $el.closest('.animated-timeline-block');
                             if (parent && parent._x_dataStack && parent._x_dataStack[0]) {
                                 const parentActiveStep = parent._x_dataStack[0].activeStep;
                                 if (parentActiveStep >= 1 && !isVisible) {
                                     setTimeout(() => {
                                         isVisible = true;
                                     }, 1 * 200);
                                 }
                             }
                         };
                         const interval = setInterval(() => {
                             checkVisibility();
                             if (isVisible) {
                                 clearInterval(interval);
                             }
                         }, 50);
                         checkVisibility();
                     "
                     x-show="isVisible"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 transform translate-y-10 translate-x-[30px] scale-90"
                     x-transition:enter-end="opacity-100 transform translate-y-0 translate-x-0 scale-100"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    <div class="flex items-center flex-row-reverse">
                        <!-- Content -->
                        <div class="w-5/12 p-6 rounded-lg shadow-md transition-all duration-500 ease-out hover:shadow-lg bg-primary-50 border-l-4 border-accent ml-8"
                             :class="isVisible ? 'shadow-lg' : 'shadow-md'">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 transition-all duration-500 ease-out bg-accent"
                                     :class="isVisible ? 'scale-105 shadow-md' : 'scale-100'">
                                    <svg class="w-6 h-6 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="step.icon"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-primary-900" x-text="step.title" data-gjs-type="text" data-gjs-name="timeline-title-2"></h3>
                                    <span class="text-sm font-semibold text-accent" x-text="step.duration" data-gjs-type="text" data-gjs-name="timeline-duration-2"></span>
                                </div>
                            </div>
                            <p class="text-base text-primary-700" x-text="step.description" data-gjs-type="text" data-gjs-name="timeline-description-2"></p>
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="relative z-10">
                            <div class="w-6 h-6 rounded-full transition-all duration-500 ease-out bg-accent border-4 border-primary-50 shadow-md"
                                 :class="isVisible ? 'scale-125' : 'scale-100'"></div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Step 3 -->
                <div class="timeline-step relative left-0" 
                     x-data="{ 
                         isVisible: false,
                         stepIndex: 2,
                         get step() {
                             const parent = $el.closest('.animated-timeline-block');
                             if (parent && parent._x_dataStack && parent._x_dataStack[0] && parent._x_dataStack[0].steps) {
                                 return parent._x_dataStack[0].steps[2];
                             }
                             return { title: 'Development', description: 'Our development team builds your solution using modern technologies and best practices.', duration: '4-8 weeks', icon: 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4' };
                         }
                     }"
                     x-init="
                         const checkVisibility = () => {
                             const parent = $el.closest('.animated-timeline-block');
                             if (parent && parent._x_dataStack && parent._x_dataStack[0]) {
                                 const parentActiveStep = parent._x_dataStack[0].activeStep;
                                 if (parentActiveStep >= 2 && !isVisible) {
                                     setTimeout(() => {
                                         isVisible = true;
                                     }, 2 * 200);
                                 }
                             }
                         };
                         const interval = setInterval(() => {
                             checkVisibility();
                             if (isVisible) {
                                 clearInterval(interval);
                             }
                         }, 50);
                         checkVisibility();
                     "
                     x-show="isVisible"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 transform translate-y-10 translate-x-[-30px] scale-90"
                     x-transition:enter-end="opacity-100 transform translate-y-0 translate-x-0 scale-100"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    <div class="flex items-center flex-row">
                        <!-- Content -->
                        <div class="w-5/12 p-6 rounded-lg shadow-md transition-all duration-500 ease-out hover:shadow-lg bg-primary-50 border-l-4 border-accent mr-8"
                             :class="isVisible ? 'shadow-lg' : 'shadow-md'">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 transition-all duration-500 ease-out bg-accent"
                                     :class="isVisible ? 'scale-105 shadow-md' : 'scale-100'">
                                    <svg class="w-6 h-6 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="step.icon"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-primary-900" x-text="step.title" data-gjs-type="text" data-gjs-name="timeline-title-3"></h3>
                                    <span class="text-sm font-semibold text-accent" x-text="step.duration" data-gjs-type="text" data-gjs-name="timeline-duration-3"></span>
                                </div>
                            </div>
                            <p class="text-base text-primary-700" x-text="step.description" data-gjs-type="text" data-gjs-name="timeline-description-3"></p>
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="relative z-10">
                            <div class="w-6 h-6 rounded-full transition-all duration-500 ease-out bg-accent border-4 border-primary-50 shadow-md"
                                 :class="isVisible ? 'scale-125' : 'scale-100'"></div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Step 4 -->
                <div class="timeline-step relative right-0" 
                     x-data="{ 
                         isVisible: false,
                         stepIndex: 3,
                         get step() {
                             const parent = $el.closest('.animated-timeline-block');
                             if (parent && parent._x_dataStack && parent._x_dataStack[0] && parent._x_dataStack[0].steps) {
                                 return parent._x_dataStack[0].steps[3];
                             }
                             return { title: 'Testing & QA', description: 'Comprehensive testing ensures your application is bug-free and performs optimally.', duration: '1-2 weeks', icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' };
                         }
                     }"
                     x-init="
                         const checkVisibility = () => {
                             const parent = $el.closest('.animated-timeline-block');
                             if (parent && parent._x_dataStack && parent._x_dataStack[0]) {
                                 const parentActiveStep = parent._x_dataStack[0].activeStep;
                                 if (parentActiveStep >= 3 && !isVisible) {
                                     setTimeout(() => {
                                         isVisible = true;
                                     }, 3 * 200);
                                 }
                             }
                         };
                         const interval = setInterval(() => {
                             checkVisibility();
                             if (isVisible) {
                                 clearInterval(interval);
                             }
                         }, 50);
                         checkVisibility();
                     "
                     x-show="isVisible"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 transform translate-y-10 translate-x-[30px] scale-90"
                     x-transition:enter-end="opacity-100 transform translate-y-0 translate-x-0 scale-100"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    <div class="flex items-center flex-row-reverse">
                        <!-- Content -->
                        <div class="w-5/12 p-6 rounded-lg shadow-md transition-all duration-500 ease-out hover:shadow-lg bg-primary-50 border-l-4 border-accent ml-8"
                             :class="isVisible ? 'shadow-lg' : 'shadow-md'">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 transition-all duration-500 ease-out bg-accent"
                                     :class="isVisible ? 'scale-105 shadow-md' : 'scale-100'">
                                    <svg class="w-6 h-6 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="step.icon"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-primary-900" x-text="step.title" data-gjs-type="text" data-gjs-name="timeline-title-4"></h3>
                                    <span class="text-sm font-semibold text-accent" x-text="step.duration" data-gjs-type="text" data-gjs-name="timeline-duration-4"></span>
                                </div>
                            </div>
                            <p class="text-base text-primary-700" x-text="step.description" data-gjs-type="text" data-gjs-name="timeline-description-4"></p>
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="relative z-10">
                            <div class="w-6 h-6 rounded-full transition-all duration-500 ease-out bg-accent border-4 border-primary-50 shadow-md"
                                 :class="isVisible ? 'scale-125' : 'scale-100'"></div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Step 5 -->
                <div class="timeline-step relative left-0" 
                     x-data="{ 
                         isVisible: false,
                         stepIndex: 4,
                         get step() {
                             const parent = $el.closest('.animated-timeline-block');
                             if (parent && parent._x_dataStack && parent._x_dataStack[0] && parent._x_dataStack[0].steps) {
                                 return parent._x_dataStack[0].steps[4];
                             }
                             return { title: 'Deployment & Launch', description: 'We deploy your application and provide ongoing support and maintenance.', duration: '1 week', icon: 'M5 13l4 4L19 7' };
                         }
                     }"
                     x-init="
                         const checkVisibility = () => {
                             const parent = $el.closest('.animated-timeline-block');
                             if (parent && parent._x_dataStack && parent._x_dataStack[0]) {
                                 const parentActiveStep = parent._x_dataStack[0].activeStep;
                                 if (parentActiveStep >= 4 && !isVisible) {
                                     setTimeout(() => {
                                         isVisible = true;
                                     }, 4 * 200);
                                 }
                             }
                         };
                         const interval = setInterval(() => {
                             checkVisibility();
                             if (isVisible) {
                                 clearInterval(interval);
                             }
                         }, 50);
                         checkVisibility();
                     "
                     x-show="isVisible"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 transform translate-y-10 translate-x-[-30px] scale-90"
                     x-transition:enter-end="opacity-100 transform translate-y-0 translate-x-0 scale-100"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    <div class="flex items-center flex-row">
                        <!-- Content -->
                        <div class="w-5/12 p-6 rounded-lg shadow-md transition-all duration-500 ease-out hover:shadow-lg bg-primary-50 border-l-4 border-accent mr-8"
                             :class="isVisible ? 'shadow-lg' : 'shadow-md'">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 transition-all duration-500 ease-out bg-accent"
                                     :class="isVisible ? 'scale-105 shadow-md' : 'scale-100'">
                                    <svg class="w-6 h-6 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="step.icon"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-primary-900" x-text="step.title" data-gjs-type="text" data-gjs-name="timeline-title-5"></h3>
                                    <span class="text-sm font-semibold text-accent" x-text="step.duration" data-gjs-type="text" data-gjs-name="timeline-duration-5"></span>
                                </div>
                            </div>
                            <p class="text-base text-primary-700" x-text="step.description" data-gjs-type="text" data-gjs-name="timeline-description-5"></p>
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="relative z-10">
                            <div class="w-6 h-6 rounded-full transition-all duration-500 ease-out bg-accent border-4 border-primary-50 shadow-md"
                                 :class="isVisible ? 'scale-125' : 'scale-100'"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif 