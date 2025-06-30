# 🧱 Dynamic Block System

The LaralGrape boilerplate now includes a dynamic block loading system that automatically scans and loads blocks from the `resources/views/filament/blocks/` directory structure.

## 📁 Block Organization

Blocks are organized by category in subdirectories:

```
resources/views/filament/blocks/
├── layouts/          # Layout blocks (hero, section, columns)
├── content/          # Content blocks (text, heading)
├── media/            # Media blocks (image, video)
├── forms/            # Form blocks (contact form, newsletter)
└── components/       # Component blocks (card, button)
```

## 🎯 Creating New Blocks

### 1. Choose a Category
Decide which category your block belongs to and create a `.blade.php` file in the appropriate directory.

### 2. Add Block Metadata
Each block file should start with a metadata comment:

```blade
{{-- @block id="my-block" label="My Block" description="A description of my block" --}}
<div class="my-block">
    <!-- Your HTML content here -->
</div>
```

### 3. Metadata Options

- **`id`**: Unique identifier for the block (required)
- **`label`**: Display name in the GrapesJS block manager (required)
- **`description`**: Description shown in the block manager (optional)
- **`attributes`**: JSON object of additional attributes (optional)

### 4. Example Block

```blade
{{-- @block id="feature-card" label="Feature Card" description="A card showcasing a feature with icon, title, and description" --}}
<div class="feature-card bg-white rounded-lg shadow-md p-6">
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
Blocks automatically appear in the GrapesJS block manager, organized by category.

### Editable Elements
Use `data-gjs-type="text"` and `data-gjs-name="unique-name"` attributes to make elements editable in GrapesJS.

### Responsive Design
All blocks use Tailwind CSS classes for responsive design.

## 📋 Available Block Categories

### Layouts (`/layouts/`)
- **hero.blade.php**: Hero section with title, subtitle, and CTA
- **section.blade.php**: General content section
- **columns.blade.php**: Two-column layout

### Content (`/content/`)
- **text.blade.php**: Simple text content block
- **heading.blade.php**: Heading with decorative underline

### Media (`/media/`)
- **image.blade.php**: Image block with placeholder

### Forms (`/forms/`)
- **contact-form.blade.php**: Contact form with name, email, and message

### Components (`/components/`)
- **card.blade.php**: Card component with image, title, and description

## 🚀 Adding New Categories

To add a new category:

1. Create a new directory in `resources/views/filament/blocks/`
2. Add `.blade.php` files with proper metadata
3. The system will automatically detect and load them

## 🔄 Block Updates

The block system automatically reloads when:
- New block files are added
- Existing block files are modified
- The application is restarted

## 🎨 Styling Blocks

- Use Tailwind CSS classes for styling
- Blocks inherit the global styles from the page template
- Custom CSS can be added to individual blocks if needed

## 📱 Responsive Considerations

- All blocks are mobile-first and responsive
- Use Tailwind's responsive prefixes (`md:`, `lg:`, etc.)
- Test blocks on different screen sizes

## 🔍 Troubleshooting

### Block Not Appearing
1. Check the file extension is `.blade.php`
2. Verify the metadata comment is properly formatted
3. Ensure the file is in the correct category directory
4. Clear application cache: `php artisan optimize:clear`

### Block Content Issues
1. Check for syntax errors in the HTML
2. Verify Tailwind classes are valid
3. Test the block in isolation

### Performance
- Blocks are cached for performance
- Large numbers of blocks may impact load time
- Consider lazy loading for complex blocks

---

**Happy block building! 🧱**

The dynamic block system makes it easy to create, organize, and maintain reusable components for your LaralGrape projects. 