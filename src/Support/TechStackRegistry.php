<?php

namespace LaraGrape\Support;

class TechStackRegistry
{
    /**
     * @return array<string, mixed>
     */
    public function resolve(string $key): array
    {
        $normalizedKey = $this->normalizeKey($key);
        $techs = $this->all();
        $fallback = $this->fallback();

        $entry = $techs[$normalizedKey] ?? $fallback;

        return array_merge($fallback, $entry, [
            'key' => $normalizedKey !== '' && isset($techs[$normalizedKey]) ? $normalizedKey : 'custom',
        ]);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function all(): array
    {
        /** @var array<string, array<string, mixed>> $techs */
        $techs = (array) config('laragrape.tech_stack.techs', []);

        return $techs;
    }

    /**
     * @return array<string, mixed>
     */
    public function fallback(): array
    {
        /** @var array<string, mixed> $fallback */
        $fallback = (array) config('laragrape.tech_stack.fallback', []);

        return $fallback;
    }

    /**
     * @return list<string>
     */
    public function defaultKeys(): array
    {
        $defaults = (array) config('laragrape.tech_stack.defaults', []);
        $techs = $this->all();

        $out = [];
        foreach ($defaults as $key) {
            $normalized = $this->normalizeKey((string) $key);
            if ($normalized !== '' && isset($techs[$normalized])) {
                $out[] = $normalized;
            }
        }

        if ($out === []) {
            $out = array_slice(array_keys($techs), 0, 3);
        }

        return $out;
    }

    /**
     * @return list<array{id:string,label:string}>
     */
    public function traitOptions(): array
    {
        $options = [];
        foreach ($this->all() as $key => $meta) {
            $label = trim((string) ($meta['label'] ?? $key));
            $options[] = [
                'id' => $key,
                'label' => $label !== '' ? $label : $key,
            ];
        }

        return $options;
    }

    /**
     * @return array<string, array{label:string,url:string,icon:string}>
     */
    public function editorMap(): array
    {
        $map = [];

        foreach ($this->all() as $key => $meta) {
            $label = trim((string) ($meta['label'] ?? $key));
            $icon = trim((string) ($meta['icon'] ?? ''));
            $url = trim((string) ($meta['url'] ?? '#'));

            if ($icon !== '' && ! str_starts_with($icon, 'http://') && ! str_starts_with($icon, 'https://')) {
                $icon = asset(ltrim($icon, '/'));
            }

            $map[$key] = [
                'label' => $label !== '' ? $label : $key,
                'url' => $url !== '' ? $url : '#',
                'icon' => $icon,
            ];
        }

        $fallback = $this->fallback();
        $fallbackIcon = trim((string) ($fallback['icon'] ?? ''));
        if ($fallbackIcon !== '' && ! str_starts_with($fallbackIcon, 'http://') && ! str_starts_with($fallbackIcon, 'https://')) {
            $fallbackIcon = asset(ltrim($fallbackIcon, '/'));
        }

        $map['custom'] = [
            'label' => trim((string) ($fallback['label'] ?? 'Technology')) ?: 'Technology',
            'url' => trim((string) ($fallback['url'] ?? '#')) ?: '#',
            'icon' => $fallbackIcon,
        ];

        return $map;
    }

    public function inferKeyFromName(string $name): string
    {
        $normalizedName = $this->normalizeKey($name);
        if ($normalizedName === '') {
            return '';
        }

        $techs = $this->all();
        if (isset($techs[$normalizedName])) {
            return $normalizedName;
        }

        /** @var array<string, string> $aliases */
        $aliases = (array) config('laragrape.tech_stack.aliases', []);
        if (isset($aliases[$normalizedName])) {
            $aliasKey = $this->normalizeKey($aliases[$normalizedName]);
            if ($aliasKey !== '' && isset($techs[$aliasKey])) {
                return $aliasKey;
            }
        }

        foreach ($techs as $key => $meta) {
            $label = $this->normalizeKey((string) ($meta['label'] ?? ''));
            if ($label !== '' && $label === $normalizedName) {
                return $key;
            }
        }

        return '';
    }

    public function normalizeKey(string $key): string
    {
        $normalized = strtolower(trim($key));
        if ($normalized === '') {
            return '';
        }

        $normalized = str_replace(['_', '.', '/', '\\'], ' ', $normalized);
        $normalized = preg_replace('/\s+/', ' ', $normalized) ?? $normalized;

        return str_replace(' ', '', $normalized);
    }
}
