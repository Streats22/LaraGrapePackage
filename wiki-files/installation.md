# 🚀 Installation & Setup

Complete guide for setting up LaraGrape in your Laravel application with comprehensive error handling and fallbacks.

## 📦 Prerequisites

Before installing LaraGrape, ensure you have:

- **PHP**: 8.2 or higher
- **Laravel**: 12.0 or higher
- **Composer**: 2.0 or higher
- **Node.js**: 18.0 or higher (for frontend assets)
- **Database**: MySQL 8.0+, PostgreSQL 13+, or SQLite 3.35+

## 🛠️ Installation Steps

### 1. Install the Package

```bash
composer require streats22/laragrape
```

### 2. Run the Setup Command

```bash
php artisan laragrape:setup --all
```

The setup command will:
- ✅ Publish all resources with error handling
- ✅ Update namespaces to App namespace
- ✅ Register commands and services
- ✅ Create necessary directories
- ✅ Run migrations and seeders
- ✅ Provide clear feedback and next steps

## 🛠️ Setup Command Options

### Available Options

| Option | Description |
|--------|-------------|
| `--all` | Complete setup (publish, migrate, seed) |
| `--migrate` | Run migrations after publishing |
| `--seed` | Run seeders after publishing |
| `--force` | Overwrite existing files |

### Examples

```bash
# Complete setup (recommended)
php artisan laragrape:setup --all

# Publish only
php artisan laragrape:setup

# Publish and migrate
php artisan laragrape:setup --migrate

# Force overwrite existing files
php artisan laragrape:setup --force
```

## 📋 What Gets Published

### Core Components
- ✅ **Laravel 12+** compatible
- ✅ **Filament 3** - Modern admin panel
- ✅ **GrapesJS** - Visual website builder
- ✅ **Alpine.js** - Lightweight JavaScript framework
- ✅ **Tailwind CSS** - Utility-first CSS framework

### Database Structure
- ✅ **Pages table** - Page content and metadata
- ✅ **Custom Blocks table** - User-created blocks
- ✅ **Site Settings table** - Site configuration
- ✅ **Tailwind Configs table** - Theme configurations

### Filament Resources
- ✅ **PageResource** - Page management with visual editor
- ✅ **CustomBlockResource** - Block builder and management
- ✅ **SiteSettingsResource** - Site configuration
- ✅ **TailwindConfigResource** - Theme management

### Frontend Components
- ✅ **Responsive layouts** - Mobile-first design
- ✅ **GrapesJS integration** - Visual page builder
- ✅ **Alpine.js components** - Interactive functionality
- ✅ **SEO optimization** - Meta tags and structure

### Assets
- ✅ **CSS files** - Site styles and utilities
- ✅ **JavaScript files** - Editor and frontend logic
- ✅ **Blade views** - Templates and components
- ✅ **Configuration files** - Package settings

## 🚀 Post-Setup Steps

### 1. Create Admin User

```bash
php artisan make:filament-user
```

### 2. Build Frontend Assets

```bash
npm install
npm run build
```

### 3. Start Your Application

```bash
php artisan serve
```

### 4. Access Your Application

- **Admin Panel**: http://localhost:8000/admin
- **Frontend**: http://localhost:8000

## 🎯 Creating Your First Page

### 1. Access Admin Panel
- Go to `/admin`
- Login with your admin credentials

### 2. Create a Page
- Navigate to **Pages** → **Create Page**
- Fill in basic information (title, slug, etc.)

### 3. Use Visual Editor
- Switch to **Visual Editor** tab
- Drag and drop blocks from the sidebar
- Customize content and styling
- Save and publish

### 4. View Your Page
- Visit the frontend to see your published page
- Use the edit bar for authenticated users

## 🎨 Customizing Components

### Adding New GrapesJS Blocks

Blocks are automatically loaded from `resources/views/filament/blocks/`:

```blade
{{-- @block id="my-block" label="My Custom Block" description="A description" --}}
<div class="my-custom-class">
    <h3 data-gjs-type="text" data-gjs-name="title">Block Title</h3>
    <p data-gjs-type="text" data-gjs-name="content">Content here</p>
</div>
```

### Using the Visual Block Builder

1. Go to **Custom Blocks** in admin panel
2. Click **Create Custom Block**
3. Use the visual builder with HTML, CSS, and JS tabs
4. Preview your block in real-time
5. Save and use in pages

### Styling

- **Global styles**: Edit `resources/css/site.css`
- **Component styles**: Use Tailwind classes in blocks
- **Admin styles**: Customize via Filament theming
- **Dynamic themes**: Use Tailwind Config resource

## 🛠️ Development Commands

### Essential Commands

```bash
# Start development server
php artisan serve

# Build assets
npm run build

# Watch for changes
npm run dev

# Clear cache
php artisan optimize:clear

# Create admin user
php artisan make:filament-user
```

### LaraGrape Commands

```bash
# Rebuild Tailwind CSS
php artisan tailwind:rebuild

# Setup LaraGrape
php artisan laragrape:setup --all

# Clear LaraGrape cache
php artisan cache:clear
```

## 📁 Key File Structure

```
app/
├── Filament/
│   ├── Resources/
│   │   ├── PageResource.php
│   │   ├── CustomBlockResource.php
│   │   ├── SiteSettingsResource.php
│   │   └── TailwindConfigResource.php
│   └── Forms/
│       └── Components/
│           └── GrapesJsEditor.php
├── Http/Controllers/
│   ├── PageController.php
│   └── AdminPageController.php
├── Models/
│   ├── Page.php
│   ├── CustomBlock.php
│   ├── SiteSettings.php
│   └── TailwindConfig.php
└── Services/
    ├── BlockService.php
    ├── SiteSettingsService.php
    └── GrapesJsConverterService.php

resources/
├── js/
│   ├── grapesjs-editor.js
│   └── app.js
├── css/
│   ├── app.css
│   ├── site.css
│   └── laralgrape-utilities.css
└── views/
    ├── filament/blocks/
    ├── components/layout/
    └── pages/show.blade.php

database/
├── migrations/
│   ├── create_pages_table.php
│   ├── create_custom_blocks_table.php
│   ├── create_site_settings_table.php
│   └── create_tailwind_configs_table.php
└── seeders/
    ├── PageSeeder.php
    ├── CustomBlockSeeder.php
    ├── SiteSettingsSeeder.php
    └── TailwindConfigSeeder.php
```

## 🎯 Next Steps

### Immediate Actions
1. **Customize the blocks** in GrapesJS editor
2. **Configure site settings** in admin panel
3. **Set up Tailwind themes** for dynamic styling
4. **Create custom blocks** using the visual builder

### Advanced Customization
1. **Add user roles** and permissions
2. **Implement media management** for images/files
3. **Create a blog system** using the same pattern
4. **Add form handling** for contact forms
5. **Implement SEO sitemap** generation
6. **Add caching** for better performance
7. **Create custom page templates**
8. **Extend with additional Filament resources**

## 🔧 Troubleshooting

### Common Issues

#### Setup Command Fails

```bash
# Clear all caches
php artisan optimize:clear

# Try setup again
php artisan laragrape:setup --all
```

#### Blocks Not Loading

```bash
# Clear block cache
php artisan cache:clear

# Check block files exist
ls resources/views/filament/blocks/
```

#### Admin Panel Issues

```bash
# Reinstall Filament
php artisan filament:install --panels

# Create admin user
php artisan make:filament-user
```

#### Frontend Assets

```bash
# Rebuild assets
npm run build

# Clear browser cache
# Hard refresh (Ctrl+F5)
```

### Error Handling

The setup command includes comprehensive error handling:
- ✅ Continues if individual steps fail
- ✅ Provides clear error messages
- ✅ Suggests manual steps when needed
- ✅ Shows progress and success counts

## 🤝 Contributing

Feel free to extend LaraGrape with:
- New GrapesJS blocks and plugins
- Additional Filament resources
- Frontend theme variants
- Performance optimizations
- Documentation improvements

## 📚 Additional Resources

- [Block System Documentation](blocks/overview.md)
- [Component System Documentation](components/overview.md)
- [Custom Blocks Documentation](custom-blocks/overview.md)
- [API Documentation](api/overview.md)
- [Troubleshooting Guide](troubleshooting/common-issues.md)

---

**Happy building with LaraGrape! 🍇**

The setup process is designed to be robust and user-friendly, with comprehensive error handling and clear guidance for next steps. 