{{-- @block id="animated-pricing" label="Animated Pricing" description="Animated pricing cards with interactive features and hover effects" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<!-- BLOCK: animated-pricing START -->
<div class="pricing-block py-12 bg-primary-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center text-primary-900" data-gjs-type="text" data-gjs-name="pricing-title">Choose Your Plan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Starter Plan -->
            <div class="pricing-card relative p-6 rounded-lg shadow-lg bg-primary-100 dark:bg-gray-700" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold mb-4 text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="plan-name-1">Starter</h3>
                    <div class="text-3xl font-bold mb-2 text-accent">
                        $<span data-gjs-type="text" data-gjs-name="plan-price-1">99</span>
                        <span class="text-lg font-normal text-primary-600" data-gjs-type="text" data-gjs-name="plan-period-1">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" data-gjs-type="text" data-gjs-name="feature-1-1">Basic Features</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" data-gjs-type="text" data-gjs-name="feature-1-2">Email Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" data-gjs-type="text" data-gjs-name="feature-1-3">5GB Storage</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-primary-200 dark:bg-gray-600 text-primary-900 dark:text-white hover:bg-accent hover:text-white transition-colors" data-gjs-type="text" data-gjs-name="button-1">Get Started</button>
            </div>

            <!-- Professional Plan -->
            <div class="pricing-card relative p-6 rounded-lg shadow-lg ring-2 ring-accent scale-105 bg-primary-100" data-gjs-type="default" data-gjs-droppable="false">
                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 px-4 py-1 rounded-full text-sm font-semibold text-white bg-accent" data-gjs-type="text" data-gjs-name="popular-badge">Most Popular</div>
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold mb-4 text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="plan-name-2">Professional</h3>
                    <div class="text-3xl font-bold mb-2 text-accent">
                        $<span data-gjs-type="text" data-gjs-name="plan-price-2">199</span>
                        <span class="text-lg font-normal text-primary-600" data-gjs-type="text" data-gjs-name="plan-period-2">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" data-gjs-type="text" data-gjs-name="feature-2-1">All Starter Features</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" data-gjs-type="text" data-gjs-name="feature-2-2">Priority Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" data-gjs-type="text" data-gjs-name="feature-2-3">25GB Storage</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" data-gjs-type="text" data-gjs-name="button-2">Get Started</button>
            </div>

            <!-- Enterprise Plan -->
            <div class="pricing-card relative p-6 rounded-lg shadow-lg bg-primary-100 dark:bg-gray-700" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold mb-4 text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="plan-name-3">Enterprise</h3>
                    <div class="text-3xl font-bold mb-2 text-accent">
                        $<span data-gjs-type="text" data-gjs-name="plan-price-3">399</span>
                        <span class="text-lg font-normal text-primary-600" data-gjs-type="text" data-gjs-name="plan-period-3">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" data-gjs-type="text" data-gjs-name="feature-3-1">All Professional Features</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" data-gjs-type="text" data-gjs-name="feature-3-2">24/7 Phone Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" data-gjs-type="text" data-gjs-name="feature-3-3">Unlimited Storage</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-primary-200 dark:bg-gray-600 text-primary-900 dark:text-white hover:bg-accent hover:text-white transition-colors" data-gjs-type="text" data-gjs-name="button-3">Get Started</button>
            </div>
        </div>
        
        <!-- Plan Comparison -->
        <div class="mt-12 text-center">
            <p class="text-lg mb-4 text-primary-700" data-gjs-type="text" data-gjs-name="comparison-text">Select a plan to get started</p>
            <button class="px-8 py-3 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" data-gjs-type="text" data-gjs-name="proceed-button">Proceed with Plan</button>
        </div>
    </div>
 </div>
<!-- BLOCK: animated-pricing END -->
@else
@php
    // Ensure dynamicData is always an array
    $dynamicData = $dynamicData ?? [];
    
    // Debug logging
    \Log::info('[Animated Pricing] Template rendering', [
        'dynamicData' => $dynamicData,
        'dynamicData_type' => gettype($dynamicData),
        'has_plans' => isset($dynamicData['plans']),
        'plans_count' => isset($dynamicData['plans']) && is_array($dynamicData['plans']) ? count($dynamicData['plans']) : 0,
        'plans_data' => $dynamicData['plans'] ?? null,
        'plan_names' => isset($dynamicData['plans']) && is_array($dynamicData['plans']) ? array_column($dynamicData['plans'], 'name') : [],
    ]);
    
    // Default plans structure with animation properties
    // Start with visible: true to ensure content shows, then animate in
    $defaultPlans = [
        [
            'name' => 'Starter',
            'price' => '99',
            'period' => 'month',
            'features' => ['Basic Features', 'Email Support', '5GB Storage'],
            'popular' => false,
            'visible' => true, // Start visible to ensure content shows
            'delay' => 0
        ],
        [
            'name' => 'Professional',
            'price' => '199',
            'period' => 'month',
            'features' => ['All Starter Features', 'Priority Support', '25GB Storage'],
            'popular' => true,
            'visible' => true, // Start visible to ensure content shows
            'delay' => 150
        ],
        [
            'name' => 'Enterprise',
            'price' => '399',
            'period' => 'month',
            'features' => ['All Professional Features', '24/7 Phone Support', 'Unlimited Storage'],
            'popular' => false,
            'visible' => true, // Start visible to ensure content shows
            'delay' => 300
        ]
    ];
    
    // Use dynamic data if available (from component_data extraction)
    $dynamicPlans = $dynamicData['plans'] ?? null;
    
    // Merge dynamic data with defaults - prioritize extracted data
    // Note: We preserve animation properties (visible, delay) from defaults
    if ($dynamicPlans && is_array($dynamicPlans)) {
        foreach ($dynamicPlans as $index => $dynamicPlan) {
            if (isset($defaultPlans[$index]) && is_array($dynamicPlan)) {
                $defaultPlans[$index]['name'] = $dynamicPlan['name'] ?? $defaultPlans[$index]['name'];
                $defaultPlans[$index]['price'] = $dynamicPlan['price'] ?? $defaultPlans[$index]['price'];
                $defaultPlans[$index]['period'] = $dynamicPlan['period'] ?? $defaultPlans[$index]['period'];
                if (isset($dynamicPlan['features']) && is_array($dynamicPlan['features']) && !empty($dynamicPlan['features'])) {
                    $defaultPlans[$index]['features'] = $dynamicPlan['features'];
                }
                $defaultPlans[$index]['popular'] = $dynamicPlan['popular'] ?? $defaultPlans[$index]['popular'];
                // Merge button text
                if (isset($dynamicPlan['buttonText']) && !empty($dynamicPlan['buttonText']) && $dynamicPlan['buttonText'] !== 'Get Started') {
                    $defaultPlans[$index]['buttonText'] = $dynamicPlan['buttonText'];
                } else {
                    $defaultPlans[$index]['buttonText'] = 'Get Started';
                }
                // Preserve animation properties - don't overwrite them from dynamic data
                // visible and delay are always set from defaults above
            }
        }
    }
    
    // Ensure $defaultPlans is always an array
    if (!isset($defaultPlans) || !is_array($defaultPlans)) {
        $defaultPlans = [];
    }
    
    // Ensure JSON encoding is safe - use @json which properly escapes for JavaScript
    $plansJson = json_encode($defaultPlans, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES);
    if ($plansJson === false) {
        $plansJson = '[]';
        \Log::error('[Animated Pricing] JSON encoding failed', ['error' => json_last_error_msg()]);
    }
@endphp
<div class="pricing-block py-12 bg-primary-50 dark:bg-gray-800" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data='{ 
         "plans": @json($defaultPlans), 
         "selectedPlan": null, 
         "animated": false 
     }'
     x-init="
         (() => {
             if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
                 // In editor, don't initialize Alpine.js to avoid affecting other blocks
                 return;
             }
             $nextTick(() => { 
                 // Plans loaded
             });
         })();
     ">
    
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="pricing-title">Choose Your Plan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Starter Plan -->
            <div class="pricing-card relative p-6 rounded-lg shadow-lg bg-primary-100 dark:bg-gray-700" 
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold mb-4 text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="plan-name-1">
                        <span x-text="plans && plans[0] ? plans[0].name : 'Starter'">Starter</span>
                    </h3>
                    <div class="text-3xl font-bold mb-2 text-accent">
                        $<span x-text="plans && plans[0] ? plans[0].price : '99'" data-gjs-type="text" data-gjs-name="plan-price-1">99</span>
                        <span class="text-lg font-normal text-primary-600" x-text="'/' + (plans && plans[0] ? plans[0].period : 'month')" data-gjs-type="text" data-gjs-name="plan-period-1">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" x-text="plans && plans[0] && plans[0].features && plans[0].features[0] ? plans[0].features[0] : 'Basic Features'" data-gjs-type="text" data-gjs-name="feature-1-1">Basic Features</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" x-text="plans && plans[0] && plans[0].features && plans[0].features[1] ? plans[0].features[1] : 'Email Support'" data-gjs-type="text" data-gjs-name="feature-1-2">Email Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" x-text="plans && plans[0] && plans[0].features && plans[0].features[2] ? plans[0].features[2] : '5GB Storage'" data-gjs-type="text" data-gjs-name="feature-1-3">5GB Storage</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-primary-200 dark:bg-gray-600 text-primary-900 dark:text-white hover:bg-accent hover:text-white transition-colors" 
                        @click="if (plans && plans[0]) selectedPlan = plans[0]"
                        data-gjs-type="text" 
                        data-gjs-name="button-1">
                    <span x-text="selectedPlan && plans && plans[0] && selectedPlan === plans[0] ? 'Selected' : (plans && plans[0] && plans[0].buttonText ? plans[0].buttonText : 'Get Started')" data-gjs-type="text" data-gjs-name="button-text-1">Get Started</span>
                </button>
            </div>

            <!-- Professional Plan -->
            <div class="pricing-card relative p-6 rounded-lg shadow-lg ring-2 ring-accent scale-105 bg-primary-100" 
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 px-4 py-1 rounded-full text-sm font-semibold text-white bg-accent" 
                     data-gjs-type="text" 
                     data-gjs-name="popular-badge">
                    Most Popular
                </div>
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold mb-4 text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="plan-name-2">
                        <span x-text="plans && plans[1] ? plans[1].name : 'Professional'">Professional</span>
                    </h3>
                    <div class="text-3xl font-bold mb-2 text-accent">
                        $<span x-text="plans && plans[1] ? plans[1].price : '199'" data-gjs-type="text" data-gjs-name="plan-price-2">199</span>
                        <span class="text-lg font-normal text-primary-600" x-text="'/' + (plans && plans[1] ? plans[1].period : 'month')" data-gjs-type="text" data-gjs-name="plan-period-2">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" x-text="plans && plans[1] && plans[1].features && plans[1].features[0] ? plans[1].features[0] : 'All Starter Features'" data-gjs-type="text" data-gjs-name="feature-2-1">All Starter Features</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" x-text="plans && plans[1] && plans[1].features && plans[1].features[1] ? plans[1].features[1] : 'Priority Support'" data-gjs-type="text" data-gjs-name="feature-2-2">Priority Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" x-text="plans && plans[1] && plans[1].features && plans[1].features[2] ? plans[1].features[2] : '25GB Storage'" data-gjs-type="text" data-gjs-name="feature-2-3">25GB Storage</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" 
                        @click="if (plans && plans[1]) selectedPlan = plans[1]"
                        data-gjs-type="text" 
                        data-gjs-name="button-2">
                    <span x-text="selectedPlan && plans && plans[1] && selectedPlan === plans[1] ? 'Selected' : (plans && plans[1] && plans[1].buttonText ? plans[1].buttonText : 'Get Started')" data-gjs-type="text" data-gjs-name="button-text-2">Get Started</span>
                </button>
            </div>

            <!-- Enterprise Plan -->
            <div class="pricing-card relative p-6 rounded-lg shadow-lg bg-primary-100 dark:bg-gray-700" 
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold mb-4 text-primary-900 dark:text-white" data-gjs-type="text" data-gjs-name="plan-name-3">
                        <span x-text="plans && plans[2] ? plans[2].name : 'Enterprise'">Enterprise</span>
                    </h3>
                    <div class="text-3xl font-bold mb-2 text-accent">
                        $<span x-text="plans && plans[2] ? plans[2].price : '399'" data-gjs-type="text" data-gjs-name="plan-price-3">399</span>
                        <span class="text-lg font-normal text-primary-600" x-text="'/' + (plans && plans[2] ? plans[2].period : 'month')" data-gjs-type="text" data-gjs-name="plan-period-3">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" x-text="plans && plans[2] && plans[2].features && plans[2].features[0] ? plans[2].features[0] : 'All Professional Features'" data-gjs-type="text" data-gjs-name="feature-3-1">All Professional Features</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" x-text="plans && plans[2] && plans[2].features && plans[2].features[1] ? plans[2].features[1] : '24/7 Phone Support'" data-gjs-type="text" data-gjs-name="feature-3-2">24/7 Phone Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700 dark:text-gray-300" x-text="plans && plans[2] && plans[2].features && plans[2].features[2] ? plans[2].features[2] : 'Unlimited Storage'" data-gjs-type="text" data-gjs-name="feature-3-3">Unlimited Storage</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-primary-200 dark:bg-gray-600 text-primary-900 dark:text-white hover:bg-accent hover:text-white transition-colors" 
                        @click="if (plans && plans[2]) selectedPlan = plans[2]"
                        data-gjs-type="text" 
                        data-gjs-name="button-3">
                    <span x-text="selectedPlan && plans && plans[2] && selectedPlan === plans[2] ? 'Selected' : (plans && plans[2] && plans[2].buttonText ? plans[2].buttonText : 'Get Started')" data-gjs-type="text" data-gjs-name="button-text-3">Get Started</span>
                </button>
            </div>
        </div>
        
        <!-- Plan Comparison -->
        <div class="mt-12 text-center">
            <p class="text-lg mb-4 text-primary-700" data-gjs-type="text" data-gjs-name="comparison-text">
                <span x-show="selectedPlan">You selected: <strong x-text="selectedPlan && selectedPlan.name ? selectedPlan.name : ''"></strong></span>
                <span x-show="!selectedPlan">Select a plan to get started</span>
            </p>
            <button x-show="selectedPlan" 
                    class="px-8 py-3 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" 
                    data-gjs-type="text" 
                    data-gjs-name="proceed-button"
                    x-text="selectedPlan && selectedPlan.name ? 'Proceed with ' + selectedPlan.name : 'Proceed with Plan'">
                Proceed with Plan
            </button>
        </div>
    </div>
</div>
@endif

