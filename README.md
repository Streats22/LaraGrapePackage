# 🍇 LaraGrape: The Ultimate Laravel Page Builder Package

**LaraGrape** combines the visual power of [GrapesJS](https://grapesjs.com/) with the modern admin experience of [Filament](https://filamentphp.com/) to deliver a seamless, developer-friendly CMS-like system for Laravel.

---

## 🚀 Getting Started with LaraGrape

After installing the package, follow these steps to get up and running:

1. **Install the package:**
   ```sh
   composer require laragrape/laragrape
   ```
2. **Run the setup command to publish config, views, migrations, and (optionally) run migrations:**
   ```sh
   php artisan laragrape:setup --migrate
   ```
3. **Create a Filament admin user:**
   ```sh
   php artisan make:filament-user
   ```
   Follow the prompts to set up your admin credentials.
4. **Install Filament admin panel:**
   ```sh
   php artisan filament:install --panel
   ```
5. **(Optional) Build frontend assets if your project uses them:**
   ```sh
   npm install
   npm run build
   ```
6. **Serve your application:**
   ```sh
   php artisan serve
   ```
   - Visit `/admin` to access the Filament admin panel.
   - Visit the frontend (e.g., `/`) to see your site.

---

## 🛠️ LaraGrape Setup Command Options

The `laragrape:setup` command provides several options for customizing your setup process:

**Usage:**
```sh
php artisan laragrape:setup [options]
```

**Available options:**

| Option                | Description                                      |
|----------------------|--------------------------------------------------|
| --migrate            | Run migrations after publishing                  |
| --seed               | Run seeders after publishing                     |
| --force              | Overwrite existing published files               |
| --publish-config     | Only publish config                              |
| --publish-views      | Only publish views                               |
| --publish-migrations | Only publish migrations                          |
| --publish-seeders    | Only publish seeders                             |
| --all                | Publish everything, migrate, and seed            |

**Examples:**
- Publish everything and run migrations:
  ```sh
  php artisan laragrape:setup --all
  ```
- Only publish views:
  ```sh
  php artisan laragrape:setup --publish-views
  ```
- Publish config and run migrations:
  ```sh
  php artisan laragrape:setup --publish-config --migrate
  ```

---

### What's Next?

- **Customize blocks, views, and settings:**  
  All package views and blocks are publishable and can be overridden in your app.
- **Check the published config file at `config/laragrape.php`** for customization options.
- **Explore the admin panel** to create and manage pages, blocks, and site settings.

---

## 🚀 Why Add LaraGrape to Your Laravel Project?

- **No More Static Pages:** Empower your users (or yourself) to visually build and manage pages with drag-and-drop ease—no code required!
- **Frontend & Backend Editing:** Enjoy the flexibility of a true WYSIWYG editor (GrapesJS) for the frontend, and robust content management with Filament on the backend.
- **Instant CMS Functionality:** Get a full-featured, extensible CMS experience without leaving the Laravel ecosystem.
- **Rapid Prototyping:** Build, preview, and publish pages in minutes—perfect for agencies, startups, and internal tools.
- **Custom Blocks & Extensibility:** Easily create and manage custom blocks, layouts, and templates to fit any project's needs.
- **SEO & Responsive Ready:** Out-of-the-box SEO features and mobile-friendly design ensure your content looks great everywhere.
- **Open Source & Actively Maintained:** Built for the community, with regular updates and support.

---

## 📦 Installation

```sh
composer require laragrape/laragrape
```

---

## ⚡ Quick Start

1. **Install the package:**
   ```sh
   composer require laragrape/laragrape
   ```
2. **Run the setup command:**
   ```sh
   php artisan laragrape:setup --migrate
   ```
3. **Create a Filament admin user:**
   ```sh
   php artisan make:filament-user
   ```
4. **Install Filament admin panel:**
   ```sh
   php artisan filament:install --panel
   ```
5. **(Optional) Build frontend assets:**
   ```sh
   npm install && npm run build
   ```
6. **Serve your app and visit `/admin` and the frontend!**

---

## 📚 Documentation

- [Package Setup Guide](LARAGRAPE_SETUP.md)
- [Dynamic Block System](BLOCKS_README.md)
- [Modular Component System](COMPONENTS_README.md)
- [Custom Block Builder & Site Settings](CUSTOM_BLOCKS_README.md)

---

**LaraGrape**: The easiest way to add a modern, visual CMS to your Laravel project—without sacrificing developer control.
