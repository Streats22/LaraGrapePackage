# ⚡ Quick Start Guide

Get up and running with LaraGrape in minutes with this step-by-step guide.

## 🚀 Prerequisites

Before you begin, ensure you have:

- **PHP**: 8.2 or higher
- **Laravel**: 12.0 or higher
- **Composer**: 2.0 or higher
- **Node.js**: 18.0 or higher
- **Database**: MySQL 8.0+, PostgreSQL 13+, or SQLite 3.35+

## 📦 Installation

### 1. Install the Package

```bash
composer require streats22/laragrape
```

### 2. Run the Setup Command

```bash
php artisan laragrape:setup --all
```

This command will:
- ✅ Publish all necessary files
- ✅ Update namespaces automatically
- ✅ Create database tables
- ✅ Seed initial data
- ✅ Register commands and services

### 3. Create Admin User

```bash
php artisan make:filament-user
```

Follow the prompts to create your admin credentials.

### 4. Build Frontend Assets

```bash
npm install
npm run build
```

### 5. Start Your Application

```bash
php artisan serve
```

## 🎯 First Steps

### Access Your Application

- **Admin Panel**: http://localhost:8000/admin
- **Frontend**: http://localhost:8000

### Create Your First Page

1. **Login to Admin Panel**
   - Go to http://localhost:8000/admin
   - Use the credentials you created

2. **Create a New Page**
   - Navigate to **Pages** → **Create Page**
   - Fill in the basic information:
     - **Title**: "Welcome to My Site"
     - **Slug**: "welcome"
     - **Meta Description**: "Welcome to my new website"

3. **Use the Visual Editor**
   - Switch to the **Visual Editor** tab
   - You'll see the GrapesJS editor interface
   - Drag blocks from the left sidebar to the canvas

4. **Add Some Content**
   - Drag a **Hero** block to the top
   - Add a **Text** block below it
   - Add a **Button** component
   - Customize the content by clicking on elements

5. **Save and Publish**
   - Click **Save** to save your work
   - Set **Is Published** to **Yes**
   - Click **Create Page**

6. **View Your Page**
   - Visit http://localhost:8000/welcome
   - You should see your published page!

## 🎨 Customizing Your Site

### Site Settings

1. **Configure Site Settings**
   - Go to **Site Settings** in the admin panel
   - Set your site name, logo, and contact information
   - Configure header and footer settings

2. **Set Up Tailwind Theme**
   - Go to **Tailwind Config** in the admin panel
   - Create a new configuration
   - Customize colors, typography, and spacing
   - Set it as active

### Creating Custom Blocks

1. **Use the Block Builder**
   - Go to **Custom Blocks** → **Create Custom Block**
   - Give it a name like "Feature Card"
   - Choose a category (e.g., "components")

2. **Design Your Block**
   - **HTML Tab**: Write the structure
   - **CSS Tab**: Add styling
   - **JavaScript Tab**: Add interactivity
   - **Preview Tab**: See how it looks

3. **Use Your Block**
   - Save the block
   - Go back to page editing
   - Your custom block will appear in the block manager

## 🔧 Development Workflow

### Adding New Blocks

Create `.blade.php` files in `resources/views/filament/blocks/`:

```blade
{{-- @block id="my-block" label="My Block" description="A custom block" --}}
<div class="my-custom-block">
    <h3 data-gjs-type="text" data-gjs-name="title">Block Title</h3>
    <p data-gjs-type="text" data-gjs-name="content">Content here</p>
</div>
```

### Customizing Styles

Edit `resources/css/site.css` for global styles:

```css
/* Custom styles */
.my-custom-block {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    padding: 2rem;
    color: white;
}
```

### Using Site Settings

Access settings in your views:

```php
@php
    $siteSettings = app(\App\Services\SiteSettingsService::class);
    $headerSettings = $siteSettings->getHeaderSettings();
@endphp

<header style="background-color: {{ $headerSettings['background_color'] }}">
    {{ $headerSettings['logo_text'] }}
</header>
```

## 🛠️ Useful Commands

### Development Commands

```bash
# Start development server
php artisan serve

# Watch for changes
npm run dev

# Build for production
npm run build

# Clear caches
php artisan optimize:clear
```

### LaraGrape Commands

```bash
# Rebuild Tailwind CSS
php artisan tailwind:rebuild

# Setup LaraGrape (if needed)
php artisan laragrape:setup --all

# Clear LaraGrape cache
php artisan cache:clear
```

## 🎯 Next Steps

### Immediate Actions
1. **Explore the Admin Panel** - Familiarize yourself with all sections
2. **Create Multiple Pages** - Build out your site structure
3. **Customize Your Theme** - Set up your brand colors and typography
4. **Add Custom Blocks** - Create reusable components for your needs

### Advanced Customization
1. **User Roles & Permissions** - Set up different user access levels
2. **Media Management** - Add image and file upload capabilities
3. **Form Handling** - Create contact forms and surveys
4. **SEO Optimization** - Set up meta tags and sitemaps
5. **Performance** - Implement caching and optimization

## 🔍 Troubleshooting

### Common Issues

**Setup Command Fails**
```bash
php artisan optimize:clear
php artisan laragrape:setup --all
```

**Blocks Not Loading**
```bash
php artisan cache:clear
```

**Admin Panel Issues**
```bash
php artisan filament:install --panels
php artisan make:filament-user
```

**Frontend Assets**
```bash
npm run build
```

### Getting Help

- **Documentation**: Check our [Wiki](README.md)
- **Troubleshooting**: See [Common Issues](../troubleshooting/common-issues.md)
- **API Reference**: Check [Service Classes](../api/overview.md)
- **GitHub Issues**: Report bugs and request features

## 📚 Related Documentation

- [Installation Guide](../installation.md) - Complete setup instructions
- [Block System](../blocks/overview.md) - Understanding blocks
- [Custom Blocks](../custom-blocks/overview.md) - Building custom blocks
- [Admin Panel](../admin-panel/overview.md) - Admin interface guide
- [API Reference](../api/overview.md) - Service classes and methods

---

**Congratulations! You're now ready to build amazing websites with LaraGrape! 🍇**

The quick start guide has you covered for the basics. Explore the rest of the documentation to unlock the full potential of LaraGrape. 