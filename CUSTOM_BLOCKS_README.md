# 🧱 Custom Block Builder & Site Settings

LaralGrape now includes a powerful custom block builder and comprehensive site settings management system.

## 🎯 **Custom Block Builder**

Create, manage, and use custom blocks directly from the Filament admin panel.

### **Features**

- ✅ **Visual Block Builder** - Create blocks with HTML, CSS, and JavaScript
- ✅ **Live Preview** - See your blocks in real-time
- ✅ **GrapesJS Integration** - Blocks automatically appear in the editor
- ✅ **Category Organization** - Organize blocks by type (layouts, content, media, forms, components)
- ✅ **Custom Attributes** - Configure GrapesJS behavior
- ✅ **Icon Support** - Choose icons for block identification

### **Creating Custom Blocks**

1. **Go to Admin Panel** → **Custom Blocks** → **Create Custom Block**

2. **Basic Info Tab**
   - **Name**: Descriptive name for your block
   - **Description**: What the block does
   - **Category**: Choose from layouts, content, media, forms, components
   - **Icon**: Select an icon for the block manager
   - **Active**: Enable/disable the block
   - **Sort Order**: Control block order in manager

3. **HTML Content Tab**
   ```html
   <!-- Example block structure -->
   <div class="custom-block bg-white rounded-lg shadow-md p-6">
       <h3 data-gjs-type="text" data-gjs-name="title">Block Title</h3>
       <p data-gjs-type="text" data-gjs-name="description">Block description goes here</p>
       <button class="btn btn-primary" data-gjs-type="text" data-gjs-name="button-text">Click Me</button>
   </div>
   ```

4. **CSS Styling Tab**
   ```css
   /* Custom styles for your block */
   .custom-block {
       background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
       color: white;
       border-radius: 12px;
       transition: transform 0.3s ease;
   }

   .custom-block:hover {
       transform: translateY(-2px);
   }
   ```

5. **JavaScript Tab**
   ```javascript
   // Custom JavaScript for your block
   document.addEventListener("DOMContentLoaded", function() {
       const block = document.querySelector(".custom-block");
       
       if (block) {
           block.addEventListener("click", function() {
               console.log("Block clicked!");
           });
       }
   });
   ```

6. **GrapesJS Settings Tab**
   - **Attributes**: Configure draggable, droppable, removable, copyable
   - **Block Settings**: Custom configuration for your block

7. **Preview Tab**
   - See how your block will look in real-time

### **GrapesJS Integration**

Custom blocks automatically appear in the GrapesJS block manager:
- Organized by category
- Include your custom icons
- Support all GrapesJS features
- Editable elements with `data-gjs-type="text"`

### **Best Practices**

1. **Use Semantic HTML** - Structure your blocks properly
2. **Make Elements Editable** - Use `data-gjs-type="text"` and `data-gjs-name="unique-name"`
3. **Responsive Design** - Use Tailwind classes for mobile-first design
4. **Performance** - Keep CSS and JS minimal and efficient
5. **Naming** - Use descriptive names and avoid conflicts

---

## ⚙️ **Site Settings Management**

Comprehensive site configuration system for header, footer, and general settings.

### **Setting Groups**

#### **General Settings**
- Site name and tagline
- Contact information
- Address and timezone
- Site description

#### **Header Settings**
- Logo text and image
- Background and text colors
- Sticky header option
- Search bar toggle
- Custom CSS

#### **Footer Settings**
- Footer logo and content
- Background and text colors
- Social media links
- Newsletter signup
- Custom CSS

#### **SEO Settings**
- Default page titles
- Meta descriptions and keywords
- Google Analytics integration
- Auto-generation options

#### **Social Media**
- Facebook, Twitter, Instagram
- LinkedIn, YouTube, GitHub
- All social platform URLs

#### **Advanced Settings**
- Caching options
- Debug mode
- Global custom CSS
- Global custom JavaScript

### **Using Site Settings**

#### **In Blade Templates**
```php
@php
    $siteSettings = app(\App\Services\SiteSettingsService::class);
    $headerSettings = $siteSettings->getHeaderSettings();
    $footerSettings = $siteSettings->getFooterSettings();
@endphp

<!-- Use settings -->
<div style="background-color: {{ $headerSettings['background_color'] }}">
    {{ $headerSettings['logo_text'] }}
</div>
```

#### **In Controllers**
```php
use App\Services\SiteSettingsService;

public function index(SiteSettingsService $settings)
{
    $headerSettings = $settings->getHeaderSettings();
    $seoSettings = $settings->getSeoSettings();
    
    return view('page', compact('headerSettings', 'seoSettings'));
}
```

#### **Dynamic CSS Generation**
```php
$siteSettings = app(\App\Services\SiteSettingsService::class);
$css = $siteSettings->getAllCss();
```

### **Setting Types**

- **Text**: Simple text input
- **Textarea**: Multi-line text
- **Boolean**: Toggle switches
- **Color**: Color picker
- **Image**: File upload
- **Select**: Dropdown options
- **JSON**: Structured data

### **Caching**

Settings are automatically cached for performance:
- 1-hour cache duration
- Automatic cache clearing on updates
- Manual cache clearing available

---

## 🔧 **Integration Examples**

### **Custom Block with Site Settings**
```html
<!-- Custom block that uses site settings -->
<div class="contact-block">
    <h3 data-gjs-type="text" data-gjs-name="title">Contact Us</h3>
    <div class="contact-info">
        <p>Email: {{ $generalSettings['contact_email'] }}</p>
        <p>Phone: {{ $generalSettings['contact_phone'] }}</p>
    </div>
</div>
```

### **Dynamic Header with Settings**
```blade
<header class="site-header" 
        style="background-color: {{ $headerSettings['background_color'] }}; 
               color: {{ $headerSettings['text_color'] }};">
    <div class="logo">
        @if($headerSettings['logo_image'])
            <img src="{{ Storage::url($headerSettings['logo_image']) }}" alt="Logo">
        @else
            {{ $headerSettings['logo_text'] }}
        @endif
    </div>
</header>
```

### **Social Media Footer**
```blade
@if($footerSettings['show_social'])
    <div class="social-links">
        @if($socialSettings['facebook'])
            <a href="{{ $socialSettings['facebook'] }}" target="_blank">Facebook</a>
        @endif
        @if($socialSettings['twitter'])
            <a href="{{ $socialSettings['twitter'] }}" target="_blank">Twitter</a>
        @endif
    </div>
@endif
```

---

## 🚀 **Advanced Features**

### **Block Templates**
Create reusable block templates:
1. Design a block in the builder
2. Save as a template
3. Clone and customize for different uses

### **Block Categories**
Organize blocks by purpose:
- **Layouts**: Hero sections, containers, grids
- **Content**: Text blocks, headings, paragraphs
- **Media**: Images, videos, galleries
- **Forms**: Contact forms, surveys, signups
- **Components**: Cards, buttons, alerts

### **Custom CSS Scoping**
CSS is automatically scoped to blocks:
```css
/* This CSS only affects your custom block */
.custom-block {
    /* Your styles */
}
```

### **JavaScript Isolation**
JavaScript runs in isolated context:
```javascript
// This JavaScript only affects your custom block
document.addEventListener("DOMContentLoaded", function() {
    // Your code here
});
```

---

## 📋 **API Reference**

### **SiteSettingsService Methods**

```php
// Get all settings
$settings = $siteSettings->all();

// Get specific setting
$value = $siteSettings->get('site_name', 'default');

// Get grouped settings
$headerSettings = $siteSettings->getHeaderSettings();
$footerSettings = $siteSettings->getFooterSettings();
$socialSettings = $siteSettings->getSocialSettings();
$seoSettings = $siteSettings->getSeoSettings();

// Generate CSS
$css = $siteSettings->getAllCss();

// Clear cache
$siteSettings->clearCache();
```

### **CustomBlock Model Methods**

```php
// Get GrapesJS configuration
$config = $customBlock->getGrapesJsConfig();

// Get complete content with CSS/JS
$content = $customBlock->getCompleteContent();

// Get available categories
$categories = CustomBlock::getCategories();

// Get available icons
$icons = CustomBlock::getIcons();
```

---

## 🎨 **Styling Guidelines**

### **Color Scheme**
- Use CSS variables for consistent theming
- Support dark/light mode
- Ensure accessibility compliance

### **Typography**
- Use system fonts for performance
- Implement proper font scaling
- Maintain readability across devices

### **Responsive Design**
- Mobile-first approach
- Use Tailwind responsive classes
- Test on multiple screen sizes

### **Performance**
- Optimize images and assets
- Minimize CSS and JavaScript
- Use lazy loading where appropriate

---

**The custom block builder and site settings system make LaralGrape incredibly flexible and powerful! 🚀** 