# 🧭 Wiki Navigation Guide

Quick guide to help you find what you need in the LaraGrape documentation.

## 🚀 Getting Started

### New to LaraGrape?
1. **[Quick Start Guide](getting-started/quick-start.md)** - Get up and running in minutes
2. **[Installation Guide](installation.md)** - Complete setup instructions
3. **[First Page Creation](getting-started/first-page.md)** - Create your first page

### Already Installed?
1. **[Admin Panel Overview](admin-panel/overview.md)** - Understanding the interface
2. **[Block System](blocks/overview.md)** - Working with blocks
3. **[Custom Blocks](custom-blocks/overview.md)** - Building custom components

## 🎯 By User Type

### 👨‍💻 Developers
- **[API Reference](api/overview.md)** - Service classes and methods
- **[Development Guide](development/customization.md)** - Extending LaraGrape
- **[Best Practices](development/best-practices.md)** - Development guidelines
- **[Performance Optimization](development/performance.md)** - Optimizing your app

### 🎨 Designers
- **[Visual Block Builder](custom-blocks/overview.md)** - Creating custom blocks
- **[Tailwind Configuration](admin-panel/tailwind-config.md)** - Theme management
- **[Responsive Design](theming/responsive.md)** - Mobile-first design
- **[Custom Themes](theming/custom-themes.md)** - Creating custom themes

### 👥 Content Managers
- **[Page Management](admin-panel/pages.md)** - Creating and editing pages
- **[Site Settings](admin-panel/site-settings.md)** - Configuring your site
- **[Block System](blocks/overview.md)** - Using pre-built blocks
- **[Custom Blocks](custom-blocks/overview.md)** - Building reusable components

## 📚 By Topic

### 🧩 Core Systems
- **[Block System](blocks/overview.md)** - Dynamic block loading
- **[Component System](components/overview.md)** - Modular components
- **[Custom Blocks](custom-blocks/overview.md)** - Visual block builder
- **[Site Settings](site-settings/overview.md)** - Site configuration

### 🎨 Visual Builder
- **[GrapesJS Integration](grapesjs/overview.md)** - Visual page building
- **[Block Editor](grapesjs/block-editor.md)** - Using the editor
- **[Style Manager](grapesjs/style-manager.md)** - Managing styles
- **[Responsive Design](grapesjs/responsive.md)** - Mobile-first approach

### 🎯 Admin Panel
- **[Overview](admin-panel/overview.md)** - Admin interface guide
- **[Page Management](admin-panel/pages.md)** - Managing pages
- **[Custom Block Builder](admin-panel/custom-blocks.md)** - Building blocks
- **[Site Settings](admin-panel/site-settings.md)** - Configuration
- **[Tailwind Configuration](admin-panel/tailwind-config.md)** - Theme management

### 🔧 Development
- **[API Reference](api/overview.md)** - Service classes and methods
- **[Customization](development/customization.md)** - Extending LaraGrape
- **[Best Practices](development/best-practices.md)** - Development guidelines
- **[Performance Optimization](development/performance.md)** - Optimizing performance

### 🎨 Theming & Styling
- **[Tailwind CSS Integration](theming/tailwind.md)** - Dynamic Tailwind
- **[Custom Themes](theming/custom-themes.md)** - Creating themes
- **[Dark Mode](theming/dark-mode.md)** - Dark mode implementation
- **[Responsive Design](theming/responsive.md)** - Mobile-first design

### 🔍 Troubleshooting
- **[Common Issues](troubleshooting/common-issues.md)** - Frequently encountered problems
- **[Error Handling](troubleshooting/error-handling.md)** - Understanding errors
- **[Debug Mode](troubleshooting/debug-mode.md)** - Debugging your app
- **[Performance Issues](troubleshooting/performance.md)** - Resolving performance problems

### 📖 Reference
- **[Configuration](reference/configuration.md)** - All configuration options
- **[Commands](reference/commands.md)** - Available Artisan commands
- **[Database Schema](reference/database.md)** - Database structure
- **[File Structure](reference/file-structure.md)** - Package organization

## 🔍 Search by Problem

### "I can't install LaraGrape"
- **[Installation Guide](installation.md)** - Complete setup instructions
- **[Troubleshooting](troubleshooting/common-issues.md)** - Common installation issues

### "Blocks aren't loading"
- **[Block System](blocks/overview.md)** - Understanding blocks
- **[Troubleshooting](troubleshooting/common-issues.md)** - Block loading issues

### "Admin panel not working"
- **[Admin Panel Overview](admin-panel/overview.md)** - Admin interface guide
- **[Troubleshooting](troubleshooting/common-issues.md)** - Admin panel issues

### "Styling not working"
- **[Tailwind Configuration](admin-panel/tailwind-config.md)** - Theme management
- **[Theming Guide](theming/tailwind.md)** - Tailwind CSS integration

### "How do I create custom blocks?"
- **[Custom Blocks](custom-blocks/overview.md)** - Visual block builder
- **[Block System](blocks/overview.md)** - Understanding the system

### "Performance is slow"
- **[Performance Optimization](development/performance.md)** - Optimizing your app
- **[Troubleshooting](troubleshooting/performance.md)** - Performance issues

## 📋 Quick Reference

### Essential Commands
```bash
# Setup
php artisan laragrape:setup --all

# Create admin user
php artisan make:filament-user

# Rebuild Tailwind
php artisan tailwind:rebuild

# Clear cache
php artisan optimize:clear
```

### Key URLs
- **Admin Panel**: `/admin`
- **Block Preview**: `/admin/block-preview/{blockId}`
- **Pages**: `/admin/pages`
- **Custom Blocks**: `/admin/custom-blocks`
- **Site Settings**: `/admin/site-settings`
- **Tailwind Config**: `/admin/tailwind-configs`

### Important Files
- **Block Directory**: `resources/views/filament/blocks/`
- **Custom CSS**: `resources/css/site.css`
- **Page Template**: `resources/views/pages/show.blade.php`
- **Admin Layout**: `resources/views/components/layout/app.blade.php`

## 🆘 Need Help?

### Documentation Issues
- Check the **[Troubleshooting Guide](troubleshooting/common-issues.md)**
- Search existing **[GitHub Issues](https://github.com/your-org/laragrape/issues)**
- Create a new issue with detailed information

### Getting Support
- **GitHub Issues**: Report bugs and request features
- **GitHub Discussions**: Ask questions and share ideas
- **Documentation**: This wiki contains comprehensive guides

### Contributing
- **[Contributing Guide](../CONTRIBUTING.md)** - How to contribute
- **[Code of Conduct](../CODE_OF_CONDUCT.md)** - Community guidelines
- **[Security Policy](../SECURITY.md)** - Security reporting

---

**Can't find what you're looking for?** Check the **[main documentation index](README.md)** or search the repository for specific terms. 