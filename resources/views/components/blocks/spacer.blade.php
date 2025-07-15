{{-- @block id="spacer" label="Spacer" description="A spacer block for adding vertical space" --}}
<div class="h-{{ $height ?? '16' }} bg-primary-100 border-2 border-dashed border-primary-300 flex items-center justify-center rounded-lg">
    <span class="text-primary-600 text-sm font-medium">Spacer ({{ ($height ?? 16) * 4 }}px)</span>
</div> 