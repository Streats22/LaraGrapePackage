# 🍇 LaraGrape: The Ultimate Laravel Page Builder Package

**LaraGrape** combines the visual power of [GrapesJS](https://grapesjs.com/) with the modern admin experience of [Filament](https://filamentphp.com/) to deliver a seamless, developer-friendly CMS-like system for Laravel.

---

## 🚀 Quick Start

### 1. Install the Package
```bash
composer require laragrape/laragrape
```

### 2. Run the Setup Command
```bash
php artisan laragrape:setup --all
```

### 3. Create Admin User
```bash
php artisan make:filament-user
```

### 4. Build Frontend Assets
```bash
npm install
npm run build
```

### 5. Start Your Application
```bash
php artisan serve
```

- **Admin Panel**: Visit `/admin` to access Filament
- **Frontend**: Visit `/` to see your site

---

## ✨ Features

### 🎨 Visual Page Builder
- **GrapesJS Integration**: Drag-and-drop page building
- **Pre-built Blocks**: Hero sections, cards, forms, and more
- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Live Preview**: See changes in real-time

### 🛠️ Admin Panel
- **Filament 3**: Modern, responsive admin interface
- **Page Management**: Create, edit, and publish pages
- **Custom Blocks**: Build and manage reusable components
- **Site Settings**: Configure header, footer, and general settings
- **Tailwind Config**: Dynamic theme management

### 🔧 Developer Experience
- **Laravel 12+ Compatible**: Built for modern Laravel
- **Alpine.js**: Lightweight JavaScript framework
- **Modular Architecture**: Clean, maintainable code structure
- **Extensible**: Easy to customize and extend

---

## 📦 What's Included

### Core Components
- ✅ **Pages System**: Full CRUD with GrapesJS integration
- ✅ **Custom Blocks**: Visual block builder with live preview
- ✅ **Site Settings**: Comprehensive configuration management
- ✅ **Tailwind Config**: Dynamic theme system
- ✅ **Admin Panel**: Filament-based administration
- ✅ **Frontend Layout**: Responsive, SEO-optimized templates

### Database Tables
- `pages` - Page content and metadata
- `custom_blocks` - User-created blocks
- `site_settings` - Site configuration
- `tailwind_configs` - Theme configurations

### Filament Resources
- **PageResource**: Page management with visual editor
- **CustomBlockResource**: Block builder and management
- **SiteSettingsResource**: Site configuration
- **TailwindConfigResource**: Theme management

---

## 🛠️ Setup Command Options

The `laragrape:setup` command provides comprehensive setup with error handling:

```bash
php artisan laragrape:setup [options]
```

### Available Options

| Option | Description |
|--------|-------------|
| `--all` | Complete setup (publish, migrate, seed) |
| `--migrate` | Run migrations after publishing |
| `--seed` | Run seeders after publishing |
| `--force` | Overwrite existing files |

### Examples
```bash
# Complete setup
php artisan laragrape:setup --all

# Publish only
php artisan laragrape:setup

# Publish and migrate
php artisan laragrape:setup --migrate
```

---

## 🎯 Key Features

### Visual Page Builder
- **Drag & Drop**: Intuitive block-based editing
- **Pre-built Blocks**: 20+ ready-to-use components
- **Custom Blocks**: Create your own reusable components
- **Responsive**: Mobile-first design approach
- **Live Preview**: Real-time editing experience

### Admin Panel
- **Modern Interface**: Filament 3 admin panel
- **Page Management**: Full CRUD operations
- **Block Builder**: Visual custom block creation
- **Site Settings**: Comprehensive configuration
- **Theme Management**: Dynamic Tailwind configuration

### Developer Tools
- **Error Handling**: Robust setup with fallbacks
- **Namespace Management**: Automatic App namespace conversion
- **Asset Management**: CSS, JS, and view publishing
- **Command Line**: Artisan commands for management

---

## 📚 Documentation

- **[Setup Guide](LARALGRAPE_SETUP.md)** - Complete installation and configuration
- **[Block System](BLOCKS_README.md)** - Dynamic block loading and management
- **[Component System](COMPONENTS_README.md)** - Modular component architecture
- **[Custom Blocks](CUSTOM_BLOCKS_README.md)** - Visual block builder guide
- **[API Documentation](API_README.md)** - Service classes and methods
- **[Troubleshooting](TROUBLESHOOTING.md)** - Common issues and solutions

---

## 🎨 Customization

### Adding Custom Blocks
1. Use the visual block builder in the admin panel
2. Or create `.blade.php` files in `resources/views/filament/blocks/`
3. Add metadata comments for automatic loading

### Styling
- **Global Styles**: Edit `resources/css/site.css`
- **Tailwind Config**: Use the admin panel for dynamic themes
- **Component Styles**: Add custom CSS to blocks

### Extending
- **New Resources**: Add custom Filament resources
- **Custom Services**: Extend the service classes
- **Frontend**: Modify the layout components

---

## 🚀 Why Choose LaraGrape?

- **No Code Required**: Visual page building for non-developers
- **Developer Friendly**: Clean, maintainable Laravel code
- **Modern Stack**: Built with Laravel 12, Filament 3, and Tailwind CSS
- **Extensible**: Easy to customize and extend
- **Production Ready**: Robust error handling and fallbacks
- **Active Development**: Regular updates and improvements

---

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

### Development Setup
```bash
# Clone the repository
git clone https://github.com/your-org/laragrape.git

# Install dependencies
composer install
npm install

# Run tests
php artisan test
```

---

## 📄 License

This package is open-sourced software licensed under the [MIT license](LICENSE).

---

## 🆘 Support

- **Documentation**: Check the docs in this repository
- **Issues**: Report bugs on GitHub
- **Discussions**: Join our community discussions

---

**LaraGrape**: The easiest way to add a modern, visual CMS to your Laravel project—without sacrificing developer control. 🍇
