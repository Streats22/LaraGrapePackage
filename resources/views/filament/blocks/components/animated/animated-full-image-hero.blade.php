{{-- @block id="animated-full-image-hero" label="Animated Full Image Hero" description="Full-viewport hero: pick a background image (hero background component), gradients + animated orbs, scroll-triggered text/buttons (same data contract as Animated Hero)" --}}
@php
    $isEditorPreview = $isEditorPreview ?? false;
    $baseHeroData = [
        'title' => 'Before they sold out<br class="hidden md:inline-block">readymade gluten',
        'description' => 'Copper mug try-hard pitchfork pour-over freegan heirloom neutra air plant cold-pressed tacos poke beard tote bag.',
        'primaryButton' => ['text' => 'Button', 'visible' => false, 'delay' => 600],
        'secondaryButton' => ['text' => 'Button', 'visible' => false, 'delay' => 700],
        'image' => ['src' => 'https://images.unsplash.com/photo-1557683316-973673baf926?w=1920&q=80', 'alt' => 'Hero background', 'visible' => false, 'delay' => 0],
        'titleClass' => '',
        'titleStyle' => '',
        'descriptionClass' => '',
        'descriptionStyle' => '',
        'primaryButtonClass' => '',
        'primaryButtonStyle' => '',
        'secondaryButtonClass' => '',
        'secondaryButtonStyle' => '',
        'imageClass' => '',
        'imageStyle' => '',
        'titleVisible' => false,
        'titleDelay' => 0,
        'descriptionVisible' => false,
        'descriptionDelay' => 200,
    ];
@endphp
@if($isEditorPreview)
<section class="relative min-h-[70vh] w-full overflow-hidden bg-zinc-900 dark:bg-black text-white flex items-center justify-center px-6 py-20" data-laragrape-block="animated-full-image-hero">
    <img
        class="absolute inset-0 h-full w-full object-cover opacity-45"
        src="{{ data_get($baseHeroData, 'image.src') }}"
        alt="{{ data_get($baseHeroData, 'image.alt') }}"
        width="1920"
        height="1080"
        data-gjs-type="image"
        data-gjs-name="hero-background-image"
    />
    <div class="absolute inset-0 bg-gradient-to-b from-zinc-950/75 via-zinc-900/50 to-zinc-950/80 dark:from-black/85 dark:via-zinc-950/70 dark:to-black/90 pointer-events-none"></div>
    <div class="relative z-10 max-w-3xl text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4" data-gjs-type="text" data-gjs-name="hero-title">{!! data_get($baseHeroData, 'title') !!}</h1>
        <p class="text-lg text-white/90 mb-8" data-gjs-type="text" data-gjs-name="hero-description">{{ data_get($baseHeroData, 'description') }}</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <button class="px-6 py-3 rounded-lg bg-primary-500 dark:bg-primary-600 text-white font-semibold" data-gjs-type="default" data-gjs-name="hero-button-primary">{{ data_get($baseHeroData, 'primaryButton.text') }}</button>
            <button class="px-6 py-3 rounded-lg bg-white/15 dark:bg-white/10 border border-white/30 dark:border-white/40 font-semibold" data-gjs-type="default" data-gjs-name="hero-button-secondary">{{ data_get($baseHeroData, 'secondaryButton.text') }}</button>
        </div>
    </div>
</section>
@else
@php
    $dynamicData = $dynamicData ?? [];
    $defaultHeroData = $baseHeroData;

    $dynamicHero = $dynamicData['hero'] ?? null;

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
        foreach ([
            'titleClass',
            'titleStyle',
            'descriptionClass',
            'descriptionStyle',
            'primaryButtonClass',
            'primaryButtonStyle',
            'secondaryButtonClass',
            'secondaryButtonStyle',
            'imageClass',
            'imageStyle',
        ] as $styleKey) {
            if (isset($dynamicHero[$styleKey]) && is_string($dynamicHero[$styleKey])) {
                $defaultHeroData[$styleKey] = $dynamicHero[$styleKey];
            }
        }
    }
    $titleBaseClass = 'text-4xl md:text-5xl font-bold mb-4 drop-shadow-md transition-all duration-1000 ease-[cubic-bezier(0.34,1.56,0.64,1)] will-change-transform';
    $descriptionBaseClass = 'text-lg text-white/90 mb-8 transition-all duration-1000 ease-[cubic-bezier(0.16,1,0.3,1)] will-change-transform';
    $primaryButtonBaseClass = 'px-6 py-3 rounded-lg bg-primary-500 text-white font-semibold transition-all duration-800 ease-[cubic-bezier(0.34,1.56,0.64,1)] will-change-transform relative overflow-hidden group';
    $secondaryButtonBaseClass = 'px-6 py-3 rounded-lg bg-white/15 border border-white/30 font-semibold transition-all duration-800 ease-[cubic-bezier(0.34,1.56,0.64,1)] will-change-transform relative overflow-hidden group';
    $imageBaseClass = 'absolute inset-0 h-full w-full object-cover opacity-45 full-image-hero-bg-zoom will-change-transform';
    $titleClass = trim((string) data_get($defaultHeroData, 'titleClass', ''));
    $descriptionClass = trim((string) data_get($defaultHeroData, 'descriptionClass', ''));
    $primaryButtonClass = trim((string) data_get($defaultHeroData, 'primaryButtonClass', ''));
    $secondaryButtonClass = trim((string) data_get($defaultHeroData, 'secondaryButtonClass', ''));
    $imageClass = trim((string) data_get($defaultHeroData, 'imageClass', ''));
    $titleClass = trim($titleBaseClass.' '.$titleClass);
    $descriptionClass = trim($descriptionBaseClass.' '.$descriptionClass);
    $primaryButtonClass = trim($primaryButtonBaseClass.' '.$primaryButtonClass);
    $secondaryButtonClass = trim($secondaryButtonBaseClass.' '.$secondaryButtonClass);
    $imageClass = trim($imageBaseClass.' '.$imageClass);
    $heroAlpineState = ['hero' => $defaultHeroData, 'animated' => false];
@endphp
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-18px) rotate(2deg); }
    }
    @keyframes floatReverse {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(18px) rotate(-2deg); }
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.06); opacity: 0.88; }
    }
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
    @keyframes slideInLeft {
        0% { transform: translateX(-80px) scale(0.92); opacity: 0; }
        100% { transform: translateX(0) scale(1); opacity: 1; }
    }
    @keyframes slideInUp {
        0% { transform: translateY(40px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
    @keyframes slowZoom {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.04); }
    }
    .full-image-hero-float { animation: float 7s ease-in-out infinite; }
    .full-image-hero-float-reverse { animation: floatReverse 9s ease-in-out infinite; }
    .full-image-hero-pulse { animation: pulse 4s ease-in-out infinite; }
    .full-image-hero-shimmer {
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        background-size: 1000px 100%;
        animation: shimmer 3s infinite;
    }
    .full-image-hero-title {
        animation: slideInLeft 1s ease-out forwards, float 9s ease-in-out 1s infinite;
    }
    .full-image-hero-cta { animation: pulse 2.2s ease-in-out infinite; }
    .full-image-hero-bg-zoom { animation: slowZoom 22s ease-in-out infinite; }
</style>
<section
    class="relative isolate -mt-8 min-h-[100svh] w-screen max-w-none left-1/2 -translate-x-1/2 overflow-hidden bg-zinc-900 dark:bg-black text-white flex items-center justify-center px-6 py-20 body-font"
    data-gjs-type="default"
    data-gjs-draggable="true"
    data-gjs-droppable="false"
    data-laragrape-block="animated-full-image-hero"
    x-data='@json($heroAlpineState)'
    x-init="
        $nextTick(() => {
            const reveal = () => {
                if (!hero || animated) return;
                animated = true;
                setTimeout(() => { hero.titleVisible = true; }, hero.titleDelay ? hero.titleDelay : 0);
                setTimeout(() => { hero.descriptionVisible = true; }, hero.descriptionDelay ? hero.descriptionDelay : 200);
                if (hero.image) setTimeout(() => { hero.image.visible = true; }, hero.image.delay || 0);
                if (hero.primaryButton) setTimeout(() => { hero.primaryButton.visible = true; }, hero.primaryButton.delay || 600);
                if (hero.secondaryButton) setTimeout(() => { hero.secondaryButton.visible = true; }, hero.secondaryButton.delay || 700);
            };
            if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
                reveal();
            } else {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => { if (entry.isIntersecting) reveal(); });
                }, { threshold: 0, rootMargin: '0px' });
                observer.observe($el);
                requestAnimationFrame(() => {
                    const r = $el.getBoundingClientRect();
                    if (r.top < window.innerHeight && r.bottom > 0) reveal();
                });
                setTimeout(() => { if (!animated) reveal(); }, 400);
            }
        });
    ">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <img
            class="{{ $imageClass }}"
            @if(data_get($defaultHeroData, 'imageStyle')) style="{{ data_get($defaultHeroData, 'imageStyle') }}" @endif
            alt="{{ data_get($defaultHeroData, 'image.alt', 'Hero background') }}"
            src="{{ data_get($defaultHeroData, 'image.src', 'https://images.unsplash.com/photo-1557683316-973673baf926?w=1920&q=80') }}"
            width="1920"
            height="1080"
            loading="eager"
            fetchpriority="high"
            data-gjs-type="image"
            data-gjs-name="hero-background-image"
        />
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-950/75 via-zinc-900/50 to-zinc-950/80 dark:from-black/85 dark:via-zinc-950/70 dark:to-black/90"></div>
    </div>

    <div class="relative z-10 max-w-3xl text-center">
            <h1
                class="{{ $titleClass }}"
                @if(data_get($defaultHeroData, 'titleStyle')) style="{{ data_get($defaultHeroData, 'titleStyle') }}" @endif
                :class="hero && hero.titleVisible ? 'opacity-100 translate-x-0 translate-y-0 scale-100 blur-0 full-image-hero-title' : 'opacity-0 -translate-x-10 translate-y-4 scale-95 blur-sm'"
                data-gjs-type="text"
                data-gjs-name="hero-title">
                {!! data_get($defaultHeroData, 'title', 'Before they sold out<br class="hidden md:inline-block">readymade gluten') !!}
            </h1>
            <p
                class="{{ $descriptionClass }}"
                @if(data_get($defaultHeroData, 'descriptionStyle')) style="{{ data_get($defaultHeroData, 'descriptionStyle') }}" @endif
                :class="hero && hero.descriptionVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                data-gjs-type="text"
                data-gjs-name="hero-description"
                x-text="hero && hero.description ? hero.description : 'Copper mug try-hard pitchfork pour-over freegan heirloom neutra air plant cold-pressed tacos poke beard tote bag.'"
            >
                Copper mug try-hard pitchfork pour-over freegan heirloom neutra air plant cold-pressed tacos poke beard tote bag.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <button
                    class="{{ $primaryButtonClass }} dark:bg-primary-600 dark:hover:bg-primary-500 dark:focus:ring-primary-800/60"
                    @if(data_get($defaultHeroData, 'primaryButtonStyle')) style="{{ data_get($defaultHeroData, 'primaryButtonStyle') }}" @endif
                    :class="hero && hero.primaryButton && hero.primaryButton.visible ? 'opacity-100 translate-y-0 scale-100 full-image-hero-cta' : 'opacity-0 translate-y-10 scale-90'"
                    data-gjs-type="default"
                    data-gjs-name="hero-button-primary"
                >
                    <span class="relative z-10" x-text="hero && hero.primaryButton && hero.primaryButton.text ? hero.primaryButton.text : 'Button'">Button</span>
                    <span class="full-image-hero-shimmer pointer-events-none absolute inset-0 opacity-0 transition-opacity group-hover:opacity-100"></span>
                </button>
                <button
                    class="{{ $secondaryButtonClass }} dark:border-white/40 dark:bg-white/10 dark:hover:bg-white/20 dark:focus:ring-white/30"
                    @if(data_get($defaultHeroData, 'secondaryButtonStyle')) style="{{ data_get($defaultHeroData, 'secondaryButtonStyle') }}" @endif
                    :class="hero && hero.secondaryButton && hero.secondaryButton.visible ? 'opacity-100 translate-y-0 scale-100 full-image-hero-cta' : 'opacity-0 translate-y-10 scale-90'"
                    data-gjs-type="default"
                    data-gjs-name="hero-button-secondary"
                >
                    <span class="relative z-10" x-text="hero && hero.secondaryButton && hero.secondaryButton.text ? hero.secondaryButton.text : 'Button'">Button</span>
                    <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent opacity-0 group-hover:opacity-100"></span>
                </button>
            </div>
    </div>
</section>
@endif
