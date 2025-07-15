@php
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $height = $getHeight();
    $state = $getState();
    
    // Load blocks dynamically from BlockService
    $blockService = app(\App\Services\BlockService::class);
    $blocks = $blockService->getGrapesJsBlocks();

    $appCss = Vite::asset('resources/css/app.css');
    $siteCss = Vite::asset('resources/css/site.css');
    $grapesCss = Vite::asset('resources/css/filament-grapesjs-editor.css');
    $adminCss = Vite::asset('resources/css/filament/admin/theme.css');
    $utilitiesCss = asset('css/laralgrape-utilities.css');
    
    // Try to get the record (could be a model or a slug)
    $record = null;
    $pageId = null;
    $saveUrl = null;
    $isCreate = true;

    try {
        $record = $getRecord();
    } catch (\Throwable $e) {
        $record = null;
    }

    // If $record is a model, get the ID
    if (is_object($record) && method_exists($record, 'getKey')) {
        $pageId = $record->getKey();
        $isCreate = false;
    }
    // If $record is a string (slug), look up the page
    elseif (is_string($record)) {
        $page = \App\Models\Page::where('slug', $record)->first();
        if ($page) {
            $pageId = $page->id;
            $isCreate = false;
        }
    }

    if ($pageId) {
        $saveUrl = route('admin.page.save-grapesjs', $pageId);
    }
    
    // Debug information
    \Log::info('GrapesJS Editor Debug', [
        'record_exists' => $record ? 'yes' : 'no',
        'record_id' => $pageId,
        'isCreate' => $isCreate,
        'saveUrl' => $saveUrl,
        'statePath' => $statePath,
        'url' => request()->url(),
        'route_name' => request()->route()->getName() ?? 'unknown',
        'route_parameters' => request()->route()->parameters() ?? []
    ]);
@endphp
@php
    $tailwindConfig = \App\Models\TailwindConfig::getActive();
    $tailwindCssVars = $tailwindConfig ? $tailwindConfig->generateCss() : '';
    $appCss = Vite::asset('resources/css/app.css');
    $adminCss = Vite::asset('resources/css/filament/admin/theme.css');
    $utilitiesCssContent = file_exists(public_path('css/laralgrape-utilities.css')) ? file_get_contents(public_path('css/laralgrape-utilities.css')) : '';
@endphp
@if($tailwindConfig)
    <style>
        {!! $tailwindConfig->generateCss() !!}
    </style>
@endif

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div class="grapesjs-editor-wrapper" id="wrapper-{{ $id }}">
        <div class="grapesjs-controls">
            <button 
                type="button" 
                class="fullscreen-toggle-btn"
                title="Toggle Fullscreen Mode (Press Escape to exit)"
            >
                <svg class="fullscreen-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
                </svg>
                <svg class="exit-fullscreen-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                    <path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"/>
                </svg>
            </button>
            <button type="button" class="grapesjs-save-btn" style="margin: 10px 0; padding: 8px 18px; background: #9333ea; color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Save</button>
        </div>
        <div 
            id="{{ $id }}"
            class="grapesjs-editor"
            style="height: {{ $height }}; min-height: 400px; border: 1.5px solid #e5e7eb; background: #fff;"
            data-state-path="{{ $statePath }}"
            data-current-state="{{ json_encode($state) }}"
            data-height="{{ $height }}"
            data-disabled="{{ $isDisabled ? 'true' : 'false' }}"
            data-blocks="{{ json_encode($blocks) }}"
            data-page-id="{{ $pageId }}"
            data-save-url="{{ $saveUrl }}"
            data-is-create="{{ $isCreate ? 'true' : 'false' }}"
        >
        </div>
        {{ $getChildComponentContainer() }}
    </div>
    
    @push('scripts')
        <script type="module" src="{{ Vite::asset('resources/js/grapesjs-editor.js') }}"></script>
        <script>
            window.grapesjsCanvasStyles = [
                @json($appCss),
                @json($adminCss),
                `<style>{!! $utilitiesCssContent !!}</style>`,
                `<style>{{ $tailwindCssVars }}</style>`
            ];
            // Debug: Log the styles array before GrapesJS loads
            console.log('grapesjsCanvasStyles (backend):', window.grapesjsCanvasStyles);
        </script>
        <script>
            // Global function to sync GrapesJS data - can be called from anywhere
            window.syncGrapesJsData = function() {
                if (window.grapesjsEditorInstance) {
                    console.log('Global sync function called');
                    window.grapesjsEditorInstance.syncToFormBeforeSubmit();
                    return true;
                }
                return false;
            };

            document.addEventListener('DOMContentLoaded', function() {
                console.log('GrapesJS Editor initial data:', @json($state));
                
                const editor = new window.LaraGrapeGrapesJsEditor({
                    containerId: '{{ $id }}',
                    mode: 'backend',
                    statePath: '{{ $statePath }}',
                    blocks: @json($blocks),
                    initialData: @json($state),
                    isDisabled: {{ $isDisabled ? 'true' : 'false' }},
                    height: '{{ $height }}'
                });

                // Store the editor instance globally for access
                window.grapesjsEditorInstance = editor;

                // Additional Filament form submission handling
                const form = document.querySelector('form[wire\\:submit]');
                if (form) {
                    console.log('Filament form found, setting up additional handlers...');

                    // Method 1: Listen for Livewire events
                    document.addEventListener('livewire:load', function () {
                        if (window.Livewire) {
                            window.Livewire.on('form-submit', function () {
                                console.log('Livewire form-submit event detected');
                                if (window.grapesjsEditorInstance) {
                                    window.grapesjsEditorInstance.syncToFormBeforeSubmit();
                                }
                            });
                        }
                    });

                    // Method 2: Listen for Filament's wire:submit events
                    form.addEventListener('wire:submit', function (e) {
                        console.log('Wire submit event detected');
                        if (window.grapesjsEditorInstance) {
                            window.grapesjsEditorInstance.syncToFormBeforeSubmit();
                        }
                    });

                    // Method 3: Intercept all form submissions
                    const originalSubmit = form.submit;
                    form.submit = function(e) {
                        console.log('Form submit intercepted (original method)');
                        if (window.grapesjsEditorInstance) {
                            window.grapesjsEditorInstance.syncToFormBeforeSubmit();
                        }
                        return originalSubmit.call(this, e);
                    };

                    // Method 4: Listen for button clicks more aggressively
                    document.addEventListener('click', function(e) {
                        const target = e.target;
                        if (target && (
                            target.type === 'submit' ||
                            target.getAttribute('wire:click')?.includes('save') ||
                            target.getAttribute('wire:click')?.includes('create') ||
                            target.getAttribute('wire:click')?.includes('update') ||
                            target.textContent?.toLowerCase().includes('save') ||
                            target.textContent?.toLowerCase().includes('create') ||
                            target.textContent?.toLowerCase().includes('update')
                        )) {
                            const buttonForm = target.closest('form');
                            if (buttonForm === form) {
                                console.log('Save button clicked (enhanced detection)');
                                setTimeout(() => {
                                    if (window.grapesjsEditorInstance) {
                                        window.grapesjsEditorInstance.syncToFormBeforeSubmit();
                                    }
                                }, 50);
                            }
                        }
                    });

                    // Method 5: Use MutationObserver to detect form state changes
                    const observer = new MutationObserver(function(mutations) {
                        mutations.forEach(function(mutation) {
                            if (mutation.type === 'attributes') {
                                const element = mutation.target;
                                if (element.getAttribute('data-loading') === 'true' || 
                                    element.classList.contains('fi-loading') ||
                                    element.getAttribute('wire:loading') === 'true') {
                                    console.log('Loading state detected, syncing content...');
                                    if (window.grapesjsEditorInstance) {
                                        window.grapesjsEditorInstance.syncToFormBeforeSubmit();
                                    }
                                }
                            }
                        });
                    });

                    observer.observe(form, {
                        attributes: true,
                        attributeFilter: ['data-loading', 'wire:loading', 'class']
                    });

                    // Method 6: Periodic sync as backup
                    setInterval(function() {
                        if (window.grapesjsEditorInstance) {
                            window.grapesjsEditorInstance.updateFilamentFormState();
                        }
                    }, 3000);

                    // Method 7: Override Filament's form submission
                    if (window.Filament) {
                        const originalFormSubmit = window.Filament.forms?.submit;
                        if (originalFormSubmit) {
                            window.Filament.forms.submit = function(...args) {
                                console.log('Filament form submit intercepted');
                                if (window.grapesjsEditorInstance) {
                                    window.grapesjsEditorInstance.syncToFormBeforeSubmit();
                                }
                                return originalFormSubmit.apply(this, args);
                            };
                        }
                    }
                }
            });
        </script>
    @endpush
    
    <style>
        .grapesjs-editor-wrapper {
            width: 100%;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .grapesjs-editor-wrapper.fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 99999 !important;
            background: var(--grapey-primary-50, #fff);
            box-sizing: border-box;
            isolation: isolate;
        }
        
        .grapesjs-controls {
            position: absolute;
            top: 80px;
            left: 15px;
            z-index: 100000 !important;
            display: flex;
            gap: 8px;
        }
        
        .fullscreen-toggle-btn {
            background: var(--grapey-primary-500, #3b82f6);
            border: 2px solid var(--grapey-primary-500, #3b82f6);
            border-radius: 8px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100001 !important;
            position: relative;
            min-width: 44px;
            min-height: 44px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .fullscreen-toggle-btn:hover {
            background: var(--grapey-primary-600, #2563eb);
            border-color: var(--grapey-primary-600, #2563eb);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
            transform: translateY(-1px);
        }
        
        .fullscreen-toggle-btn svg {
            color: var(--grapey-primary-50, #fff);
            width: 20px;
            height: 20px;
        }
        
        .fullscreen-toggle-btn:hover svg {
            color: var(--grapey-primary-50, #fff);
        }
        
        .grapesjs-editor {
            border-radius: 8px;
            overflow: hidden;
            width: 100% !important;
            min-height: 400px;
            background: var(--grapey-primary-50, #ffffff);
            border: 1.5px solid var(--grapey-primary-200, #e5e7eb);
            transition: height 0.3s ease;
        }
        
        .grapesjs-editor-wrapper.fullscreen .grapesjs-editor {
            height: calc(100vh - 120px) !important;
            border-radius: 0;
            border: none;
            z-index: 99999 !important;
        }
        
        @media (max-width: 1024px) {
            .grapesjs-editor {
                min-height: 300px;
            }
        }
        
        @media (max-width: 768px) {
            .grapesjs-controls {
                top: 60px;
                left: 10px;
            }
            
            .fullscreen-toggle-btn {
                padding: 10px;
                min-width: 40px;
                min-height: 40px;
            }
            
            .fullscreen-toggle-btn svg {
                width: 18px;
                height: 18px;
            }
        }
    </style>
</x-dynamic-component>
