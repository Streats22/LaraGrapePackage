{{-- @block id="icon" label="Icon" description="A draggable icon component with customizable icon selection" --}}
@php 
    $isEditorPreview = $isEditorPreview ?? false;
    $iconClass = $iconClass ?? 'fa-solid fa-star';
    $iconSize = $iconSize ?? 'text-4xl';
    $iconColor = $iconColor ?? 'text-primary-600 dark:text-primary-400';
    
    // Check if it's Font Awesome or Heroicon
    $isFontAwesome = strpos($iconClass, 'fa-') === 0 || strpos($iconClass, 'fa-solid') !== false || strpos($iconClass, 'fa-regular') !== false || strpos($iconClass, 'fa-brands') !== false;
@endphp
@if($isEditorPreview)
{{-- Editor preview - same as actual content but with data attributes for GrapesJS --}}
<div class="inline-flex items-center justify-center p-2" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     data-gjs-name="icon-component"
     data-gjs-selectable="false">
    @if($isFontAwesome)
        <i class="{{ $iconClass }} {{ $iconSize }} {{ $iconColor }}"
           data-gjs-type="icon"
           data-gjs-name="icon-element"
           data-gjs-editable="true"
           data-gjs-selectable="true"
           data-icon-class="{{ $iconClass }}"></i>
    @else
        {{-- Fallback to SVG for Heroicons --}}
        <svg class="{{ $iconSize }} {{ $iconColor }} w-8 h-8" 
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24" 
             xmlns="http://www.w3.org/2000/svg"
             data-gjs-type="icon"
             data-gjs-name="icon-element"
             data-gjs-editable="true"
             data-gjs-selectable="true"
             data-icon-class="{{ $iconClass }}">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
        </svg>
    @endif
</div>
@else
<div class="inline-flex items-center justify-center p-2" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     data-gjs-name="icon-component"
     data-gjs-selectable="false">
    @if($isFontAwesome)
        <i class="{{ $iconClass }} {{ $iconSize }} {{ $iconColor }}"
           data-gjs-type="icon"
           data-gjs-name="icon-element"
           data-gjs-editable="true"
           data-gjs-selectable="true"
           data-icon-class="{{ $iconClass }}"></i>
    @else
        {{-- Fallback to SVG for Heroicons --}}
        <svg class="{{ $iconSize }} {{ $iconColor }} w-8 h-8" 
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24" 
             xmlns="http://www.w3.org/2000/svg"
             data-gjs-type="icon"
             data-gjs-name="icon-element"
             data-gjs-editable="true"
             data-gjs-selectable="true"
             data-icon-class="{{ $iconClass }}">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
        </svg>
    @endif
</div>
@endif

