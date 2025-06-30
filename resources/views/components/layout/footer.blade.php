@php
    $siteSettings = app(\App\Services\SiteSettingsService::class);
    $footerSettings = $siteSettings->getFooterSettings();
    $socialSettings = $siteSettings->getSocialSettings();
    $generalSettings = $siteSettings->getGeneralSettings();
@endphp

<footer class="site-footer bg-gray-900 text-white" 
        style="background-color: {{ $footerSettings['background_color'] }}; color: {{ $footerSettings['text_color'] }};">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <!-- Brand/Logo Section -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-2 mb-4">
                    @if($footerSettings['logo_image'])
                        <img src="{{ Storage::url($footerSettings['logo_image']) }}" 
                             alt="{{ $generalSettings['site_name'] }}" 
                             class="h-8 w-auto">
                    @else
                        <div class="text-2xl font-bold text-purple-400">
                            {{ $footerSettings['logo_text'] }}
                        </div>
                    @endif
                </div>
                
                <p class="text-gray-300 mb-6 max-w-md">
                    {{ $generalSettings['site_description'] }}
                </p>
                
                <!-- Contact Info -->
                <div class="space-y-2 text-sm text-gray-300">
                    @if($generalSettings['contact_email'])
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:{{ $generalSettings['contact_email'] }}" class="hover:text-white transition-colors">
                                {{ $generalSettings['contact_email'] }}
                            </a>
                        </div>
                    @endif
                    
                    @if($generalSettings['contact_phone'])
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="tel:{{ $generalSettings['contact_phone'] }}" class="hover:text-white transition-colors">
                                {{ $generalSettings['contact_phone'] }}
                            </a>
                        </div>
                    @endif
                    
                    @if($generalSettings['address'])
                        <div class="flex items-start space-x-2">
                            <svg class="w-4 h-4 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $generalSettings['address'] }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    @foreach(\Streats22\LaraGrape\Models\Page::inMenu()->take(5)->get() as $menuPage)
                        <li>
                            <a href="{{ route('page.show', $menuPage->slug) }}" 
                               class="text-gray-300 hover:text-white transition-colors">
                                {{ $menuPage->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Social Links -->
            @if($footerSettings['show_social'])
                <div>
                    <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        @if($socialSettings['facebook'])
                            <a href="{{ $socialSettings['facebook'] }}" target="_blank" rel="noopener" 
                               class="text-gray-300 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                        @endif
                        
                        @if($socialSettings['twitter'])
                            <a href="{{ $socialSettings['twitter'] }}" target="_blank" rel="noopener" 
                               class="text-gray-300 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                        @endif
                        
                        @if($socialSettings['instagram'])
                            <a href="{{ $socialSettings['instagram'] }}" target="_blank" rel="noopener" 
                               class="text-gray-300 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.418-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.928.875 1.418 2.026 1.418 3.323s-.49 2.448-1.418 3.244c-.875.807-2.026 1.297-3.323 1.297zm7.83-9.781c-.49 0-.928-.175-1.297-.49-.368-.315-.49-.753-.49-1.243 0-.49.122-.928.49-1.243.369-.315.807-.49 1.297-.49s.928.175 1.297.49c.368.315.49.753.49 1.243 0 .49-.122.928-.49 1.243-.369.315-.807.49-1.297.49z"/>
                                </svg>
                            </a>
                        @endif
                        
                        @if($socialSettings['linkedin'])
                            <a href="{{ $socialSettings['linkedin'] }}" target="_blank" rel="noopener" 
                               class="text-gray-300 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        @endif
                        
                        @if($socialSettings['github'])
                            <a href="{{ $socialSettings['github'] }}" target="_blank" rel="noopener" 
                               class="text-gray-300 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Newsletter Signup (if enabled) -->
        @if($footerSettings['show_newsletter'])
            <div class="mt-8 pt-8 border-t border-gray-700">
                <div class="max-w-md">
                    <h3 class="text-lg font-semibold mb-4">Stay Updated</h3>
                    <form class="flex space-x-2">
                        <input type="email" 
                               placeholder="Enter your email" 
                               class="flex-1 px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-white placeholder-gray-400">
                        <button type="submit" 
                                class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        @endif
        
        <!-- Copyright -->
        <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
            <div class="text-sm">
                {!! $footerSettings['content'] !!}
            </div>
        </div>
    </div>
</footer>

@if($footerSettings['custom_css'])
<style>
{!! $footerSettings['custom_css'] !!}
</style>
@endif 