@php
    $compact = $compact ?? false;
    $fullWidth = $fullWidth ?? true;
    $previewKey = 'laragrape-preview-'.md5((string) $content);
    $previewId = $previewKey;
@endphp
<div @class([
    'laragrape-block-builder-item-preview',
    'laragrape-block-builder-item-preview--compact' => $compact,
    'laragrape-block-builder-item-preview--fullwidth' => $fullWidth,
])>
    @if(!empty($label) && !$compact)
        <div class="laragrape-block-builder-item-preview__label">
            <span class="laragrape-block-builder-item-preview__badge">{{ $label }}</span>
        </div>
    @endif

    @include('filament.forms.components.block-builder-preview-chrome', [
        'previewId' => $previewId,
        'fullscreenHtml' => $content,
        'showFullscreen' => true,
        'fullscreenLabel' => 'Full screen',
    ])

    <div class="laragrape-block-builder-item-preview__canvas">
        <div class="laragrape-block-builder-preview-mount" wire:key="{{ $previewKey }}">
            <template class="laragrape-block-builder-preview-source">{!! $content !!}</template>
            <div
                class="laragrape-block-builder-preview-host"
                data-laragrape-block-builder-preview
                data-laragrape-preview-id="{{ $previewId }}"
            ></div>
        </div>
    </div>
</div>

@include('filament.forms.components.block-builder-preview-script')
