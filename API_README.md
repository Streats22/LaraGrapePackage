# 🔧 LaraGrape API Documentation

Comprehensive documentation for LaraGrape service classes, methods, and integration points.

## 📦 Service Classes

### BlockService

The `BlockService` handles dynamic block loading, management, and GrapesJS integration.

#### Location
```php
App\Services\BlockService
```

#### Key Methods

##### `getBlocks()`
Returns all available blocks organized by category.

```php
use App\Services\BlockService;

$blockService = new BlockService();
$blocks = $blockService->getBlocks();

// Returns:
[
    'components' => [
        [
            'id' => 'button',
            'label' => 'Button',
            'content' => '<button class="btn">Click me</button>',
            'category' => 'components'
        ],
        // ... more blocks
    ],
    'layouts' => [
        // ... layout blocks
    ],
    // ... more categories
]
```

##### `getGrapesJsBlocks()`
Returns blocks formatted for GrapesJS block manager.

```php
$grapesJsBlocks = $blockService->getGrapesJsBlocks();

// Returns array of blocks with GrapesJS format:
[
    [
        'id' => 'button',
        'label' => 'Button',
        'content' => '<button class="btn">Click me</button>',
        'category' => 'components',
        'attributes' => [
            'draggable' => true,
            'droppable' => true,
            'removable' => true,
            'copyable' => true
        ]
    ]
]
```

##### `renderBlockPreview($blockId)`
Renders a block preview for the GrapesJS editor.

```php
$preview = $blockService->renderBlockPreview('button');
// Returns HTML string of the block
```

##### `findBlockFileById($blockId)`
Finds the Blade file path for a block by ID.

```php
$filePath = $blockService->findBlockFileById('button');
// Returns: /path/to/resources/views/filament/blocks/components/button.blade.php
```

#### Block Discovery

The service automatically scans for blocks in:
```
resources/views/filament/blocks/
├── components/
├── content/
├── forms/
├── layouts/
└── media/
```

#### Block Metadata

Blocks are defined with metadata comments:

```blade
{{-- @block id="my-block" label="My Block" description="Description" --}}
<div class="my-block">
    <h3 data-gjs-type="text" data-gjs-name="title">Title</h3>
</div>
```

---

### SiteSettingsService

The `SiteSettingsService` manages site-wide configuration and settings.

#### Location
```php
App\Services\SiteSettingsService
```

#### Key Methods

##### `getSettings()`
Returns all site settings as an array.

```php
use App\Services\SiteSettingsService;

$siteSettings = new SiteSettingsService();
$settings = $siteSettings->getSettings();

// Returns all settings from database
```

##### `getSetting($key, $default = null)`
Gets a specific setting by key.

```php
$siteName = $siteSettings->getSetting('site_name', 'Default Site Name');
$logoUrl = $siteSettings->getSetting('logo_url');
```

##### `getHeaderSettings()`
Returns header-specific settings.

```php
$headerSettings = $siteSettings->getHeaderSettings();

// Returns:
[
    'logo_text' => 'Site Name',
    'logo_image' => '/path/to/logo.png',
    'background_color' => '#ffffff',
    'text_color' => '#000000',
    'sticky_header' => true,
    'show_search' => false
]
```

##### `getFooterSettings()`
Returns footer-specific settings.

```php
$footerSettings = $siteSettings->getFooterSettings();

// Returns:
[
    'footer_text' => '© 2024 Site Name',
    'background_color' => '#f8f9fa',
    'text_color' => '#6c757d',
    'show_social' => true,
    'social_links' => [
        'facebook' => 'https://facebook.com/site',
        'twitter' => 'https://twitter.com/site'
    ]
]
```

##### `getSeoSettings()`
Returns SEO-related settings.

```php
$seoSettings = $siteSettings->getSeoSettings();

// Returns:
[
    'default_title' => 'Site Name',
    'default_description' => 'Site description',
    'default_keywords' => 'keyword1, keyword2',
    'google_analytics' => 'GA_TRACKING_ID'
]
```

##### `getAllCss()`
Generates CSS from settings for dynamic styling.

```php
$css = $siteSettings->getAllCss();

// Returns CSS string with dynamic values from settings
```

#### Setting Categories

- **General**: Site name, contact info, address
- **Header**: Logo, colors, navigation settings
- **Footer**: Footer content, social links
- **SEO**: Meta tags, analytics
- **Social**: Social media URLs
- **Advanced**: Custom CSS, JavaScript

---

### GrapesJsConverterService

The `GrapesJsConverterService` handles conversion between GrapesJS data and HTML.

#### Location
```php
App\Services\GrapesJsConverterService
```

#### Key Methods

##### `convertToHtml($grapesJsData)`
Converts GrapesJS JSON data to HTML.

```php
use App\Services\GrapesJsConverterService;

$converter = new GrapesJsConverterService();
$html = $converter->convertToHtml($grapesJsJsonData);

// Returns rendered HTML string
```

##### `convertToGrapesJs($html)`
Converts HTML to GrapesJS format (if needed).

```php
$grapesJsData = $converter->convertToGrapesJs($html);
```

##### `extractStyles($grapesJsData)`
Extracts CSS styles from GrapesJS data.

```php
$styles = $converter->extractStyles($grapesJsData);

// Returns CSS string
```

---

## 🎯 Model Classes

### Page Model

#### Location
```php
App\Models\Page
```

#### Key Properties
```php
protected $fillable = [
    'title',
    'slug',
    'content',
    'grapesjs_data',
    'blade_content',
    'meta_title',
    'meta_description',
    'meta_keywords',
    'is_published',
    'published_at',
    'template'
];
```

#### Key Methods

##### `getRouteKeyName()`
Returns 'slug' for route model binding.

##### `scopePublished($query)`
Scope for published pages only.

```php
$publishedPages = Page::published()->get();
```

### CustomBlock Model

#### Location
```php
App\Models\CustomBlock
```

#### Key Properties
```php
protected $fillable = [
    'name',
    'description',
    'category',
    'html_content',
    'css_content',
    'js_content',
    'grapesjs_attributes',
    'is_active',
    'sort_order'
];
```

### SiteSettings Model

#### Location
```php
App\Models\SiteSettings
```

#### Key Properties
```php
protected $fillable = [
    'key',
    'value',
    'type',
    'group'
];
```

### TailwindConfig Model

#### Location
```php
App\Models\TailwindConfig
```

#### Key Methods

##### `generateUtilityClassesCss()`
Generates CSS for utility classes.

##### `generateSiteThemeCss()`
Generates CSS for site theme.

##### `generateAdminThemeCss()`
Generates CSS for admin theme.

---

## 🛠️ Controller Classes

### PageController

#### Location
```php
App\Http\Controllers\PageController
```

#### Key Methods

##### `show($slug)`
Displays a page by slug.

```php
public function show($slug)
{
    $page = Page::where('slug', $slug)->published()->firstOrFail();
    return view('pages.show', compact('page'));
}
```

### AdminPageController

#### Location
```php
App\Http\Controllers\AdminPageController
```

#### Key Methods

##### `blockPreview($blockId)`
Serves block previews for GrapesJS.

```php
public function blockPreview($blockId)
{
    $blockService = new BlockService();
    $preview = $blockService->renderBlockPreview($blockId);
    
    return response($preview)->header('Content-Type', 'text/html');
}
```

---

## 🎨 Filament Resources

### PageResource

#### Location
```php
App\Filament\Resources\PageResource
```

#### Key Features
- Tabbed interface (Basic Info, Visual Editor, Content, SEO)
- GrapesJS editor integration
- SEO management
- Publishing controls

### CustomBlockResource

#### Location
```php
App\Filament\Resources\CustomBlockResource
```

#### Key Features
- Visual block builder
- Live preview
- HTML/CSS/JS editors
- GrapesJS integration

### SiteSettingsResource

#### Location
```php
App\Filament\Resources\SiteSettingsResource
```

#### Key Features
- Grouped settings interface
- Color pickers
- File uploads
- Dynamic form fields

### TailwindConfigResource

#### Location
```php
App\Filament\Resources\TailwindConfigResource
```

#### Key Features
- Color palette management
- Typography settings
- Spacing configuration
- Theme generation

---

## 🔧 Artisan Commands

### LaraGrapeSetupCommand

#### Usage
```bash
php artisan laragrape:setup [options]
```

#### Options
- `--all`: Complete setup
- `--migrate`: Run migrations
- `--seed`: Run seeders
- `--force`: Overwrite files

### RebuildTailwindCommand

#### Usage
```bash
php artisan tailwind:rebuild
```

#### Features
- Generates dynamic CSS from TailwindConfig
- Creates utility classes
- Updates theme files
- Copies to public directory

---

## 🎯 Integration Examples

### Using Services in Controllers

```php
use App\Services\BlockService;
use App\Services\SiteSettingsService;

class HomeController extends Controller
{
    public function index(BlockService $blockService, SiteSettingsService $siteSettings)
    {
        $blocks = $blockService->getGrapesJsBlocks();
        $headerSettings = $siteSettings->getHeaderSettings();
        
        return view('home', compact('blocks', 'headerSettings'));
    }
}
```

### Using Services in Blade Views

```php
@php
    $siteSettings = app(\App\Services\SiteSettingsService::class);
    $headerSettings = $siteSettings->getHeaderSettings();
@endphp

<header style="background-color: {{ $headerSettings['background_color'] }}">
    {{ $headerSettings['logo_text'] }}
</header>
```

### Custom Block Integration

```php
use App\Services\BlockService;

$blockService = new BlockService();
$customBlocks = $blockService->getBlocks();

// Add to GrapesJS
foreach ($customBlocks as $category => $blocks) {
    foreach ($blocks as $block) {
        // Add to GrapesJS block manager
    }
}
```

---

## 🔍 Error Handling

All services include comprehensive error handling:

```php
try {
    $blocks = $blockService->getBlocks();
} catch (\Exception $e) {
    Log::error('Failed to load blocks: ' . $e->getMessage());
    $blocks = []; // Fallback to empty array
}
```

---

## 📚 Additional Resources

- [Setup Guide](LARALGRAPE_SETUP.md)
- [Block System](BLOCKS_README.md)
- [Component System](COMPONENTS_README.md)
- [Custom Blocks](CUSTOM_BLOCKS_README.md)

---

**The API is designed to be intuitive, extensible, and well-documented for easy integration into your Laravel applications! 🔧** 