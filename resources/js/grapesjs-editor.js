/**
 * LaraGrape Unified GrapesJS Editor
 * Works for both frontend and backend (Filament) contexts
 */

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
            ...options
        };
        this.editor = null;
        this.wrapper = null;
        this.fullscreenBtn = null;
        this.init();
    }

    init() {
        this.wrapper = document.getElementById(`wrapper-${this.options.containerId}`) || document.querySelector('.grapejs-editor-wrapper');
        this.fullscreenBtn = this.wrapper?.querySelector('.fullscreen-toggle-btn');
        if (typeof grapesjs === 'undefined') {
            console.error('GrapesJS is not loaded');
            return;
        }
        this.initializeEditor();
        this.setupEventListeners();
    }

    initializeEditor() {
        const editorElement = document.getElementById(this.options.containerId);
        if (!editorElement) {
            console.error(`Editor element with ID ${this.options.containerId} not found`);
            return;
        }
        this.editor = grapesjs.init({
            container: editorElement,
            height: this.options.height,
            width: '100%',
            fromElement: false,
            showOffsets: true,
            noticeOnUnload: false,
            storageManager: false,
            canvas: {
                styles: window.grapesjsCanvasStyles || [],
                scripts: [],
            },
            blockManager: {
                blocks: this.options.blocks
            }
        });
        this.loadExistingContent();
        this.setupChangeListeners();
        if (this.options.isDisabled) {
            this.editor.Commands.run('core:canvas-clear');
        }
        setTimeout(() => {
            this.editor.refresh();
        }, 100);
    }

    loadExistingContent() {
        const data = this.options.initialData;
        if (data && data.html) {
            this.editor.setComponents(data.html);
        }
        if (data && data.css) {
            this.editor.setStyle(data.css);
        }
    }

    setupChangeListeners() {
        const updateState = () => {
            if (this.options.mode === 'backend') {
                this.updateFilamentFormState();
            }
        };
        // Robust: listen to all relevant events
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

    updateFilamentFormState() {
        if (!this.editor) return;
        
        const html = this.editor.getHtml();
        const css = this.editor.getCss();
        const data = {
            html: html,
            css: css,
            data: this.editor.getProjectData(),
            last_updated: new Date().toISOString()
        };
        
        const form = this.wrapper.closest('form');
        if (form) {
            let hiddenInput = form.querySelector(`input[name="${this.options.statePath}"]`);
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = this.options.statePath;
                form.appendChild(hiddenInput);
            }
            
            // Update the hidden input value
            hiddenInput.value = JSON.stringify(data);
            
            // Trigger events to notify Filament
            hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
            
            // Also trigger Filament-specific events
            const fieldWrapper = this.wrapper.closest('[data-field-wrapper]');
            if (fieldWrapper) {
                fieldWrapper.dispatchEvent(new CustomEvent('filament:field-changed', {
                    detail: { value: data },
                    bubbles: true
                }));
            }
            
            // Trigger form change event
            form.dispatchEvent(new CustomEvent('filament:form-changed', {
                detail: { field: this.options.statePath, value: data },
                bubbles: true
            }));
        }
    }

    // Method to sync content before form submission
    syncToFormBeforeSubmit() {
        if (this.options.mode === 'backend' && this.editor) {
            console.log('Syncing GrapesJS content to form before submit...');
            this.updateFilamentFormState();
        }
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
                    // Also update the form state to keep it in sync
                    this.updateFilamentFormState();
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
            
            // Listen for Filament form submission to sync content
            const form = this.wrapper.closest('form');
            if (form) {
                // Listen for form submit events
                form.addEventListener('submit', (e) => {
                    this.syncToFormBeforeSubmit();
                });
                
                // Listen for Filament-specific events
                form.addEventListener('filament:submit', (e) => {
                    this.syncToFormBeforeSubmit();
                });
                
                // Also listen for button clicks that might submit the form
                document.addEventListener('click', (e) => {
                    const target = e.target;
                    if (target && (target.type === 'submit' || target.classList.contains('fi-btn--primary'))) {
                        // Check if this button is in the same form
                        const buttonForm = target.closest('form');
                        if (buttonForm === form) {
                            setTimeout(() => {
                                this.syncToFormBeforeSubmit();
                            }, 10);
                        }
                    }
                });
            }
        }
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.exitFullscreen();
            }
        });
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
        console.log('Save status:', type, message);
        
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
