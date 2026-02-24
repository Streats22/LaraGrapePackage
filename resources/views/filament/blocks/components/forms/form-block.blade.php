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
            {!! app(\App\Services\FormService::class)->generateFormHtml($form) !!}
        </div>
    </div>
</div>

<script>
// Enhanced form functionality with your existing dark mode system
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.dynamic-form');
    if (!form) return;

    // Use your existing dark mode detection
    const isDarkMode = () => {
        return document.documentElement.classList.contains('dark');
    };

    // Real-time validation
    const validateField = (field) => {
        const value = field.value.trim();
        const fieldType = field.type;
        let isValid = true;
        let errorMessage = '';

        // Remove existing error
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }

        // Validation rules
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required.';
        } else if (fieldType === 'email' && value && !isValidEmail(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address.';
        } else if (fieldType === 'url' && value && !isValidUrl(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid URL.';
        }

        // Show/hide error
        if (!isValid) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'field-error';
            errorDiv.textContent = errorMessage;
            field.parentNode.appendChild(errorDiv);
            field.classList.add('border-red-500');
        } else {
            field.classList.remove('border-red-500');
        }

        return isValid;
    };

    const isValidEmail = (email) => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    };

    const isValidUrl = (url) => {
        try {
            new URL(url);
            return true;
        } catch {
            return false;
        }
    };

    // Add validation to all fields
    const fields = form.querySelectorAll('input, textarea, select');
    fields.forEach(field => {
        field.addEventListener('blur', () => validateField(field));
        field.addEventListener('input', () => {
            if (field.classList.contains('border-red-500')) {
                validateField(field);
            }
        });
    });

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        const submitButton = form.querySelector('.submit-button');
        const originalText = submitButton.textContent;
        
        // Show loading state
        submitButton.classList.add('loading');
        submitButton.textContent = 'Submitting...';
        submitButton.disabled = true;

        // Remove loading state after submission (success or error)
        setTimeout(() => {
            submitButton.classList.remove('loading');
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }, 3000);
    });
});
</script>