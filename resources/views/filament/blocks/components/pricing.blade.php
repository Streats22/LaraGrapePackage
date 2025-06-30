{{-- @block id="pricing" label="Pricing Table" description="A pricing table block for displaying plans and packages" --}}
<div class="pricing-block bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <h3 class="text-3xl font-bold text-center mb-12" data-gjs-type="text" data-gjs-name="pricing-title">Choose Your Plan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Basic Plan -->
            <div class="bg-white rounded-lg shadow-lg p-8 border-2 border-gray-200">
                <h4 class="text-2xl font-bold mb-4" data-gjs-type="text" data-gjs-name="plan-name-1">Basic</h4>
                <div class="mb-6">
                    <span class="text-4xl font-bold text-gray-900" data-gjs-type="text" data-gjs-name="plan-price-1">$29</span>
                    <span class="text-gray-600" data-gjs-type="text" data-gjs-name="plan-period-1">/month</span>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span data-gjs-type="text" data-gjs-name="plan-feature-1-1">Feature 1</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span data-gjs-type="text" data-gjs-name="plan-feature-1-2">Feature 2</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span data-gjs-type="text" data-gjs-name="plan-feature-1-3">Feature 3</span>
                    </li>
                </ul>
                <button class="w-full bg-gray-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-700 transition-colors" data-gjs-type="text" data-gjs-name="plan-button-1">Get Started</button>
            </div>

            <!-- Pro Plan -->
            <div class="bg-white rounded-lg shadow-lg p-8 border-2 border-blue-500 relative transform scale-105">
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <span class="bg-blue-500 text-white px-4 py-1 rounded-full text-sm font-semibold" data-gjs-type="text" data-gjs-name="popular-badge">Most Popular</span>
                </div>
                <h4 class="text-2xl font-bold mb-4" data-gjs-type="text" data-gjs-name="plan-name-2">Pro</h4>
                <div class="mb-6">
                    <span class="text-4xl font-bold text-gray-900" data-gjs-type="text" data-gjs-name="plan-price-2">$79</span>
                    <span class="text-gray-600" data-gjs-type="text" data-gjs-name="plan-period-2">/month</span>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span data-gjs-type="text" data-gjs-name="plan-feature-2-1">Everything in Basic</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span data-gjs-type="text" data-gjs-name="plan-feature-2-2">Advanced Feature 1</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span data-gjs-type="text" data-gjs-name="plan-feature-2-3">Advanced Feature 2</span>
                    </li>
                </ul>
                <button class="w-full bg-blue-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-600 transition-colors" data-gjs-type="text" data-gjs-name="plan-button-2">Get Started</button>
            </div>

            <!-- Enterprise Plan -->
            <div class="bg-white rounded-lg shadow-lg p-8 border-2 border-gray-200">
                <h4 class="text-2xl font-bold mb-4" data-gjs-type="text" data-gjs-name="plan-name-3">Enterprise</h4>
                <div class="mb-6">
                    <span class="text-4xl font-bold text-gray-900" data-gjs-type="text" data-gjs-name="plan-price-3">$199</span>
                    <span class="text-gray-600" data-gjs-type="text" data-gjs-name="plan-period-3">/month</span>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span data-gjs-type="text" data-gjs-name="plan-feature-3-1">Everything in Pro</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span data-gjs-type="text" data-gjs-name="plan-feature-3-2">Enterprise Feature 1</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span data-gjs-type="text" data-gjs-name="plan-feature-3-3">Enterprise Feature 2</span>
                    </li>
                </ul>
                <button class="w-full bg-gray-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-700 transition-colors" data-gjs-type="text" data-gjs-name="plan-button-3">Contact Sales</button>
            </div>
        </div>
    </div>
</div> 