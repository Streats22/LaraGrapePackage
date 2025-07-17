# 🧩 Block System Overview

The LaraGrape package includes a robust dynamic block loading system that automatically scans and loads blocks from the `resources/views/filament/blocks/` directory structure with comprehensive error handling and fallbacks.

## 🚀 Quick Start

### Installation
```bash
composer require streats22/laragrape
php artisan laragrape:setup --all
```

## 📁 Block Organization

Blocks are organized by category in subdirectories for easy management:

```
resources/views/filament/blocks/
├── components/     # UI components (buttons, cards, alerts)
├── content/        # Content blocks (text, headings, lists)
├── forms/          # Form blocks (contact forms, newsletters)
├── layouts/        # Layout blocks (hero, sections, columns)
└── media/          # Media blocks (images, videos, galleries)
```

## 🎯 Creating New Blocks

### 1. Choose a Category
Decide which category your block belongs to and create a `.blade.php` file in the appropriate directory.

### 2. Add Block Metadata
Each block file must start with a metadata comment for automatic discovery:

```blade
{{-- @block id="my-block" label="My Block" description="A description of my block" --}}
<div class="my-block">
    <!-- Your HTML content here -->
</div>
```

### 3. Metadata Options

| Option | Required | Description |
|--------|----------|-------------|
| `id` | ✅ | Unique identifier for the block |
| `label` | ✅ | Display name in the GrapesJS block manager |
| `description` | ❌ | Description shown in the block manager |
| `attributes` | ❌ | JSON object of GrapesJS attributes |

### 4. Example Block

```blade
{{-- @block id="feature-card" label="Feature Card" description="A card showcasing a feature with icon, title, and description" --}}
<div class="feature-card bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
    <div class="text-center">
        <div class="w-16 h-16 bg-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold mb-2" data-gjs-type="text" data-gjs-name="title">Feature Title</h3>
        <p class="text-gray-600" data-gjs-type="text" data-gjs-name="description">Feature description goes here</p>
    </div>
</div>
```

## 🔧 Block Features

### GrapesJS Integration
- ✅ **Automatic Discovery**: Blocks are automatically loaded from the file system
- ✅ **Category Organization**: Blocks appear organized by category in the block manager
- ✅ **Live Preview**: Block previews are generated automatically
- ✅ **Error Handling**: Graceful fallbacks if blocks fail to load

### Editable Elements
Use `data-gjs-type="text"` and `data-gjs-name="unique-name"` attributes to make elements editable in GrapesJS:

```blade
<h1 data-gjs-type="text" data-gjs-name="heading">Editable Heading</h1>
<p data-gjs-type="text" data-gjs-name="content">Editable content</p>
<button data-gjs-type="text" data-gjs-name="button-text">Editable Button</button>
```

### Responsive Design
All blocks use Tailwind CSS classes for responsive design:

```blade
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Responsive grid layout -->
</div>
```

## 📋 Available Block Categories

### Components (`/components/`)
- **alert.blade.php**: Alert/notification component
- **button.blade.php**: Button component with variants
- **card.blade.php**: Card component with image, title, description
- **pricing.blade.php**: Pricing table component
- **testimonial.blade.php**: Customer testimonial component

### Content (`/content/`)
- **divider.blade.php**: Horizontal divider/separator
- **heading.blade.php**: Heading with decorative underline
- **list.blade.php**: Ordered and unordered lists
- **quote.blade.php**: Blockquote component
- **spacer.blade.php**: Vertical spacing component
- **text.blade.php**: Simple text content block

### Forms (`/forms/`)
- **contact-form.blade.php**: Contact form with name, email, message

### Layouts (`/layouts/`)
- **columns.blade.php**: Two-column layout
- **container.blade.php**: Content container wrapper
- **grid.blade.php**: CSS Grid layout
- **hero.blade.php**: Hero section with title, subtitle, CTA
- **section.blade.php**: General content section

### Media (`/media/`)
- **gallery.blade.php**: Image gallery component
- **image.blade.php**: Image block with placeholder
- **video.blade.php**: Video embed component

## 🚀 Adding New Categories

To add a new category:

1. Create a new directory in `resources/views/filament/blocks/`
2. Add `.blade.php` files with proper metadata
3. The system will automatically detect and load them

Example:
```bash
mkdir resources/views/filament/blocks/widgets
touch resources/views/filament/blocks/widgets/weather.blade.php
```

## 🔄 Block Updates

The block system automatically reloads when:
- ✅ New block files are added
- ✅ Existing block files are modified
- ✅ The application is restarted
- ✅ Cache is cleared (`php artisan cache:clear`)

## 🎨 Styling Blocks

### Tailwind CSS
- Use Tailwind CSS classes for styling
- Blocks inherit global styles from your app's page template
- Responsive design with mobile-first approach

### Custom CSS
Add custom CSS to individual blocks if needed:

```blade
<style>
.custom-block {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    transition: transform 0.3s ease;
}

.custom-block:hover {
    transform: translateY(-2px);
}
</style>
```

### Dynamic Themes
Blocks automatically inherit dynamic theme settings from TailwindConfig:

```blade
<div class="bg-primary-500 text-primary-50">
    <!-- Uses dynamic primary colors -->
</div>
```

## 📱 Responsive Considerations

### Mobile-First Design
- All blocks are mobile-first and responsive
- Use Tailwind's responsive prefixes (`md:`, `lg:`, etc.)
- Test blocks on different screen sizes

### Touch-Friendly
- Ensure buttons and interactive elements are large enough for touch
- Use appropriate spacing for mobile devices
- Consider touch targets (minimum 44px)

## 🔍 Troubleshooting

### Block Not Appearing
1. **Check file extension**: Must be `.blade.php`
2. **Verify metadata**: Ensure `@block` comment is properly formatted
3. **Check directory**: Ensure file is in correct category directory
4. **Clear cache**: `php artisan cache:clear`
5. **Check BlockService**: Use Tinker to test service

```bash
php artisan tinker
>>> use App\Services\BlockService;
>>> $service = new BlockService();
>>> dd($service->getBlocks());
```

### Block Content Issues
1. **Check HTML syntax**: Validate HTML structure
2. **Verify Tailwind classes**: Ensure classes are valid
3. **Test in isolation**: Test block outside of GrapesJS
4. **Check for JavaScript errors**: Look in browser console

### Performance Issues
- **Cache blocks**: Blocks are cached for performance
- **Optimize images**: Use appropriate image sizes
- **Limit complexity**: Avoid overly complex blocks
- **Lazy loading**: Consider lazy loading for heavy blocks

### Block Preview Issues
1. **Check route**: Ensure `/admin/block-preview/{blockId}` route exists
2. **Verify controller**: Check AdminPageController exists
3. **Clear route cache**: `php artisan route:clear`
4. **Check block IDs**: Ensure frontend uses correct block IDs

## 🛠️ Advanced Features

### Custom Block Attributes
Add custom GrapesJS attributes to blocks:

```blade
{{-- @block id="my-block" label="My Block" attributes='{"draggable": true, "droppable": false}' --}}
```

### Block Templates
Create reusable block templates:

```blade
{{-- @block id="template-card" label="Template Card" description="Reusable card template" --}}
<div class="template-card" data-gjs-draggable="true" data-gjs-droppable="true">
    <!-- Template content -->
</div>
```

### Conditional Blocks
Use Blade directives for conditional content:

```blade
@if(config('app.debug'))
    <div class="debug-info">Debug information</div>
@endif
```

## 📊 Block Statistics

The system provides statistics about loaded blocks:

```php
$blockService = new BlockService();
$stats = $blockService->getBlockStatistics();

// Returns:
[
    'total_blocks' => 25,
    'categories' => [
        'components' => 5,
        'content' => 6,
        'forms' => 1,
        'layouts' => 5,
        'media' => 3
    ],
    'active_blocks' => 23,
    'inactive_blocks' => 2
]
```

## 🔧 Development Workflow

### Creating New Blocks
1. **Plan the block**: Determine purpose and category
2. **Create the file**: Add to appropriate directory
3. **Add metadata**: Include `@block` comment
4. **Write HTML**: Use semantic HTML structure
5. **Add styling**: Use Tailwind classes
6. **Make editable**: Add `data-gjs-*` attributes
7. **Test**: Verify in GrapesJS editor
8. **Document**: Add to block documentation

### Block Maintenance
- **Regular review**: Check for outdated blocks
- **Performance monitoring**: Monitor block loading times
- **User feedback**: Gather feedback on block usability
- **Updates**: Keep blocks compatible with new versions

## 🎯 Best Practices

### Block Design
- **Semantic HTML**: Use proper HTML structure
- **Accessibility**: Include ARIA labels and keyboard navigation
- **Performance**: Keep blocks lightweight and efficient
- **Consistency**: Maintain consistent styling across blocks

### Code Quality
- **Clean code**: Write readable, maintainable code
- **Comments**: Add comments for complex logic
- **Validation**: Test blocks thoroughly
- **Documentation**: Document custom blocks

### User Experience
- **Intuitive**: Make blocks easy to understand and use
- **Flexible**: Allow customization where appropriate
- **Responsive**: Ensure blocks work on all devices
- **Fast**: Optimize for quick loading

## 📚 Related Documentation

- [Custom Blocks](custom-blocks/overview.md) - Visual block builder
- [Component System](components/overview.md) - Modular components
- [GrapesJS Integration](grapesjs/overview.md) - Visual editor
- [API Reference](api/overview.md) - Service classes

---

**The dynamic block system makes it easy to create, organize, and maintain reusable components for your Laravel projects using the LaraGrape package! 🧩**

With comprehensive error handling, automatic discovery, and robust fallbacks, the block system provides a reliable foundation for building dynamic, visual content. 