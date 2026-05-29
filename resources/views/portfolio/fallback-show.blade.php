<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->meta_title ?: $portfolioProject->title }} - {{ config('app.name') }}</title>
    @if($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}">
    @endif
    <style>
        body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; margin: 0; background: #fafafa; color: #111827; }
        .container { max-width: 900px; margin: 0 auto; padding: 2rem 1rem; }
        .card { background: #fff; border-radius: 0.75rem; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06); padding: 1.5rem; }
        .title { margin: 0 0 1rem; font-size: 2rem; line-height: 1.2; }
        .excerpt { color: #374151; font-size: 1.1rem; }
        .back { display: inline-block; margin-top: 1.5rem; color: #2563eb; text-decoration: none; font-weight: 600; }
        .image { width: 100%; border-radius: 0.75rem; margin-bottom: 1rem; object-fit: cover; max-height: 30rem; }
    </style>
</head>
<body>
    <main class="container">
        <article class="card">
            @if($portfolioProject->featured_image)
                <img
                    class="image"
                    src="{{ Storage::url($portfolioProject->featured_image) }}"
                    alt="{{ $portfolioProject->title }}"
                >
            @endif

            <h1 class="title">{{ $portfolioProject->title }}</h1>

            @if($portfolioProject->excerpt)
                <p class="excerpt">{{ $portfolioProject->excerpt }}</p>
            @endif

            @if(! empty($portfolioProject->content))
                <div>{!! $portfolioProject->content !!}</div>
            @endif

            <a class="back" href="{{ url('/portfolio') }}">&larr; {{ __('Back to portfolio') }}</a>
        </article>
    </main>
</body>
</html>
