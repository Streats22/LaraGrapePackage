{{-- @block id="button" label="Button Block" description="A customizable button block" --}}
@php $isEditorPreview = $isEditorPreview ?? false; $attributes = $attributes ?? new \Illuminate\View\ComponentAttributeBag([]); $slot = $slot ?? 'Button (edit me)'; @endphp
@if($isEditorPreview)
<button class="btn btn-primary bg-primary-500 border-primary-600 text-primary-50 px-6 py-3 rounded-lg font-semibold transition-colors" title="{{ $tooltip ?? 'Click me!' }}" disabled>
    {{ $slot }}
</button>
@else
<button class="btn btn-primary bg-primary-500 border-primary-600 text-primary-50 px-6 py-3 rounded-lg font-semibold transition-colors" 
        title="{{ $tooltip ?? 'Click me!' }}"
        data-gjs-type="text" data-gjs-name="button-text">
    {{ $slot }}
</button>
@endif