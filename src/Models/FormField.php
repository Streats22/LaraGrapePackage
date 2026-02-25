<?php

namespace LaraGrape\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'label',
        'name',
        'type',
        'placeholder',
        'help_text',
        'is_required',
        'is_unique',
        'sort_order',
        'options',
        'validation_rules',
        'settings',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_unique' => 'boolean',
        'options' => 'array',
        'validation_rules' => 'array',
        'settings' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function getOptionsArrayAttribute(): array
    {
        if (! $this->options) {
            return [];
        }

        $opts = $this->options;

        return is_array($opts) ? $opts : (json_decode((string) $opts, true) ?? []);
    }

    public function getValidationRulesArrayAttribute(): array
    {
        if (! $this->validation_rules) {
            return [];
        }

        return is_array($this->validation_rules) ? $this->validation_rules : (json_decode($this->validation_rules, true) ?? []);
    }

    public static function getFieldTypes()
    {
        return [
            'text' => 'Text Input',
            'email' => 'Email Input',
            'textarea' => 'Text Area',
            'number' => 'Number Input',
            'tel' => 'Phone Number',
            'url' => 'URL Input',
            'password' => 'Password Input',
            'select' => 'Dropdown Select',
            'radio' => 'Radio Buttons',
            'checkbox' => 'Checkbox',
            'file' => 'File Upload',
            'date' => 'Date Input',
            'datetime-local' => 'Date & Time Input',
            'time' => 'Time Input',
            'hidden' => 'Hidden Field',
        ];
    }
}
