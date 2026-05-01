{{-- @block id="portfolio-grid" label="Portfolio grid" description="All published projects in a grid (for /portfolio page)" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="portfolio-grid-block py-12 bg-primary-50 dark:bg-primary-950" data-laragrape-block="portfolio-grid">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-2 text-primary-900" data-gjs-type="text" data-gjs-name="grid-title">Portfolio</h2>
        <p class="text-center text-zinc-600 dark:text-zinc-400 mb-10" data-gjs-type="text" data-gjs-name="grid-subtitle">All projects</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach([1, 2, 3, 4, 5, 6] as $i)
                <div class="rounded-xl overflow-hidden border border-zinc-200/80 bg-white shadow-md dark:border-zinc-700/70 dark:bg-zinc-900/90 dark:shadow-none">
                    <div class="h-44 bg-gradient-to-br from-primary-500/20 to-accent/20 dark:from-primary-900/40 dark:to-accent/20 flex items-center justify-center text-5xl">📁</div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl text-zinc-900 dark:text-zinc-100 mb-2" data-gjs-type="text">Project {{ $i }}</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-300 mb-4" data-gjs-type="text">Description for project {{ $i }}.</p>
                        <a href="#" class="text-accent font-semibold" data-gjs-type="link">View project →</a>
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
        ->get();
@endphp
<section class="portfolio-grid-block py-12 bg-primary-50 dark:bg-primary-950">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-2 text-primary-900">Portfolio</h2>
        <p class="text-center text-zinc-600 dark:text-zinc-400 mb-10">All projects</p>
        @if($projects->isEmpty())
            <p class="text-center text-zinc-500 dark:text-zinc-400 py-12">No projects published yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $p)
                    <article class="flex flex-col overflow-hidden rounded-xl border border-zinc-200/80 bg-white shadow-md dark:border-zinc-700/70 dark:bg-zinc-900/90 dark:shadow-none">
                        <div class="h-44 overflow-hidden bg-primary-200/50 dark:bg-primary-900/40">
                            @if($p->featured_image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($p->featured_image) }}" alt="" class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full flex items-center justify-center text-5xl">📁</div>
                            @endif
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="mb-2 text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ $p->title }}</h3>
                            <p class="mb-4 flex-1 text-sm text-zinc-600 dark:text-zinc-300">{{ \Illuminate\Support\Str::limit($p->excerpt ?? '', 200) }}</p>
                            @if(count($p->tagsArray()) > 0)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach(array_slice($p->tagsArray(), 0, 4) as $tag)
                                        <span class="px-2 py-0.5 rounded text-xs bg-accent/15 text-accent border border-accent/30">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <a href="{{ route('portfolio.show', $p->slug) }}" class="text-accent font-semibold hover:underline mt-auto">
                                View project →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endif
