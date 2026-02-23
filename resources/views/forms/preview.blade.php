<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Preview: {{ $form->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen py-8">
<div class="container mx-auto px-4 max-w-2xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Form Preview: {{ $form->name }}</h1>
        @if($form->description)
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <p class="text-gray-700 dark:text-gray-300">{{ $form->description }}</p>
            </div>
        @endif

        <div class="form-preview">
            {!! $formHtml !!}
        </div>

        <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">Form Information</h3>
            <div class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                <p><strong>Form ID:</strong> {{ $form->id }}</p>
                <p><strong>Slug:</strong> {{ $form->slug }}</p>
                <p><strong>Fields:</strong> {{ $form->fields->count() }}</p>
                <p><strong>Email Notifications:</strong> {{ $form->send_email_notification ? 'Enabled' : 'Disabled' }}</p>
                @if($form->send_email_notification && $form->email_to)
                    <p><strong>Email To:</strong> {{ $form->email_to }}</p>
                @endif
                <p><strong>Store Submissions:</strong> {{ $form->store_submissions ? 'Enabled' : 'Disabled' }}</p>
            </div>
        </div>

        <div class="mt-6 flex space-x-4">
            <a href="{{ route('form.embed', $form) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors" target="_blank">View Embed Code</a>
        </div>
    </div>
</div>
</body>
</html>
