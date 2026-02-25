{{-- @block id="animated-faq" label="Animated FAQ" description="Animated FAQ section with expandable answers and smooth transitions" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="faq-block py-12 bg-primary-50" data-laragrape-block="animated-faq">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center text-primary-900" data-gjs-type="text" data-gjs-name="faq-title">Frequently Asked Questions</h2>
        <div class="max-w-4xl mx-auto space-y-4">
            <!-- FAQ Item 1 -->
            <div class="faq-item bg-primary-100 rounded-lg shadow-md" data-gjs-type="default" data-gjs-droppable="false">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-primary-200 dark:hover:bg-gray-600 transition-colors">
                    <h3 class="text-lg font-semibold text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="faq-question-1">What services do you offer?</h3>
                    <span class="text-2xl text-accent transform transition-transform">+</span>
                </button>
                <div class="px-6 pb-4">
                    <p class="text-primary-700" data-gjs-type="text" data-gjs-name="faq-answer-1">
                        We offer comprehensive web development services including custom websites, e-commerce solutions, web applications, and ongoing maintenance and support.
                    </p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="faq-item bg-primary-100 rounded-lg shadow-md" data-gjs-type="default" data-gjs-droppable="false">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-primary-200 dark:hover:bg-gray-600 transition-colors">
                    <h3 class="text-lg font-semibold text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="faq-question-2">How long does a typical project take?</h3>
                    <span class="text-2xl text-accent transform transition-transform">+</span>
                </button>
                <div class="px-6 pb-4">
                    <p class="text-primary-700" data-gjs-type="text" data-gjs-name="faq-answer-2">
                        Project timelines vary depending on complexity. Simple websites typically take 2-4 weeks, while complex applications can take 2-3 months or more.
                    </p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="faq-item bg-primary-100 rounded-lg shadow-md" data-gjs-type="default" data-gjs-droppable="false">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-primary-200 dark:hover:bg-gray-600 transition-colors">
                    <h3 class="text-lg font-semibold text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="faq-question-3">Do you provide ongoing support?</h3>
                    <span class="text-2xl text-accent transform transition-transform">+</span>
                </button>
                <div class="px-6 pb-4">
                    <p class="text-primary-700" data-gjs-type="text" data-gjs-name="faq-answer-3">
                        Yes, we offer various support packages including maintenance, updates, security monitoring, and technical support to keep your website running smoothly.
                    </p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="faq-item bg-primary-100 rounded-lg shadow-md" data-gjs-type="default" data-gjs-droppable="false">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-primary-200 dark:hover:bg-gray-600 transition-colors">
                    <h3 class="text-lg font-semibold text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="faq-question-4">What technologies do you use?</h3>
                    <span class="text-2xl text-accent transform transition-transform">+</span>
                </button>
                <div class="px-6 pb-4">
                    <p class="text-primary-700" data-gjs-type="text" data-gjs-name="faq-answer-4">
                        We use modern technologies including React, Vue.js, Laravel, Node.js, and other cutting-edge tools to create fast, secure, and scalable solutions.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Contact CTA -->
        <div class="mt-12 text-center">
            <p class="text-lg text-primary-700 mb-4" data-gjs-type="text" data-gjs-name="faq-cta-text">Still have questions? We're here to help!</p>
            <button class="px-8 py-3 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" data-gjs-type="text" data-gjs-name="faq-cta-button">Contact Us</button>
        </div>
    </div>
 </div>
@else
@php
    // Ensure dynamicData is always an array
    $dynamicData = $dynamicData ?? [];
    
    // Default FAQs structure with animation properties
    $defaultFaqs = [
        [
            'question' => 'What services do you offer?',
            'answer' => 'We offer comprehensive web development services including custom websites, e-commerce solutions, web applications, and ongoing maintenance and support.',
            'open' => false,
            'visible' => true,
            'delay' => 0
        ],
        [
            'question' => 'How long does a typical project take?',
            'answer' => 'Project timelines vary depending on complexity. Simple websites typically take 2-4 weeks, while complex applications can take 2-3 months or more.',
            'open' => false,
            'visible' => true,
            'delay' => 100
        ],
        [
            'question' => 'Do you provide ongoing support?',
            'answer' => 'Yes, we offer various support packages including maintenance, updates, security monitoring, and technical support to keep your website running smoothly.',
            'open' => false,
            'visible' => true,
            'delay' => 200
        ],
        [
            'question' => 'What technologies do you use?',
            'answer' => 'We use modern technologies including React, Vue.js, Laravel, Node.js, and other cutting-edge tools to create fast, secure, and scalable solutions.',
            'open' => false,
            'visible' => true,
            'delay' => 300
        ]
    ];
    
    // Use dynamic data if available (from component_data extraction)
    $dynamicFaqs = $dynamicData['faqs'] ?? null;
    
    // Merge dynamic data with defaults - prioritize extracted data
    if ($dynamicFaqs && is_array($dynamicFaqs)) {
        foreach ($dynamicFaqs as $index => $dynamicFaq) {
            if (isset($defaultFaqs[$index]) && is_array($dynamicFaq)) {
                $defaultFaqs[$index]['question'] = $dynamicFaq['question'] ?? $defaultFaqs[$index]['question'];
                $defaultFaqs[$index]['answer'] = $dynamicFaq['answer'] ?? $defaultFaqs[$index]['answer'];
                // Preserve animation properties from defaults
            }
        }
    }
    
    // Ensure $defaultFaqs is always an array
    if (!isset($defaultFaqs) || !is_array($defaultFaqs)) {
        $defaultFaqs = [];
    }
    
    // Extract CTA button and text from dynamic data
    $ctaButtonText = $dynamicData['ctaButton'] ?? 'Contact Us';
    $ctaText = $dynamicData['ctaText'] ?? 'Still have questions? We\'re here to help!';
    
    // Debug logging
    \Log::info('[Animated FAQ] Template rendering', [
        'dynamic_data_keys' => array_keys($dynamicData),
        'has_cta_button' => isset($dynamicData['ctaButton']),
        'cta_button_value' => $ctaButtonText,
        'has_cta_text' => isset($dynamicData['ctaText']),
        'cta_text_value' => $ctaText,
        'dynamic_data_sample' => array_slice($dynamicData, 0, 5, true),
    ]);
@endphp
<div class="faq-block py-12 bg-primary-50 dark:bg-gray-800" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data='{ 
         "faqs": @json($defaultFaqs), 
         "animated": false
     }' 
     x-init="
         (() => {
         if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
             animated = true;
             faqs.forEach(f => f.visible = true);
         } else {
             const observer = new IntersectionObserver((entries) => {
                 entries.forEach(entry => {
                     if (entry.isIntersecting && !animated) {
                         animated = true;
                             faqs.forEach((faq, index) => {
                                 setTimeout(() => {
                                     faq.visible = true;
                                 }, faq.delay);
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
        <h2 class="text-3xl font-bold mb-8 text-center text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="faq-title">Frequently Asked Questions</h2>
        <div class="max-w-4xl mx-auto space-y-4">
            <!-- FAQ Item 1 -->
            <div class="faq-item bg-primary-100 dark:bg-gray-700 rounded-lg shadow-md transform transition-all duration-700 ease-out will-change-transform" 
                 :class="faqs[0].visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-primary-200 dark:hover:bg-gray-600 transition-colors" 
                        @click="faqs[0].open = !faqs[0].open">
                    <h3 class="text-lg font-semibold text-primary-900 dark:text-white" x-text="faqs[0].question" data-gjs-type="text" data-gjs-name="faq-question-1">What services do you offer?</h3>
                    <span class="text-2xl text-accent transform transition-transform duration-300" 
                          :class="faqs[0].open ? 'rotate-45' : ''">+</span>
                </button>
                
                <div class="overflow-hidden transition-all duration-300 ease-out" 
                     :class="faqs[0].open ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'">
                    <div class="px-6 pb-4">
                        <p class="text-primary-700 dark:text-gray-300" x-text="faqs[0].answer" data-gjs-type="text" data-gjs-name="faq-answer-1">We offer comprehensive web development services including custom websites, e-commerce solutions, web applications, and ongoing maintenance and support.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="faq-item bg-primary-100 dark:bg-gray-700 rounded-lg shadow-md transform transition-all duration-700 ease-out will-change-transform" 
                 :class="faqs[1].visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-primary-200 dark:hover:bg-gray-600 transition-colors" 
                        @click="faqs[1].open = !faqs[1].open">
                    <h3 class="text-lg font-semibold text-primary-900 dark:text-white" x-text="faqs[1].question" data-gjs-type="text" data-gjs-name="faq-question-2">How long does a typical project take?</h3>
                    <span class="text-2xl text-accent transform transition-transform duration-300" 
                          :class="faqs[1].open ? 'rotate-45' : ''">+</span>
                </button>
                
                <div class="overflow-hidden transition-all duration-300 ease-out" 
                     :class="faqs[1].open ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'">
                    <div class="px-6 pb-4">
                        <p class="text-primary-700 dark:text-gray-300" x-text="faqs[1].answer" data-gjs-type="text" data-gjs-name="faq-answer-2">Project timelines vary depending on complexity. Simple websites typically take 2-4 weeks, while complex applications can take 2-3 months or more.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="faq-item bg-primary-100 dark:bg-gray-700 rounded-lg shadow-md transform transition-all duration-700 ease-out will-change-transform" 
                 :class="faqs[2].visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-primary-200 dark:hover:bg-gray-600 transition-colors" 
                        @click="faqs[2].open = !faqs[2].open">
                    <h3 class="text-lg font-semibold text-primary-900 dark:text-white" x-text="faqs[2].question" data-gjs-type="text" data-gjs-name="faq-question-3">Do you provide ongoing support?</h3>
                    <span class="text-2xl text-accent transform transition-transform duration-300" 
                          :class="faqs[2].open ? 'rotate-45' : ''">+</span>
                </button>
                
                <div class="overflow-hidden transition-all duration-300 ease-out" 
                     :class="faqs[2].open ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'">
                    <div class="px-6 pb-4">
                        <p class="text-primary-700 dark:text-gray-300" x-text="faqs[2].answer" data-gjs-type="text" data-gjs-name="faq-answer-3">Yes, we offer various support packages including maintenance, updates, security monitoring, and technical support to keep your website running smoothly.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="faq-item bg-primary-100 dark:bg-gray-700 rounded-lg shadow-md transform transition-all duration-700 ease-out will-change-transform" 
                 :class="faqs[3].visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                
                <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-primary-200 dark:hover:bg-gray-600 transition-colors" 
                        @click="faqs[3].open = !faqs[3].open">
                    <h3 class="text-lg font-semibold text-primary-900 dark:text-white" x-text="faqs[3].question" data-gjs-type="text" data-gjs-name="faq-question-4">What technologies do you use?</h3>
                    <span class="text-2xl text-accent transform transition-transform duration-300" 
                          :class="faqs[3].open ? 'rotate-45' : ''">+</span>
                </button>
                
                <div class="overflow-hidden transition-all duration-300 ease-out" 
                     :class="faqs[3].open ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'">
                    <div class="px-6 pb-4">
                        <p class="text-primary-700 dark:text-gray-300" x-text="faqs[3].answer" data-gjs-type="text" data-gjs-name="faq-answer-4">We use modern technologies including React, Vue.js, Laravel, Node.js, and other cutting-edge tools to create fast, secure, and scalable solutions.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact CTA -->
        <div class="mt-12 text-center">
            <p class="text-lg text-primary-700 dark:text-gray-300 mb-4" data-gjs-type="text" data-gjs-name="faq-cta-text">{{ $ctaText }}</p>
            <button class="px-8 py-3 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" 
                    data-gjs-type="text" 
                    data-gjs-name="faq-cta-button">
                {{ $ctaButtonText }}
            </button>
        </div>
    </div>
</div>
@endif 