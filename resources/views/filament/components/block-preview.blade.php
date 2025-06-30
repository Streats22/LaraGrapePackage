<div class="block-preview-container">
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-600 mb-2">Block Preview:</div>
        <div class="block-preview-content bg-white rounded border p-4">
            {!! $content !!}
        </div>
    </div>
</div>

<style>
.block-preview-container {
    max-width: 100%;
    overflow-x: auto;
}

.block-preview-content {
    min-height: 100px;
    position: relative;
}

.block-preview-content * {
    max-width: 100%;
}

/* Ensure images don't overflow */
.block-preview-content img {
    max-width: 100%;
    height: auto;
}

/* Style any buttons or interactive elements */
.block-preview-content button,
.block-preview-content .btn {
    cursor: pointer;
}

/* Add some basic styling for common elements */
.block-preview-content h1,
.block-preview-content h2,
.block-preview-content h3,
.block-preview-content h4,
.block-preview-content h5,
.block-preview-content h6 {
    margin-top: 0;
    margin-bottom: 0.5rem;
}

.block-preview-content p {
    margin-bottom: 0.5rem;
}
</style> 