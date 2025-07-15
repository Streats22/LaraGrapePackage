@php
    $siteSettings = app(\App\Services\SiteSettingsService::class);
    $headerSettings = $siteSettings->getHeaderSettings();
    $generalSettings = $siteSettings->getGeneralSettings();
@endphp

<header class="site-header bg-primary-50 dark:bg-primary-900 shadow-lg border-b-2 border-primary-200 text-primary-900 dark:text-primary-100 dark:border-primary-800">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    @if($headerSettings['logo_image'])
                        <img src="{{ Storage::url($headerSettings['logo_image']) }}" 
                             alt="{{ $generalSettings['site_name'] }}" 
                             class="h-8 w-auto">
                    @else
                        <div class="text-2xl font-bold text-primary-600 dark:text-primary-100">
                            {{ $headerSettings['logo_text'] }}
                        </div>
                    @endif
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-8">
                @foreach(\App\Models\Page::inMenu()->get() as $menuPage)
                    <a href="{{ route('page.show', $menuPage->slug) }}" 
                       class="text-primary-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 dark:text-primary-100 dark:hover:text-primary-300 no-underline hover:no-underline">
                        {{ $menuPage->title }}
                    </a>
                @endforeach
            </nav>

            <!-- Right side items -->
            <div class="flex items-center space-x-4">
                
                <!-- Search (if enabled) -->
                @if($headerSettings['show_search'])
                    <div class="relative">
                        <input type="text" 
                               placeholder="Search..." 
                               class="w-64 pl-10 pr-4 py-2 border border-primary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                @endif

                <!-- Dark Mode Toggle -->
                <button x-data="{ dark: (localStorage.getItem('theme') === 'dark') }"
                  @click="dark = !dark; if(dark){ document.documentElement.classList.add('dark'); localStorage.setItem('theme', 'dark'); } else { document.documentElement.classList.remove('dark'); localStorage.setItem('theme', 'light'); }"
                  :class="dark ? 'bg-primary-700 text-primary-50' : 'bg-primary-100 text-primary-700'"
                  class="transition-colors px-3 py-2 rounded-lg text-sm font-medium focus:outline-none border border-primary-300 flex items-center gap-2"
                  title="Toggle dark mode">
                    <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-13.66l-.71.71M4.05 19.07l-.71.71M21 12h-1M4 12H3m16.66 5.66l-.71-.71M4.05 4.93l-.71-.71M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" /></svg>
                </button>

                <!-- Admin Link (if authenticated) -->
                @auth
                    <a href="{{ route('filament.admin.pages.dashboard') }}" 
                       class="bg-primary-600 hover:bg-primary-700 text-primary-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                        Admin
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="text-primary-700 hover:text-primary-600 focus:outline-none focus:text-primary-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden border-t border-primary-200">
        <div class="px-2 pt-2 pb-3 space-y-1">
            @foreach(\App\Models\Page::inMenu()->get() as $menuPage)
                <a href="{{ route('page.show', $menuPage->slug) }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-primary-700 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 dark:text-primary-100 dark:hover:text-primary-300 dark:hover:bg-primary-900">
                    {{ $menuPage->title }}
                </a>
            @endforeach
            
            @auth
                <a href="{{ route('filament.admin.pages.dashboard') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium bg-primary-600 text-primary-50 hover:bg-primary-700 transition-colors duration-200">
                    Admin Panel
                </a>
            @endauth
        </div>
    </div>
</header>

@if($headerSettings['custom_css'])
<style>
{!! $headerSettings['custom_css'] !!}
</style>
@endif 