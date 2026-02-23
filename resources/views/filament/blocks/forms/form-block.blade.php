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
            {!! app(\LaraGrape\Services\FormService::class)->generateFormHtml($form) !!}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.dynamic-form');
    if (!form) return;

    const isDarkMode = () => document.documentElement.classList.contains('dark');

    const validateField = (field) => {
        const value = field.value.trim();
        const fieldType = field.type;
        let isValid = true;
        let errorMessage = '';

        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) existingError.remove();

        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required.';
        } else if (fieldType === 'email' && value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address.';
        } else if (fieldType === 'url' && value) {
            try { new URL(value); } catch { isValid = false; errorMessage = 'Please enter a valid URL.'; }
        }

        if (!isValid) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'field-error text-red-500 text-sm mt-1';
            errorDiv.textContent = errorMessage;
            field.parentNode.appendChild(errorDiv);
            field.classList.add('border-red-500');
        } else {
            field.classList.remove('border-red-500');
        }
        return isValid;
    };

    form.querySelectorAll('input, textarea, select').forEach(field => {
        field.addEventListener('blur', () => validateField(field));
        field.addEventListener('input', () => {
            if (field.classList.contains('border-red-500')) validateField(field);
        });
    });

    form.addEventListener('submit', function() {
        const submitButton = form.querySelector('.submit-button');
        if (submitButton) {
            const originalText = submitButton.textContent;
            submitButton.classList.add('loading');
            submitButton.textContent = 'Submitting...';
            submitButton.disabled = true;
            setTimeout(() => {
                submitButton.classList.remove('loading');
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }, 3000);
        }
    });
});
</script>
