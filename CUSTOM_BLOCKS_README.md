# 🧑‍🎨 Custom Block Builder & Site Settings (LaraGrape Package)

LaraGrape provides a powerful custom block builder and comprehensive site settings management system with robust error handling and modern features for your Laravel application.

## 📦 Installation

```bash
composer require streats22/laragrape
php artisan laragrape:setup --all
```

## 🎯 **Custom Block Builder**

Create, manage, and use custom blocks directly from the Filament admin panel with comprehensive error handling and live preview capabilities.

### **Features**

- ✅ **Visual Block Builder** - Create blocks with HTML, CSS, and JavaScript
- ✅ **Live Preview** - See your blocks in real-time with error handling
- ✅ **GrapesJS Integration** - Blocks automatically appear in the editor
- ✅ **Category Organization** - Organize blocks by type (layouts, content, media, forms, components)
- ✅ **Custom Attributes** - Configure GrapesJS behavior and properties
- ✅ **Icon Support** - Choose icons for block identification
- ✅ **Error Handling** - Robust error recovery and validation
- ✅ **Performance Optimization** - Efficient block loading and caching

### **Creating Custom Blocks**

#### 1. Access the Block Builder
- Go to **Admin Panel** → **Custom Blocks** → **Create Custom Block**
- The builder provides a comprehensive interface with multiple tabs

#### 2. Basic Info Tab
Configure the fundamental block properties:

- **Name**: Descriptive name for your block (required)
- **Description**: What the block does and how to use it
- **Category**: Choose from layouts, content, media, forms, components
- **Icon**: Select an icon for the block manager (FontAwesome support)
- **Active**: Enable/disable the block
- **Sort Order**: Control block order in manager (lower numbers appear first)

#### 3. HTML Content Tab
Write the HTML structure for your block:

```html
<!-- Example block structure with GrapesJS editable elements -->
<div class="custom-block bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
    <div class="text-center">
        <div class="w-16 h-16 bg-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold mb-2" data-gjs-type="text" data-gjs-name="title">Block Title</h3>
        <p class="text-gray-600 mb-4" data-gjs-type="text" data-gjs-name="description">Block description goes here</p>
        <button class="btn btn-primary" data-gjs-type="text" data-gjs-name="button-text">Click Me</button>
    </div>
</div>
```

**GrapesJS Editable Elements:**
- `data-gjs-type="text"` - Makes element editable as text
- `data-gjs-name="unique-name"` - Unique identifier for the element
- `data-gjs-type="image"` - Makes element editable as image
- `data-gjs-type="link"` - Makes element editable as link

#### 4. CSS Styling Tab
Add custom styles for your block:

```css
/* Custom styles for your block */
.custom-block {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
}

.custom-block::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.custom-block:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.custom-block:hover::before {
    left: 100%;
}

/* Responsive design */
@media (max-width: 768px) {
    .custom-block {
        padding: 1rem;
    }
}
```

#### 5. JavaScript Tab
Add interactive functionality:

```javascript
// Custom JavaScript for your block
document.addEventListener("DOMContentLoaded", function() {
    const blocks = document.querySelectorAll(".custom-block");
    
    blocks.forEach(function(block) {
        // Add click event
        block.addEventListener("click", function() {
            console.log("Block clicked!");
            this.style.transform = "scale(0.95)";
            setTimeout(() => {
                this.style.transform = "scale(1)";
            }, 150);
        });
        
        // Add hover effects
        block.addEventListener("mouseenter", function() {
            this.style.cursor = "pointer";
        });
        
        // Add keyboard accessibility
        block.addEventListener("keydown", function(e) {
            if (e.key === "Enter" || e.key === " ") {
                e.preventDefault();
                this.click();
            }
        });
        
        // Make block focusable
        block.setAttribute("tabindex", "0");
    });
});
```

#### 6. GrapesJS Settings Tab
Configure how the block behaves in the GrapesJS editor:

- **Draggable**: Can the block be dragged? (default: true)
- **Droppable**: Can other blocks be dropped into it? (default: true)
- **Removable**: Can the block be removed? (default: true)
- **Copyable**: Can the block be copied? (default: true)
- **Selectable**: Can the block be selected? (default: true)
- **Custom Attributes**: Additional GrapesJS attributes as JSON

```json
{
    "draggable": true,
    "droppable": false,
    "removable": true,
    "copyable": true,
    "selectable": true,
    "category": "components",
    "label": "My Custom Block"
}
```

#### 7. Preview Tab
- **Live Preview**: See how your block will look in real-time
- **Error Display**: Shows any syntax errors or issues
- **Responsive Preview**: Test how it looks on different screen sizes
- **Validation**: Checks for common issues and provides suggestions

### **GrapesJS Integration**

Custom blocks automatically appear in the GrapesJS block manager:

**Features:**
- ✅ **Category Organization**: Blocks appear in their assigned categories
- ✅ **Custom Icons**: Your chosen icons are displayed
- ✅ **Full GrapesJS Support**: All GrapesJS features work with custom blocks
- ✅ **Editable Elements**: Elements with `data-gjs-*` attributes are editable
- ✅ **Error Recovery**: Graceful handling of block loading errors
- ✅ **Performance**: Efficient loading and caching of custom blocks

### **Best Practices**

#### 1. **Semantic HTML**
Use proper HTML structure for accessibility and SEO:

```html
<article class="feature-card">
    <header>
        <h3 data-gjs-type="text" data-gjs-name="title">Feature Title</h3>
    </header>
    <main>
        <p data-gjs-type="text" data-gjs-name="description">Description</p>
    </main>
    <footer>
        <button data-gjs-type="text" data-gjs-name="button-text">Learn More</button>
    </footer>
</article>
```

#### 2. **Make Elements Editable**
Use `data-gjs-type="text"` and `data-gjs-name="unique-name"` for editable content:

```html
<h1 data-gjs-type="text" data-gjs-name="heading">Editable Heading</h1>
<p data-gjs-type="text" data-gjs-name="content">Editable content</p>
<img data-gjs-type="image" data-gjs-name="image" src="placeholder.jpg" alt="Editable image">
<a data-gjs-type="link" data-gjs-name="link" href="#">Editable link</a>
```

#### 3. **Responsive Design**
Use Tailwind classes for mobile-first responsive design:

```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <div class="p-4 md:p-6 lg:p-8">
        <!-- Responsive content -->
    </div>
</div>
```

#### 4. **Performance Optimization**
Keep blocks lightweight and efficient:

- Use optimized images
- Minimize CSS and JavaScript
- Avoid heavy external dependencies
- Use efficient selectors

#### 5. **Naming Conventions**
Use descriptive names and avoid conflicts:

- Use kebab-case for block IDs: `my-custom-block`
- Use descriptive names: `feature-card` instead of `card`
- Avoid generic names that might conflict

---

## ⚙️ **Site Settings Management**

LaraGrape provides a comprehensive site configuration system with robust error handling and dynamic updates.

### **Setting Groups**

#### **General Settings**
- **Site Information**: Name, tagline, description
- **Contact Information**: Email, phone, address
- **Business Details**: Company info, timezone, currency
- **Social Media**: Default social media URLs

#### **Header Settings**
- **Logo Configuration**: Text logo and image logo
- **Colors**: Background and text colors
- **Navigation**: Sticky header, search bar, menu items
- **Custom CSS**: Header-specific styles

#### **Footer Settings**
- **Footer Content**: Logo, text, links
- **Colors**: Background and text colors
- **Social Media**: Social media links with icons
- **Newsletter**: Newsletter signup configuration
- **Custom CSS**: Footer-specific styles

#### **SEO Settings**
- **Meta Information**: Default titles, descriptions, keywords
- **Analytics**: Google Analytics, Google Tag Manager
- **Social Media**: Open Graph and Twitter Card settings
- **Auto-generation**: Automatic meta tag generation

#### **Social Media**
- **Platform URLs**: Facebook, Twitter, Instagram, LinkedIn, YouTube, GitHub
- **Sharing Settings**: Default sharing images and descriptions
- **Icons**: Social media icon configuration

#### **Advanced Settings**
- **Performance**: Caching options, debug mode
- **Custom Code**: Global CSS and JavaScript injection
- **Security**: Security headers and settings
- **Backup**: Settings backup and restore

### **Using Site Settings**

#### **In Blade Templates**
```php
@php
    try {
        $siteSettings = app(\App\Services\SiteSettingsService::class);
        $headerSettings = $siteSettings->getHeaderSettings();
        $footerSettings = $siteSettings->getFooterSettings();
    } catch (\Exception $e) {
        Log::error('Failed to load site settings: ' . $e->getMessage());
        $headerSettings = [];
        $footerSettings = [];
    }
@endphp

<!-- Use settings with fallbacks -->
<header style="background-color: {{ $headerSettings['background_color'] ?? '#ffffff' }}">
    {{ $headerSettings['logo_text'] ?? 'Default Site Name' }}
</header>
```

#### **In Controllers**
```php
use App\Services\SiteSettingsService;

public function index(SiteSettingsService $settings)
{
    try {
        $headerSettings = $settings->getHeaderSettings();
        $seoSettings = $settings->getSeoSettings();
        
        return view('page', compact('headerSettings', 'seoSettings'));
    } catch (\Exception $e) {
        Log::error('Site settings error: ' . $e->getMessage());
        return view('page', ['headerSettings' => [], 'seoSettings' => []]);
    }
}
```

#### **Dynamic CSS Generation**
```php
try {
    $siteSettings = app(\App\Services\SiteSettingsService::class);
    $css = $siteSettings->getAllCss();
    
    // Inject into page
    return view('page', ['dynamicCss' => $css]);
} catch (\Exception $e) {
    Log::error('CSS generation error: ' . $e->getMessage());
    return view('page', ['dynamicCss' => '']);
}
```

### **Setting Types**

| Type | Description | Example |
|------|-------------|---------|
| **Text** | Simple text input | Site name, tagline |
| **Textarea** | Multi-line text | Description, custom CSS |
| **Boolean** | Toggle switches | Enable features, debug mode |
| **Color** | Color picker | Background colors, text colors |
| **Image** | File upload | Logo, favicon |
| **Select** | Dropdown options | Theme, language |
| **JSON** | Structured data | Social media links, custom data |

### **Caching and Performance**

Settings are automatically cached for performance:

- ✅ **1-hour cache duration** by default
- ✅ **Automatic cache clearing** on updates
- ✅ **Manual cache clearing** available
- ✅ **Fallback values** for missing settings
- ✅ **Error recovery** for cache failures

```php
// Clear settings cache
Cache::forget('site_settings');

// Or use the service method
$siteSettings = app(SiteSettingsService::class);
$siteSettings->clearCache();
```

---

## 🛠️ **Integration Examples**

### **Custom Block with Site Settings**
```html
<!-- Custom block that uses site settings -->
<div class="contact-block">
    <h3 data-gjs-type="text" data-gjs-name="title">Contact Us</h3>
    <div class="contact-info">
        <p>Email: {{ $generalSettings['contact_email'] ?? 'contact@example.com' }}</p>
        <p>Phone: {{ $generalSettings['contact_phone'] ?? '+1 234 567 8900' }}</p>
        <p>Address: {{ $generalSettings['address'] ?? '123 Main St, City, State' }}</p>
    </div>
</div>
```

### **Dynamic Header with Settings**
```blade
<header class="site-header" 
        style="background-color: {{ $headerSettings['background_color'] ?? '#ffffff' }}; 
               color: {{ $headerSettings['text_color'] ?? '#000000' }};">
    <div class="logo">
        @if(!empty($headerSettings['logo_image']))
            <img src="{{ Storage::url($headerSettings['logo_image']) }}" 
                 alt="{{ $headerSettings['logo_text'] ?? 'Site Logo' }}">
        @else
            {{ $headerSettings['logo_text'] ?? 'Default Site Name' }}
        @endif
    </div>
    
    @if($headerSettings['show_search'] ?? false)
        <div class="search-bar">
            <input type="search" placeholder="Search...">
        </div>
    @endif
</header>
```

### **Social Media Footer**
```blade
@if($footerSettings['show_social'] ?? false)
    <div class="social-links">
        @if(!empty($socialSettings['facebook']))
            <a href="{{ $socialSettings['facebook'] }}" target="_blank" rel="noopener">
                <i class="fab fa-facebook"></i>
            </a>
        @endif
        
        @if(!empty($socialSettings['twitter']))
            <a href="{{ $socialSettings['twitter'] }}" target="_blank" rel="noopener">
                <i class="fab fa-twitter"></i>
            </a>
        @endif
        
        @if(!empty($socialSettings['instagram']))
            <a href="{{ $socialSettings['instagram'] }}" target="_blank" rel="noopener">
                <i class="fab fa-instagram"></i>
            </a>
        @endif
    </div>
@endif
```

---

## 🚀 **Advanced Features**

### **Block Templates**
Create reusable block templates:

1. **Design a block** in the visual builder
2. **Save as template** with descriptive name
3. **Clone and customize** for different uses
4. **Share templates** across projects

### **Block Categories**
Organize blocks by purpose and functionality:

```php
// Available categories
$categories = [
    'layouts' => 'Layout blocks (hero, section, columns)',
    'content' => 'Content blocks (text, heading, list)',
    'media' => 'Media blocks (image, video, gallery)',
    'forms' => 'Form blocks (contact, newsletter, survey)',
    'components' => 'UI components (button, card, alert)',
    'widgets' => 'Interactive widgets (weather, calendar)',
    'ecommerce' => 'E-commerce blocks (product, cart, checkout)',
    'blog' => 'Blog blocks (post, comment, author)'
];
```

### **Dynamic Block Loading**
Blocks are loaded dynamically with error handling:

```php
// Service method with error handling
public function getCustomBlocks()
{
    try {
        return CustomBlock::where('is_active', true)
                         ->orderBy('sort_order')
                         ->get();
    } catch (\Exception $e) {
        Log::error('Failed to load custom blocks: ' . $e->getMessage());
        return collect([]);
    }
}
```

### **Block Validation**
Comprehensive validation for custom blocks:

- ✅ **HTML validation** - Ensures valid HTML structure
- ✅ **CSS validation** - Checks for CSS syntax errors
- ✅ **JavaScript validation** - Validates JavaScript code
- ✅ **GrapesJS compatibility** - Ensures GrapesJS compatibility
- ✅ **Performance checks** - Warns about performance issues

### **Block Versioning**
Track changes to custom blocks:

- ✅ **Version history** - Track all changes
- ✅ **Rollback capability** - Revert to previous versions
- ✅ **Change tracking** - See what changed and when
- ✅ **Collaboration** - Multiple users can work on blocks

---

## 🔧 **Troubleshooting**

### **Common Block Issues**

#### Block Not Appearing
1. **Check if active**: Ensure block is marked as active
2. **Clear cache**: `php artisan cache:clear`
3. **Check category**: Verify block is in correct category
4. **Validate HTML**: Check for HTML syntax errors

#### Preview Not Working
1. **Check JavaScript**: Look for JavaScript errors in console
2. **Validate CSS**: Ensure CSS is valid
3. **Check GrapesJS settings**: Verify GrapesJS attributes
4. **Clear browser cache**: Hard refresh the page

#### Performance Issues
1. **Optimize images**: Use appropriate image sizes
2. **Minimize CSS/JS**: Keep code lightweight
3. **Use lazy loading**: For heavy blocks
4. **Enable caching**: Use block caching

### **Common Settings Issues**

#### Settings Not Loading
1. **Check database**: Ensure settings table exists
2. **Clear cache**: `php artisan cache:clear`
3. **Check service**: Verify SiteSettingsService is working
4. **Check permissions**: Ensure proper file permissions

#### Changes Not Reflecting
1. **Clear cache**: Settings are cached for performance
2. **Check browser cache**: Hard refresh the page
3. **Verify save**: Ensure settings were saved successfully
4. **Check logs**: Look for error messages

---

## 📊 **Performance Optimization**

### **Block Performance**
- **Lazy loading**: Load blocks only when needed
- **Caching**: Cache block data and previews
- **Minification**: Minify CSS and JavaScript
- **Image optimization**: Use optimized images

### **Settings Performance**
- **Caching**: Cache settings for 1 hour
- **Lazy loading**: Load settings only when needed
- **Database optimization**: Use efficient queries
- **CDN integration**: Use CDN for assets

---

## 🎯 **Best Practices**

### **Block Development**
- **Semantic HTML**: Use proper HTML structure
- **Accessibility**: Include ARIA labels and keyboard support
- **Performance**: Keep blocks lightweight and fast
- **Responsive**: Design for all screen sizes
- **Testing**: Test blocks thoroughly before publishing

### **Settings Management**
- **Backup regularly**: Backup settings before major changes
- **Use fallbacks**: Always provide fallback values
- **Validate input**: Validate all user input
- **Document changes**: Document setting changes
- **Test thoroughly**: Test settings across different scenarios

---

**The custom block builder and site settings system provides a powerful, flexible foundation for building dynamic, configurable websites with LaraGrape! 🧑‍🎨**

With comprehensive error handling, live preview capabilities, and robust performance optimization, you can create professional, maintainable websites with ease. 