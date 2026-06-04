@php
    use LaraGrape\Support\BlockBuilderCanvasStyles;

    $canvasStyles = BlockBuilderCanvasStyles::styles();
@endphp
@if($canvasStyles !== [])
    @foreach($canvasStyles as $style)
        @if(str_starts_with($style, '<style'))
            {!! $style !!}
        @else
            <link rel="stylesheet" href="{{ $style }}" data-laragrape-block-builder-canvas>
        @endif
    @endforeach
    <style data-laragrape-block-builder-canvas>
        .laragrape-block-preview-root { width: 100%; }
        .laragrape-block-preview-root .container {
            width: 100%;
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
        }
        .fi-prose .laragrape-block-preview-root :where(*) {
            max-width: none;
        }
    </style>
@endif
