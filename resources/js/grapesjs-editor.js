/**
 * LaraGrape — unified GrapesJS editor
 * Works for both frontend and backend (Filament) contexts
 */

import { initDynamicForms } from './form-blocks';

// Alpine in the canvas iframe (animated blocks use x-data / x-intersect / etc.)
const GRAPESJS_CANVAS_ALPINE_SCRIPT = 'https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js';

// Import grapesjs-parser-postcss if using a bundler (uncomment if needed)
// import parserPostCSS from 'grapesjs-parser-postcss';

// Helper to fetch rendered block preview from backend
async function fetchBlockPreview(blockId) {
    const url = `/admin/block-preview?id=${encodeURIComponent(blockId)}`;
    try {
        const response = await fetch(url, { credentials: 'same-origin' });
        if (!response.ok) {
            throw new Error(`Failed to fetch block preview (${response.status})`);
        }
        return await response.text();
    } catch (e) {
        return `<div style='color:red;'>Preview error: ${e.message}</div>`;
    }
}

class LaraGrapeGrapesJsEditor {
    constructor(options = {}) {
        this.options = {
            containerId: 'grapejs-editor',
            mode: 'frontend', // 'frontend' or 'backend'
            saveUrl: '',
            blocks: [],
            initialData: {},
            statePath: '', // for Filament
            isDisabled: false,
            height: '100vh',
            onSave: null, // custom save handler
            portfolioEnabled: false,
            ...options
        };
        
        this.editor = null;
        this.wrapper = null;
        this.fullscreenBtn = null;
        
        // Initialize the editor
        this.init();
    }

    init() {
        this.wrapper = document.getElementById(`wrapper-${this.options.containerId}`) || document.querySelector('.grapejs-editor-wrapper');
        this.fullscreenBtn = this.wrapper?.querySelector('.fullscreen-toggle-btn');
        if (typeof grapesjs === 'undefined') {
            console.error('GrapesJS is not loaded');
            return;
        }
        
        // Store the editor instance on the DOM element for global access
        if (this.wrapper) {
            this.wrapper.laraGrapeEditor = this;
        }
        
        this.initializeEditor();
        this.setupEventListeners();
    }

    async initializeEditor() {
        const editorElement = document.getElementById(this.options.containerId);
        if (!editorElement) {
            console.error(`Editor element with ID ${this.options.containerId} not found`);
            return;
        }
        
        // Ensure the editor container is visible for initialization
        const editorWrapper = editorElement.closest('.grapejs-editor-wrapper');
        if (editorWrapper && editorWrapper.style.display === 'none') {
            console.log('Making editor container visible for initialization');
            editorWrapper.style.display = 'block';
            // Hide it again after initialization
            setTimeout(() => {
                if (editorWrapper && !this.options.isDisabled) {
                    editorWrapper.style.display = 'none';
                }
            }, 100);
        }
        
        // Add PostCSS parser plugin for better CSS variable support
        const plugins = [];
        if (typeof parserPostCSS !== 'undefined') {
            plugins.push(parserPostCSS);
        } else if (typeof grapesjsParserPostcss !== 'undefined') {
            plugins.push(grapesjsParserPostcss);
        }
        
        // Instead of using static blocks, fetch previews dynamically
        const blockManagerBlocks = [];
        for (const block of this.options.blocks) {
            // Only fetch preview for file-based blocks (not custom or dynamic blocks)
            if (block.id && !block.is_custom) {
                const html = await fetchBlockPreview(block.id);
                blockManagerBlocks.push({ ...block, content: html });
            } else {
                blockManagerBlocks.push(block);
            }
        }
        
        this.editor = grapesjs.init({
            container: editorElement,
            height: this.options.height,
            width: '100%',
            fromElement: false,
            showOffsets: true,
            noticeOnUnload: false,
            storageManager: false,
            // Per Components module tips: scope styles to the selected instance (avoids editing shared classes).
            selectorManager: {
                componentFirst: true,
            },
            canvas: {
                styles: window.grapesjsCanvasStyles || [],
                scripts: [GRAPESJS_CANVAS_ALPINE_SCRIPT],
            },
            blockManager: {
                blocks: blockManagerBlocks
            },
            plugins,
        });

        // Must run before setComponents/load — custom types with traits (data-gjs-type on blocks references these).
        if (this.options.portfolioEnabled) {
            this.registerAnimatedPortfolioBlockType();
            this.registerAnimatedPortfolioItemType();
            this.attachPortfolioBlockDataDialog();
        }
        this.registerAnimatedTechItemType();

        this.wireCanvasDarkMode();
        this.wireCanvasAlpineLifecycle();
        
        // Check if disabled before loading content
        if (this.options.isDisabled) {
            this.editor.Commands.run('core:canvas-clear');
        } else {
            // Load existing content
            this.loadExistingContent();
        }
        
        // Setup change listeners
        this.setupChangeListeners();
        
        // Setup form submission handlers
        this.setupFilamentFormSubmission();
        
        // Refresh the editor and inject styles
        setTimeout(() => {
            this.editor.refresh();
        }, 100);
        setTimeout(() => {
            injectStylesIntoGrapesJsIframe(this.editor, window.grapesjsCanvasStyles);
            syncGrapesJsCanvasDarkMode(this.editor);
            this.refreshCanvasAlpineAndForms();
        }, 500);
    }

    /**
     * Keep the canvas <html> in sync with the parent (Filament / site) dark mode so
     * `.dark { --laralgrape-* }`, Tailwind `dark:*`, and `site-forms.css` apply to blocks and forms.
     */
    /**
     * Animated portfolio root: shell only (IDs live on each animated-portfolio-item). Root attrs optional fallback for extraction.
     */
    registerAnimatedPortfolioBlockType() {
        const editor = this.editor;
        if (!editor?.DomComponents) {
            return;
        }
        editor.DomComponents.addType('animated-portfolio-block', {
            extend: 'default',
            isComponent: (el) =>
                typeof el?.getAttribute === 'function' &&
                el.getAttribute('data-laragrape-block') === 'animated-portfolio',
            model: {
                defaults: {
                    attributes: {
                        'data-laragrape-block': 'animated-portfolio',
                        'data-portfolio-project-ids': '',
                        'data-portfolio-project-slugs': '',
                    },
                },
                /** Section shell: no portfolio fields (those are per card). */
                init(...args) {
                    const base = editor.DomComponents.getType('default')?.model?.prototype;
                    if (base?.init) {
                        base.init.apply(this, args);
                    }
                    this.setTraits([]);
                },
            },
        });
    }

    /**
     * Each portfolio card: Trait "Portfolio project ID" → data-portfolio-project-id (saved + extracted per slot).
     */
    registerAnimatedPortfolioItemType() {
        const editor = this.editor;
        if (!editor?.DomComponents) {
            return;
        }
        editor.DomComponents.addType('animated-portfolio-item', {
            extend: 'default',
            isComponent: (el) => el?.getAttribute?.('data-gjs-type') === 'animated-portfolio-item',
            model: {
                defaults: {
                    attributes: {
                        'data-portfolio-project-id': '',
                    },
                },
                init(...args) {
                    const base = editor.DomComponents.getType('default')?.model?.prototype;
                    if (base?.init) {
                        base.init.apply(this, args);
                    }
                    this.setTraits([
                        {
                            type: 'text',
                            label: 'Portfolio project ID (this card)',
                            name: 'data-portfolio-project-id',
                            placeholder: 'e.g. 1, 2, or project_3',
                        },
                    ]);
                },
            },
        });
    }

    /**
     * Animated tech stack card item: Settings dropdown for techKey.
     */
    registerAnimatedTechItemType() {
        const editor = this.editor;
        if (!editor?.DomComponents) {
            return;
        }

        const options = this.getTechTraitOptions();
        const registryMap = this.getTechRegistryMap();
        const defaultKey = options[0]?.id || 'nuxt';

        const findFirstChildByTag = (component, tagName) => {
            if (!component) {
                return null;
            }

            const children = component.components?.();
            if (!children || typeof children.each !== 'function') {
                return null;
            }

            let found = null;
            children.each((child) => {
                if (found) {
                    return;
                }
                const childTag = String(child.get?.('tagName') || '').toLowerCase();
                if (childTag === tagName) {
                    found = child;
                    return;
                }
                found = findFirstChildByTag(child, tagName) || found;
            });

            return found;
        };

        const resolveMeta = (key) => {
            const normalized = String(key || '').trim();
            if (normalized && registryMap[normalized]) {
                return { key: normalized, ...registryMap[normalized] };
            }
            const fallback = registryMap.custom || { label: 'Technology', url: '#', icon: '' };
            return { key: normalized || 'custom', ...fallback };
        };

        const applyTechMeta = (component, key) => {
            if (!component) {
                return;
            }

            const meta = resolveMeta(key);
            component.addAttributes({ 'data-tech-key': meta.key });

            const imageComp = findFirstChildByTag(component, 'img');
            if (imageComp) {
                const imageAttrs = imageComp.getAttributes?.() || {};
                imageComp.addAttributes({
                    ...imageAttrs,
                    src: meta.icon || imageAttrs.src || '',
                    alt: `${meta.label || 'Technology'} logo`,
                });
            }

            const titleComp = findFirstChildByTag(component, 'h3');
            if (titleComp) {
                titleComp.components(meta.label || 'Technology');
            }

            const rootTag = String(component.get?.('tagName') || '').toLowerCase();
            if (rootTag === 'a') {
                const rootAttrs = component.getAttributes?.() || {};
                component.addAttributes({
                    ...rootAttrs,
                    href: meta.url || '#',
                });
            }
        };

        editor.DomComponents.addType('animated-tech-item', {
            extend: 'default',
            isComponent: (el) =>
                el?.getAttribute?.('data-gjs-type') === 'animated-tech-item' || !!el?.getAttribute?.('data-tech-key'),
            model: {
                defaults: {
                    attributes: {
                        'data-tech-key': defaultKey,
                    },
                },
                init(...args) {
                    const base = editor.DomComponents.getType('default')?.model?.prototype;
                    if (base?.init) {
                        base.init.apply(this, args);
                    }

                    const attrs = this.getAttributes?.() || {};
                    const initialKey = attrs['data-tech-key'] || defaultKey;
                    applyTechMeta(this, initialKey);

                    this.on('change:attributes', () => {
                        const nextAttrs = this.getAttributes?.() || {};
                        const key = nextAttrs['data-tech-key'] || defaultKey;
                        applyTechMeta(this, key);
                    });
                    this.on('change:attributes:data-tech-key', () => {
                        const nextAttrs = this.getAttributes?.() || {};
                        const key = nextAttrs['data-tech-key'] || defaultKey;
                        applyTechMeta(this, key);
                    });

                    this.setTraits([
                        {
                            type: 'select',
                            label: 'Tech key',
                            name: 'data-tech-key',
                            options: options.map((option) => ({
                                id: option.id,
                                name: option.label,
                                value: option.id,
                            })),
                        },
                    ]);
                },
            },
        });

        // Keep canvas visuals in sync when traits/attributes change, without saving.
        if (!this._techVisualSyncBound) {
            this._techVisualSyncBound = true;

            const syncIfTechItem = (component) => {
                if (!component) {
                    return;
                }
                const attrs = component.getAttributes?.() || {};
                const type = component.get?.('type');
                if (type === 'animated-tech-item' || attrs['data-tech-key']) {
                    const key = attrs['data-tech-key'] || defaultKey;
                    applyTechMeta(component, key);
                }
            };

            editor.on('component:update:attributes', syncIfTechItem);
            editor.on('component:update', syncIfTechItem);
            editor.on('component:selected', syncIfTechItem);
            editor.on('trait:value', (...args) => {
                const trait = args[0];
                const value = args[1];
                const selected = editor.getSelected?.();
                const traitName = trait?.get?.('name') || trait?.attributes?.name || '';
                if (traitName === 'data-tech-key' && selected) {
                    applyTechMeta(selected, value);
                    this.updateFilamentFormState();
                }
            });
            editor.on('load', () => {
                const walk = (component) => {
                    if (!component) {
                        return;
                    }
                    syncIfTechItem(component);
                    const children = component.components?.();
                    if (children && typeof children.each === 'function') {
                        children.each(walk);
                    }
                };
                walk(editor.DomComponents.getWrapper());
            });
        }
    }

    getTechTraitOptions() {
        const raw = window.grapesjsTechRegistryOptions;
        if (Array.isArray(raw) && raw.length > 0) {
            return raw
                .map((item) => {
                    const id = String(item?.id || '').trim();
                    const label = String(item?.label || id).trim();
                    if (!id) {
                        return null;
                    }
                    return { id, label: label || id };
                })
                .filter(Boolean);
        }

        return [
            { id: 'wordpress', label: 'WordPress' },
            { id: 'nuxt', label: 'Nuxt.js' },
            { id: 'vue', label: 'Vue.js' },
            { id: 'react', label: 'React' },
            { id: 'inertia', label: 'Inertia.js' },
            { id: 'laravel', label: 'Laravel' },
            { id: 'tallstack', label: 'Laravel TALL Stack' },
            { id: 'laragrape', label: 'LaraGrape' },
            { id: 'livewire', label: 'Livewire' },
            { id: 'filament', label: 'Filament' },
            { id: 'alpine', label: 'Alpine.js' },
            { id: 'tailwind', label: 'Tailwind CSS' },
            { id: 'flutter', label: 'Flutter' },
            { id: 'dart', label: 'Dart' },
            { id: 'typescript', label: 'TypeScript' },
            { id: 'javascript', label: 'JavaScript' },
            { id: 'node', label: 'Node.js' },
            { id: 'nextjs', label: 'Next.js' },
            { id: 'svelte', label: 'Svelte' },
            { id: 'angular', label: 'Angular' },
            { id: 'remix', label: 'Remix' },
            { id: 'electron', label: 'Electron' },
            { id: 'php', label: 'PHP' },
            { id: 'python', label: 'Python' },
            { id: 'go', label: 'Go' },
            { id: 'rust', label: 'Rust' },
            { id: 'csharp', label: 'C#' },
            { id: 'dotnet', label: '.NET' },
            { id: 'vite', label: 'Vite' },
            { id: 'graphql', label: 'GraphQL' },
            { id: 'mysql', label: 'MySQL' },
            { id: 'mariadb', label: 'MariaDB' },
            { id: 'postgresql', label: 'PostgreSQL' },
            { id: 'mongodb', label: 'MongoDB' },
            { id: 'redis', label: 'Redis' },
            { id: 'prisma', label: 'Prisma' },
            { id: 'firebase', label: 'Firebase' },
            { id: 'supabase', label: 'Supabase' },
            { id: 'docker', label: 'Docker' },
            { id: 'kubernetes', label: 'Kubernetes' },
            { id: 'aws', label: 'AWS' },
            { id: 'gcp', label: 'Google Cloud' },
            { id: 'vercel', label: 'Vercel' },
            { id: 'cloudflare', label: 'Cloudflare' },
            { id: 'stripe', label: 'Stripe' },
            { id: 'shopify', label: 'Shopify' },
            { id: 'figma', label: 'Figma' },
            { id: 'openai', label: 'OpenAI' },
            { id: 'nginx', label: 'Nginx' },
        ];
    }

    getTechRegistryMap() {
        const raw = window.grapesjsTechRegistryMap;
        if (!raw || typeof raw !== 'object') {
            return {};
        }

        const map = {};
        Object.entries(raw).forEach(([key, value]) => {
            const label = String(value?.label || key).trim();
            const url = String(value?.url || '#').trim();
            const icon = String(value?.icon || '').trim();
            map[String(key)] = {
                label: label || key,
                url: url || '#',
                icon,
            };
        });

        return map;
    }

    /**
     * Dialog: bulk-fill per-card IDs in order; optional block-level IDs/slugs as extraction fallback.
     */
    attachPortfolioBlockDataDialog() {
        const wrapper = this.wrapper;
        const editor = this.editor;
        if (!wrapper || !editor || wrapper.querySelector('[data-laragrape-portfolio-data-ui]')) {
            return;
        }

        const controls = wrapper.querySelector('.grapesjs-controls');
        if (!controls) {
            return;
        }

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.setAttribute('data-laragrape-portfolio-data-ui', '1');
        btn.className = 'laragrape-portfolio-data-btn';
        btn.title =
            'Fill portfolio project IDs per card in order, or set block-level fallback. Per card: select card → Settings.';
        btn.textContent = 'Portfolio block data';
        controls.appendChild(btn);

        const dialog = document.createElement('dialog');
        dialog.className = 'laragrape-portfolio-data-dialog';
        dialog.setAttribute('data-laragrape-portfolio-data-dialog', '1');
        dialog.innerHTML = `
<div class="laragrape-portfolio-data-dialog__inner">
  <h3 class="laragrape-portfolio-data-dialog__title">Animated Portfolio — projects</h3>
  <p class="laragrape-portfolio-data-dialog__help">
    <strong>Per card:</strong> select a portfolio card on the canvas → <strong>Settings</strong> → <strong>Portfolio project ID</strong>.
    Use the field below to set IDs for card 1, card 2, … in one go (comma-separated). Admin IDs: <code>/admin/portfolio-projects/{id}/edit</code>.
  </p>
  <label class="laragrape-portfolio-data-dialog__label">Ordered IDs for each card (1st, 2nd, 3rd, …)</label>
  <input type="text" name="portfolio-card-ids" class="laragrape-portfolio-data-dialog__input" placeholder="e.g. 5, 12, 3 or project_5, project_12" autocomplete="off" />
  <p class="laragrape-portfolio-data-dialog__hint">Fewer values than cards leaves remaining cards unchanged. Extra values are ignored.</p>
  <label class="laragrape-portfolio-data-dialog__label">Block-level project IDs (fallback if no card IDs)</label>
  <input type="text" name="portfolio-ids" class="laragrape-portfolio-data-dialog__input" placeholder="comma-separated, whole block" autocomplete="off" />
  <label class="laragrape-portfolio-data-dialog__label">Block-level slugs (fallback, optional)</label>
  <input type="text" name="portfolio-slugs" class="laragrape-portfolio-data-dialog__input" placeholder="comma-separated" autocomplete="off" />
  <div class="laragrape-portfolio-data-dialog__actions">
    <button type="button" data-action="cancel" class="laragrape-portfolio-data-dialog__btn laragrape-portfolio-data-dialog__btn--secondary">Cancel</button>
    <button type="button" data-action="save" class="laragrape-portfolio-data-dialog__btn laragrape-portfolio-data-dialog__btn--primary">Save</button>
  </div>
</div>`;
        wrapper.appendChild(dialog);

        const collectPortfolioItems = (rootComp) => {
            const acc = [];
            const walk = (c) => {
                if (!c) {
                    return;
                }
                if (c.get?.('type') === 'animated-portfolio-item') {
                    acc.push(c);
                }
                const ch = c.components?.();
                if (ch && typeof ch.each === 'function') {
                    ch.each(walk);
                }
            };
            walk(rootComp);
            return acc;
        };

        const getPortfolioBlockComponent = () => {
            let comp = editor.getSelected();
            const matches = (c) => {
                const el = c?.getEl?.();
                return el?.getAttribute?.('data-laragrape-block') === 'animated-portfolio';
            };
            if (comp && matches(comp)) {
                return comp;
            }
            if (comp) {
                let p = comp.parent?.();
                let depth = 0;
                while (p && depth < 20) {
                    if (matches(p)) {
                        return p;
                    }
                    p = p.parent?.();
                    depth += 1;
                }
            }
            const walk = (c, acc) => {
                if (!c) {
                    return acc;
                }
                if (matches(c)) {
                    acc.push(c);
                }
                const ch = c.components?.();
                if (ch && typeof ch.each === 'function') {
                    ch.each((child) => walk(child, acc));
                }
                return acc;
            };
            const found = walk(editor.DomComponents.getWrapper(), []);
            return found[0] ?? null;
        };

        const syncFormFromComponent = (comp) => {
            if (!comp) {
                return;
            }
            const items = collectPortfolioItems(comp);
            const slotValues = items.map((ic) => {
                const a = ic.getAttributes?.() ?? {};
                return (a['data-portfolio-project-id'] ?? '').trim();
            });
            dialog.querySelector('[name="portfolio-card-ids"]').value = slotValues.join(', ');
            const el = comp.getEl?.();
            dialog.querySelector('[name="portfolio-ids"]').value =
                el?.getAttribute?.('data-portfolio-project-ids') || '';
            dialog.querySelector('[name="portfolio-slugs"]').value =
                el?.getAttribute?.('data-portfolio-project-slugs') || '';
        };

        btn.addEventListener('click', () => {
            const comp = getPortfolioBlockComponent();
            if (!comp) {
                window.alert(
                    'No Animated Portfolio block found. Drag "Animated Portfolio" from the blocks panel onto the page, then open this dialog again.',
                );
                return;
            }
            editor.select(comp);
            syncFormFromComponent(comp);
            dialog.showModal();
        });

        dialog.addEventListener('click', (e) => {
            if (e.target === dialog) {
                dialog.close();
            }
        });

        dialog.querySelector('[data-action="cancel"]')?.addEventListener('click', () => dialog.close());

        dialog.querySelector('[data-action="save"]')?.addEventListener('click', () => {
            const comp = getPortfolioBlockComponent();
            if (!comp) {
                dialog.close();
                return;
            }
            const cardLine = dialog.querySelector('[name="portfolio-card-ids"]').value;
            const ids = dialog.querySelector('[name="portfolio-ids"]').value.trim();
            const slugs = dialog.querySelector('[name="portfolio-slugs"]').value.trim();
            const raw = cardLine.trim();
            let parts = [];
            if (raw) {
                parts = raw.includes(',')
                    ? raw.split(',').map((s) => s.trim())
                    : raw.split(/[\s,]+/)
                          .map((s) => s.trim())
                          .filter(Boolean);
            }
            const items = collectPortfolioItems(comp);
            items.forEach((ic, i) => {
                if (i < parts.length) {
                    ic.addAttributes({ 'data-portfolio-project-id': parts[i] });
                }
            });
            comp.addAttributes({
                'data-portfolio-project-ids': ids,
                'data-portfolio-project-slugs': slugs,
            });
            this.updateFilamentFormState();
            dialog.close();
        });
    }

    wireCanvasDarkMode() {
        if (!this.editor) {
            return;
        }
        const apply = () => syncGrapesJsCanvasDarkMode(this.editor);

        apply();
        this.editor.on('canvas:frame:load', apply);

        if (typeof MutationObserver === 'undefined') {
            return;
        }

        this._canvasDarkModeObserver?.disconnect();
        this._canvasDarkModeObserver = new MutationObserver(apply);
        this._canvasDarkModeObserver.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class'],
        });
    }

    /**
     * Animated blocks need Alpine inside the GrapesJS iframe; forms need JS (inline scripts are stripped).
     */
    wireCanvasAlpineLifecycle() {
        if (!this.editor) {
            return;
        }
        const refresh = () => {
            setTimeout(() => this.refreshCanvasAlpineAndForms(), 100);
        };
        this.editor.on('load', refresh);
        this.editor.on('canvas:frame:load', refresh);
        this.editor.on('component:add', refresh);
        this.editor.on('component:update', refresh);
    }

    initAlpineInCanvas(retries = 0) {
        if (!this.editor) {
            return;
        }
        const frame = this.editor.Canvas?.getFrameEl?.();
        if (!frame?.contentWindow) {
            return;
        }
        const win = frame.contentWindow;
        const doc = frame.contentDocument;
        if (!doc?.body) {
            if (retries < 60) {
                setTimeout(() => this.initAlpineInCanvas(retries + 1), 80);
            }
            return;
        }
        if (win.Alpine && typeof win.Alpine.initTree === 'function') {
            try {
                win.Alpine.initTree(doc.body);
            } catch (e) {
                console.warn('Alpine initTree in GrapesJS canvas failed', e);
            }
            return;
        }
        if (retries < 100) {
            setTimeout(() => this.initAlpineInCanvas(retries + 1), 80);
        }
    }

    refreshCanvasAlpineAndForms() {
        syncGrapesJsCanvasDarkMode(this.editor);
        this.initAlpineInCanvas();
        const frame = this.editor?.Canvas?.getFrameEl?.();
        if (frame?.contentDocument) {
            setTimeout(() => initDynamicForms(frame.contentDocument), 60);
        }
    }

    loadExistingContent() {
        const data = this.options.initialData;

        const pickHtmlCss = (obj) => {
            if (!obj || typeof obj !== 'object') {
                return null;
            }
            const rawHtml = obj.html;
            if (rawHtml === undefined || rawHtml === null) {
                return null;
            }
            const html = String(rawHtml);
            if (html.trim() === '') {
                return null;
            }
            const rawCss = obj.css;
            const css =
                rawCss !== undefined && rawCss !== null ? String(rawCss) : '';
            return { html, css };
        };

        let resolved = null;
        if (data && typeof data === 'object' && Object.keys(data).length > 0) {
            resolved = pickHtmlCss(data);
            if (!resolved && data.original_grapesjs) {
                resolved = pickHtmlCss(data.original_grapesjs);
            }
            if (!resolved && data.grapesjs_data) {
                const g = data.grapesjs_data;
                resolved = pickHtmlCss(g);
                if (!resolved && g.original_grapesjs) {
                    resolved = pickHtmlCss(g.original_grapesjs);
                }
            }
        }

        if (resolved) {
            this.editor.setComponents(resolved.html);
            if (resolved.css.trim() !== '') {
                this.editor.setStyle(resolved.css);
            }
        }
        setTimeout(() => this.refreshCanvasAlpineAndForms(), 350);
    }

    setupChangeListeners() {
        const updateState = () => {
            if (this.options.mode === 'backend') {
                this.updateFilamentFormState();
            }
        };
        
        // Listen to all relevant events
        this.editor.on('component:add', updateState);
        this.editor.on('component:remove', updateState);
        this.editor.on('component:update', updateState);
        this.editor.on('change:changedComponent', updateState);
        this.editor.on('change:changedStyle', updateState);
        this.editor.on('component:selected', updateState);
        this.editor.on('component:deselected', updateState);
        this.editor.on('style:change', updateState);
        this.editor.on('canvas:drop', updateState);
        this.editor.on('canvas:dragend', updateState);
        this.editor.on('change', updateState);
    }

    updateFilamentFormState(data = null) {
        if (!this.editor) return;
        
        const html = this.editor.getHtml();
        const css = this.editor.getCss();
        const editorData = data || {
            html: html,
            css: css,
            data: this.editor.getProjectData(),
            last_updated: new Date().toISOString()
        };
        
        // Wrap the data in the structure that Filament expects
        const formData = {
            grapesjs_data: editorData
        };
        
        const form = this.wrapper.closest('form');
        if (form) {
            // Method 1: Update hidden input field by name
            let hiddenInput = form.querySelector(`input[name="${this.options.statePath}"]`);
            if (hiddenInput) {
                hiddenInput.value = JSON.stringify(formData);
                hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
            
            // Method 2: Find Filament field wrapper and update its input
            const fieldWrapper = this.wrapper.closest('[data-field-wrapper]');
            if (fieldWrapper) {
                const filamentInput = fieldWrapper.querySelector('input[type="hidden"]');
                if (filamentInput) {
                    filamentInput.value = JSON.stringify(formData);
                    filamentInput.dispatchEvent(new Event('input', { bubbles: true }));
                    filamentInput.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
            
            // Method 3: Create hidden input if it doesn't exist
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = this.options.statePath;
                form.appendChild(hiddenInput);
                hiddenInput.value = JSON.stringify(formData);
                hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
            
            // Method 4: Trigger Filament-specific events
            if (fieldWrapper) {
                fieldWrapper.dispatchEvent(new CustomEvent('filament:field-changed', {
                    detail: { value: formData },
                    bubbles: true
                }));
            }
            
            form.dispatchEvent(new CustomEvent('filament:form-changed', {
                detail: { field: this.options.statePath, value: formData },
                bubbles: true
            }));
        }
    }

    /**
     * Legacy / Filament blade hook — same as updateFilamentFormState (used before Livewire submit).
     */
    syncToFormBeforeSubmit() {
        this.updateFilamentFormState();
    }

    async saveContent() {
        if (this.options.mode === 'backend') {
            // Backend: Make AJAX request to save endpoint
            const html = this.editor.getHtml();
            const css = this.editor.getCss();
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                alert('CSRF token not found. Please refresh the page and try again.');
                return;
            }
            
            // Get the save URL from the editor element data
            const editorElement = document.getElementById(this.options.containerId);
            let saveUrl = editorElement?.dataset.saveUrl;
            
            // If no save URL is provided, try to construct it from the current page
            if (!saveUrl) {
                const pageId = editorElement?.dataset.pageId;
                if (pageId) {
                    saveUrl = `/admin/pages/${pageId}/save-grapesjs`;
                } else {
                    // Try to extract page ID from the current URL
                    const currentUrl = window.location.pathname;
                    const match = currentUrl.match(/\/admin\/pages\/(\d+)\/edit/);
                    if (match) {
                        const extractedPageId = match[1];
                        saveUrl = `/admin/pages/${extractedPageId}/save-grapesjs`;
                    }
                }
            }
            
            if (!saveUrl) {
                alert('Save URL not found. Please refresh the page and try again.');
                return;
            }
            
            try {
                const response = await fetch(saveUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ html, css }),
                    credentials: 'same-origin'
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    this.showSaveStatus('success', result.message || 'Page builder content saved!');
                    
                    // Update the Filament form state with the saved data
                    this.updateFilamentFormState();
                    
                    // Also ensure the form field is properly updated
                    const form = this.wrapper.closest('form');
                    if (form) {
                        // Dispatch a custom event for any listeners
                        const syncEvent = new CustomEvent('grapesjs-sync', {
                            detail: {
                                field: this.options.statePath,
                                data: { grapesjs_data: {
                                    html: html,
                                    css: css,
                                    data: this.editor.getProjectData(),
                                    last_updated: new Date().toISOString(),
                                    saved_via_ajax: true
                                }}
                            },
                            bubbles: true
                        });
                        
                        form.dispatchEvent(syncEvent);
                    }
                } else {
                    this.showSaveStatus('error', 'Save failed: ' + (result.message || result.error || 'Unknown error'));
                }
            } catch (error) {
                console.error('Save error:', error);
                this.showSaveStatus('error', 'Save error: ' + error.message);
            }
        } else {
            // Frontend: POST to saveUrl
            const html = this.editor.getHtml();
            const css = this.editor.getCss();
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                alert('CSRF token not found. Please refresh the page and try again.');
                return;
            }
            try {
                const response = await fetch(this.options.saveUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ html, css }),
                    credentials: 'same-origin'
                });
                const result = await response.json();
                if (!(response.ok && result.success)) {
                    alert('Save failed: ' + (result.message || result.error));
                }
            } catch (error) {
                alert('Save error: ' + error.message);
            }
        }
    }

    setupEventListeners() {
        // Fullscreen toggle
        if (this.fullscreenBtn) {
            this.fullscreenBtn.addEventListener('click', () => {
                this.toggleFullscreen();
            });
        }
        
        // Save button (backend)
        if (this.options.mode === 'backend' && this.wrapper) {
            const saveBtn = this.wrapper.querySelector('.grapesjs-save-btn');
            
            if (saveBtn) {
                const editorElement = document.getElementById(this.options.containerId);
                const saveUrl = editorElement?.dataset.saveUrl;
                
                // Always enable the save button in backend mode
                saveBtn.disabled = false;
                saveBtn.style.opacity = '1';
                saveBtn.style.cursor = 'pointer';
                saveBtn.title = 'Save page builder content';
                
                saveBtn.addEventListener('click', () => {
                    this.saveContent();
                });
            }
        }
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.exitFullscreen();
            }
        });
    }

    setupFilamentFormSubmission() {
        const form = this.wrapper.closest('form');
        if (!form) return;

        // Listen for form submit events and sync data
        form.addEventListener('submit', (e) => {
            if (this.options.mode === 'backend' && this.editor) {
                this.updateFilamentFormState();
            }
        });

        // Listen for Filament-specific events
        form.addEventListener('filament:submit', (e) => {
            if (this.options.mode === 'backend' && this.editor) {
                this.updateFilamentFormState();
            }
        });

        // Listen for button clicks that might submit the form
        document.addEventListener('mousedown', (e) => {
            const target = e.target;
            if (target && (
                target.type === 'submit' || 
                target.classList.contains('fi-btn--primary') ||
                target.closest('.fi-btn--primary') ||
                target.textContent?.toLowerCase().includes('save') ||
                target.textContent?.toLowerCase().includes('create') ||
                target.textContent?.toLowerCase().includes('update')
            )) {
                // Check if this button is in the same form
                const buttonForm = target.closest('form');
                if (buttonForm === form && this.options.mode === 'backend' && this.editor) {
                    this.updateFilamentFormState();
                }
            }
        });

        // Periodic sync to ensure data is always up to date
        setInterval(() => {
            if (this.editor && this.options.mode === 'backend') {
                this.updateFilamentFormState();
            }
        }, 5000); // Sync every 5 seconds
    }

    toggleFullscreen() {
        if (!this.wrapper) return;
        const fullscreenIcon = this.fullscreenBtn?.querySelector('.fullscreen-icon');
        const exitIcon = this.fullscreenBtn?.querySelector('.exit-fullscreen-icon');
        const editorDiv = this.wrapper.querySelector('.grapesjs-editor');
        if (this.wrapper.classList.contains('fullscreen')) {
            this.exitFullscreen();
        } else {
            this.enterFullscreen();
        }
    }
    
    enterFullscreen() {
        if (!this.wrapper) return;
        const fullscreenIcon = this.fullscreenBtn?.querySelector('.fullscreen-icon');
        const exitIcon = this.fullscreenBtn?.querySelector('.exit-fullscreen-icon');
        const editorDiv = this.wrapper.querySelector('.grapesjs-editor');
        this.wrapper.classList.add('fullscreen');
        if (fullscreenIcon) fullscreenIcon.style.display = 'none';
        if (exitIcon) exitIcon.style.display = 'block';
        if (this.fullscreenBtn) this.fullscreenBtn.title = 'Exit Fullscreen';
        if (editorDiv) editorDiv.style.height = 'calc(100vh - 120px)';
        document.body.style.overflow = 'hidden';
    }
    
    exitFullscreen() {
        if (!this.wrapper) return;
        const fullscreenIcon = this.fullscreenBtn?.querySelector('.fullscreen-icon');
        const exitIcon = this.fullscreenBtn?.querySelector('.exit-fullscreen-icon');
        const editorDiv = this.wrapper.querySelector('.grapesjs-editor');
        this.wrapper.classList.remove('fullscreen');
        if (fullscreenIcon) fullscreenIcon.style.display = 'block';
        if (exitIcon) exitIcon.style.display = 'none';
        if (this.fullscreenBtn) this.fullscreenBtn.title = 'Toggle Fullscreen Mode (Press Escape to exit)';
        if (editorDiv) editorDiv.style.height = editorDiv.dataset.height || '600px';
        document.body.style.overflow = '';
    }
    
    destroy() {
        if (this.editor) {
            this.editor.destroy();
        }
    }
    
    showSaveStatus(type, message) {
        // For backend, show a temporary notification
        if (this.options.mode === 'backend') {
            // Create a temporary notification element
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 12px 20px;
                border-radius: 8px;
                color: white;
                font-weight: 600;
                z-index: 1000000;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                transition: all 0.3s ease;
                ${type === 'success' ? 'background: #10b981;' : 'background: #ef4444;'}
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 3000);
        } else {
            // For frontend, use alert as fallback
            alert(message);
        }
    }
}

// Export globally
window.LaraGrapeGrapesJsEditor = LaraGrapeGrapesJsEditor;

/**
 * Mirror `document.documentElement` dark mode into the GrapesJS canvas iframe so theme CSS applies.
 */
function syncGrapesJsCanvasDarkMode(editor) {
    if (!editor?.Canvas?.getFrameEl) {
        return;
    }
    const iframe = editor.Canvas.getFrameEl();
    const root = iframe?.contentDocument?.documentElement;
    if (!root) {
        return;
    }
    const isDark = document.documentElement.classList.contains('dark');
    root.classList.toggle('dark', isDark);
}

function injectStylesIntoGrapesJsIframe(editor, stylesArray) {
    const iframe = editor.Canvas.getFrameEl();
    if (!iframe) return;
    const head = iframe.contentDocument.head;
    // Remove any previously injected styles to avoid duplicates
    Array.from(head.querySelectorAll('[data-grapey-injected]')).forEach(el => el.remove());
    stylesArray.forEach(style => {
        let el;
        if (style.startsWith('<style')) {
            el = document.createElement('style');
            el.setAttribute('data-grapey-injected', 'true');
            el.innerHTML = style.replace(/^<style[^>]*>|<\/style>$/g, '');
        } else if (style.endsWith('.css')) {
            el = document.createElement('link');
            el.setAttribute('data-grapey-injected', 'true');
            el.rel = 'stylesheet';
            el.href = style;
        }
        if (el) head.appendChild(el);
    });
    syncGrapesJsCanvasDarkMode(editor);
}

// Global function to sync GrapesJS data before form submission
function syncGrapesJsData() {
    // Find all GrapesJS editors on the page
    const editors = document.querySelectorAll('.grapesjs-editor');
    editors.forEach(editor => {
        const editorInstance = editor.laraGrapeEditor;
        if (editorInstance && typeof editorInstance.updateFilamentFormState === 'function') {
            editorInstance.updateFilamentFormState();
        }
    });
    
    // Wrappers hold laraGrapeEditor (class: grapesjs-editor-wrapper)
    const wrappers = document.querySelectorAll('.grapesjs-editor-wrapper');
    wrappers.forEach(wrapper => {
        const editorInstance = wrapper.laraGrapeEditor;
        if (editorInstance && typeof editorInstance.updateFilamentFormState === 'function') {
            editorInstance.updateFilamentFormState();
        }
    });
}

// Make it globally available
window.syncGrapesJsData = syncGrapesJsData;
