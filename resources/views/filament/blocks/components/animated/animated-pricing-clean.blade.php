{{-- @block id="animated-pricing" label="Animated Pricing" description="Animated pricing cards with interactive features and hover effects" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<!-- BLOCK: animated-pricing START -->
<div class="pricing-block py-12 bg-primary-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center text-primary-900" data-gjs-type="text" data-gjs-name="pricing-title">Choose Your Plan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Starter Plan -->
            <div class="pricing-card relative p-6 rounded-lg shadow-lg bg-primary-100" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold mb-4 text-primary-900" data-gjs-type="text" data-gjs-name="plan-name-1">Starter</h3>
                    <div class="text-3xl font-bold mb-2 text-accent">
                        $<span data-gjs-type="text" data-gjs-name="plan-price-1">99</span>
                        <span class="text-lg font-normal text-primary-600" data-gjs-type="text" data-gjs-name="plan-period-1">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" data-gjs-type="text" data-gjs-name="feature-1-1">Basic Features</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" data-gjs-type="text" data-gjs-name="feature-1-2">Email Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" data-gjs-type="text" data-gjs-name="feature-1-3">5GB Storage</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-primary-200 text-primary-900 hover:bg-accent hover:text-white transition-colors" data-gjs-type="text" data-gjs-name="button-1">Get Started</button>
            </div>

            <!-- Professional Plan -->
            <div class="pricing-card relative p-6 rounded-lg shadow-lg ring-2 ring-accent scale-105 bg-primary-100" data-gjs-type="default" data-gjs-droppable="false">
                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 px-4 py-1 rounded-full text-sm font-semibold text-white bg-accent" data-gjs-type="text" data-gjs-name="popular-badge">Most Popular</div>
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold mb-4 text-primary-900" data-gjs-type="text" data-gjs-name="plan-name-2">Professional</h3>
                    <div class="text-3xl font-bold mb-2 text-accent">
                        $<span data-gjs-type="text" data-gjs-name="plan-price-2">199</span>
                        <span class="text-lg font-normal text-primary-600" data-gjs-type="text" data-gjs-name="plan-period-2">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" data-gjs-type="text" data-gjs-name="feature-2-1">All Starter Features</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" data-gjs-type="text" data-gjs-name="feature-2-2">Priority Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" data-gjs-type="text" data-gjs-name="feature-2-3">25GB Storage</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" data-gjs-type="text" data-gjs-name="button-2">Get Started</button>
            </div>

            <!-- Enterprise Plan -->
            <div class="pricing-card relative p-6 rounded-lg shadow-lg bg-primary-100" data-gjs-type="default" data-gjs-droppable="false">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold mb-4 text-primary-900" data-gjs-type="text" data-gjs-name="plan-name-3">Enterprise</h3>
                    <div class="text-3xl font-bold mb-2 text-accent">
                        $<span data-gjs-type="text" data-gjs-name="plan-price-3">399</span>
                        <span class="text-lg font-normal text-primary-600" data-gjs-type="text" data-gjs-name="plan-period-3">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" data-gjs-type="text" data-gjs-name="feature-3-1">All Professional Features</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" data-gjs-type="text" data-gjs-name="feature-3-2">24/7 Phone Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" data-gjs-type="text" data-gjs-name="feature-3-3">Unlimited Storage</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-primary-200 text-primary-900 hover:bg-accent hover:text-white transition-colors" data-gjs-type="text" data-gjs-name="button-3">Get Started</button>
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
    
    // Default plans structure
    $defaultPlans = [
        [
            'name' => 'Starter',
            'price' => '99',
            'period' => 'month',
            'features' => ['Basic Features', 'Email Support', '5GB Storage'],
            'popular' => false,
        ],
        [
            'name' => 'Professional',
            'price' => '199',
            'period' => 'month',
            'features' => ['All Starter Features', 'Priority Support', '25GB Storage'],
            'popular' => true,
        ],
        [
            'name' => 'Enterprise',
            'price' => '399',
            'period' => 'month',
            'features' => ['All Professional Features', '24/7 Phone Support', 'Unlimited Storage'],
            'popular' => false,
        ]
    ];
    
    // Use dynamic data if available (from component_data extraction)
    $dynamicPlans = $dynamicData['plans'] ?? null;
    
    // Merge dynamic data with defaults - prioritize extracted data
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
            }
        }
    }
    
    // Ensure $defaultPlans is always an array
    if (!isset($defaultPlans) || !is_array($defaultPlans)) {
        $defaultPlans = [];
    }
@endphp
<div class="pricing-block py-12 bg-primary-50" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data="{
         plans: @json($defaultPlans),
         selectedPlan: null
     }">
    
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center text-primary-900" data-gjs-type="text" data-gjs-name="pricing-title">Choose Your Plan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Starter Plan -->
            <div class="pricing-card relative p-6 rounded-lg shadow-lg bg-primary-100" 
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold mb-4 text-primary-900" data-gjs-type="text" data-gjs-name="plan-name-1">
                        <span x-text="plans[0]?.name || 'Starter'">Starter</span>
                    </h3>
                    <div class="text-3xl font-bold mb-2 text-accent">
                        $<span x-text="plans[0]?.price || '99'" data-gjs-type="text" data-gjs-name="plan-price-1">99</span>
                        <span class="text-lg font-normal text-primary-600" x-text="'/' + (plans[0]?.period || 'month')" data-gjs-type="text" data-gjs-name="plan-period-1">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" x-text="plans[0]?.features?.[0] || 'Basic Features'" data-gjs-type="text" data-gjs-name="feature-1-1">Basic Features</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" x-text="plans[0]?.features?.[1] || 'Email Support'" data-gjs-type="text" data-gjs-name="feature-1-2">Email Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" x-text="plans[0]?.features?.[2] || '5GB Storage'" data-gjs-type="text" data-gjs-name="feature-1-3">5GB Storage</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-primary-200 text-primary-900 hover:bg-accent hover:text-white transition-colors" 
                        @click="selectedPlan = plans[0]"
                        data-gjs-type="text" 
                        data-gjs-name="button-1">
                    <span x-text="selectedPlan === plans[0] ? 'Selected' : 'Get Started'">Get Started</span>
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
                    <h3 class="text-xl font-bold mb-4 text-primary-900" data-gjs-type="text" data-gjs-name="plan-name-2">
                        <span x-text="plans[1]?.name || 'Professional'">Professional</span>
                    </h3>
                    <div class="text-3xl font-bold mb-2 text-accent">
                        $<span x-text="plans[1]?.price || '199'" data-gjs-type="text" data-gjs-name="plan-price-2">199</span>
                        <span class="text-lg font-normal text-primary-600" x-text="'/' + (plans[1]?.period || 'month')" data-gjs-type="text" data-gjs-name="plan-period-2">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" x-text="plans[1]?.features?.[0] || 'All Starter Features'" data-gjs-type="text" data-gjs-name="feature-2-1">All Starter Features</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" x-text="plans[1]?.features?.[1] || 'Priority Support'" data-gjs-type="text" data-gjs-name="feature-2-2">Priority Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" x-text="plans[1]?.features?.[2] || '25GB Storage'" data-gjs-type="text" data-gjs-name="feature-2-3">25GB Storage</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" 
                        @click="selectedPlan = plans[1]"
                        data-gjs-type="text" 
                        data-gjs-name="button-2">
                    <span x-text="selectedPlan === plans[1] ? 'Selected' : 'Get Started'">Get Started</span>
                </button>
            </div>

            <!-- Enterprise Plan -->
            <div class="pricing-card relative p-6 rounded-lg shadow-lg bg-primary-100" 
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold mb-4 text-primary-900" data-gjs-type="text" data-gjs-name="plan-name-3">
                        <span x-text="plans[2]?.name || 'Enterprise'">Enterprise</span>
                    </h3>
                    <div class="text-3xl font-bold mb-2 text-accent">
                        $<span x-text="plans[2]?.price || '399'" data-gjs-type="text" data-gjs-name="plan-price-3">399</span>
                        <span class="text-lg font-normal text-primary-600" x-text="'/' + (plans[2]?.period || 'month')" data-gjs-type="text" data-gjs-name="plan-period-3">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" x-text="plans[2]?.features?.[0] || 'All Professional Features'" data-gjs-type="text" data-gjs-name="feature-3-1">All Professional Features</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" x-text="plans[2]?.features?.[1] || '24/7 Phone Support'" data-gjs-type="text" data-gjs-name="feature-3-2">24/7 Phone Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <span class="mr-3 text-lg text-accent">✓</span>
                        <span class="text-primary-700" x-text="plans[2]?.features?.[2] || 'Unlimited Storage'" data-gjs-type="text" data-gjs-name="feature-3-3">Unlimited Storage</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-lg font-semibold bg-primary-200 text-primary-900 hover:bg-accent hover:text-white transition-colors" 
                        @click="selectedPlan = plans[2]"
                        data-gjs-type="text" 
                        data-gjs-name="button-3">
                    <span x-text="selectedPlan === plans[2] ? 'Selected' : 'Get Started'">Get Started</span>
                </button>
            </div>
        </div>
        
        <!-- Plan Comparison -->
        <div class="mt-12 text-center">
            <p class="text-lg mb-4 text-primary-700" data-gjs-type="text" data-gjs-name="comparison-text">
                <span x-show="selectedPlan">You selected: <strong x-text="selectedPlan?.name || ''"></strong></span>
                <span x-show="!selectedPlan">Select a plan to get started</span>
            </p>
            <button x-show="selectedPlan" 
                    class="px-8 py-3 rounded-lg font-semibold bg-accent text-white hover:scale-105 transition-all" 
                    data-gjs-type="text" 
                    data-gjs-name="proceed-button"
                    x-text="selectedPlan ? 'Proceed with ' + (selectedPlan?.name || 'Plan') : 'Proceed with Plan'">
                Proceed with Plan
            </button>
        </div>
    </div>
</div>
@endif



