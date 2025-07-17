{{-- @block id="section" label="Section Block" description="A layout section block" --}}
<section {{ $attributes->merge(['class' => 'py-12 md:py-20']) }}>
    @if(!empty($title))
        <h2 class="text-3xl font-bold mb-6">{{ $title }}</h2>
@endif 
    {{ $slot }}
</section> 