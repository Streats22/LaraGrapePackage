{{-- @block id="hero" label="Hero Block" description="A hero section with background image support" --}}
<section {{ $attributes->merge(['class' => 'relative py-24 md:py-36 flex items-center justify-center text-center bg-primary-50 dark:bg-primary-900']) }} @if(!empty($background)) style="background-image: url('{{ $background }}'); background-size: cover; background-position: center;" @endif>
    <div class="relative z-10">
        {{ $slot }}
    </div>
    <div class="absolute inset-0 bg-black/30 dark:bg-black/50 z-0"></div>
</section> 