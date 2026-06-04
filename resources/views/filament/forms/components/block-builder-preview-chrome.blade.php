@php
    $previewId = $previewId ?? ('laragrape-preview-'.uniqid());
    $showFullscreen = $showFullscreen ?? true;
    $fullscreenLabel = $fullscreenLabel ?? 'Full screen preview';
    $fullscreenHtml = $fullscreenHtml ?? '';
@endphp
<div
    class="laragrape-block-builder-preview-chrome"
    x-data="laragrapeBlockBuilderPreviewChrome('{{ $previewId }}')"
    x-on:keydown.escape.window="closeFullscreen()"
>
    @if($showFullscreen && filled($fullscreenHtml))
        <div class="laragrape-block-builder-preview-chrome__toolbar">
            <span class="laragrape-block-builder-preview-chrome__hint">Preview uses the same styles as the live site</span>
            <button
                type="button"
                class="laragrape-block-builder-preview-chrome__fs-btn"
                x-on:click="openFullscreen()"
            >
                {{ $fullscreenLabel }}
            </button>
        </div>
    @endif

    <template x-ref="fullscreenSource" class="laragrape-block-builder-preview-source">
        {!! $fullscreenHtml !!}
    </template>

    <div
        class="laragrape-block-builder-fs-overlay"
        data-laragrape-preview-chrome="{{ $previewId }}"
        x-show="fullscreenOpen"
        x-cloak
        x-transition.opacity
        role="dialog"
        aria-modal="true"
        aria-label="Full screen page preview"
    >
        <div class="laragrape-block-builder-fs-overlay__header">
            <span class="laragrape-block-builder-fs-overlay__title">Page preview</span>
            <button type="button" class="laragrape-block-builder-fs-overlay__close" x-on:click="closeFullscreen()">
                Close (Esc)
            </button>
        </div>
        <div class="laragrape-block-builder-fs-overlay__body">
            <div
                class="laragrape-block-builder-preview-mount laragrape-block-builder-preview-mount--fullscreen"
                data-laragrape-block-builder-preview
                data-laragrape-preview-id="{{ $previewId }}-fs"
            ></div>
        </div>
    </div>
</div>
