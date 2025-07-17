<div class="block-preview-container border-l-4 border-accent shadow-lg">
    <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
        <div class="text-sm text-primary-700 mb-2 font-semibold">Block Preview:</div>
        <div class="block-preview-content bg-primary-50 rounded border p-4">
            {!! $content !!}
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
    .block-preview-content img {
        max-width: 100%;
        height: auto;
    }
    .block-preview-content button,
    .block-preview-content .btn {
        cursor: pointer;
    }
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
</div> 