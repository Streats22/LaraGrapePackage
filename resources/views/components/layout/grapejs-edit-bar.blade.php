<div 
    x-data="grapejsEditBar()"
    class="grapejs-edit-bar bg-primary-50 dark:bg-primary-900 from-primary-600 via-accent to-secondary text-primary-50 shadow-lg px-6 py-3 flex items-center justify-between gap-4 dark:bg-black dark:text-primary-50"
    style="box-shadow:0 2px 8px rgba(124,58,237,0.2);font-size:15px;"
>
    <span class="font-medium text-primary-900 dark:text-secondary-400">🍇 Edit this page with GrapesJS</span>
    <div class="flex gap-2">
    <button 
        @click="startEditing()"
        x-show="!isEditing"
        class="grapejs-btn grapejs-btn-primary"
    >
        Edit
    </button>
    <button 
        @click="saveContent()"
        x-show="isEditing"
        class="grapejs-btn grapejs-btn-success"
        :disabled="isSaving"
    >
        <span x-text="isSaving ? 'Saving...' : 'Save'"></span>
    </button>
    <button 
        @click="exitEditing()"
        x-show="isEditing"
        class="grapejs-btn grapejs-btn-danger"
    >
        Exit
    </button>
    </div>
    <!-- Status message -->
    <div 
        x-show="saveStatus"
        x-transition
        class="save-status"
        style="display:none;margin-top:8px;font-weight:500;"
    ></div>
</div>

<style>
    .grapejs-btn {
        margin-left: 8px;
        padding: 6px 18px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .grapejs-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .grapejs-btn-primary {
        background: var(--grapey-primary-600, #8b5cf6);
        color: var(--grapey-primary-50, #fff);
    }
    .dark .grapejs-btn-primary {
        background: var(--laralgrape-primary-700, #7c3aed);
        color: var(--laralgrape-primary-50, #fff);
    }
    .grapejs-btn-primary:hover:not(:disabled) {
        background: var(--grapey-primary-700, #7c3aed);
        color: var(--grapey-primary-50, #fff);
    }
    .dark .grapejs-btn-primary:hover:not(:disabled) {
        background: var(--laralgrape-primary-800, #581c87);
        color: var(--laralgrape-primary-100, #fff);
    }
    .grapejs-btn-success {
        background: var(--grapey-success, #10b981);
        color: var(--grapey-primary-50, #fff);
    }
    .dark .grapejs-btn-success {
        background: var(--laralgrape-success, #22d3ee);
        color: var(--laralgrape-primary-900, #fff);
    }
    .grapejs-btn-success:hover:not(:disabled) {
        background: var(--grapey-success-dark, #059669);
        color: var(--grapey-primary-50, #fff);
    }
    .dark .grapejs-btn-success:hover:not(:disabled) {
        background: var(--laralgrape-success, #22d3ee);
        color: var(--laralgrape-primary-900, #fff);
    }
    .grapejs-btn-danger {
        background: var(--grapey-error, #ef4444);
        color: var(--grapey-primary-50, #fff);
    }
    .dark .grapejs-btn-danger {
        background: var(--laralgrape-error, #ef4444);
        color: var(--laralgrape-primary-900, #fff);
    }
    .grapejs-btn-danger:hover:not(:disabled) {
        background: var(--grapey-error-dark, #dc2626);
        color: var(--grapey-primary-50, #fff);
    }
    .dark .grapejs-btn-danger:hover:not(:disabled) {
        background: var(--laralgrape-error, #ef4444);
        color: var(--laralgrape-primary-100, #fff);
    }
    
    .save-status {
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 14px;
    }
</style> 