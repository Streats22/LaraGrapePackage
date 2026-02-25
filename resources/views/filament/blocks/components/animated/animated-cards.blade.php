{{-- @block id="animated-cards" label="Animated Cards" description="Animated cards with hover effects and interactive features" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="cards-block py-12 bg-primary-50" data-laragrape-block="animated-cards">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center text-primary-900" data-gjs-type="text" data-gjs-name="cards-title">Our Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Card 1 -->
            <div class="card relative p-6 rounded-lg shadow-lg bg-primary-100 hover:shadow-xl transition-all duration-300" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-accent flex items-center justify-center">
                        <span class="text-2xl text-white">🚀</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="card-title-1">Web Development</h3>
                    <p class="text-primary-700 dark:text-gray-300 mb-4" data-gjs-type="text" data-gjs-name="card-description-1">Custom web applications built with modern technologies and best practices.</p>
                </div>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" data-gjs-type="text" data-gjs-name="card-button-1">Learn More</button>
            </div>

            <!-- Card 2 -->
            <div class="card relative p-6 rounded-lg shadow-lg bg-primary-100 hover:shadow-xl transition-all duration-300" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-accent flex items-center justify-center">
                        <span class="text-2xl text-white">🎨</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="card-title-2">UI/UX Design</h3>
                    <p class="text-primary-700 dark:text-gray-300 mb-4" data-gjs-type="text" data-gjs-name="card-description-2">Beautiful and intuitive user interfaces that enhance user experience.</p>
                </div>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" data-gjs-type="text" data-gjs-name="card-button-2">Learn More</button>
            </div>

            <!-- Card 3 -->
            <div class="card relative p-6 rounded-lg shadow-lg bg-primary-100 hover:shadow-xl transition-all duration-300" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-accent flex items-center justify-center">
                        <span class="text-2xl text-white">⚡</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="card-title-3">Performance</h3>
                    <p class="text-primary-700 dark:text-gray-300 mb-4" data-gjs-type="text" data-gjs-name="card-description-3">Optimized applications that load fast and perform exceptionally well.</p>
                </div>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" data-gjs-type="text" data-gjs-name="card-button-3">Learn More</button>
            </div>
        </div>
    </div>
 </div>
@else
@php
    // Ensure dynamicData is always an array
    $dynamicData = $dynamicData ?? [];
    
    // Default cards structure with animation properties
    $defaultCards = [
        [
            'icon' => '🚀',
            'title' => 'Web Development',
            'description' => 'Custom web applications built with modern technologies and best practices.',
            'buttonText' => 'Learn More',
            'visible' => true,
            'delay' => 0
        ],
        [
            'icon' => '🎨',
            'title' => 'UI/UX Design',
            'description' => 'Beautiful and intuitive user interfaces that enhance user experience.',
            'buttonText' => 'Learn More',
            'visible' => true,
            'delay' => 200
        ],
        [
            'icon' => '⚡',
            'title' => 'Performance',
            'description' => 'Optimized applications that load fast and perform exceptionally well.',
            'buttonText' => 'Learn More',
            'visible' => true,
            'delay' => 400
        ]
    ];
    
    // Use dynamic data if available (from component_data extraction)
    $dynamicCards = $dynamicData['cards'] ?? null;
    
    // Merge dynamic data with defaults - prioritize extracted data
    if ($dynamicCards && is_array($dynamicCards)) {
        foreach ($dynamicCards as $index => $dynamicCard) {
            if (isset($defaultCards[$index]) && is_array($dynamicCard)) {
                $defaultCards[$index]['title'] = $dynamicCard['title'] ?? $defaultCards[$index]['title'];
                $defaultCards[$index]['description'] = $dynamicCard['description'] ?? $defaultCards[$index]['description'];
                $defaultCards[$index]['buttonText'] = $dynamicCard['buttonText'] ?? $defaultCards[$index]['buttonText'];
                // Preserve icon and animation properties from defaults
            }
        }
    }
    
    // Ensure $defaultCards is always an array
    if (!isset($defaultCards) || !is_array($defaultCards)) {
        $defaultCards = [];
    }
@endphp
<div class="cards-block py-12 bg-primary-50 dark:bg-gray-800" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data='{ 
         "cards": @json($defaultCards), 
         "animated": false,
         "selectedCard": null
     }' 
     x-init="
         (() => {
         if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
             animated = true;
             cards.forEach((c) => { c.visible = true; });
         } else {
             const observer = new IntersectionObserver((entries) => {
                 entries.forEach(entry => {
                     if (entry.isIntersecting && !animated) {
                         animated = true;
                             cards.forEach((card, index) => {
                                 setTimeout(() => {
                                     card.visible = true;
                                 }, card.delay);
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
        <h2 class="text-3xl font-bold mb-8 text-center text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="cards-title">Our Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Card 1 -->
            <div class="card relative p-6 rounded-lg shadow-lg bg-primary-100 dark:bg-gray-700 transform transition-all duration-700 ease-out hover:scale-105 hover:shadow-xl will-change-transform" 
                 :class="cards && cards[0] && cards[0].visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 @click="if (cards && cards[0]) { selectedCard = cards[0]; }"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-accent flex items-center justify-center">
                        <span class="text-2xl text-white" x-text="cards && cards[0] ? cards[0].icon : '🚀'">🚀</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-primary-900 dark:text-white" x-text="cards && cards[0] ? cards[0].title : 'Web Development'" data-gjs-type="text" data-gjs-name="card-title-1">Web Development</h3>
                    <p class="text-primary-700 dark:text-gray-300 mb-4" x-text="cards && cards[0] ? cards[0].description : 'Custom web applications built with modern technologies and best practices.'" data-gjs-type="text" data-gjs-name="card-description-1">Custom web applications built with modern technologies and best practices.</p>
                </div>
                
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-accent text-white transition-all duration-300 hover:scale-105 hover:shadow-lg" 
                        data-gjs-type="default" 
                        data-gjs-droppable="false">
                    <span x-text="cards && cards[0] ? cards[0].buttonText : 'Learn More'">Learn More</span>
                </button>
                
                <!-- Selection Indicator -->
                <div x-show="selectedCard && cards && cards[0] && selectedCard === cards[0]" 
                     class="absolute top-4 right-4 w-6 h-6 rounded-full flex items-center justify-center bg-accent text-white">
                    ✓
                </div>
            </div>

            <!-- Card 2 -->
            <div class="card relative p-6 rounded-lg shadow-lg bg-primary-100 dark:bg-gray-700 transform transition-all duration-700 ease-out hover:scale-105 hover:shadow-xl will-change-transform" 
                 :class="cards && cards[1] && cards[1].visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 @click="if (cards && cards[1]) { selectedCard = cards[1]; }"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-accent flex items-center justify-center">
                        <span class="text-2xl text-white" x-text="cards && cards[1] ? cards[1].icon : '🎨'">🎨</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-primary-900 dark:text-white" x-text="cards && cards[1] ? cards[1].title : 'UI/UX Design'" data-gjs-type="text" data-gjs-name="card-title-2">UI/UX Design</h3>
                    <p class="text-primary-700 dark:text-gray-300 mb-4" x-text="cards && cards[1] ? cards[1].description : 'Beautiful and intuitive user interfaces that enhance user experience.'" data-gjs-type="text" data-gjs-name="card-description-2">Beautiful and intuitive user interfaces that enhance user experience.</p>
                </div>
                
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-accent text-white transition-all duration-300 hover:scale-105 hover:shadow-lg" 
                        data-gjs-type="default" 
                        data-gjs-droppable="false">
                    <span x-text="cards && cards[1] ? cards[1].buttonText : 'Learn More'">Learn More</span>
                </button>
                
                <!-- Selection Indicator -->
                <div x-show="selectedCard && cards && cards[1] && selectedCard === cards[1]" 
                     class="absolute top-4 right-4 w-6 h-6 rounded-full flex items-center justify-center bg-accent text-white">
                    ✓
                </div>
            </div>

            <!-- Card 3 -->
            <div class="card relative p-6 rounded-lg shadow-lg bg-primary-100 dark:bg-gray-700 transform transition-all duration-700 ease-out hover:scale-105 hover:shadow-xl will-change-transform" 
                 :class="cards && cards[2] && cards[2].visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 @click="if (cards && cards[2]) { selectedCard = cards[2]; }"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-accent flex items-center justify-center">
                        <span class="text-2xl text-white" x-text="cards && cards[2] ? cards[2].icon : '⚡'">⚡</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-primary-900 dark:text-white" x-text="cards && cards[2] ? cards[2].title : 'Performance'" data-gjs-type="text" data-gjs-name="card-title-3">Performance</h3>
                    <p class="text-primary-700 dark:text-gray-300 mb-4" x-text="cards && cards[2] ? cards[2].description : 'Optimized applications that load fast and perform exceptionally well.'" data-gjs-type="text" data-gjs-name="card-description-3">Optimized applications that load fast and perform exceptionally well.</p>
                </div>
                
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-accent text-white transition-all duration-300 hover:scale-105 hover:shadow-lg" 
                        data-gjs-type="default" 
                        data-gjs-droppable="false">
                    <span x-text="cards && cards[2] ? cards[2].buttonText : 'Learn More'">Learn More</span>
                </button>
                
                <!-- Selection Indicator -->
                <div x-show="selectedCard && cards && cards[2] && selectedCard === cards[2]" 
                     class="absolute top-4 right-4 w-6 h-6 rounded-full flex items-center justify-center bg-accent text-white">
                    ✓
                </div>
            </div>
        </div>
        
        <!-- Selection Summary -->
        <div class="mt-12 text-center">
            <p class="text-lg mb-4 text-primary-700 dark:text-gray-300">
                <span x-show="selectedCard">You selected: <strong x-text="selectedCard && selectedCard.title ? selectedCard.title : ''"></strong></span>
                <span x-show="!selectedCard">Click on a card to learn more</span>
            </p>
            <button x-show="selectedCard" 
                    class="px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg bg-accent text-white"
                    data-gjs-type="default" 
                    data-gjs-droppable="false">
                Get Started with <span x-text="selectedCard && selectedCard.title ? selectedCard.title : ''"></span>
            </button>
        </div>
    </div>
</div>
@endif 