@php
    /** @var \LaraGrape\Models\PortfolioProject $portfolioProject */
    /** @var \LaraGrape\Models\Page $page */
    $tags = $portfolioProject->tagsArray();
    $renderedBuilderContent = null;
    $builderRenderFailed = false;

    if (! empty($portfolioProject->blade_content)) {
        try {
            $renderedBuilderContent = \Illuminate\Support\Facades\Blade::render(
                $portfolioProject->blade_content,
                ['page' => $page, 'portfolioProject' => $portfolioProject]
            );
        } catch (\Throwable $e) {
            $builderRenderFailed = true;
            \Illuminate\Support\Facades\Log::error('Portfolio project blade render failed', [
                'portfolio_project_id' => $portfolioProject->id,
                'slug' => $portfolioProject->slug,
                'error' => $e->getMessage(),
            ]);
        }
    }
@endphp
@if($renderedBuilderContent !== null)
    <div class="portfolio-project-builder-content w-full">
        {!! $renderedBuilderContent !!}
    </div>
@else
<article class="container mx-auto max-w-4xl px-4 py-8">
    @if($builderRenderFailed && auth()->check())
        <div class="mb-6 rounded-lg border border-amber-300 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            Builder content for this portfolio item could not be rendered. Showing fallback content instead.
        </div>
    @endif
    @if($portfolioProject->featured_image)
        <div class="mb-8 overflow-hidden rounded-xl">
            <img
                src="{{ Storage::url($portfolioProject->featured_image) }}"
                alt="{{ $portfolioProject->title }}"
                class="w-full max-h-[28rem] object-cover"
            />
        </div>
    @endif

    <header class="mb-8">
        <h1 class="text-4xl font-bold text-primary-900 mb-4">
            {{ $portfolioProject->title }}
        </h1>
        @if(count($tags) > 0)
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <span class="px-3 py-1 rounded-full text-sm bg-accent/20 text-accent border border-accent/30">
                        {{ $tag }}
                    </span>
                @endforeach
            </div>
        @endif
    </header>

    @if($portfolioProject->excerpt)
        <p class="text-lg text-primary-700 dark:text-primary-300 mb-8 leading-relaxed">
            {{ $portfolioProject->excerpt }}
        </p>
    @endif

    <div class="prose prose-lg dark:prose-invert max-w-none">
        {!! $portfolioProject->content !!}
    </div>

    <p class="mt-10">
        <a
            href="{{ url('/portfolio') }}"
            class="text-accent font-semibold hover:underline"
        >
            &larr; {{ __('Back to portfolio') }}
        </a>
    </p>
</article>
@endif
