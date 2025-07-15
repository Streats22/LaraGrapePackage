import './bootstrap';
import Alpine from 'alpinejs';

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
        this.originalScroll = window.scrollY;
        
        // Hide page content and show editor
        const pageContent = document.querySelector('.page-content');
        const editorWrapper = document.querySelector('.grapejs-editor-wrapper');
        
        if (pageContent) pageContent.style.display = 'none';
        if (editorWrapper) editorWrapper.style.display = 'block';
        
        // Make sure we have the editor instance
        if (!this.grapejsEditor) {
            this.waitForEditor();
        }
    },
    
    exitEditing() {
        console.log('Exiting editing...');
        this.isEditing = false;
        this.saveStatus = '';
        
        // Show page content and hide editor
        const pageContent = document.querySelector('.page-content');
        const editorWrapper = document.querySelector('.grapejs-editor-wrapper');
        
        if (pageContent) pageContent.style.display = '';
        if (editorWrapper) editorWrapper.style.display = 'none';
        
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
