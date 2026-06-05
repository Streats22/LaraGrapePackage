@php
    /** @var list<array{block_id: string, label: string, html: string}> $blocks */
    $blocks = $blocks ?? [];
    $combinedHtml = collect($blocks)->pluck('html')->implode("\n");
    $previewId = 'laragrape-page-preview-'.md5($combinedHtml);
@endphp
<div class="laragrape-block-layout-stack laragrape-block-layout-stack--page-panel laragrape-block-builder-preview--fullwidth">
    @include('filament.forms.components.block-builder-preview-chrome', [
        'previewId' => $previewId,
        'fullscreenHtml' => $combinedHtml,
        'showFullscreen' => $blocks !== [],
        'fullscreenLabel' => 'Full screen preview',
    ])

    @if($blocks === [])
        <div class="laragrape-block-layout-stack__empty">
            <p class="text-sm text-gray-500 dark:text-gray-400">Add blocks above to see how the page will look.</p>
        </div>
    @else
        <div class="laragrape-block-layout-stack__page-canvas" wire:key="page-preview-{{ md5($combinedHtml) }}">
            <div class="laragrape-block-builder-preview-mount laragrape-block-builder-preview-mount--page">
                <template class="laragrape-block-builder-preview-source">{!! $combinedHtml !!}</template>
                <div
                    class="laragrape-block-builder-preview-host"
                    data-laragrape-block-builder-preview
                    data-laragrape-preview-id="{{ $previewId }}"
                ></div>
            </div>
        </div>
    @endif
</div>

@include('filament.forms.components.block-builder-preview-script')
