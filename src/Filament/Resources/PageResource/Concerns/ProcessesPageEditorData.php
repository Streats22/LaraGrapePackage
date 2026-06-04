<?php

namespace LaraGrape\Filament\Resources\PageResource\Concerns;

use LaraGrape\Services\BlockLayoutService;
use LaraGrape\Services\GrapesJsConverterService;
use LaraGrape\Support\EditorSettings;

trait ProcessesPageEditorData
{
    protected function normalizePageEditorData(array $data): array
    {
        if (EditorSettings::editorModePolicy() === EditorSettings::POLICY_BLOCK_ONLY) {
            $data['editor_mode'] = EditorSettings::PAGE_MODE_BLOCK;
        }

        if (! isset($data['editor_mode']) || $data['editor_mode'] === '') {
            $data['editor_mode'] = EditorSettings::defaultPageEditorMode();
        }

        return $data;
    }

    protected function processPageEditorDataForSave(array $data): array
    {
        $data = $this->normalizePageEditorData($data);
        $editorMode = $data['editor_mode'] ?? EditorSettings::PAGE_MODE_VISUAL;

        if (
            $editorMode === EditorSettings::PAGE_MODE_BLOCK
            && EditorSettings::allowsBlockBuilder()
            && is_array($data['block_layout'] ?? null)
        ) {
            return $this->processBlockLayoutSave($data);
        }

        return $this->processVisualEditorSave($data);
    }

    protected function processBlockLayoutSave(array $data): array
    {
        $blockLayout = array_values(array_filter(
            $data['block_layout'] ?? [],
            fn ($row) => ! empty($row['block_id'] ?? null),
        ));

        if ($blockLayout === []) {
            return $data;
        }

        /** @var BlockLayoutService $blockLayoutService */
        $blockLayoutService = app(BlockLayoutService::class);
        $processed = $blockLayoutService->processBlockLayoutForSave($blockLayout);

        return array_merge($data, $processed, [
            'block_layout' => $blockLayout,
        ]);
    }

    protected function processVisualEditorSave(array $data): array
    {
        if (! isset($data['grapesjs_data']) || ! is_array($data['grapesjs_data'])) {
            return $data;
        }

        $grapesjsData = $data['grapesjs_data'];
        $converterService = app(GrapesJsConverterService::class);
        $processedData = $converterService->processForSaving($grapesjsData);

        $data['grapesjs_html'] = $processedData['html'] ?? null;
        $data['grapesjs_css'] = $processedData['css'] ?? null;
        $data['grapesjs_data'] = $processedData;
        $data['blade_content'] = $converterService->convertToBlade($processedData);

        $html = $processedData['html'] ?? '';
        if ($html !== '' && EditorSettings::allowsBlockBuilder()) {
            /** @var BlockLayoutService $blockLayoutService */
            $blockLayoutService = app(BlockLayoutService::class);
            $decompiled = $blockLayoutService->decompileFromHtml($html);
            if ($decompiled !== []) {
                $data['block_layout'] = $decompiled;
            }
        }

        return $data;
    }

    protected function hydrateBlockLayoutFromStoredContent(array $data): array
    {
        if (! empty($data['block_layout']) && is_array($data['block_layout'])) {
            return $data;
        }

        $html = $data['grapesjs_data']['html'] ?? $data['grapesjs_data']['original_grapesjs']['html'] ?? null;
        if (! is_string($html) || trim($html) === '') {
            return $data;
        }

        /** @var BlockLayoutService $blockLayoutService */
        $blockLayoutService = app(BlockLayoutService::class);
        $decompiled = $blockLayoutService->decompileFromHtml($html);

        if ($decompiled !== []) {
            $data['block_layout'] = $decompiled;
        }

        return $data;
    }
}
