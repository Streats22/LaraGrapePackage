/**
 * Block builder previews: isolated iframe, 1280px canvas width, full-screen overlay.
 */

const LARAGRAPE_PREVIEW_VIEWPORT_WIDTH = 1280;

function isFullscreenPreviewFrame(iframe) {
    return Boolean(iframe?.closest('.laragrape-block-builder-preview-mount--fullscreen'));
}

function injectLaragrapeCanvasStyles(targetDocument, stylesArray, compact = false) {
    if (!targetDocument?.head) {
        return;
    }

    const head = targetDocument.head;
    head.querySelectorAll('[data-laragrape-injected-style]').forEach((el) => el.remove());

    (stylesArray || []).forEach((style) => {
        if (!style) {
            return;
        }

        const value = String(style);
        let el;

        if (value.startsWith('<style')) {
            el = targetDocument.createElement('style');
            el.setAttribute('data-laragrape-injected-style', 'true');
            el.innerHTML = value.replace(/^<style[^>]*>|<\/style>$/gi, '');
        } else if (value.endsWith('.css')) {
            el = targetDocument.createElement('link');
            el.setAttribute('data-laragrape-injected-style', 'true');
            el.rel = 'stylesheet';
            el.href = value;
        }

        if (el) {
            head.appendChild(el);
        }
    });

    if (!head.querySelector('[data-laragrape-injected-style="base"]')) {
        const base = targetDocument.createElement('style');
        base.setAttribute('data-laragrape-injected-style', 'base');
        base.textContent =
            'html,body{margin:0;padding:0;background:#fff;color:inherit;}' +
            'body{box-sizing:border-box;}' +
            '.laragrape-block-preview-root{width:' +
            LARAGRAPE_PREVIEW_VIEWPORT_WIDTH +
            'px;max-width:100%;margin:0 auto;}' +
            'img{max-width:100%;height:auto;}';
        head.appendChild(base);
    }

    if (compact) {
        const compactRules = targetDocument.createElement('style');
        compactRules.setAttribute('data-laragrape-injected-style', 'compact');
        compactRules.textContent =
            'html,body{min-height:0!important;height:auto!important;}' +
            '.laragrape-block-preview-root{min-height:0!important;height:auto!important;}' +
            '.laragrape-block-preview-root [class*="min-h-screen"],' +
            '.laragrape-block-preview-root [class*="min-h-\\["],' +
            '.laragrape-block-preview-root [class*="100svh"],' +
            '.laragrape-block-preview-root [class*="100vh"]{min-height:auto!important;height:auto!important;}' +
            '.laragrape-block-preview-root section{min-height:auto!important;}';
        head.appendChild(compactRules);
    }

    const isDark = document.documentElement.classList.contains('dark');
    targetDocument.documentElement.classList.toggle('dark', isDark);
}

function measurePreviewContentHeight(doc, compact) {
    const root = doc.querySelector('.laragrape-block-preview-root');

    if (compact && root) {
        const height = Math.ceil(
            Math.max(root.scrollHeight, root.offsetHeight, root.getBoundingClientRect().height),
        );

        return Math.max(height, 48);
    }

    return Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight, 80);
}

function isPagePanelPreviewFrame(iframe) {
    return Boolean(iframe?.closest('.laragrape-block-builder-preview-mount--page'));
}

function applyIframeScale(iframe, doc) {
    const scaler = iframe.parentElement;
    if (!scaler?.classList.contains('laragrape-block-builder-preview-scaler')) {
        return;
    }

    const isFullscreen = isFullscreenPreviewFrame(iframe);
    const isPagePanel = isPagePanelPreviewFrame(iframe);
    const compact = !isFullscreen;
    const contentHeight = measurePreviewContentHeight(doc, compact);

    if (isFullscreen || isPagePanel) {
        const hostWidth = Math.max(
            scaler.clientWidth || 0,
            iframe.closest('.laragrape-block-builder-fs-overlay__body')?.clientWidth || 0,
            window.innerWidth || LARAGRAPE_PREVIEW_VIEWPORT_WIDTH,
        );

        iframe.style.width = `${hostWidth}px`;
        iframe.style.maxWidth = '100%';
        iframe.style.height = `${contentHeight}px`;
        iframe.style.transform = 'none';
        iframe.style.transformOrigin = 'top left';
        scaler.style.width = '100%';
        scaler.style.maxWidth = '100%';
        scaler.style.height = `${contentHeight}px`;
        scaler.style.margin = '0';

        if (isPagePanel && !isFullscreen) {
            scaler.style.minHeight = '100%';
        }

        return;
    }

    const hostWidth = scaler.clientWidth || LARAGRAPE_PREVIEW_VIEWPORT_WIDTH;
    const scale = Math.min(1, hostWidth / LARAGRAPE_PREVIEW_VIEWPORT_WIDTH);

    iframe.style.width = `${LARAGRAPE_PREVIEW_VIEWPORT_WIDTH}px`;
    iframe.style.height = `${contentHeight}px`;
    iframe.style.transform = `scale(${scale})`;
    iframe.style.transformOrigin = 'top left';
    scaler.style.height = `${Math.ceil(contentHeight * scale)}px`;
    scaler.style.maxWidth = '';
    scaler.style.margin = '';
}

function writeIframePreview(iframe, html, styles, compact = true) {
    const doc = iframe.contentDocument;
    if (!doc) {
        return;
    }

    doc.open();
    doc.write('<!DOCTYPE html><html><head><meta charset="utf-8"></head><body></body></html>');
    doc.close();

    injectLaragrapeCanvasStyles(doc, styles, compact);

    const root = doc.createElement('div');
    root.className = 'laragrape-block-preview-root not-prose max-w-none';
    root.innerHTML = html;
    doc.body.appendChild(root);

    const resize = () => applyIframeScale(iframe, doc);

    resize();

    doc.querySelectorAll('link[data-laragrape-injected-style]').forEach((link) => {
        link.addEventListener('load', resize);
        link.addEventListener('error', resize);
    });

    setTimeout(resize, 400);
    setTimeout(resize, 1200);
}

function previewHtmlFromHost(host) {
    const mount = host.closest('.laragrape-block-builder-preview-mount');
    if (mount) {
        const mountTemplate = mount.querySelector('template.laragrape-block-builder-preview-source');
        if (mountTemplate?.innerHTML?.trim()) {
            return mountTemplate.innerHTML.trim();
        }

        const overlay = mount.closest('.laragrape-block-builder-fs-overlay');
        const overlayTemplate = overlay?.querySelector('template.laragrape-block-builder-preview-source');
        if (overlayTemplate?.innerHTML?.trim()) {
            return overlayTemplate.innerHTML.trim();
        }

        const pageCanvas = mount.closest('.laragrape-block-layout-stack__page-canvas');
        const pageTemplate = pageCanvas?.querySelector('template.laragrape-block-builder-preview-source');
        if (pageTemplate?.innerHTML?.trim()) {
            return pageTemplate.innerHTML.trim();
        }
    }

    const chrome = host.closest('.laragrape-block-builder-preview-chrome');
    const chromeTemplate = chrome?.querySelector('template.laragrape-block-builder-preview-source');
    if (chromeTemplate?.innerHTML?.trim()) {
        return chromeTemplate.innerHTML.trim();
    }

    return '';
}

function mountBlockBuilderPreviewHost(host) {
    const html = previewHtmlFromHost(host);
    if (!html) {
        host.innerHTML = '';
        return;
    }

    const htmlKey = String(html.length) + ':' + html.slice(0, 80);
    if (host.dataset.laragrapeLastHtml === htmlKey && host.querySelector('iframe')) {
        return;
    }

    host.dataset.laragrapeLastHtml = htmlKey;

    const styles = window.laragrapeBlockBuilderCanvasStyles || [];

    const scaler = document.createElement('div');
    scaler.className = 'laragrape-block-builder-preview-scaler';

    const iframe = document.createElement('iframe');
    iframe.setAttribute('title', 'Block preview');
    iframe.setAttribute('tabindex', '-1');
    iframe.className = 'laragrape-block-builder-preview__frame';

    scaler.appendChild(iframe);
    host.innerHTML = '';
    host.appendChild(scaler);

    const compact = !host.closest('.laragrape-block-builder-preview-mount--fullscreen');
    writeIframePreview(iframe, html, styles, compact);
}

function mountBlockBuilderPreviewHosts() {
    document.querySelectorAll('[data-laragrape-block-builder-preview]').forEach((host) => {
        mountBlockBuilderPreviewHost(host);
    });
}

function syncBlockBuilderPreviewDarkMode() {
    const isDark = document.documentElement.classList.contains('dark');
    document.querySelectorAll('.laragrape-block-builder-preview__frame').forEach((frame) => {
        const root = frame.contentDocument?.documentElement;
        if (root) {
            root.classList.toggle('dark', isDark);
        }
    });
}

document.addEventListener('DOMContentLoaded', mountBlockBuilderPreviewHosts);

window.addEventListener('resize', () => {
    mountBlockBuilderPreviewHosts();
});

if (typeof Livewire !== 'undefined') {
    Livewire.hook('morph.updated', () => {
        requestAnimationFrame(() => {
            mountBlockBuilderPreviewHosts();
            syncBlockBuilderPreviewDarkMode();
        });
    });

    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => {
            requestAnimationFrame(() => {
                mountBlockBuilderPreviewHosts();
                syncBlockBuilderPreviewDarkMode();
            });
        });
    });
}

document.addEventListener('livewire:navigated', mountBlockBuilderPreviewHosts);

const darkObserver = new MutationObserver(syncBlockBuilderPreviewDarkMode);
darkObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

window.mountLaragrapeBlockBuilderPreviews = mountBlockBuilderPreviewHosts;

document.addEventListener('alpine:init', () => {
    if (typeof Alpine === 'undefined') {
        return;
    }

    Alpine.data('laragrapeBlockBuilderPreviewChrome', (previewId) => ({
        fullscreenOpen: false,
        previewId,
        _fsPlaceholder: null,

        teleportOverlayToBody() {
            const overlay = this.$el.querySelector('.laragrape-block-builder-fs-overlay');
            if (!overlay || overlay.parentElement === document.body) {
                return overlay;
            }

            if (!this._fsPlaceholder) {
                this._fsPlaceholder = document.createComment('laragrape-fs-overlay');
                overlay.parentNode?.insertBefore(this._fsPlaceholder, overlay);
            }

            document.body.appendChild(overlay);

            return overlay;
        },

        restoreOverlayFromBody() {
            const overlay = document.querySelector(
                `.laragrape-block-builder-fs-overlay[data-laragrape-preview-chrome="${this.previewId}"]`,
            ) || this.$el.querySelector('.laragrape-block-builder-fs-overlay');

            if (
                !overlay
                || !this._fsPlaceholder?.parentNode
                || overlay.parentElement !== document.body
            ) {
                return;
            }

            this._fsPlaceholder.parentNode.insertBefore(
                overlay,
                this._fsPlaceholder.nextSibling,
            );
        },

        openFullscreen() {
            this.fullscreenOpen = true;
            document.body.classList.add('laragrape-block-builder-fs-active');
            this.$nextTick(() => {
                this.teleportOverlayToBody();
                const overlay = document.querySelector(
                    `.laragrape-block-builder-fs-overlay[data-laragrape-preview-chrome="${this.previewId}"]`,
                );
                overlay
                    ?.querySelector('[data-laragrape-block-builder-preview]')
                    ?.removeAttribute('data-laragrape-last-html');
                window.mountLaragrapeBlockBuilderPreviews?.();
            });
        },

        closeFullscreen() {
            this.fullscreenOpen = false;
            document.body.classList.remove('laragrape-block-builder-fs-active');
            this.restoreOverlayFromBody();
        },
    }));
});
