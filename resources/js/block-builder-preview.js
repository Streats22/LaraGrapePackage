/**
 * Block builder previews: isolated iframe, 1280px canvas width, full-screen overlay.
 */

const LARAGRAPE_PREVIEW_VIEWPORT_WIDTH = 1280;

function injectLaragrapeCanvasStyles(targetDocument, stylesArray) {
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

    const isDark = document.documentElement.classList.contains('dark');
    targetDocument.documentElement.classList.toggle('dark', isDark);
}

function applyIframeScale(iframe, doc) {
    const scaler = iframe.parentElement;
    if (!scaler?.classList.contains('laragrape-block-builder-preview-scaler')) {
        return;
    }

    const contentHeight = Math.max(
        doc.body.scrollHeight,
        doc.documentElement.scrollHeight,
        80,
    );
    const hostWidth = scaler.clientWidth || LARAGRAPE_PREVIEW_VIEWPORT_WIDTH;
    const scale = Math.min(1, hostWidth / LARAGRAPE_PREVIEW_VIEWPORT_WIDTH);

    iframe.style.width = `${LARAGRAPE_PREVIEW_VIEWPORT_WIDTH}px`;
    iframe.style.height = `${contentHeight}px`;
    iframe.style.transform = `scale(${scale})`;
    iframe.style.transformOrigin = 'top left';
    scaler.style.height = `${Math.ceil(contentHeight * scale)}px`;
}

function writeIframePreview(iframe, html, styles) {
    const doc = iframe.contentDocument;
    if (!doc) {
        return;
    }

    doc.open();
    doc.write('<!DOCTYPE html><html><head><meta charset="utf-8"></head><body></body></html>');
    doc.close();

    injectLaragrapeCanvasStyles(doc, styles);

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
    const chrome = host.closest('.laragrape-block-builder-preview-chrome');
    const chromeTemplate = chrome?.querySelector('template.laragrape-block-builder-preview-source');
    if (chromeTemplate?.innerHTML?.trim()) {
        return chromeTemplate.innerHTML.trim();
    }

    const mount = host.closest('.laragrape-block-builder-preview-mount');
    const template = mount?.querySelector('template.laragrape-block-builder-preview-source');

    return template?.innerHTML?.trim() || '';
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

    writeIframePreview(iframe, html, styles);
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

        openFullscreen() {
            this.fullscreenOpen = true;
            document.body.style.overflow = 'hidden';
            this.$nextTick(() => {
                window.mountLaragrapeBlockBuilderPreviews?.();
            });
        },

        closeFullscreen() {
            this.fullscreenOpen = false;
            document.body.style.overflow = '';
        },
    }));
});
