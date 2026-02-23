<?php

namespace LaraGrape\Services;

use LaraGrape\Models\Form;
use LaraGrape\Models\FormField;
use LaraGrape\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FormService
{
    public function submitForm(Form $form, Request $request): array
    {
        $validator = Validator::make($request->all(), $form->validation_rules);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $form->error_message,
                'errors' => $validator->errors(),
            ];
        }

        $data = $validator->validated();
        $submission = null;

        if ($form->store_submissions) {
            $submission = FormSubmission::create([
                'form_id' => $form->id,
                'data' => $data,
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 500),
            ]);
        }

        if ($form->send_email_notification && $form->email_to) {
            $this->sendEmailNotification($form, $data, $submission);
        }

        return [
            'success' => true,
            'message' => $form->success_message,
            'submission_id' => $submission?->id,
        ];
    }

    protected function sendEmailNotification(Form $form, array $data, ?FormSubmission $submission): void
    {
        $subject = $this->parseTemplate($form->subject_template ?? 'New form submission from {form_name}', [
            'form_name' => $form->name,
            'submission_date' => now()->format('Y-m-d H:i:s'),
        ]);

        $emailData = [
            'form' => $form,
            'data' => $data,
            'submission_date' => now()->format('Y-m-d H:i:s'),
        ];

        $viewName = 'LaraGrape::emails.form-submission';
        if (! view()->exists($viewName)) {
            $viewName = 'emails.form-submission';
        }

        Mail::send($viewName, $emailData, function ($message) use ($form, $subject) {
            $message->to($form->email_to)
                ->subject($subject);
        });

        if ($submission) {
            $submission->update([
                'email_sent' => true,
                'email_sent_at' => now(),
            ]);
        }
    }

    protected function parseTemplate(string $template, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $template = str_replace('{'.$key.'}', (string) $value, $template);
        }

        return $template;
    }

    public function generateFormHtml(Form $form): string
    {
        $action = route('form.submit', $form);
        $html = '<form method="POST" action="'.e($action).'" enctype="multipart/form-data" class="dynamic-form flex flex-col gap-7">';
        $html .= csrf_field();

        foreach ($form->fields as $field) {
            $html .= $this->generateFieldHtml($field);
        }

        $html .= '<div class="form-submit-section mt-6">';
        $html .= '<button type="submit" class="submit-button relative overflow-hidden bg-gradient-to-r from-blue-500 to-blue-600 text-white border-3 border-blue-500 rounded-xl py-4 px-6 font-bold text-lg transition-all duration-300 cursor-pointer w-full uppercase tracking-wide hover:from-blue-600 hover:to-blue-500 hover:border-blue-600 hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-blue-200">Submit</button>';
        $html .= '</div>';
        $html .= '</form>';

        return $html;
    }

    protected function generateFieldHtml(FormField $formField): string
    {
        $required = $formField->is_required ? 'required' : '';
        $placeholder = $formField->placeholder ? 'placeholder="'.e($formField->placeholder).'"' : '';
        $helpText = $formField->help_text ? '<p class="help-text mt-2 text-sm">'.e($formField->help_text).'</p>' : '';

        $html = '<div class="form-field flex flex-col gap-2">';
        $html .= '<label for="'.e($formField->name).'" class="field-label text-sm font-semibold flex items-center gap-1">';
        $html .= e($formField->label);
        if ($formField->is_required) {
            $html .= '<span class="required-indicator font-bold text-red-500">*</span>';
        }
        $html .= '</label>';

        $optionsArray = $formField->options_array ?? [];

        switch ($formField->type) {
            case 'textarea':
                $html .= '<textarea name="'.e($formField->name).'" id="'.e($formField->name).'" '.$required.' '.$placeholder.' rows="4" class="field-input w-full px-4 py-3 text-base transition-all duration-200 font-inherit min-h-[120px] resize-y leading-relaxed rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 placeholder-gray-500 dark:placeholder-gray-400"></textarea>';
                break;

            case 'select':
                $html .= '<select name="'.e($formField->name).'" id="'.e($formField->name).'" '.$required.' class="field-input w-full px-4 py-3 text-base transition-all duration-200 appearance-none bg-no-repeat bg-right pr-10 cursor-pointer rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800" style="background-image: url(\'data:image/svg+xml,%3csvg xmlns=\\\'http://www.w3.org/2000/svg\\\' fill=\\\'none\\\' viewBox=\\\'0 0 20 20\\\'%3e%3cpath stroke=\\\'%236b7280\\\' stroke-linecap=\\\'round\\\' stroke-linejoin=\\\'round\\\' stroke-width=\\\'1.5\\\' d=\\\'m6 8 4 4 4-4\\\'/%3e%3c/svg%3e\'); background-size: 1.5em 1.5em;">';
                $html .= '<option value="">Select an option</option>';
                foreach ($optionsArray as $option) {
                    $value = $option['value'] ?? $option;
                    $label = $option['label'] ?? $value;
                    $html .= '<option value="'.e($value).'">'.e($label).'</option>';
                }
                $html .= '</select>';
                break;

            case 'radio':
                $html .= '<div class="radio-group flex flex-col gap-3">';
                foreach ($optionsArray as $option) {
                    $value = $option['value'] ?? $option;
                    $label = $option['label'] ?? $value;
                    $optId = e($formField->name.'_'.$value);
                    $html .= '<div class="radio-option flex items-center gap-3 p-3 rounded-lg transition-colors duration-200 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600">';
                    $html .= '<input type="radio" name="'.e($formField->name).'" id="'.$optId.'" value="'.e($value).'" '.$required.' class="radio-input w-4 h-4 cursor-pointer accent-blue-500">';
                    $html .= '<label for="'.$optId.'" class="radio-label text-sm font-medium cursor-pointer flex-1">'.e($label).'</label>';
                    $html .= '</div>';
                }
                $html .= '</div>';
                break;

            case 'checkbox':
                $html .= '<div class="checkbox-group flex flex-col gap-3">';
                foreach ($optionsArray as $option) {
                    $value = $option['value'] ?? $option;
                    $label = $option['label'] ?? $value;
                    $optId = e($formField->name.'_'.$value);
                    $html .= '<div class="checkbox-option flex items-center gap-3 p-3 rounded-lg transition-colors duration-200 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600">';
                    $html .= '<input type="checkbox" name="'.e($formField->name).'[]" id="'.$optId.'" value="'.e($value).'" class="checkbox-input w-4 h-4 cursor-pointer accent-blue-500">';
                    $html .= '<label for="'.$optId.'" class="checkbox-label text-sm font-medium cursor-pointer flex-1">'.e($label).'</label>';
                    $html .= '</div>';
                }
                $html .= '</div>';
                break;

            case 'file':
                $html .= '<input type="file" name="'.e($formField->name).'" id="'.e($formField->name).'" '.$required.' class="field-input w-full px-3 py-2 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-500 file:text-white hover:file:bg-blue-600 file:cursor-pointer rounded-lg">';
                break;

            default:
                $html .= '<input type="'.e($formField->type).'" name="'.e($formField->name).'" id="'.e($formField->name).'" '.$required.' '.$placeholder.' class="field-input w-full px-4 py-3 text-base transition-all duration-200 font-inherit rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 placeholder-gray-500 dark:placeholder-gray-400">';
                break;
        }

        $html .= $helpText;
        $html .= '</div>';

        return $html;
    }
}
