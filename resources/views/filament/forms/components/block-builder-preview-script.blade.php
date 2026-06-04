@php
    use Illuminate\Support\Facades\Vite;
    use LaraGrape\Support\BlockBuilderCanvasStyles;

    $canvasStyles = BlockBuilderCanvasStyles::styles();
    $previewJs = null;

    try {
        $previewJs = Vite::asset('resources/js/block-builder-preview.js');
    } catch (Throwable) {
        $previewJs = null;
    }
@endphp
@include('filament.forms.components.block-builder-preview-styles')
@if (! app()->bound('laragrape.block_builder_preview_script'))
    @php app()->instance('laragrape.block_builder_preview_script', true); @endphp
    @if($previewJs)
        <script type="module" src="{{ $previewJs }}"></script>
    @endif
    <script>
        window.laragrapeBlockBuilderCanvasStyles = @json($canvasStyles);
        if (typeof window.mountLaragrapeBlockBuilderPreviews === 'function') {
            window.mountLaragrapeBlockBuilderPreviews();
        }
    </script>
@endif
