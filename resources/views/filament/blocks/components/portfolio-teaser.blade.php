{{-- @block id="portfolio-teaser" label="Portfolio teaser" description="Latest projects with link to full portfolio" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="portfolio-teaser-block py-12 bg-primary-50 dark:bg-primary-950" data-laragrape-block="portfolio-teaser">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-primary-900" data-gjs-type="text" data-gjs-name="teaser-title">Featured work</h2>
                <p class="text-zinc-600 dark:text-zinc-400 mt-2" data-gjs-type="text" data-gjs-name="teaser-subtitle">A selection of recent projects</p>
            </div>
            <a href="{{ url('/portfolio') }}" class="inline-flex items-center justify-center rounded-lg bg-accent px-5 py-2.5 font-semibold text-neutral-950 hover:opacity-90 dark:text-white" data-gjs-type="link">
                View all
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([1, 2, 3] as $i)
                <div class="overflow-hidden rounded-xl border border-zinc-200/80 bg-white shadow-md dark:border-zinc-700/70 dark:bg-zinc-900/90 dark:shadow-none">
                    <div class="flex h-40 items-center justify-center bg-gradient-to-br from-accent/40 to-primary-500/30 text-4xl dark:from-primary-900/50 dark:to-accent/20">🖼️</div>
                    <div class="p-5">
                        <h3 class="mb-2 text-lg font-bold text-zinc-900 dark:text-zinc-100" data-gjs-type="text">Project {{ $i }}</h3>
                        <p class="mb-4 text-sm text-zinc-600 dark:text-zinc-300" data-gjs-type="text">Short excerpt appears here for each project.</p>
                        <span class="text-accent font-semibold text-sm">Show more →</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@else
@php
    $projects = \App\Models\PortfolioProject::query()
        ->published()
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->limit(3)
        ->get();
@endphp
<section class="portfolio-teaser-block py-12 bg-primary-50 dark:bg-primary-950">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-primary-900">Featured work</h2>
                <p class="text-zinc-600 dark:text-zinc-400 mt-2">A selection of recent projects</p>
            </div>
            <a href="{{ url('/portfolio') }}" class="inline-flex items-center justify-center rounded-lg bg-accent px-5 py-2.5 font-semibold text-neutral-950 hover:opacity-90 dark:text-white">
                View all
            </a>
        </div>
        @if($projects->isEmpty())
            <p class="text-center text-primary-600 dark:text-primary-400 py-8">No portfolio projects yet. Add some in the admin.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($projects as $p)
                    <article class="flex flex-col overflow-hidden rounded-xl border border-zinc-200/80 bg-white shadow-md dark:border-zinc-700/70 dark:bg-zinc-900/90 dark:shadow-none">
                        <div class="h-40 overflow-hidden bg-primary-200/50 dark:bg-primary-900/40">
                            @if($p->featured_image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($p->featured_image) }}" alt="" class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full flex items-center justify-center text-4xl">🖼️</div>
                            @endif
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="mb-2 text-lg font-bold text-zinc-900 dark:text-zinc-100">{{ $p->title }}</h3>
                            <p class="mb-4 flex-1 text-sm text-zinc-600 dark:text-zinc-300">{{ \Illuminate\Support\Str::limit($p->excerpt ?? '', 140) }}</p>
                            <a href="{{ route('portfolio.show', $p->slug) }}" class="text-accent font-semibold text-sm hover:underline mt-auto">
                                Show more →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endif
