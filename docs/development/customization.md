# 🔧 Customization Guide

Learn how to customize and extend LaraGrape to fit your specific needs and requirements.

## 🚀 Overview

LaraGrape is designed to be highly customizable and extensible. You can:

- ✅ **Customize Blocks**: Modify existing blocks or create new ones
- ✅ **Extend Services**: Add new functionality to service classes
- ✅ **Modify Resources**: Customize Filament resources
- ✅ **Add Features**: Create new features and integrations
- ✅ **Theme Customization**: Customize styling and themes
- ✅ **API Extensions**: Extend the API for custom functionality

## 🧩 Block Customization

### Creating New Blocks

#### Method 1: File-Based Blocks

Create `.blade.php` files in `resources/views/filament/blocks/`:

```blade
{{-- @block id="my-custom-block" label="My Custom Block" description="A custom block for my needs" --}}
<div class="my-custom-block">
    <div class="header">
        <h3 data-gjs-type="text" data-gjs-name="title">Block Title</h3>
        <p data-gjs-type="text" data-gjs-name="subtitle">Block subtitle</p>
    </div>
    <div class="content">
        <p data-gjs-type="text" data-gjs-name="content">Main content goes here</p>
    </div>
    <div class="footer">
        <button data-gjs-type="text" data-gjs-name="button-text">Action Button</button>
    </div>
</div>
```

#### Method 2: Custom Block Builder

Use the admin panel to create blocks visually:

1. Go to **Custom Blocks** → **Create Custom Block**
2. Use the HTML, CSS, and JS tabs
3. Preview and save your block

### Block Categories

Organize blocks by creating category directories:

```bash
mkdir resources/views/filament/blocks/widgets
mkdir resources/views/filament/blocks/ecommerce
mkdir resources/views/filament/blocks/blog
```

### Advanced Block Features

#### Dynamic Content

Create blocks that load dynamic content:

```blade
{{-- @block id="dynamic-posts" label="Dynamic Posts" description="Load posts from database" --}}
<div class="dynamic-posts">
    @php
        $posts = \App\Models\Post::latest()->take(3)->get();
    @endphp
    
    @foreach($posts as $post)
        <article class="post-card">
            <h3>{{ $post->title }}</h3>
            <p>{{ Str::limit($post->excerpt, 100) }}</p>
            <a href="{{ route('posts.show', $post) }}">Read More</a>
        </article>
    @endforeach
</div>
```

#### Form Integration

Create blocks that handle forms:

```blade
{{-- @block id="contact-form" label="Contact Form" description="Contact form with validation" --}}
<form class="contact-form" method="POST" action="{{ route('contact.submit') }}">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea id="message" name="message" rows="4" required></textarea>
    </div>
    <button type="submit">Send Message</button>
</form>
```

## 🔧 Service Extensions

### Extending BlockService

Create a custom service that extends the base BlockService:

```php
<?php

namespace App\Services;

use LaraGrape\Services\BlockService as BaseBlockService;

class CustomBlockService extends BaseBlockService
{
    /**
     * Get blocks with custom filtering
     */
    public function getFilteredBlocks($category = null, $active = true)
    {
        $blocks = $this->getBlocks();
        
        if ($category) {
            $blocks = array_filter($blocks, function($block) use ($category) {
                return $block['category'] === $category;
            });
        }
        
        if ($active) {
            $blocks = array_filter($blocks, function($block) {
                return $block['active'] ?? true;
            });
        }
        
        return $blocks;
    }
    
    /**
     * Get blocks with custom metadata
     */
    public function getBlocksWithMetadata()
    {
        $blocks = $this->getBlocks();
        
        foreach ($blocks as &$block) {
            $block['metadata'] = $this->extractMetadata($block['content']);
        }
        
        return $blocks;
    }
    
    /**
     * Extract metadata from block content
     */
    private function extractMetadata($content)
    {
        // Extract custom metadata from block content
        preg_match('/data-custom-(\w+)="([^"]*)"/', $content, $matches);
        
        return [
            'custom_attribute' => $matches[2] ?? null,
        ];
    }
}
```

### Extending SiteSettingsService

Add custom settings functionality:

```php
<?php

namespace App\Services;

use LaraGrape\Services\SiteSettingsService as BaseSiteSettingsService;

class CustomSiteSettingsService extends BaseSiteSettingsService
{
    /**
     * Get theme-specific settings
     */
    public function getThemeSettings($theme = 'default')
    {
        $settings = $this->getSettings();
        
        return array_filter($settings, function($setting) use ($theme) {
            return strpos($setting['key'], "theme_{$theme}_") === 0;
        });
    }
    
    /**
     * Get settings by group with caching
     */
    public function getSettingsByGroup($group, $useCache = true)
    {
        $cacheKey = "site_settings_group_{$group}";
        
        if ($useCache && cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }
        
        $settings = $this->getSettings();
        $groupedSettings = array_filter($settings, function($setting) use ($group) {
            return $setting['group'] === $group;
        });
        
        if ($useCache) {
            cache()->put($cacheKey, $groupedSettings, now()->addHours(1));
        }
        
        return $groupedSettings;
    }
    
    /**
     * Update multiple settings at once
     */
    public function updateMultipleSettings(array $settings)
    {
        foreach ($settings as $key => $value) {
            $this->updateSetting($key, $value);
        }
        
        // Clear cache
        cache()->forget('site_settings');
        
        return true;
    }
}
```

## 🎨 Filament Resource Customization

### Customizing PageResource

Extend the PageResource for custom functionality:

```php
<?php

namespace App\Filament\Resources;

use LaraGrape\Filament\Resources\PageResource as BasePageResource;
use Filament\Forms;
use Filament\Tables;

class CustomPageResource extends BasePageResource
{
    public static function form(Forms\Form $form): Forms\Form
    {
        $form = parent::form($form);
        
        // Add custom fields
        $form->schema([
            // Your custom fields here
            Forms\Components\Select::make('template')
                ->options([
                    'default' => 'Default Template',
                    'landing' => 'Landing Page',
                    'blog' => 'Blog Post',
                    'contact' => 'Contact Page',
                ])
                ->default('default'),
                
            Forms\Components\Toggle::make('show_breadcrumbs')
                ->label('Show Breadcrumbs')
                ->default(true),
                
            Forms\Components\TextInput::make('custom_css_class')
                ->label('Custom CSS Class')
                ->placeholder('my-custom-page'),
        ]);
        
        return $form;
    }
    
    public static function table(Tables\Table $table): Tables\Table
    {
        $table = parent::table($table);
        
        // Add custom columns
        $table->columns([
            // Your custom columns here
            Tables\Columns\TextColumn::make('template')
                ->label('Template')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'landing' => 'success',
                    'blog' => 'info',
                    'contact' => 'warning',
                    default => 'gray',
                }),
                
            Tables\Columns\IconColumn::make('show_breadcrumbs')
                ->label('Breadcrumbs')
                ->boolean(),
        ]);
        
        return $table;
    }
}
```

### Customizing CustomBlockResource

Add advanced features to the block builder:

```php
<?php

namespace App\Filament\Resources;

use LaraGrape\Filament\Resources\CustomBlockResource as BaseCustomBlockResource;
use Filament\Forms;

class CustomBlockResource extends BaseCustomBlockResource
{
    public static function form(Forms\Form $form): Forms\Form
    {
        $form = parent::form($form);
        
        // Add advanced features
        $form->schema([
            // Your custom fields here
            Forms\Components\Select::make('framework')
                ->options([
                    'tailwind' => 'Tailwind CSS',
                    'bootstrap' => 'Bootstrap',
                    'custom' => 'Custom CSS',
                ])
                ->default('tailwind'),
                
            Forms\Components\Textarea::make('dependencies')
                ->label('External Dependencies')
                ->placeholder('CDN links or npm packages')
                ->rows(3),
                
            Forms\Components\Toggle::make('is_responsive')
                ->label('Responsive Design')
                ->default(true),
                
            Forms\Components\Toggle::make('has_animations')
                ->label('Include Animations')
                ->default(false),
        ]);
        
        return $form;
    }
}
```

## 🎯 Adding New Features

### Creating Custom Commands

Add new Artisan commands for custom functionality:

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CustomBlockService;

class GenerateBlockDocumentation extends Command
{
    protected $signature = 'blocks:documentation {--format=markdown}';
    protected $description = 'Generate documentation for all blocks';

    public function handle(CustomBlockService $blockService)
    {
        $blocks = $blockService->getBlocks();
        $format = $this->option('format');
        
        $this->info("Generating block documentation in {$format} format...");
        
        foreach ($blocks as $category => $categoryBlocks) {
            $this->line("Category: {$category}");
            
            foreach ($categoryBlocks as $block) {
                $this->line("  - {$block['label']}: {$block['description']}");
            }
        }
        
        $this->info('Documentation generated successfully!');
    }
}
```

### Creating Custom Middleware

Add middleware for custom functionality:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockPreviewMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Add custom logic for block previews
        if ($request->is('admin/block-preview/*')) {
            // Add custom headers or processing
            $response = $next($request);
            $response->header('X-Block-Preview', 'true');
            return $response;
        }
        
        return $next($request);
    }
}
```

### Creating Custom Events

Define custom events for extensibility:

```php
<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BlockCreated
{
    use Dispatchable, SerializesModels;

    public $block;

    public function __construct($block)
    {
        $this->block = $block;
    }
}
```

```php
<?php

namespace App\Listeners;

use App\Events\BlockCreated;

class LogBlockCreation
{
    public function handle(BlockCreated $event): void
    {
        \Log::info('Block created', [
            'block_id' => $event->block->id,
            'block_name' => $event->block->name,
            'created_at' => now(),
        ]);
    }
}
```

## 🎨 Theme Customization

### Custom CSS Variables

Define custom CSS variables for theming:

```css
/* resources/css/site.css */
:root {
    /* Custom color palette */
    --primary-color: #3b82f6;
    --secondary-color: #64748b;
    --accent-color: #f59e0b;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --error-color: #ef4444;
    
    /* Custom spacing */
    --spacing-xs: 0.25rem;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;
    
    /* Custom typography */
    --font-family-primary: 'Inter', sans-serif;
    --font-family-secondary: 'Georgia', serif;
    --font-size-base: 1rem;
    --line-height-base: 1.5;
}

/* Use variables in your styles */
.custom-block {
    background-color: var(--primary-color);
    padding: var(--spacing-lg);
    font-family: var(--font-family-primary);
}
```

### Custom Tailwind Configuration

Extend Tailwind configuration:

```javascript
// tailwind.config.js
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#eff6ff',
                    500: '#3b82f6',
                    900: '#1e3a8a',
                },
                custom: {
                    'brand-blue': '#1e40af',
                    'brand-green': '#059669',
                }
            },
            fontFamily: {
                'custom': ['Custom Font', 'sans-serif'],
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
```

## 🔧 API Extensions

### Creating Custom API Endpoints

Add custom API endpoints for your blocks:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CustomBlockService;
use Illuminate\Http\Request;

class BlockApiController extends Controller
{
    public function index(CustomBlockService $blockService)
    {
        $blocks = $blockService->getBlocks();
        
        return response()->json([
            'success' => true,
            'data' => $blocks,
            'meta' => [
                'total' => count($blocks),
                'categories' => array_keys($blocks),
            ]
        ]);
    }
    
    public function show($id, CustomBlockService $blockService)
    {
        $block = $blockService->findBlockById($id);
        
        if (!$block) {
            return response()->json([
                'success' => false,
                'message' => 'Block not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $block
        ]);
    }
    
    public function preview($id, CustomBlockService $blockService)
    {
        $preview = $blockService->renderBlockPreview($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'html' => $preview,
                'block_id' => $id
            ]
        ]);
    }
}
```

### Custom API Resources

Create API resources for structured responses:

```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlockResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'label' => $this->label,
            'description' => $this->description,
            'category' => $this->category,
            'content' => $this->content,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'preview_url' => route('api.blocks.preview', $this->id),
        ];
    }
}
```

## 🎯 Best Practices

### Code Organization

1. **Service Layer**: Keep business logic in services
2. **Resource Separation**: Separate concerns in Filament resources
3. **Event-Driven**: Use events for extensibility
4. **Configuration**: Use config files for settings

### Performance

1. **Caching**: Cache expensive operations
2. **Lazy Loading**: Load resources on demand
3. **Optimization**: Optimize database queries
4. **Assets**: Minimize and compress assets

### Security

1. **Validation**: Validate all inputs
2. **Authorization**: Check permissions
3. **Sanitization**: Sanitize user content
4. **CSRF Protection**: Use CSRF tokens

### Testing

1. **Unit Tests**: Test individual components
2. **Feature Tests**: Test complete features
3. **Integration Tests**: Test with external services
4. **Browser Tests**: Test user interactions

## 📚 Related Documentation

- [Block System](../blocks/overview.md) - Understanding blocks
- [Custom Blocks](../custom-blocks/overview.md) - Creating custom blocks
- [API Reference](../api/overview.md) - Service classes and methods
- [Admin Panel](../admin-panel/overview.md) - Admin interface

---

**Customization gives you the power to extend LaraGrape to fit your specific needs! 🔧**

With the right approach, you can create powerful, custom functionality while maintaining the core benefits of the LaraGrape system. 