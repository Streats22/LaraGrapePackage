<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Form Submission</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .field { margin-bottom: 15px; }
        .field-label { font-weight: bold; color: #555; }
        .field-value { background-color: #f8f9fa; padding: 10px; border-radius: 3px; margin-top: 5px; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Form Submission</h2>
        <p><strong>Form:</strong> {{ $form->name }}</p>
        <p><strong>Submitted:</strong> {{ $submission_date }}</p>
    </div>
    <div class="submission-data">
        @foreach($data as $field => $value)
            <div class="field">
                <div class="field-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</div>
                <div class="field-value">
                    @if(is_array($value))
                        {{ implode(', ', $value) }}
                    @else
                        {{ $value }}
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="footer">
        <p>This email was sent automatically from your website form.</p>
        <p>Form ID: {{ $form->id }}</p>
    </div>
</body>
</html>
