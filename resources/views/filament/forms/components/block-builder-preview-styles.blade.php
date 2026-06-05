{{-- Shared layout/CSS for block builder previews (loaded once per page). --}}
<style>
    .laragrape-block-builder-preview--fullwidth,
    .laragrape-block-layout-stack.laragrape-block-builder-preview--fullwidth {
        width: 100%;
        max-width: 100%;
    }

    .laragrape-block-builder-item-preview__label {
        margin-bottom: 0.5rem;
    }

    .laragrape-block-builder-item-preview__badge {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: rgb(107 114 128);
    }

    .laragrape-block-builder-item-preview__canvas,
    .laragrape-block-layout-stack__block-content {
        background: rgb(249 250 251);
        border: 1px solid rgb(229 231 235);
        border-radius: 0.375rem;
        overflow: hidden;
        width: 100%;
    }

    .dark .laragrape-block-builder-item-preview__canvas,
    .dark .laragrape-block-layout-stack__block-content {
        background: rgb(17 24 39);
        border-color: rgb(55 65 81);
    }

    .laragrape-block-builder-preview-scaler {
        width: 100%;
        overflow: hidden;
    }

    /* Inline repeater / stack previews: height follows block content only */
    .laragrape-block-builder-item-preview__canvas .laragrape-block-builder-preview-scaler,
    .laragrape-block-layout-stack__block-content .laragrape-block-builder-preview-scaler {
        max-height: none;
    }

    .laragrape-block-builder-preview-host {
        width: 100%;
        min-height: 0;
    }

    .laragrape-block-builder-item-preview__canvas .laragrape-block-builder-preview-host,
    .laragrape-block-layout-stack__block-content .laragrape-block-builder-preview-host {
        min-height: 0;
    }

    .laragrape-block-builder-preview__frame {
        width: 100%;
        border: 0;
        display: block;
        background: transparent;
    }

    .laragrape-block-builder-preview-source {
        display: none !important;
    }

    .laragrape-block-builder-preview-chrome__toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
        flex-wrap: wrap;
    }

    .laragrape-block-builder-preview-chrome__hint {
        font-size: 0.75rem;
        color: rgb(107 114 128);
    }

    .laragrape-block-builder-preview-chrome__fs-btn {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35rem 0.75rem;
        border-radius: 0.375rem;
        border: 1px solid rgb(209 213 219);
        background: #fff;
        color: rgb(55 65 81);
        cursor: pointer;
    }

    .laragrape-block-builder-preview-chrome__fs-btn:hover {
        background: rgb(249 250 251);
    }

    .dark .laragrape-block-builder-preview-chrome__fs-btn {
        background: rgb(31 41 55);
        border-color: rgb(75 85 99);
        color: rgb(229 231 235);
    }

    body.laragrape-block-builder-fs-active {
        overflow: hidden;
    }

    .laragrape-block-builder-fs-overlay {
        position: fixed;
        inset: 0;
        z-index: 999999;
        background: rgb(3 7 18 / 0.96);
        display: flex;
        flex-direction: column;
    }

    .laragrape-block-builder-fs-overlay__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        background: rgb(17 24 39);
        color: #fff;
        flex-shrink: 0;
    }

    .laragrape-block-builder-fs-overlay__title {
        font-weight: 600;
    }

    .laragrape-block-builder-fs-overlay__close {
        font-size: 0.875rem;
        font-weight: 600;
        padding: 0.4rem 0.85rem;
        border-radius: 0.375rem;
        background: rgb(99 102 241);
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .laragrape-block-builder-fs-overlay__body {
        flex: 1;
        min-height: 0;
        overflow: auto;
        padding: 0;
        background: rgb(249 250 251);
        display: flex;
        flex-direction: column;
    }

    .laragrape-block-builder-preview-mount--fullscreen {
        width: 100%;
        max-width: 100%;
        min-height: 100%;
        flex: 1;
        margin: 0;
        background: #fff;
        border-radius: 0;
        box-shadow: none;
        overflow: auto;
    }

    .laragrape-block-builder-preview-mount--fullscreen .laragrape-block-builder-preview-scaler {
        width: 100%;
        max-width: 100%;
        margin: 0;
    }

    .laragrape-block-builder-preview-mount--fullscreen .laragrape-block-builder-preview__frame {
        display: block;
        width: 100%;
        margin: 0;
    }

    .laragrape-block-layout-stack {
        width: 100%;
    }

    /* Page preview panel: full width + tall viewport in the admin form */
    .laragrape-block-layout-stack--page-panel {
        width: 100%;
        max-width: 100%;
        display: flex;
        flex-direction: column;
    }

    .laragrape-block-layout-stack--page-panel .laragrape-block-builder-preview-chrome__toolbar {
        flex-shrink: 0;
    }

    .laragrape-block-layout-stack__page-canvas {
        width: 100%;
        min-height: min(75vh, 900px);
        height: min(75vh, 900px);
        overflow: auto;
        background: #fff;
        border: 1px solid rgb(229 231 235);
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    }

    .dark .laragrape-block-layout-stack__page-canvas {
        background: rgb(17 24 39);
        border-color: rgb(55 65 81);
    }

    .laragrape-block-builder-preview-mount--page {
        width: 100%;
        min-height: 100%;
    }

    .laragrape-block-layout-stack__page-canvas .laragrape-block-builder-preview-scaler {
        width: 100%;
        max-width: 100%;
    }

    .laragrape-block-layout-stack__page-canvas .laragrape-block-builder-preview__frame {
        width: 100%;
    }

    /* Filament section wrapper */
    .laragrape-page-preview-section,
    .laragrape-page-preview-section > .fi-section,
    .laragrape-page-preview-section .fi-section-content-ctn {
        width: 100%;
        max-width: 100%;
    }

    .laragrape-block-layout-stack__empty {
        border: 2px dashed rgb(209 213 219);
        border-radius: 0.75rem;
        padding: 2.5rem 1.5rem;
        text-align: center;
        background: rgb(249 250 251);
    }

    .dark .laragrape-block-layout-stack__empty {
        border-color: rgb(75 85 99);
        background: rgb(17 24 39);
    }

    .laragrape-block-layout-stack__canvas {
        background: #fff;
        border: 1px solid rgb(229 231 235);
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        width: 100%;
    }

    .dark .laragrape-block-layout-stack__canvas {
        background: rgb(17 24 39);
        border-color: rgb(55 65 81);
    }

    .laragrape-block-layout-stack__block + .laragrape-block-layout-stack__block {
        border-top: 1px solid rgb(229 231 235);
    }

    .dark .laragrape-block-layout-stack__block + .laragrape-block-layout-stack__block {
        border-top-color: rgb(55 65 81);
    }

    .laragrape-block-layout-stack__block-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.5rem 0.75rem;
        background: rgb(249 250 251);
        border-bottom: 1px solid rgb(243 244 246);
        font-size: 0.75rem;
    }

    .dark .laragrape-block-layout-stack__block-toolbar {
        background: rgb(31 41 55);
        border-bottom-color: rgb(55 65 81);
    }

    .laragrape-block-layout-stack__block-title {
        font-weight: 600;
        color: rgb(55 65 81);
    }

    .dark .laragrape-block-layout-stack__block-title {
        color: rgb(229 231 235);
    }

    .laragrape-block-layout-stack__block-id {
        color: rgb(107 114 128);
        font-family: ui-monospace, monospace;
    }

    .laragrape-block-layout-stack__block-content {
        position: relative;
    }
</style>
