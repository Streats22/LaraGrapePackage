<div 
    x-data="grapejsEditBar()"
    class="grapejs-edit-bar"
    style="background:linear-gradient(135deg, #7c3aed, #5b21b6);color:white;padding:8px 0;text-align:center;box-shadow:0 2px 8px rgba(124,58,237,0.2);font-size:15px;"
>
    <span class="font-medium">🍇 Edit this page with GrapesJS</span>
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
        background: #8b5cf6;
        color: white;
    }
    
    .grapejs-btn-primary:hover:not(:disabled) {
        background: #7c3aed;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .grapejs-btn-success {
        background: #10b981;
        color: white;
    }
    
    .grapejs-btn-success:hover:not(:disabled) {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .grapejs-btn-danger {
        background: #ef4444;
        color: white;
    }
    
    .grapejs-btn-danger:hover:not(:disabled) {
        background: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .save-status {
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 14px;
    }
</style> 