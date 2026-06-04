@php
    /** @var list<array{block_id: string, label: string, html: string}> $blocks */
    $blocks = $blocks ?? [];
    $combinedHtml = collect($blocks)->pluck('html')->implode("\n");
    $previewId = 'laragrape-page-preview-'.md5($combinedHtml);
@endphp
<div class="laragrape-block-layout-stack laragrape-block-builder-preview--fullwidth">
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
        <div class="laragrape-block-layout-stack__canvas">
            @foreach($blocks as $index => $block)
                <div class="laragrape-block-layout-stack__block" wire:key="block-stack-{{ $block['block_id'] }}-{{ $index }}-{{ md5($block['html']) }}">
                    <div class="laragrape-block-layout-stack__block-toolbar">
                        <span class="laragrape-block-layout-stack__block-title">{{ $block['label'] }}</span>
                        <span class="laragrape-block-layout-stack__block-id">{{ $block['block_id'] }}</span>
                    </div>
                    <div class="laragrape-block-layout-stack__block-content">
                        <div class="laragrape-block-builder-preview-mount">
                            <template class="laragrape-block-builder-preview-source">{!! $block['html'] !!}</template>
                            <div
                                class="laragrape-block-builder-preview-host"
                                data-laragrape-block-builder-preview
                                data-laragrape-preview-id="{{ $previewId }}-{{ $index }}"
                            ></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@include('filament.forms.components.block-builder-preview-script')
