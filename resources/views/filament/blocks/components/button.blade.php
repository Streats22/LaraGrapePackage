{{-- @block id="button" label="Button Block" description="A customizable button block" --}}
@php $attributes = $attributes ?? new \Illuminate\View\ComponentAttributeBag([]); $slot = $slot ?? 'Button (edit me)'; @endphp
<button {{ $attributes->merge(['class' => 'btn btn-primary bg-primary-500 border-primary-600 text-primary-50 px-6 py-3 rounded-lg font-semibold transition-colors']) }} title="{{ $tooltip ?? 'Click me!' }}">
    {{ $slot }}
    </button>