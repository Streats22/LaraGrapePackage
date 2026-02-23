{{-- @block id="animated-testimonials" label="Animated Testimonials" description="Animated testimonials with carousel and interactive features" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<!-- BLOCK: animated-testimonials START -->
<div class="testimonials-block py-12 bg-primary-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center text-primary-900" data-gjs-type="text" data-gjs-name="testimonials-title">What Our Clients Say</h2>
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Testimonial 1 -->
            <div class="testimonial-card p-6 rounded-2xl shadow-lg bg-primary-100 text-center" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-4xl mb-4 text-accent">"</div>
                <p class="text-lg text-primary-700 dark:text-gray-300 mb-6 italic" data-gjs-type="text" data-gjs-name="testimonial-text-1">
                    "Working with this team was an absolute pleasure. They delivered our project on time and exceeded our expectations. The attention to detail and quality of work is outstanding."
                </p>
                <div class="flex items-center justify-center">
                    <div class="w-12 h-12 rounded-full bg-accent flex items-center justify-center mr-4">
                        <span class="text-white font-bold">JS</span>
                    </div>
                    <div class="text-left">
                        <h4 class="font-semibold text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="client-name-1">John Smith</h4>
                        <p class="text-sm text-primary-600 dark:text-gray-400" data-gjs-type="text" data-gjs-name="client-title-1">CEO, TechCorp</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="testimonial-card p-6 rounded-2xl shadow-lg bg-primary-100 text-center" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-4xl mb-4 text-accent">"</div>
                <p class="text-lg text-primary-700 dark:text-gray-300 mb-6 italic" data-gjs-type="text" data-gjs-name="testimonial-text-2">
                    "The level of professionalism and technical expertise is remarkable. They transformed our vision into reality with a beautiful, functional website that our customers love."
                </p>
                <div class="flex items-center justify-center">
                    <div class="w-12 h-12 rounded-full bg-accent flex items-center justify-center mr-4">
                        <span class="text-white font-bold">SJ</span>
                    </div>
                    <div class="text-left">
                        <h4 class="font-semibold text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="client-name-2">Sarah Johnson</h4>
                        <p class="text-sm text-primary-600 dark:text-gray-400" data-gjs-type="text" data-gjs-name="client-title-2">Marketing Director, InnovateCo</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="testimonial-card p-6 rounded-2xl shadow-lg bg-primary-100 text-center" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-4xl mb-4 text-accent">"</div>
                <p class="text-lg text-primary-700 dark:text-gray-300 mb-6 italic" data-gjs-type="text" data-gjs-name="testimonial-text-3">
                    "Outstanding service from start to finish. The team was responsive, creative, and delivered exactly what we needed. Highly recommended for any web development project."
                </p>
                <div class="flex items-center justify-center">
                    <div class="w-12 h-12 rounded-full bg-accent flex items-center justify-center mr-4">
                        <span class="text-white font-bold">MD</span>
                    </div>
                    <div class="text-left">
                        <h4 class="font-semibold text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="client-name-3">Mike Davis</h4>
                        <p class="text-sm text-primary-600 dark:text-gray-400" data-gjs-type="text" data-gjs-name="client-title-3">Founder, StartupXYZ</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="mt-8 text-center">
            <div class="flex justify-center space-x-2">
                <button class="w-3 h-3 rounded-full bg-accent" data-gjs-type="default" data-gjs-droppable="false"></button>
                <button class="w-3 h-3 rounded-full bg-primary-300" data-gjs-type="default" data-gjs-droppable="false"></button>
                <button class="w-3 h-3 rounded-full bg-primary-300" data-gjs-type="default" data-gjs-droppable="false"></button>
            </div>
        </div>
    </div>
</div>
<!-- BLOCK: animated-testimonials END -->
@else
@php
    // Ensure dynamicData is always an array
    $dynamicData = $dynamicData ?? [];
    
    // Helper function to get initials
    $getInitials = function($name) {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return substr($initials, 0, 2);
    };
    
    // Default testimonials structure with animation properties
    $defaultTestimonials = [
        [
            'text' => 'Working with this team was an absolute pleasure. They delivered our project on time and exceeded our expectations. The attention to detail and quality of work is outstanding.',
            'name' => 'John Smith',
            'title' => 'CEO, TechCorp',
            'initials' => 'JS',
            'visible' => true,
            'delay' => 0
        ],
        [
            'text' => 'The level of professionalism and technical expertise is remarkable. They transformed our vision into reality with a beautiful, functional website that our customers love.',
            'name' => 'Sarah Johnson',
            'title' => 'Marketing Director, InnovateCo',
            'initials' => 'SJ',
            'visible' => true,
            'delay' => 200
        ],
        [
            'text' => 'Outstanding service from start to finish. The team was responsive, creative, and delivered exactly what we needed. Highly recommended for any web development project.',
            'name' => 'Mike Davis',
            'title' => 'Founder, StartupXYZ',
            'initials' => 'MD',
            'visible' => true,
            'delay' => 400
        ]
    ];
    
    // Use dynamic data if available (from component_data extraction)
    $dynamicTestimonials = $dynamicData['testimonials'] ?? null;
    
    // Merge dynamic data with defaults - prioritize extracted data
    if ($dynamicTestimonials && is_array($dynamicTestimonials)) {
        // Deduplicate before merging
        $seen = [];
        $uniqueTestimonials = [];
        foreach ($dynamicTestimonials as $testimonial) {
            if (is_array($testimonial)) {
                $key = md5(($testimonial['name'] ?? '') . '|' . ($testimonial['text'] ?? ''));
                if (!isset($seen[$key])) {
                    $seen[$key] = true;
                    $uniqueTestimonials[] = $testimonial;
                }
            }
        }
        
        // Merge unique testimonials
        foreach ($uniqueTestimonials as $index => $dynamicTestimonial) {
            if (isset($defaultTestimonials[$index]) && is_array($dynamicTestimonial)) {
                $defaultTestimonials[$index]['text'] = $dynamicTestimonial['text'] ?? $defaultTestimonials[$index]['text'];
                $name = $dynamicTestimonial['name'] ?? $defaultTestimonials[$index]['name'];
                $defaultTestimonials[$index]['name'] = $name;
                $defaultTestimonials[$index]['initials'] = $getInitials($name);
                $defaultTestimonials[$index]['title'] = $dynamicTestimonial['title'] ?? $defaultTestimonials[$index]['title'];
                // Preserve animation properties from defaults
            }
        }
    }
    
    // Ensure $defaultTestimonials is always an array
    if (!isset($defaultTestimonials) || !is_array($defaultTestimonials)) {
        $defaultTestimonials = [];
    }
@endphp
<div class="testimonials-block py-12 bg-primary-50 dark:bg-gray-800" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data='{ 
         "testimonials": @json($defaultTestimonials), 
         "currentIndex": 0,
         "animated": false,
         "previousIndex": 0
     }' 
     x-init="
         currentIndex = 0;
         if (!window.IS_GRAPESJS_EDITOR && !document.body.classList.contains('is-grapesjs-canvas')) {
             setInterval(() => {
                 if (testimonials && testimonials.length > 0) {
             currentIndex = (currentIndex + 1) % testimonials.length;
                 }
         }, 5000);
         }
     ">
    
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="testimonials-title">What Our Clients Say</h2>
        <div class="max-w-4xl mx-auto relative overflow-hidden" style="min-height: 250px;">
            <!-- Testimonial 1 -->
            <div class="testimonial-card p-6 rounded-2xl shadow-lg bg-primary-100 dark:bg-gray-700 text-center absolute inset-0 w-full" 
                 x-show="currentIndex === 0"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-full"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                <div class="text-4xl mb-4 text-accent">"</div>
                <p class="text-lg text-primary-700 dark:text-gray-300 mb-6 italic" x-text="testimonials && testimonials[0] ? testimonials[0].text : ''" data-gjs-type="text" data-gjs-name="testimonial-text-1"></p>
                <div class="flex items-center justify-center">
                    <div class="w-12 h-12 rounded-full bg-accent flex items-center justify-center mr-4">
                        <span class="text-white font-bold" x-text="testimonials && testimonials[0] ? testimonials[0].initials : 'JS'">JS</span>
                    </div>
                    <div class="text-left">
                        <h4 class="font-semibold text-primary-900 dark:text-white" x-text="testimonials && testimonials[0] ? testimonials[0].name : 'John Smith'" data-gjs-type="text" data-gjs-name="client-name-1"></h4>
                        <p class="text-sm text-primary-600 dark:text-gray-400" x-text="testimonials && testimonials[0] ? testimonials[0].title : 'CEO, TechCorp'" data-gjs-type="text" data-gjs-name="client-title-1"></p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="testimonial-card p-6 rounded-2xl shadow-lg bg-primary-100 dark:bg-gray-700 text-center absolute inset-0 w-full" 
                 x-show="currentIndex === 1"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-full"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                <div class="text-4xl mb-4 text-accent">"</div>
                <p class="text-lg text-primary-700 dark:text-gray-300 mb-6 italic" x-text="testimonials && testimonials[1] ? testimonials[1].text : ''" data-gjs-type="text" data-gjs-name="testimonial-text-2"></p>
                <div class="flex items-center justify-center">
                    <div class="w-12 h-12 rounded-full bg-accent flex items-center justify-center mr-4">
                        <span class="text-white font-bold" x-text="testimonials && testimonials[1] ? testimonials[1].initials : 'SJ'">SJ</span>
                    </div>
                    <div class="text-left">
                        <h4 class="font-semibold text-primary-900 dark:text-white" x-text="testimonials && testimonials[1] ? testimonials[1].name : 'Sarah Johnson'" data-gjs-type="text" data-gjs-name="client-name-2"></h4>
                        <p class="text-sm text-primary-600 dark:text-gray-400" x-text="testimonials && testimonials[1] ? testimonials[1].title : 'Marketing Director, InnovateCo'" data-gjs-type="text" data-gjs-name="client-title-2"></p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="testimonial-card p-6 rounded-2xl shadow-lg bg-primary-100 dark:bg-gray-700 text-center absolute inset-0 w-full" 
                 x-show="currentIndex === 2"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-full"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                <div class="text-4xl mb-4 text-accent">"</div>
                <p class="text-lg text-primary-700 dark:text-gray-300 mb-6 italic" x-text="testimonials && testimonials[2] ? testimonials[2].text : ''" data-gjs-type="text" data-gjs-name="testimonial-text-3"></p>
                <div class="flex items-center justify-center">
                    <div class="w-12 h-12 rounded-full bg-accent flex items-center justify-center mr-4">
                        <span class="text-white font-bold" x-text="testimonials && testimonials[2] ? testimonials[2].initials : 'MD'">MD</span>
                    </div>
                    <div class="text-left">
                        <h4 class="font-semibold text-primary-900 dark:text-white" x-text="testimonials && testimonials[2] ? testimonials[2].name : 'Mike Davis'" data-gjs-type="text" data-gjs-name="client-name-3"></h4>
                        <p class="text-sm text-primary-600 dark:text-gray-400" x-text="testimonials && testimonials[2] ? testimonials[2].title : 'Founder, StartupXYZ'" data-gjs-type="text" data-gjs-name="client-title-3"></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="mt-8 text-center">
            <div class="flex justify-center space-x-2">
                <button class="w-3 h-3 rounded-full transition-all duration-300" 
                        :class="currentIndex === 0 ? 'bg-accent' : 'bg-primary-300'"
                        @click="currentIndex = 0"
                        data-gjs-type="default" 
                        data-gjs-droppable="false">
                </button>
                <button class="w-3 h-3 rounded-full transition-all duration-300" 
                        :class="currentIndex === 1 ? 'bg-accent' : 'bg-primary-300'"
                        @click="currentIndex = 1"
                        data-gjs-type="default" 
                        data-gjs-droppable="false">
                </button>
                <button class="w-3 h-3 rounded-full transition-all duration-300" 
                        :class="currentIndex === 2 ? 'bg-accent' : 'bg-primary-300'"
                        @click="currentIndex = 2"
                        data-gjs-type="default" 
                        data-gjs-droppable="false">
                </button>
            </div>
        </div>
    </div>
</div>
@endif 