/**
 * Dynamic form blocks (.dynamic-form) — validation, AJAX submit, toasts.
 * Used on the public site and in the GrapesJS canvas iframe.
 */

const TOAST_CONTAINER_ID = 'laragrape-form-toast-root';
const TOAST_DURATION_MS = 6500;

/**
 * CSRF from layout meta (current document or parent when form runs inside GrapesJS iframe).
 */
function getCsrfTokenFromPage() {
    const meta =
        document.querySelector('meta[name="csrf-token"]') ||
        (typeof window.parent !== 'undefined' && window.parent !== window
            ? (() => {
                  try {
                      return window.parent.document.querySelector('meta[name="csrf-token"]');
                  } catch {
                      return null;
                  }
              })()
            : null);
    return meta ? meta.getAttribute('content') || '' : '';
}

function syncCsrfToken(form) {
    const token = getCsrfTokenFromPage();
    if (!token) {
        return;
    }
    let input = form.querySelector('input[name="_token"]');
    if (!input) {
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = '_token';
        form.insertBefore(input, form.firstChild);
    }
    input.value = token;
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function isValidUrl(url) {
    try {
        new URL(url);
        return true;
    } catch {
        return false;
    }
}

function ensureToastContainer() {
    let root = document.getElementById(TOAST_CONTAINER_ID);
    if (root) {
        return root;
    }
    root = document.createElement('div');
    root.id = TOAST_CONTAINER_ID;
    root.className = 'laragrape-form-toast-root';
    root.setAttribute('aria-live', 'polite');
    root.setAttribute('aria-relevant', 'additions');
    document.body.appendChild(root);
    return root;
}

function dismissToast(toast) {
    if (!toast || toast.dataset.dismissed === '1') {
        return;
    }
    toast.dataset.dismissed = '1';
    toast.classList.add('laragrape-form-toast--leaving');
    setTimeout(() => toast.remove(), 280);
}

/**
 * @param {'success'|'error'|'info'} type
 * @param {string} message
 * @param {string} [title]
 */
export function showFormToast(type, message, title = '') {
    if (!message) {
        return;
    }

    document.documentElement.classList.add('form-toasts-enabled');

    const root = ensureToastContainer();
    const toast = document.createElement('div');
    toast.className = `laragrape-form-toast laragrape-form-toast--${type}`;
    toast.setAttribute('role', type === 'error' ? 'alert' : 'status');

    const icons = {
        success: '✓',
        error: '!',
        info: 'i',
    };

    const defaultTitles = {
        success: 'Gelukt',
        error: 'Let op',
        info: 'Melding',
    };

    const heading = title || defaultTitles[type] || 'Melding';

    toast.innerHTML = `
        <div class="laragrape-form-toast__icon" aria-hidden="true">${icons[type] || 'i'}</div>
        <div class="laragrape-form-toast__body">
            <p class="laragrape-form-toast__title">${escapeHtml(heading)}</p>
            <p class="laragrape-form-toast__message">${escapeHtml(message)}</p>
        </div>
        <button type="button" class="laragrape-form-toast__close" aria-label="Sluiten">&times;</button>
    `;

    toast.querySelector('.laragrape-form-toast__close')?.addEventListener('click', () => dismissToast(toast));

    root.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('laragrape-form-toast--visible'));

    const timer = setTimeout(() => dismissToast(toast), TOAST_DURATION_MS);
    toast.addEventListener('mouseenter', () => clearTimeout(timer));
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

export function initFormFlashFromSession() {
    const flash = window.__formFlash;
    if (!flash || !flash.message) {
        return;
    }

    showFormToast(flash.type === 'success' ? 'success' : 'error', flash.message);

    document.querySelectorAll('.form-feedback-inline').forEach((el) => {
        el.setAttribute('hidden', 'hidden');
    });
}

function clearFieldErrors(form) {
    form.querySelectorAll('.field-error').forEach((el) => el.remove());
    form.querySelectorAll('.border-red-500').forEach((el) => el.classList.remove('border-red-500'));
    form.querySelectorAll('.form-errors-inline').forEach((el) => el.remove());
}

function showFieldErrors(form, errors) {
    if (!errors || typeof errors !== 'object') {
        return;
    }

    Object.entries(errors).forEach(([name, messages]) => {
        const list = Array.isArray(messages) ? messages : [messages];
        const message = list[0];
        if (!message) {
            return;
        }

        const baseName = name.replace(/\[\]$/, '');
        let field =
            form.querySelector(`[name="${CSS.escape(name)}"]`) ||
            form.querySelector(`[name="${CSS.escape(baseName)}"]`) ||
            form.querySelector(`[name="${CSS.escape(baseName)}[]"]`);

        if (field) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'field-error';
            errorDiv.textContent = message;
            const wrapper = field.closest('.form-field') || field.parentNode;
            wrapper?.appendChild(errorDiv);
            field.classList.add('border-red-500');
        }
    });
}

function validateField(field) {
    const value = field.type === 'checkbox' || field.type === 'radio' ? field.value : field.value.trim();
    const fieldType = field.type;
    let isValid = true;
    let errorMessage = '';

    const wrapper = field.closest('.form-field') || field.parentNode;
    wrapper?.querySelector('.field-error')?.remove();

    if (field.hasAttribute('required') && field.type === 'checkbox') {
        const group = formCheckboxGroup(field);
        if (group && !group.some((cb) => cb.checked)) {
            isValid = false;
            errorMessage = 'Selecteer minimaal één optie.';
        }
    } else if (field.hasAttribute('required') && field.type === 'radio') {
        const group = formRadioGroup(field);
        if (group && !group.some((rb) => rb.checked)) {
            isValid = false;
            errorMessage = 'Selecteer een optie.';
        }
    } else if (field.hasAttribute('required') && !value && field.type !== 'checkbox' && field.type !== 'radio') {
        isValid = false;
        errorMessage = 'Dit veld is verplicht.';
    } else if (fieldType === 'email' && value && !isValidEmail(value)) {
        isValid = false;
        errorMessage = 'Vul een geldig e-mailadres in.';
    } else if (fieldType === 'url' && value && !isValidUrl(value)) {
        isValid = false;
        errorMessage = 'Vul een geldige URL in.';
    }

    if (!isValid) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = errorMessage;
        wrapper?.appendChild(errorDiv);
        field.classList.add('border-red-500');
    } else {
        field.classList.remove('border-red-500');
    }

    return isValid;
}

function formCheckboxGroup(field) {
    const name = field.name;
    const form = field.closest('form');
    return form ? [...form.querySelectorAll(`input[type="checkbox"][name="${CSS.escape(name)}"]`)] : [];
}

function formRadioGroup(field) {
    const name = field.name;
    const form = field.closest('form');
    return form ? [...form.querySelectorAll(`input[type="radio"][name="${CSS.escape(name)}"]`)] : [];
}

function validateForm(form) {
    clearFieldErrors(form);
    let valid = true;
    const seenRadio = new Set();
    const seenCheckbox = new Set();

    form.querySelectorAll('input, textarea, select').forEach((field) => {
        if (field.type === 'hidden' || field.name === '_honeypot') {
            return;
        }
        if (field.type === 'radio') {
            if (seenRadio.has(field.name)) {
                return;
            }
            seenRadio.add(field.name);
        }
        if (field.type === 'checkbox' && field.name.endsWith('[]')) {
            if (seenCheckbox.has(field.name)) {
                return;
            }
            seenCheckbox.add(field.name);
        }
        if (!validateField(field)) {
            valid = false;
        }
    });

    form.querySelectorAll('.form-field[data-required="true"]').forEach((wrapper) => {
        const checkboxes = wrapper.querySelectorAll('input[type="checkbox"]');
        const radios = wrapper.querySelectorAll('input[type="radio"]');

        if (checkboxes.length && ![...checkboxes].some((cb) => cb.checked)) {
            valid = false;
            if (!wrapper.querySelector('.field-error')) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'field-error';
                errorDiv.textContent = 'Selecteer minimaal één optie.';
                wrapper.appendChild(errorDiv);
            }
        }

        if (radios.length && ![...radios].some((rb) => rb.checked)) {
            valid = false;
            if (!wrapper.querySelector('.field-error')) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'field-error';
                errorDiv.textContent = 'Selecteer een optie.';
                wrapper.appendChild(errorDiv);
            }
        }
    });

    return valid;
}

function setSubmitting(form, submitting) {
    const submitButton = form.querySelector('.submit-button');
    if (!submitButton) {
        return;
    }
    if (submitting) {
        if (!submitButton.dataset.originalText) {
            submitButton.dataset.originalText = submitButton.textContent || 'Submit';
        }
        submitButton.classList.add('loading');
        submitButton.textContent = 'Verzenden…';
        submitButton.disabled = true;
    } else {
        submitButton.classList.remove('loading');
        submitButton.textContent = submitButton.dataset.originalText || 'Submit';
        submitButton.disabled = false;
    }
}

async function submitFormAjax(form) {
    syncCsrfToken(form);

    if (!validateForm(form)) {
        showFormToast('error', 'Controleer de gemarkeerde velden en probeer het opnieuw.');
        form.querySelector('.field-error')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    setSubmitting(form, true);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        });

        let payload = {};
        try {
            payload = await response.json();
        } catch {
            payload = { success: false, message: 'Er ging iets mis. Probeer het later opnieuw.' };
        }

        if (response.ok && payload.success) {
            showFormToast('success', payload.message || 'Bedankt! Uw bericht is verzonden.');
            form.reset();
            clearFieldErrors(form);
            form.querySelector('.form-feedback-inline')?.setAttribute('hidden', 'hidden');
            return;
        }

        const message = payload.message || 'Er ging iets mis bij het verzenden.';
        showFormToast('error', message);

        if (payload.errors) {
            showFieldErrors(form, payload.errors);
            form.querySelector('.field-error')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    } catch {
        showFormToast('error', 'Geen verbinding met de server. Controleer uw internet en probeer opnieuw.');
    } finally {
        setSubmitting(form, false);
    }
}

function bindForm(form) {
    if (form.dataset.formBlocksBound === '1') {
        return;
    }
    form.dataset.formBlocksBound = '1';

    syncCsrfToken(form);

    const fields = form.querySelectorAll('input, textarea, select');
    fields.forEach((field) => {
        field.addEventListener('blur', () => validateField(field));
        field.addEventListener('input', () => {
            if (field.classList.contains('border-red-500')) {
                validateField(field);
            }
        });
        field.addEventListener('change', () => {
            if (field.classList.contains('border-red-500')) {
                validateField(field);
            }
        });
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        submitFormAjax(form);
    });
}

/**
 * @param {Document|ParentNode} root
 */
export function initDynamicForms(root = document) {
    if (!root || !root.querySelectorAll) {
        return;
    }
    document.documentElement.classList.add('form-toasts-enabled');
    root.querySelectorAll('.dynamic-form').forEach((form) => bindForm(form));
}
