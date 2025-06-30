# 🍇 LaraGrape - Laravel + GrapesJS + Filament Package

A powerful and modern Laravel package that brings:
- **GrapesJS** - Visual website builder
- **Filament** - Modern admin panel
- **Dynamic Page Management**

to your existing Laravel application.

## ✨ Features

- 🎨 **Visual Page Builder** - Drag & drop website building with GrapesJS
- 📱 **Responsive Design** - Built with Tailwind CSS
- 🛠️ **Admin Panel** - Beautiful Filament admin interface
- 📄 **Page Management** - Create, edit, and manage pages visually
- 🔍 **SEO Optimized** - Built-in meta tags and SEO features
- 🚀 **Production Ready** - Optimized for performance

## 📚 Documentation

- [Package Setup Guide](LARALGRAPE_SETUP.md)
- [Dynamic Block System](BLOCKS_README.md)
- [Modular Component System](COMPONENTS_README.md)
- [Custom Block Builder & Site Settings](CUSTOM_BLOCKS_README.md)

## 🚀 Installation

### Prerequisites
- Laravel 10/11/12 (PHP 8.2+)
- Composer
- Node.js & NPM (for asset building)

### 1. Install via Composer
```bash
composer require streats22/laragrape
```

### 2. Publish Assets & Config
```bash
php artisan vendor:publish --provider="Streats22\LaraGrape\Providers\LaralGrapeServiceProvider"
```

### 3. Run Migrations
```bash
php artisan migrate
```

### 4. Install Node Dependencies & Build Assets
```bash
npm install && npm run build
```

### 5. (Optional) Seed Demo Data
```bash
php artisan db:seed --class=\Streats22\LaraGrape\Database\Seeders\DatabaseSeeder
```

### 6. Create Admin User
```bash
php artisan make:filament-user
```

## 📖 Usage

### Access the Admin Panel
- Visit `/admin` in your Laravel app to manage pages and blocks.

### Creating Pages
1. Go to the admin panel (`/admin`)
2. Navigate to "Pages"
3. Click "Create Page"
4. Fill in basic information
5. Use the "Visual Editor" tab to design your page with GrapesJS
6. Publish when ready!

### Visual Editor Features
- **Pre-built Components**: Hero sections, text blocks, images, videos, buttons, forms, cards, columns, and more
- **Responsive Design**: Preview and edit for desktop, tablet, and mobile
- **Style Manager**: Customize colors, fonts, spacing, and more
- **Layer Management**: Organize your page elements

### Frontend Features
- Responsive navigation with mobile menu
- SEO-optimized page rendering
- Clean, modern design with Tailwind CSS

## 🏗️ Architecture

### Models
- **Page**: Stores page content, metadata, and GrapesJS data

### Controllers
- **PageController**: Handles frontend page display
- **PageResource**: Filament admin resource for page management

### Views & Components
- Provided as Blade templates and Filament resources for easy integration

### Services
- **BlockService**: Dynamic block loading and management

## ⚙️ Customization

- Add or modify blocks in `resources/views/filament/blocks/`
- Extend or override package views by publishing them
- Use the admin panel to create custom blocks

## 📝 Contributing

Contributions are welcome! Please open issues or PRs for bug fixes, features, or documentation improvements.

---

**LaraGrape** is a reusable package to supercharge your Laravel projects with a visual builder and modern admin tools.
