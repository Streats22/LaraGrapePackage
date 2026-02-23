<?php

namespace LaraGrape\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'email_to',
        'subject_template',
        'success_message',
        'error_message',
        'is_active',
        'send_email_notification',
        'store_submissions',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'send_email_notification' => 'boolean',
        'store_submissions' => 'boolean',
        'settings' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($form) {
            if (empty($form->slug)) {
                $form->slug = Str::slug($form->name);
            }
        });
    }

    public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('sort_order');
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getGrapesJsConfig(): array
    {
        $formService = app(\LaraGrape\Services\FormService::class);

        return [
            'id' => 'dynamic-form-' . $this->id,
            'label' => $this->name,
            'category' => 'forms',
            'content' => $this->generateFormHtml(),
            'attributes' => [
                'form_id' => $this->id,
                'show_title' => true,
                'show_description' => true,
                'title' => $this->name,
            ],
            'description' => $this->description ?: 'Dynamic form block',
            'icon' => 'fas fa-wpforms',
            'is_dynamic_form' => true,
            'form_id' => $this->id,
        ];
    }

    public function generateFormHtml(): string
    {
        $viewName = 'filament.blocks.components.forms.form-block';
        if (! view()->exists($viewName)) {
            $viewName = 'LaraGrape::filament.blocks.forms.form-block';
        }

        return view($viewName, ['form' => $this])->render();
    }

    public function getValidationRulesAttribute()
    {
        $rules = [];

        foreach ($this->fields as $field) {
            $fieldRules = [];
            $fieldRules[] = $field->is_required ? 'required' : 'nullable';

            switch ($field->type) {
                case 'email':
                    $fieldRules[] = 'email';
                    break;
                case 'file':
                    $fieldRules[] = 'file';
                    break;
                case 'number':
                    $fieldRules[] = 'numeric';
                    break;
                case 'url':
                    $fieldRules[] = 'url';
                    break;
            }

            if ($field->validation_rules) {
                $customRules = is_array($field->validation_rules)
                    ? $field->validation_rules
                    : (json_decode($field->validation_rules, true) ?: []);
                if (is_array($customRules)) {
                    $fieldRules = array_merge($fieldRules, $customRules);
                }
            }

            $rules[$field->name] = $fieldRules;
        }

        return $rules;
    }
}
