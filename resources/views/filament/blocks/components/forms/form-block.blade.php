<div data-form-id="{{ $form->id }}" class="form-block w-full max-w-2xl mx-auto p-8">
    <div class="form-container rounded-2xl p-10 shadow-lg dark:shadow-xl animate-form-slide-in">
        <div class="form-header text-center mb-8">
            <h3 class="form-title text-3xl font-bold mb-3 leading-tight">
                {{ $form->name }}
            </h3>
            @if($form->description)
                <p class="form-description text-base leading-relaxed max-w-md mx-auto">
                    {{ $form->description }}
                </p>
            @endif
        </div>
        
        <div class="form-content w-full">
            {!! app(class_exists(\App\Services\FormService::class) ? \App\Services\FormService::class : \LaraGrape\Services\FormService::class)->generateFormHtml($form) !!}
        </div>
    </div>
</div>
{{-- Form behaviour: resources/js/form-blocks.js --}}
