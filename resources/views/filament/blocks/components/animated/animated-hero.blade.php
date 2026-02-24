{{-- @block id="animated-hero" label="Animated Hero" description="Animated hero section with text and image, featuring smooth scroll-triggered animations" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<!-- BLOCK: animated-hero START -->
<section class="text-gray-600 dark:text-gray-300 body-font">
    <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
        <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900 dark:text-white" data-gjs-type="text" data-gjs-name="hero-title">
                Before they sold out
                <br class="hidden lg:inline-block">readymade gluten
            </h1>
            <p class="mb-8 leading-relaxed text-gray-600 dark:text-gray-300" data-gjs-type="text" data-gjs-name="hero-description">
                Copper mug try-hard pitchfork pour-over freegan heirloom neutra air plant cold-pressed tacos poke beard tote bag. Heirloom echo park mlkshk tote bag selvage hot chicken authentic tumeric truffaut hexagon try-hard chambray.
            </p>
            <div class="flex justify-center">
                <button class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg" data-gjs-type="default" data-gjs-name="hero-button-primary">Button</button>
                <button class="ml-4 inline-flex text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-lg" data-gjs-type="default" data-gjs-name="hero-button-secondary">Button</button>
            </div>
        </div>
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
            <img class="object-cover object-center rounded" alt="hero" src="https://dummyimage.com/720x600" data-gjs-type="image" data-gjs-name="hero-image">
        </div>
    </div>
</section>
<!-- BLOCK: animated-hero END -->
@else
@php
    // Ensure dynamicData is always an array
    $dynamicData = $dynamicData ?? [];
    
    // Default hero data structure with animation properties
    $defaultHeroData = [
        'title' => 'Before they sold out<br class="hidden lg:inline-block">readymade gluten',
        'description' => 'Copper mug try-hard pitchfork pour-over freegan heirloom neutra air plant cold-pressed tacos poke beard tote bag. Heirloom echo park mlkshk tote bag selvage hot chicken authentic tumeric truffaut hexagon try-hard chambray.',
        'primaryButton' => [
            'text' => 'Button',
            'visible' => false,
            'delay' => 600
        ],
        'secondaryButton' => [
            'text' => 'Button',
            'visible' => false,
            'delay' => 700
        ],
        'image' => [
            'src' => 'https://dummyimage.com/720x600',
            'alt' => 'hero',
            'visible' => false,
            'delay' => 400
        ],
        'titleVisible' => false,
        'titleDelay' => 0,
        'descriptionVisible' => false,
        'descriptionDelay' => 200
    ];
    
    // Use dynamic data if available (from component_data extraction)
    $dynamicHero = $dynamicData['hero'] ?? null;
    
    // Merge dynamic data with defaults - prioritize extracted data
    if ($dynamicHero && is_array($dynamicHero)) {
        if (isset($dynamicHero['title'])) {
            $defaultHeroData['title'] = $dynamicHero['title'];
        }
        if (isset($dynamicHero['description'])) {
            $defaultHeroData['description'] = $dynamicHero['description'];
        }
        if (isset($dynamicHero['primaryButton']) && is_array($dynamicHero['primaryButton'])) {
            $defaultHeroData['primaryButton']['text'] = $dynamicHero['primaryButton']['text'] ?? $defaultHeroData['primaryButton']['text'];
        }
        if (isset($dynamicHero['secondaryButton']) && is_array($dynamicHero['secondaryButton'])) {
            $defaultHeroData['secondaryButton']['text'] = $dynamicHero['secondaryButton']['text'] ?? $defaultHeroData['secondaryButton']['text'];
        }
        if (isset($dynamicHero['image']) && is_array($dynamicHero['image'])) {
            $defaultHeroData['image']['src'] = $dynamicHero['image']['src'] ?? $defaultHeroData['image']['src'];
            $defaultHeroData['image']['alt'] = $dynamicHero['image']['alt'] ?? $defaultHeroData['image']['alt'];
        }
    }
    
    // Ensure $defaultHeroData is always an array
    if (!isset($defaultHeroData) || !is_array($defaultHeroData)) {
        $defaultHeroData = [];
    }
@endphp
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(2deg); }
    }
    
    @keyframes floatReverse {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(20px) rotate(-2deg); }
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.9; }
    }
    
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
    
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    @keyframes slideInLeft {
        0% { transform: translateX(-100px) scale(0.8); opacity: 0; }
        100% { transform: translateX(0) scale(1); opacity: 1; }
    }
    
    @keyframes slideInRight {
        0% { transform: translateX(100px) scale(0.8); opacity: 0; }
        100% { transform: translateX(0) scale(1); opacity: 1; }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animate-float-reverse {
        animation: floatReverse 8s ease-in-out infinite;
    }
    
    .animate-pulse-slow {
        animation: pulse 3s ease-in-out infinite;
    }
    
    .animate-shimmer {
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        background-size: 1000px 100%;
        animation: shimmer 3s infinite;
    }
    
    .hero-title-animated {
        animation: slideInLeft 1s ease-out forwards, float 8s ease-in-out 1s infinite;
    }
    
    .hero-image-animated {
        animation: slideInRight 1s ease-out forwards, floatReverse 6s ease-in-out 1s infinite;
    }
    
    .hero-button-bounce {
        animation: pulse 2s ease-in-out infinite;
    }
</style>
<section class="text-gray-600 dark:text-gray-300 body-font relative overflow-hidden" 
         data-gjs-type="default" 
         data-gjs-draggable="true" 
         data-gjs-droppable="false"
         x-data='{ 
             "hero": @json($defaultHeroData), 
             "animated": false
         }' 
         x-init="
             $nextTick(() => {
                 if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
                     animated = true;
                     if (hero) {
                         hero.titleVisible = true;
                         hero.descriptionVisible = true;
                         if (hero.image) hero.image.visible = true;
                         if (hero.primaryButton) hero.primaryButton.visible = true;
                         if (hero.secondaryButton) hero.secondaryButton.visible = true;
                     }
                 } else {
                     const observer = new IntersectionObserver((entries) => {
                         entries.forEach(entry => {
                             if (entry.isIntersecting && !animated) {
                                 animated = true;
                                 
                                 // Animate title with scale and blur effect
                                 setTimeout(() => {
                                     if (hero) hero.titleVisible = true;
                                 }, hero && hero.titleDelay ? hero.titleDelay : 0);
                                 
                                 // Animate description with stagger
                                 setTimeout(() => {
                                     if (hero) hero.descriptionVisible = true;
                                 }, hero && hero.descriptionDelay ? hero.descriptionDelay : 200);
                                 
                                 // Animate image with parallax-like effect
                                 if (hero && hero.image) {
                                     setTimeout(() => {
                                         hero.image.visible = true;
                                     }, hero.image.delay || 400);
                                 }
                                 
                                 // Animate buttons with bounce effect
                                 if (hero && hero.primaryButton) {
                                     setTimeout(() => {
                                         hero.primaryButton.visible = true;
                                     }, hero.primaryButton.delay || 600);
                                 }
                                 
                                 if (hero && hero.secondaryButton) {
                                     setTimeout(() => {
                                         hero.secondaryButton.visible = true;
                                     }, hero.secondaryButton.delay || 700);
                                 }
                             }
                         });
                     }, {
                         threshold: 0.1,
                         rootMargin: '0px 0px -50px 0px'
                     });
                     observer.observe($el);
                 }
             });
         ">
    <!-- Animated background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse-slow"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float"></div>
        <div class="absolute -bottom-32 left-1/2 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float-reverse"></div>
    </div>
    
    <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center relative z-10">
        <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900 dark:text-white transform transition-all duration-1000 ease-[cubic-bezier(0.34,1.56,0.64,1)] will-change-transform relative" 
                :class="hero && hero.titleVisible ? 'opacity-100 translate-x-0 translate-y-0 scale-100 blur-0 hero-title-animated' : 'opacity-0 -translate-x-12 translate-y-4 scale-95 blur-sm'"
                data-gjs-type="text" 
                data-gjs-name="hero-title"
                x-html="hero && hero.title ? hero.title : 'Before they sold out<br class=\"hidden lg:inline-block\">readymade gluten'">
                Before they sold out
                <br class="hidden lg:inline-block">readymade gluten
            </h1>
            <p class="mb-8 leading-relaxed text-gray-600 dark:text-gray-300 transform transition-all duration-1000 ease-[cubic-bezier(0.16,1,0.3,1)] will-change-transform" 
               :class="hero && hero.descriptionVisible ? 'opacity-100 translate-y-0 animate-pulse-slow' : 'opacity-0 translate-y-6'"
               data-gjs-type="text" 
               data-gjs-name="hero-description"
               x-text="hero && hero.description ? hero.description : 'Copper mug try-hard pitchfork pour-over freegan heirloom neutra air plant cold-pressed tacos poke beard tote bag. Heirloom echo park mlkshk tote bag selvage hot chicken authentic tumeric truffaut hexagon try-hard chambray.'">
                Copper mug try-hard pitchfork pour-over freegan heirloom neutra air plant cold-pressed tacos poke beard tote bag. Heirloom echo park mlkshk tote bag selvage hot chicken authentic tumeric truffaut hexagon try-hard chambray.
            </p>
            <div class="flex justify-center">
                <button class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg transform transition-all duration-800 ease-[cubic-bezier(0.34,1.56,0.64,1)] will-change-transform hover:scale-110 hover:shadow-xl active:scale-95 relative overflow-hidden group" 
                        :class="hero && hero.primaryButton && hero.primaryButton.visible ? 'opacity-100 translate-y-0 scale-100 rotate-0 hero-button-bounce' : 'opacity-0 translate-y-8 scale-75 -rotate-3'"
                        data-gjs-type="default" 
                        data-gjs-name="hero-button-primary">
                    <span class="relative z-10" x-text="hero && hero.primaryButton && hero.primaryButton.text ? hero.primaryButton.text : 'Button'">Button</span>
                    <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-30 group-hover:animate-shimmer"></span>
                </button>
                <button class="ml-4 inline-flex text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-lg transform transition-all duration-800 ease-[cubic-bezier(0.34,1.56,0.64,1)] will-change-transform hover:scale-110 hover:shadow-lg active:scale-95 relative overflow-hidden group" 
                        :class="hero && hero.secondaryButton && hero.secondaryButton.visible ? 'opacity-100 translate-y-0 scale-100 rotate-0 hero-button-bounce' : 'opacity-0 translate-y-8 scale-75 rotate-3'"
                        data-gjs-type="default" 
                        data-gjs-name="hero-button-secondary">
                    <span class="relative z-10" x-text="hero && hero.secondaryButton && hero.secondaryButton.text ? hero.secondaryButton.text : 'Button'">Button</span>
                    <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-20 group-hover:animate-shimmer"></span>
                </button>
            </div>
        </div>
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 transform transition-all duration-1000 ease-[cubic-bezier(0.16,1,0.3,1)] will-change-transform relative"
             :class="hero && hero.image && hero.image.visible ? 'opacity-100 translate-x-0 translate-y-0 scale-100 rotate-0 hero-image-animated' : 'opacity-0 translate-x-12 translate-y-8 scale-90 rotate-2'">
            <!-- Animated glow effect -->
            <div class="absolute -inset-4 bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 rounded-lg opacity-20 blur-2xl animate-pulse-slow"></div>
            <img class="object-cover object-center rounded shadow-2xl w-full h-full transform transition-transform duration-500 ease-out will-change-transform hover:scale-105 hover:shadow-3xl relative z-10" 
                 :alt="hero && hero.image && hero.image.alt ? hero.image.alt : 'hero'"
                 :src="hero && hero.image && hero.image.src ? hero.image.src : 'https://dummyimage.com/720x600'"
                 data-gjs-type="image" 
                 data-gjs-name="hero-image"
                 alt="hero" 
                 src="https://dummyimage.com/720x600">
        </div>
    </div>
</section>
@endif


