<?php

namespace LaraGrape\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'data',
        'ip_address',
        'user_agent',
        'email_sent',
        'email_sent_at',
    ];

    protected $casts = [
        'data' => 'array',
        'email_sent' => 'boolean',
        'email_sent_at' => 'datetime',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function getFieldValue($fieldName)
    {
        return $this->data[$fieldName] ?? null;
    }

    public function scopeForForm($query, $formId)
    {
        return $query->where('form_id', $formId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
