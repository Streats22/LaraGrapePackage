# 🔧 Troubleshooting Guide

Comprehensive guide for resolving common issues with LaraGrape installation, setup, and usage.

## 🚨 Common Issues

### Setup Issues

#### 1. Setup Command Fails

**Symptoms:**
- `php artisan laragrape:setup` fails with errors
- Files not published correctly
- Namespace issues

**Solutions:**
```bash
# Clear all caches
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Try setup again
php artisan laragrape:setup --all

# If still failing, try with force
php artisan laragrape:setup --all --force
```

**Check:**
- Laravel version (requires Laravel 12+)
- PHP version (requires PHP 8.2+)
- Composer dependencies installed
- File permissions

#### 2. Filament Not Installed

**Symptoms:**
- Admin panel not accessible
- Filament commands not found

**Solutions:**
```bash
# Install Filament
php artisan filament:install --panels

# Create admin user
php artisan make:filament-user

# Check if admin panel is accessible
# Visit: http://your-site.test/admin
```

#### 3. Database Migration Issues

**Symptoms:**
- Migration errors
- Tables not created
- Column type issues

**Solutions:**
```bash
# Rollback and re-run migrations
php artisan migrate:rollback
php artisan migrate

# Or fresh install
php artisan migrate:fresh --seed

# Check migration files exist
ls database/migrations/
```

### Block System Issues

#### 4. Blocks Not Loading in GrapesJS

**Symptoms:**
- Empty block manager
- 404 errors for block previews
- Blocks not appearing

**Solutions:**
```bash
# Clear block cache
php artisan cache:clear

# Check block files exist
ls resources/views/filament/blocks/

# Verify block metadata format
# Should have: {{-- @block id="..." label="..." --}}

# Check BlockService is working
php artisan tinker
>>> use App\Services\BlockService;
>>> $service = new BlockService();
>>> dd($service->getBlocks());
```

**Common Block Issues:**
- Missing metadata comments
- Incorrect file extensions (must be `.blade.php`)
- Wrong directory structure
- Syntax errors in block files

#### 5. Block Preview 404 Errors

**Symptoms:**
- Console errors: `Failed to load resource: 404`
- Block previews not loading

**Solutions:**
```bash
# Check route exists
php artisan route:list | grep block-preview

# Verify AdminPageController exists
ls app/Http/Controllers/AdminPageController.php

# Clear route cache
php artisan route:clear

# Check block IDs match
# Frontend should use simple IDs (e.g., 'button')
# Not category prefixes (e.g., 'components/button')
```

#### 6. Custom Blocks Not Working

**Symptoms:**
- Custom blocks not appearing
- Visual builder not working
- Preview not updating

**Solutions:**
```bash
# Check custom blocks table
php artisan tinker
>>> use App\Models\CustomBlock;
>>> CustomBlock::where('is_active', true)->get();

# Verify block is active
# Check in admin panel: Custom Blocks → Edit Block → Active = Yes

# Clear cache
php artisan cache:clear
```

### Frontend Issues

#### 7. GrapesJS Editor Not Loading

**Symptoms:**
- Editor not appearing
- JavaScript errors in console
- Alpine.js errors

**Solutions:**
```bash
# Build frontend assets
npm install
npm run build

# Check Alpine.js is installed
npm list alpinejs

# Install if missing
npm install alpinejs

# Clear browser cache
# Hard refresh (Ctrl+F5 or Cmd+Shift+R)
```

#### 8. Styling Issues

**Symptoms:**
- Tailwind classes not working
- Custom CSS not loading
- Theme not applying

**Solutions:**
```bash
# Rebuild Tailwind CSS
php artisan tailwind:rebuild

# Check Tailwind config
cat tailwind.config.js

# Verify CSS files exist
ls public/css/
ls resources/css/

# Check for active TailwindConfig
php artisan tinker
>>> use App\Models\TailwindConfig;
>>> TailwindConfig::where('is_active', true)->first();
```

#### 9. Page Not Displaying

**Symptoms:**
- 404 errors for pages
- Page content not showing
- Route not found

**Solutions:**
```bash
# Check routes
php artisan route:list | grep pages

# Verify page exists and is published
php artisan tinker
>>> use App\Models\Page;
>>> Page::where('slug', 'your-page-slug')->published()->first();

# Check page controller
ls app/Http/Controllers/PageController.php

# Clear route cache
php artisan route:clear
```

### Admin Panel Issues

#### 10. Filament Resources Not Found

**Symptoms:**
- Resources not appearing in admin
- "Resource not found" errors
- Missing menu items

**Solutions:**
```bash
# Check resource files exist
ls app/Filament/Resources/

# Verify namespaces are correct
# Should be: namespace App\Filament\Resources;

# Clear Filament cache
php artisan filament:cache

# Check AdminPanelProvider
cat app/Providers/Filament/AdminPanelProvider.php
```

#### 11. GrapesJS Editor in Admin Not Working

**Symptoms:**
- Editor not loading in admin
- Save not working
- Preview not updating

**Solutions:**
```bash
# Check GrapesJsEditor component
ls app/Filament/Forms/Components/GrapesJsEditor.php

# Verify JavaScript assets
ls public/js/
ls resources/js/

# Check for JavaScript errors in browser console
# Look for CORS issues or missing files
```

### Performance Issues

#### 12. Slow Loading

**Symptoms:**
- Pages load slowly
- Editor takes time to initialize
- Block loading delays

**Solutions:**
```bash
# Enable caching
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize assets
npm run build --production

# Check for large block files
# Consider lazy loading for complex blocks

# Monitor database queries
# Use Laravel Debugbar for development
```

#### 13. Memory Issues

**Symptoms:**
- PHP memory limit exceeded
- Timeout errors
- Server crashes

**Solutions:**
```bash
# Increase PHP memory limit
# In php.ini: memory_limit = 512M

# Increase max execution time
# In php.ini: max_execution_time = 300

# Check for memory leaks in custom blocks
# Limit block complexity and file sizes
```

## 🔍 Debugging Tools

### Laravel Debugging

```bash
# Enable debug mode
# In .env: APP_DEBUG=true

# View logs
tail -f storage/logs/laravel.log

# Check configuration
php artisan config:show

# List all routes
php artisan route:list

# Check service providers
php artisan config:cache
```

### Browser Debugging

```javascript
// Check Alpine.js components
console.log('Alpine components:', window.Alpine);

// Check GrapesJS
console.log('GrapesJS:', window.grapesjs);

// Check for JavaScript errors
// Open browser dev tools → Console tab
```

### Database Debugging

```bash
# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Check table structure
php artisan tinker
>>> Schema::getColumnListing('pages');
>>> Schema::getColumnListing('custom_blocks');
>>> Schema::getColumnListing('site_settings');
>>> Schema::getColumnListing('tailwind_configs');
```

## 🛠️ Maintenance Commands

### Regular Maintenance

```bash
# Clear all caches
php artisan optimize:clear

# Rebuild assets
npm run build

# Update Tailwind CSS
php artisan tailwind:rebuild

# Check for updates
composer update
npm update
```

### Emergency Recovery

```bash
# Complete reset (WARNING: Deletes all data)
php artisan migrate:fresh --seed

# Reinstall LaraGrape
php artisan laragrape:setup --all --force

# Rebuild everything
npm run build
php artisan tailwind:rebuild
php artisan optimize:clear
```

## 📞 Getting Help

### Before Asking for Help

1. **Check this troubleshooting guide**
2. **Search existing issues** on GitHub
3. **Check Laravel and Filament documentation**
4. **Verify your environment** meets requirements

### When Reporting Issues

Include:
- Laravel version (`php artisan --version`)
- PHP version (`php --version`)
- Error messages and stack traces
- Steps to reproduce
- Environment details (OS, server, etc.)

### Useful Commands for Debugging

```bash
# System information
php artisan about

# Check requirements
php artisan laragrape:setup --help

# Test services
php artisan tinker
>>> app(\App\Services\BlockService::class)->getBlocks();
>>> app(\App\Services\SiteSettingsService::class)->getSettings();

# Check file permissions
ls -la resources/views/filament/blocks/
ls -la app/Filament/Resources/
```

## 🎯 Quick Fix Checklist

When experiencing issues, try this order:

1. ✅ **Clear all caches**: `php artisan optimize:clear`
2. ✅ **Rebuild assets**: `npm run build`
3. ✅ **Check file permissions**: Ensure write access
4. ✅ **Verify database**: Check tables and data
5. ✅ **Test services**: Use Tinker to test services
6. ✅ **Check browser console**: Look for JavaScript errors
7. ✅ **Verify routes**: Check if routes are registered
8. ✅ **Test in isolation**: Create minimal test case

## 📚 Related Documentation

- [Installation Guide](../installation.md)
- [Block System](../blocks/overview.md)
- [API Reference](../api/overview.md)
- [Component System](../components/overview.md)

---

**Most issues can be resolved with proper cache clearing and asset rebuilding! 🔧**

For persistent issues, check the [GitHub issues](https://github.com/your-org/laragrape/issues) or create a new one with detailed information. 