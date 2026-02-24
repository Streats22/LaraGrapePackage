{{-- @block id="interactive-pricing" label="Interactive Pricing" description="Interactive pricing table with hover effects and animations" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="interactive-pricing-block py-16" style="background-color: var(--laralgrape-primary-50);" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4" style="color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="pricing-title">Choose Your Plan</h2>
            <p class="text-lg mb-8" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="pricing-subtitle">Flexible pricing options tailored to your business needs</p>
            
            <!-- Billing Toggle -->
            <div class="flex items-center justify-center space-x-4 mb-8">
                <span class="text-sm font-medium" style="color: var(--laralgrape-primary-700);">Monthly</span>
                <button class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200"
                        style="background-color: var(--laralgrape-primary-300);">
                    <span class="inline-block h-4 w-4 transform rounded-full transition-transform duration-200"
                          style="background-color: var(--laralgrape-primary-50);"></span>
                </button>
                <span class="text-sm font-medium" style="color: var(--laralgrape-primary-700);">Yearly</span>
                <span class="px-2 py-1 text-xs font-semibold rounded-full" style="background-color: var(--laralgrape-accent); color: var(--laralgrape-primary-900);">Save 20%</span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Starter Plan -->
            <div class="pricing-card relative p-8 rounded-2xl shadow-lg transition-all duration-500 hover:scale-105 hover:shadow-2xl"
                 style="background-color: var(--laralgrape-primary-50);"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                
                <!-- Plan Header -->
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold mb-2" style="color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="plan-name-1">Starter</h3>
                    <p class="text-sm mb-6" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="plan-description-1">Perfect for small businesses and startups</p>
                    
                    <!-- Price -->
                    <div class="mb-6">
                        <div class="flex items-baseline justify-center">
                            <span class="text-4xl font-bold" style="color: var(--laralgrape-accent);">
                                $<span data-gjs-type="text" data-gjs-name="plan-price-1">2999</span>
                            </span>
                            <span class="text-lg ml-1" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="plan-period-1">/month</span>
                        </div>
                    </div>
                </div>
                
                <!-- Features -->
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-1-1">Custom Web Application</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-1-2">Responsive Design</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-1-3">Basic SEO Setup</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-1-4">1 Month Support</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-1-5">Hosting Setup</span>
                    </li>
                </ul>
                
                <!-- CTA Button -->
                <button class="w-full py-3 px-6 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-md"
                        style="background-color: var(--laralgrape-primary-700); color: var(--laralgrape-primary-50);"
                        data-gjs-type="text" data-gjs-name="button-1">
                    Get Started
                </button>
            </div>

            <!-- Professional Plan -->
            <div class="pricing-card relative p-8 rounded-2xl shadow-lg transition-all duration-500 hover:scale-105 hover:shadow-2xl ring-4"
                 style="border-color: var(--laralgrape-accent); background-color: var(--laralgrape-primary-100);"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                
                <!-- Popular Badge -->
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 px-4 py-2 rounded-full text-sm font-bold"
                     style="background-color: var(--laralgrape-accent); color: var(--laralgrape-primary-900);">
                    Most Popular
                </div>
                
                <!-- Plan Header -->
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold mb-2" style="color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="plan-name-2">Professional</h3>
                    <p class="text-sm mb-6" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="plan-description-2">Ideal for growing businesses with advanced needs</p>
                    
                    <!-- Price -->
                    <div class="mb-6">
                        <div class="flex items-baseline justify-center">
                            <span class="text-4xl font-bold" style="color: var(--laralgrape-accent);">
                                $<span data-gjs-type="text" data-gjs-name="plan-price-2">5999</span>
                            </span>
                            <span class="text-lg ml-1" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="plan-period-2">/month</span>
                        </div>
                    </div>
                </div>
                
                <!-- Features -->
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-2-1">Everything in Starter</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-2-2">Mobile App Development</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-2-3">Advanced SEO & Analytics</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-2-4">3 Months Support</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-2-5">Database Design</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-2-6">API Integration</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-2-7">Performance Optimization</span>
                    </li>
                </ul>
                
                <!-- CTA Button -->
                <button class="w-full py-3 px-6 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg"
                        style="background-color: var(--laralgrape-accent); color: var(--laralgrape-primary-900);"
                        data-gjs-type="text" data-gjs-name="button-2">
                    Get Started
                </button>
            </div>

            <!-- Enterprise Plan -->
            <div class="pricing-card relative p-8 rounded-2xl shadow-lg transition-all duration-500 hover:scale-105 hover:shadow-2xl"
                 style="background-color: var(--laralgrape-primary-50);"
                 data-gjs-type="default" 
                 data-gjs-droppable="false">
                
                <!-- Plan Header -->
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold mb-2" style="color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="plan-name-3">Enterprise</h3>
                    <p class="text-sm mb-6" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="plan-description-3">Complete solution for large-scale projects</p>
                    
                    <!-- Price -->
                    <div class="mb-6">
                        <div class="flex items-baseline justify-center">
                            <span class="text-4xl font-bold" style="color: var(--laralgrape-accent);">
                                $<span data-gjs-type="text" data-gjs-name="plan-price-3">12999</span>
                            </span>
                            <span class="text-lg ml-1" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="plan-period-3">/month</span>
                        </div>
                    </div>
                </div>
                
                <!-- Features -->
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-3-1">Everything in Professional</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-3-2">Custom AI/ML Integration</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-3-3">Advanced Security</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-3-4">12 Months Support</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-3-5">Cloud Infrastructure</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-3-6">Scalability Planning</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-3-7">24/7 Monitoring</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" style="color: var(--laralgrape-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="feature-3-8">Dedicated Project Manager</span>
                    </li>
                </ul>
                
                <!-- CTA Button -->
                <button class="w-full py-3 px-6 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-md"
                        style="background-color: var(--laralgrape-primary-700); color: var(--laralgrape-primary-50);"
                        data-gjs-type="text" data-gjs-name="button-3">
                    Get Started
                </button>
            </div>
        </div>
    </div>
</div>
@else
<div class="interactive-pricing-block py-16" style="background-color: var(--laralgrape-primary-50);" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data="{ 
         plans: [
             {
                 name: 'Starter',
                 price: 2999,
                 period: 'month',
                 description: 'Perfect for small businesses and startups',
                 features: [
                     'Custom Web Application',
                     'Responsive Design',
                     'Basic SEO Setup',
                     '1 Month Support',
                     'Hosting Setup'
                 ],
                 popular: false,
                 color: 'var(--laralgrape-primary-600)'
             },
             {
                 name: 'Professional',
                 price: 5999,
                 period: 'month',
                 description: 'Ideal for growing businesses with advanced needs',
                 features: [
                     'Everything in Starter',
                     'Mobile App Development',
                     'Advanced SEO & Analytics',
                     '3 Months Support',
                     'Database Design',
                     'API Integration',
                     'Performance Optimization'
                 ],
                 popular: true,
                 color: 'var(--laralgrape-accent)'
             },
             {
                 name: 'Enterprise',
                 price: 12999,
                 period: 'month',
                 description: 'Complete solution for large-scale projects',
                 features: [
                     'Everything in Professional',
                     'Custom AI/ML Integration',
                     'Advanced Security',
                     '12 Months Support',
                     'Cloud Infrastructure',
                     'Scalability Planning',
                     '24/7 Monitoring',
                     'Dedicated Project Manager'
                 ],
                 popular: false,
                 color: 'var(--laralgrape-primary-800)'
             }
         ],
         selectedPlan: null,
         showYearly: false
     }">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-4" style="color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="pricing-title">Choose Your Plan</h2>
            <p class="text-lg mb-8" style="color: var(--laralgrape-primary-700);" data-gjs-type="text" data-gjs-name="pricing-subtitle">Flexible pricing options tailored to your business needs</p>
            
            <!-- Billing Toggle -->
            <div class="flex items-center justify-center space-x-4 mb-8">
                <span class="text-sm font-medium" style="color: var(--laralgrape-primary-700);">Monthly</span>
                <button @click="showYearly = !showYearly" 
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200"
                        :class="showYearly ? 'bg-accent' : 'bg-gray-300'"
                        style="background-color: var(--laralgrape-primary-300);">
                    <span class="inline-block h-4 w-4 transform rounded-full transition-transform duration-200"
                          :class="showYearly ? 'translate-x-6' : 'translate-x-1'"
                          style="background-color: var(--laralgrape-primary-50);"></span>
                </button>
                <span class="text-sm font-medium" style="color: var(--laralgrape-primary-700);">Yearly</span>
                <span class="px-2 py-1 text-xs font-semibold rounded-full" style="background-color: var(--laralgrape-accent); color: var(--laralgrape-primary-900);">Save 20%</span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <template x-for="(plan, index) in plans" :key="index">
                <div class="pricing-card relative p-8 rounded-2xl shadow-lg transition-all duration-500 hover:scale-105 hover:shadow-2xl"
                     :class="plan.popular ? 'ring-4' : ''"
                     :style="plan.popular ? 'border-color: var(--laralgrape-accent); background-color: var(--laralgrape-primary-100);' : 'background-color: var(--laralgrape-primary-50);'"
                     data-gjs-type="default" 
                     data-gjs-droppable="false"
                     @mouseenter="selectedPlan = index"
                     @mouseleave="selectedPlan = null">
                    
                    <!-- Popular Badge -->
                    <div x-show="plan.popular" 
                         class="absolute -top-4 left-1/2 transform -translate-x-1/2 px-4 py-2 rounded-full text-sm font-bold"
                         style="background-color: var(--laralgrape-accent); color: var(--laralgrape-primary-900);">
                        Most Popular
                    </div>
                    
                    <!-- Plan Header -->
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold mb-2" style="color: var(--laralgrape-primary-900);" x-text="plan.name"></h3>
                        <p class="text-sm mb-6" style="color: var(--laralgrape-primary-700);" x-text="plan.description"></p>
                        
                        <!-- Price -->
                        <div class="mb-6">
                            <div class="flex items-baseline justify-center">
                                <span class="text-4xl font-bold" style="color: var(--laralgrape-accent);">
                                    $<span x-text="showYearly ? Math.round(plan.price * 0.8) : plan.price"></span>
                                </span>
                                <span class="text-lg ml-1" style="color: var(--laralgrape-primary-700);" x-text="'/' + (showYearly ? 'year' : plan.period)"></span>
                            </div>
                            <p x-show="showYearly" class="text-sm mt-1" style="color: var(--laralgrape-primary-600);">
                                <span x-text="'$' + Math.round(plan.price * 0.8 / 12)"></span> per month
                            </p>
                        </div>
                    </div>
                    
                    <!-- Features -->
                    <ul class="space-y-4 mb-8">
                        <template x-for="feature in plan.features" :key="feature">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 flex-shrink-0 transition-transform duration-300"
                                     :class="selectedPlan === index ? 'scale-110' : 'scale-100'"
                                     style="color: var(--laralgrape-accent);" 
                                     fill="none" 
                                     stroke="currentColor" 
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm" style="color: var(--laralgrape-primary-700);" x-text="feature"></span>
                            </li>
                        </template>
                    </ul>
                    
                    <!-- CTA Button -->
                    <button class="w-full py-3 px-6 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105"
                            :class="plan.popular ? 'shadow-lg' : 'shadow-md'"
                            :style="plan.popular ? 'background-color: var(--laralgrape-accent); color: var(--laralgrape-primary-900);' : 'background-color: var(--laralgrape-primary-700); color: var(--laralgrape-primary-50);'">
                        Get Started
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>
@endif 