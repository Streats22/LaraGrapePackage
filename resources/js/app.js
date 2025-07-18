import './bootstrap';
import Alpine from 'alpinejs';

// Create a store for GrapesJS editing state
Alpine.store('grapejs', {
    isEditing: false,
    isSaving: false
});

// Register Alpine components
Alpine.data('siteLayout', () => ({
    mobileMenuOpen: false,
    
    init() {
        // Close mobile menu when clicking outside
        document.addEventListener('click', (event) => {
            const menu = this.$el.querySelector('[x-show="mobileMenuOpen"]');
            const button = event.target.closest('button');
            
            if (menu && !menu.contains(event.target) && !button) {
                this.mobileMenuOpen = false;
            }
        });
    }
}));

Alpine.data('grapejsEditBar', () => ({
    isEditing: false,
    isSaving: false,
    originalScroll: 0,
    grapejsEditor: null,
    saveStatus: '', // 'success', 'error', or ''
    
    init() {
        console.log('Alpine grapejsEditBar initialized');
        // Sync local state with store
        this.isEditing = this.$store.grapejs.isEditing;
        this.isSaving = this.$store.grapejs.isSaving;
        
        // Wait for the frontend editor to be initialized
        this.waitForEditor();
    },
    
    waitForEditor() {
        if (window.frontendGrapesJsEditor) {
            this.grapejsEditor = window.frontendGrapesJsEditor;
            console.log('Frontend GrapesJS editor found:', this.grapejsEditor);
        } else {
            console.log('Frontend GrapesJS editor not found yet, retrying...');
            setTimeout(() => this.waitForEditor(), 100);
        }
    },
    
    startEditing() {
        console.log('Starting editing...');
        this.isEditing = true;
        this.$store.grapejs.isEditing = true;
        this.originalScroll = window.scrollY;
        
        // Make sure we have the editor instance
        if (!this.grapejsEditor) {
            this.waitForEditor();
        }
    },
    
    exitEditing() {
        console.log('Exiting editing...');
        this.isEditing = false;
        this.$store.grapejs.isEditing = false;
        this.saveStatus = '';
        
        // Restore scroll position
        window.scrollTo(0, this.originalScroll);
    },
    
    async saveContent() {
        console.log('Alpine saveContent() called');
        console.log('this.grapejsEditor:', this.grapejsEditor);
        
        if (!this.grapejsEditor) {
            console.error('GrapesJS editor not initialized');
            this.showSaveStatus('error', 'Editor not initialized');
            return;
        }
        
        this.isSaving = true;
        this.$store.grapejs.isSaving = true;
        
        try {
            console.log('Calling grapejsEditor.saveContent()...');
            await this.grapejsEditor.saveContent();
            console.log('saveContent() completed');
            this.showSaveStatus('success', 'Page saved successfully!');
        } catch (error) {
            console.error('Error in saveContent:', error);
            this.showSaveStatus('error', 'Save failed: ' + error.message);
        } finally {
            this.isSaving = false;
            this.$store.grapejs.isSaving = false;
        }
    },
    
    showSaveStatus(type, message) {
        console.log('Showing save status:', type, message);
        this.saveStatus = type;
        
        // Show status message
        const statusElement = this.$el.querySelector('.save-status');
        if (statusElement) {
            statusElement.textContent = message;
            statusElement.className = `save-status ${type === 'success' ? 'text-green-600' : 'text-red-600'}`;
            statusElement.style.display = 'block';
            
            setTimeout(() => {
                statusElement.style.display = 'none';
                this.saveStatus = '';
            }, 3000);
        }
    }
}));

// Frontend GrapesJS Editor Initialization
function initializeFrontendEditor() {
    if (typeof grapesjs !== 'undefined' && typeof window.LaraGrapeGrapesJsEditor !== 'undefined') {
        window.frontendGrapesJsEditor = new window.LaraGrapeGrapesJsEditor({
            containerId: 'grapejs-frontend-editor',
            mode: 'frontend',
            saveUrl: window.saveGrapesjsUrl,
            blocks: window.grapesjsBlocks,
            initialData: window.pageGrapesjsData
        });
    } else {
        setTimeout(initializeFrontendEditor, 200);
    }
}

// Make the function globally available
window.initializeFrontendEditor = initializeFrontendEditor;

// Start Alpine
Alpine.start();

// Make Alpine available globally
window.Alpine = Alpine;

// Apply dark mode preference on page load
(function() {
    const theme = localStorage.getItem('theme');
    if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();
