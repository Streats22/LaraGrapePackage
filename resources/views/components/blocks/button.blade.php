{{-- @block id="button" label="Button" description="A clickable button with customizable styling" --}}
<button {{ $attributes->merge(['class' => 'bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg']) }}>
    {{ $slot }}
</button> 