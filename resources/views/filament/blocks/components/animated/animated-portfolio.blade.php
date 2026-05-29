{{-- @block id="animated-portfolio" label="Animated Portfolio" description="Per-card: set Portfolio project ID on each card (Traits). Optional bulk: Portfolio block data. Fallback: block-level IDs or latest published. --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
{{-- data-gjs-type on root + each card — see GrapesJS Components docs --}}
<div class="portfolio-block py-12 bg-primary-50 dark:bg-primary-950" data-gjs-type="animated-portfolio-block" data-laragrape-block="animated-portfolio" data-gjs-name="animated-portfolio-root">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4 text-center text-zinc-900 dark:text-zinc-100" data-gjs-type="text" data-gjs-name="portfolio-title">Featured work</h2>
        <p class="text-center text-sm text-zinc-600 dark:text-zinc-400 mb-8 max-w-2xl mx-auto" data-gjs-type="text" data-gjs-name="portfolio-subtitle">Select each <strong class="text-zinc-800 dark:text-zinc-200">card</strong> → <strong class="text-zinc-800 dark:text-zinc-200">Settings</strong> → <strong class="text-zinc-800 dark:text-zinc-200">Portfolio project ID</strong> (e.g. <code class="text-xs">1</code> or <code class="text-xs">project_2</code>). Or use <strong class="text-zinc-800 dark:text-zinc-200">Portfolio block data</strong> to fill ordered IDs at once.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Project 1 -->
            <div class="portfolio-item overflow-hidden rounded-xl border border-zinc-200/80 bg-white shadow-md dark:border-zinc-700/70 dark:bg-zinc-900/90 dark:shadow-none" data-gjs-type="animated-portfolio-item" data-portfolio-project-id="" data-gjs-droppable="false">
                <div class="h-44 overflow-hidden bg-primary-200/50 dark:bg-primary-900/40 flex items-center justify-center text-5xl">📁</div>
                <div class="p-6">
                    <h3 class="mb-2 text-xl font-bold text-zinc-900 dark:text-zinc-100" data-gjs-type="text" data-gjs-name="project-title-1">Project title</h3>
                    <p class="mb-4 text-sm text-zinc-600 dark:text-zinc-300" data-gjs-type="text" data-gjs-name="project-description-1">Excerpt from your portfolio project appears here.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-2 py-0.5 rounded text-xs bg-accent/15 text-accent border border-accent/30" data-gjs-type="text" data-gjs-name="project-tag-1-1">Tag</span>
                    </div>
                    <a href="#" class="text-accent font-semibold hover:underline" data-gjs-type="text" data-gjs-name="project-link-1">View project →</a>
                </div>
            </div>
            <!-- Project 2 -->
            <div class="portfolio-item overflow-hidden rounded-xl border border-zinc-200/80 bg-white shadow-md dark:border-zinc-700/70 dark:bg-zinc-900/90 dark:shadow-none" data-gjs-type="animated-portfolio-item" data-portfolio-project-id="" data-gjs-droppable="false">
                <div class="h-44 overflow-hidden bg-primary-200/50 dark:bg-primary-900/40 flex items-center justify-center text-5xl">📁</div>
                <div class="p-6">
                    <h3 class="mb-2 text-xl font-bold text-zinc-900 dark:text-zinc-100" data-gjs-type="text" data-gjs-name="project-title-2">Project title</h3>
                    <p class="mb-4 text-sm text-zinc-600 dark:text-zinc-300" data-gjs-type="text" data-gjs-name="project-description-2">Excerpt from your portfolio project appears here.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-2 py-0.5 rounded text-xs bg-accent/15 text-accent border border-accent/30" data-gjs-type="text" data-gjs-name="project-tag-2-1">Tag</span>
                    </div>
                    <a href="#" class="text-accent font-semibold hover:underline" data-gjs-type="text" data-gjs-name="project-link-2">View project →</a>
                </div>
            </div>
            <!-- Project 3 -->
            <div class="portfolio-item overflow-hidden rounded-xl border border-zinc-200/80 bg-white shadow-md dark:border-zinc-700/70 dark:bg-zinc-900/90 dark:shadow-none" data-gjs-type="animated-portfolio-item" data-portfolio-project-id="" data-gjs-droppable="false">
                <div class="h-44 overflow-hidden bg-primary-200/50 dark:bg-primary-900/40 flex items-center justify-center text-5xl">📁</div>
                <div class="p-6">
                    <h3 class="mb-2 text-xl font-bold text-zinc-900 dark:text-zinc-100" data-gjs-type="text" data-gjs-name="project-title-3">Project title</h3>
                    <p class="mb-4 text-sm text-zinc-600 dark:text-zinc-300" data-gjs-type="text" data-gjs-name="project-description-3">Excerpt from your portfolio project appears here.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-2 py-0.5 rounded text-xs bg-accent/15 text-accent border border-accent/30" data-gjs-type="text" data-gjs-name="project-tag-3-1">Tag</span>
                    </div>
                    <a href="#" class="text-accent font-semibold hover:underline" data-gjs-type="text" data-gjs-name="project-link-3">View project →</a>
                </div>
            </div>
        </div>
    </div>
</div>
@else
@php
    $dynamicData = $dynamicData ?? [];

    $title = $dynamicData['title'] ?? 'Featured work';
    $subtitle = $dynamicData['subtitle'] ?? 'A selection of recent projects';

    $hadExplicitSelection = filled($dynamicData['project_ids'] ?? null)
        || filled($dynamicData['project_slugs'] ?? null)
        || (
            isset($dynamicData['project_slot_ids'])
            && is_array($dynamicData['project_slot_ids'])
            && collect($dynamicData['project_slot_ids'])->filter(fn ($v) => $v !== null && trim((string) $v) !== '')->isNotEmpty()
        );

    $portfolioModel = class_exists(\App\Models\PortfolioProject::class)
        ? \App\Models\PortfolioProject::class
        : \LaraGrape\Models\PortfolioProject::class;
    $portfolioRows = $portfolioModel::queryForAnimatedPortfolioBlock($dynamicData);

    $defaultProjects = [];
    foreach ($portfolioRows as $i => $p) {
        $defaultProjects[] = [
            'title' => $p->title,
            'description' => \Illuminate\Support\Str::limit((string) ($p->excerpt ?? ''), 200),
            'tags' => array_values(array_slice($p->tagsArray(), 0, 4)),
            'link' => $p->publicUrl(),
            'image_url' => $p->featured_image ? \Illuminate\Support\Facades\Storage::url($p->featured_image) : null,
            'visible' => false,
            'delay' => $i * 150,
        ];
    }
@endphp
<section class="portfolio-block py-12 bg-primary-50 dark:bg-primary-950"
     data-gjs-type="default"
     data-gjs-draggable="true"
     data-gjs-droppable="false"
     @if(count($defaultProjects) > 0)
     x-data='{
         "projects": @json($defaultProjects),
         "animated": false
     }'
     x-init="
         if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
             animated = true;
             projects.forEach(project => project.visible = true);
         } else {
             const observer = new IntersectionObserver((entries) => {
                 entries.forEach(entry => {
                     if (entry.isIntersecting && !animated) {
                         animated = true;
                         projects.forEach((project, index) => {
                             setTimeout(() => {
                                 project.visible = true;
                             }, project.delay);
                         });
                     }
                 });
             }, {
                 threshold: 0.1,
                 rootMargin: '0px 0px -50px 0px'
             });
             observer.observe($el);
         }
     "
     @endif
    >
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4 text-center text-primary-900" data-gjs-type="text" data-gjs-name="portfolio-title">{{ $title }}</h2>
        <p class="text-center text-zinc-600 dark:text-zinc-400 mb-8" data-gjs-type="text" data-gjs-name="portfolio-subtitle">{{ $subtitle }}</p>

        @if(count($defaultProjects) === 0)
            <p class="text-center text-primary-600 dark:text-primary-400 py-8">
                @if($hadExplicitSelection)
                    No matching published projects for this selection. Set each card’s project ID in the builder (Settings), or bulk IDs, and ensure projects are published.
                @else
                    No portfolio projects yet. Add some in the admin.
                @endif
            </p>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 gap-y-8">
            <template x-for="(project, index) in projects" :key="index">
                <article class="portfolio-item flex flex-col overflow-hidden rounded-xl border border-zinc-200/80 bg-white shadow-md transition-all duration-300 hover:scale-[1.02] hover:shadow-xl dark:border-zinc-700/70 dark:bg-zinc-900/90 dark:shadow-none"
                     :class="project.visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     :style="project.visible ? 'transition: all 0.6s ease-out;' : 'transition: all 0.6s ease-out;'"
                     data-gjs-type="default"
                     data-gjs-droppable="false">
                    <div class="h-44 overflow-hidden bg-primary-200/50 dark:bg-primary-900/40">
                        <template x-if="project.image_url">
                            <img :src="project.image_url" :alt="project.title" class="h-full w-full object-cover" loading="lazy" width="600" height="264" data-gjs-type="image" />
                        </template>
                        <template x-if="!project.image_url">
                            <div class="flex h-full w-full items-center justify-center text-5xl">📁</div>
                        </template>
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="mb-2 text-xl font-bold text-zinc-900 dark:text-zinc-100" x-text="project.title" data-gjs-type="text" :data-gjs-name="'project-title-' + (index + 1)"></h3>
                        <p class="mb-4 flex-1 text-sm text-zinc-600 dark:text-zinc-300" x-text="project.description" data-gjs-type="text" :data-gjs-name="'project-description-' + (index + 1)"></p>
                        <div class="mb-4 flex flex-wrap gap-2" x-show="project.tags && project.tags.length">
                            <template x-for="(tag, tagIndex) in project.tags" :key="tagIndex">
                                <span class="rounded border border-accent/30 bg-accent/15 px-2 py-0.5 text-xs text-accent"
                                      x-text="tag"
                                      data-gjs-type="text"
                                      :data-gjs-name="'project-tag-' + (index + 1) + '-' + (tagIndex + 1)"></span>
                            </template>
                        </div>
                        <a :href="project.link" class="mt-auto font-semibold text-accent hover:underline" data-gjs-type="link" :data-gjs-name="'project-link-' + (index + 1)">
                            View project →
                        </a>
                    </div>
                </article>
            </template>
        </div>
        @endif
    </div>
</section>
@endif
