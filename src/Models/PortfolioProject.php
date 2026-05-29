<?php

namespace LaraGrape\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PortfolioProject extends Model
{
    

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'grapesjs_data',
        'blade_content',
        'featured_image',
        'tags',
        'sort_order',
        'is_published',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'tags' => 'array',
        'grapesjs_data' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (PortfolioProject $project) {
            if (empty($project->slug) && ! empty($project->title)) {
                $project->slug = Str::slug($project->title);
            }
        });

        static::updating(function (PortfolioProject $project) {
            if ($project->isDirty('title') && empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Use id in Filament admin URLs; slug for public portfolio detail route.
     */
    public function getRouteKeyName(): string
    {
        return request()->is('admin/*') ? 'id' : 'slug';
    }

    /**
     * Tags as array even when cast is bypassed or DB holds JSON text.
     *
     * @return array<int, mixed>
     */
    /**
     * Public detail URL when portfolio routes are enabled.
     */
    public function publicUrl(): string
    {
        if (config('laragrape.portfolio_enabled', false)
            && \Illuminate\Support\Facades\Route::has('portfolio.show')) {
            return route('portfolio.show', $this->slug);
        }

        return '#';
    }

    public function tagsArray(): array
    {
        $tags = $this->tags;

        if (is_array($tags)) {
            return $tags;
        }

        if (is_string($tags)) {
            $decoded = json_decode($tags, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    /**
     * Projects for the animated portfolio block: explicit IDs or slugs (preserving order), otherwise recent published.
     *
     * Supported formats for project_ids: "5, 12", "project_5, project_12", JSON [5, 12]. project_slugs: comma list or array.
     *
     * @param  array<string, mixed>  $dynamicData
     * @return Collection<int, self>
     */
    public static function queryForAnimatedPortfolioBlock(array $dynamicData): Collection
    {
        $limit = 9;
        if (isset($dynamicData['limit']) && is_numeric($dynamicData['limit'])) {
            $limit = min(9, max(1, (int) $dynamicData['limit']));
        }

        /** Per-card slots from the page builder (data-portfolio-project-id on each .portfolio-item). */
        $slotIds = $dynamicData['project_slot_ids'] ?? null;
        if (is_array($slotIds) && count($slotIds) > 0) {
            $ordered = collect();
            foreach ($slotIds as $raw) {
                if ($raw === null) {
                    continue;
                }
                $s = is_string($raw) ? trim($raw) : trim((string) $raw);
                if ($s === '') {
                    continue;
                }
                $ids = static::parseProjectIdTokens($s);
                $id = $ids[0] ?? null;
                if (! $id) {
                    continue;
                }
                $p = static::query()->published()->whereKey($id)->first();
                if ($p) {
                    $ordered->push($p);
                }
            }

            if ($ordered->isNotEmpty()) {
                return $ordered->values();
            }
            // All slots empty or unpublished — fall through to block-level IDs or recent list.
        }

        $ids = static::parseProjectIdTokens($dynamicData['project_ids'] ?? null);

        if ($ids !== []) {
            /** @var Collection<int, self> $keyed */
            $keyed = static::query()->published()->whereIn('id', $ids)->get()->keyBy('id');

            return collect($ids)
                ->map(fn (int $id) => $keyed->get($id))
                ->filter()
                ->values();
        }

        $slugs = static::parseProjectSlugTokens($dynamicData['project_slugs'] ?? null);
        if ($slugs !== []) {
            $normalized = array_map(fn (string $s) => Str::slug($s), $slugs);
            /** @var Collection<string, self> $keyed */
            $keyed = static::query()->published()->whereIn('slug', $normalized)->get()->keyBy('slug');

            return collect($normalized)
                ->map(fn (string $slug) => $keyed->get($slug))
                ->filter()
                ->values();
        }

        return static::query()
            ->published()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    /**
     * @return array<int, int>
     */
    public static function parseProjectIdTokens(mixed $raw): array
    {
        if ($raw === null || $raw === '' || $raw === []) {
            return [];
        }

        if (is_array($raw)) {
            $ids = [];
            foreach ($raw as $v) {
                if (is_int($v) && $v > 0) {
                    $ids[] = $v;
                } elseif (is_string($v)) {
                    $ids = array_merge($ids, static::parseProjectIdTokens($v));
                }
            }

            return array_values(array_unique(array_filter($ids, fn ($id) => $id > 0)));
        }

        $parts = preg_split('/\s*,\s*/', (string) $raw, -1, PREG_SPLIT_NO_EMPTY);
        $ids = [];
        foreach ($parts as $part) {
            $part = trim($part);
            if ($part === '') {
                continue;
            }
            if (preg_match('/^project_(\d+)$/i', $part, $m)) {
                $ids[] = (int) $m[1];
            } elseif (ctype_digit($part)) {
                $ids[] = (int) $part;
            }
        }

        return array_values(array_unique(array_filter($ids, fn ($id) => $id > 0)));
    }

    /**
     * @return array<int, string>
     */
    public static function parseProjectSlugTokens(mixed $raw): array
    {
        if ($raw === null || $raw === '' || $raw === []) {
            return [];
        }

        if (is_array($raw)) {
            $slugs = [];
            foreach ($raw as $v) {
                if (is_string($v) && trim($v) !== '') {
                    $slugs[] = trim($v);
                }
            }

            return array_values(array_unique($slugs));
        }

        $parts = preg_split('/\s*,\s*/', (string) $raw, -1, PREG_SPLIT_NO_EMPTY);

        return array_values(array_unique(array_filter(array_map('trim', $parts))));
    }
}
