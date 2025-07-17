@php
        use Illuminate\Support\Facades\Blade;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $page->meta_title ?: $page->title }} - {{ config('app.name') }}</title>
    
    <!-- SEO Meta Tags -->
    @if($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}">
    @endif
    
    @if($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif
    
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $page->meta_title ?: $page->title }}">
    @if($page->meta_description)
        <meta property="og:description" content="{{ $page->meta_description }}">
    @endif
    @if($page->featured_image)
        <meta property="og:image" content="{{ Storage::url($page->featured_image) }}">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome for GrapesJS icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- GrapesJS CSS for frontend editor -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/grapesjs@0.22.8/dist/css/grapes.min.css">
    
    <!-- Vite Assets -->
    @vite([
        'resources/css/app.css', 
        'resources/js/app.js'
    ])
    
    @php
        $tailwindConfig = \App\Models\TailwindConfig::getActive();
        $tailwindCssVars = $tailwindConfig ? $tailwindConfig->generateCss() : '';
        $appCss = Vite::asset('resources/css/app.css');
        $utilitiesCss = asset('css/laralgrape-utilities.css');
        $utilitiesCssContent = file_exists(public_path('css/laralgrape-utilities.css')) ? file_get_contents(public_path('css/laralgrape-utilities.css')) : '';
    @endphp
    @if($tailwindConfig)
        <style>
            {!! $tailwindCssVars !!}
        </style>
    @endif
    
    <style>
        /* Only set min-height for the editor wrapper */
        .grapejs-editor-wrapper {
            min-height: 700px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/laralgrape-utilities.css') }}">
</head>
<body class="bg-gradient-to-br from-primary-50 via-white to-secondary/10 text-primary-900 antialiased min-h-screen flex flex-col dark:bg-black dark:text-primary-50" x-data="siteLayout()">
    @if(auth()->check())
        @include('components.layout.grapejs-edit-bar')
    @endif

    @include('components.layout.header')

    <!-- Main Content -->
    <main class="flex-1 flex flex-col bg-primary-50 dark:bg-primary-900 px-4">
        <!-- Page Content -->
        <div class="page-content flex-1 py-8 bg-primary-50 dark:bg-primary-900 transition-colors">
            @if (!empty($page->blade_content))
                {!! Blade::render($page->blade_content, ['page' => $page]) !!}
           
            @endif
        </div>
        
        @if(auth()->check())
            <!-- GrapesJS Editor Container (hidden by default) -->
            <div class="grapejs-editor-wrapper" style="display:none; min-height: 700px;">
                <div id="grapejs-frontend-editor" style="min-height: 700px;"></div>
            </div>
        @endif
    </main>

    @include('components.layout.footer')

    <script>
        window.grapesjsCanvasStyles = [
            @json($appCss),
            `<style>{!! $utilitiesCssContent !!}</style>`,
            `<style>{!! $tailwindCssVars !!}</style>`
        ];
        // Debug: Log the styles array before GrapesJS loads
        console.log('grapesjsCanvasStyles:', window.grapesjsCanvasStyles);
    </script>
    @if(auth()->check())
        @php
            $blockService = app(\App\Services\BlockService::class);
            $grapesjsBlocks = $blockService->getGrapesJsBlocks();
        @endphp
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/grapesjs@0.22.8/dist/css/grapes.min.css">
        <script src="https://unpkg.com/grapesjs@0.22.8/dist/grapes.min.js"></script>
        <script type="module" src="{{ Vite::asset('resources/js/grapesjs-editor.js') }}"></script>
        <script>
            window.grapesjsBlocks = @json($grapesjsBlocks);
            window.pageGrapesjsData = @json($editingData ?? []);
            window.saveGrapesjsUrl = "{{ route('page.save-grapesjs', ['slug' => $page->slug]) }}";
            function initializeFrontendEditor() {
                if (typeof grapesjs !== 'undefined' && typeof window.LaraGrapeGrapesJsEditor !== 'undefined') {
                    window.frontendGrapesJsEditor = new window.LaraGrapeGrapesJsEditor({
                        containerId: 'grapejs-frontend-editor',
                        mode: 'frontend',
                        saveUrl: window.saveGrapesjsUrl,
                        blocks: window.grapesjsBlocks,
                        initialData: window.pageGrapesjsData
                    });
                } else {
                    setTimeout(initializeFrontendEditor, 200);
                }
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeFrontendEditor);
            } else {
                initializeFrontendEditor();
            }
        </script>
    @endif
</body>
</html> 