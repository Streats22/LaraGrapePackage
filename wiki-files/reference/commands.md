# 📋 Artisan Commands Reference

Complete reference for all Artisan commands available in LaraGrape.

## 🚀 LaraGrape Commands

### laragrape:setup

Sets up LaraGrape in your Laravel application.

```bash
php artisan laragrape:setup [options]
```

#### Options

| Option | Description | Default |
|--------|-------------|---------|
| `--all` | Complete setup (publish, migrate, seed) | false |
| `--migrate` | Run migrations after publishing | false |
| `--seed` | Run seeders after publishing | false |
| `--force` | Overwrite existing files | false |

#### Examples

```bash
# Complete setup (recommended)
php artisan laragrape:setup --all

# Publish only
php artisan laragrape:setup

# Publish and migrate
php artisan laragrape:setup --migrate

# Force overwrite existing files
php artisan laragrape:setup --force

# Complete setup with force
php artisan laragrape:setup --all --force
```

#### What It Does

1. **Publishes Resources**:
   - Filament resources and pages
   - Controllers and models
   - Service classes
   - Database migrations and seeders
   - Views and components
   - CSS and JavaScript files
   - Configuration files

2. **Updates Namespaces**:
   - Converts `LaraGrape` namespaces to `App`
   - Updates all class references
   - Fixes import statements

3. **Registers Services**:
   - Registers service providers
   - Registers commands
   - Sets up routes

4. **Database Setup** (with `--migrate`):
   - Runs all migrations
   - Creates necessary tables

5. **Seed Data** (with `--seed`):
   - Seeds initial data
   - Creates sample pages and blocks

### tailwind:rebuild

Rebuilds Tailwind CSS with dynamic configuration from the database.

```bash
php artisan tailwind:rebuild [options]
```

#### Options

| Option | Description | Default |
|--------|-------------|---------|
| `--config` | Specific config ID to rebuild | null |
| `--force` | Force rebuild even if no changes | false |
| `--watch` | Watch for changes and rebuild | false |

#### Examples

```bash
# Rebuild with active configuration
php artisan tailwind:rebuild

# Rebuild specific configuration
php artisan tailwind:rebuild --config=1

# Force rebuild
php artisan tailwind:rebuild --force

# Watch for changes
php artisan tailwind:rebuild --watch
```

#### What It Does

1. **Loads Configuration**:
   - Retrieves active TailwindConfig from database
   - Falls back to default configuration if none active

2. **Generates CSS**:
   - Creates utility classes CSS
   - Generates site theme CSS
   - Creates admin theme CSS

3. **Writes Files**:
   - Writes to `public/css/laralgrape-utilities.css`
   - Writes to `public/css/laralgrape-site-theme.css`
   - Writes to `public/css/laralgrape-admin-theme.css`

4. **Updates Assets**:
   - Copies files to public directory
   - Ensures proper file permissions

## 🔧 Laravel Commands

### Standard Laravel Commands

These commands are available in any Laravel application:

#### Cache Commands

```bash
# Clear all caches
php artisan optimize:clear

# Clear specific caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Database Commands

```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh install with seeding
php artisan migrate:fresh --seed

# Reset database
php artisan migrate:reset

# Check migration status
php artisan migrate:status
```

#### User Commands

```bash
# Create Filament user
php artisan make:filament-user

# Create Laravel user
php artisan make:user
```

## 🎯 Filament Commands

### Filament Installation

```bash
# Install Filament panels
php artisan filament:install --panels

# Install Filament widgets
php artisan filament:install --widgets

# Install Filament forms
php artisan filament:install --forms

# Install Filament tables
php artisan filament:install --tables

# Install Filament notifications
php artisan filament:install --notifications
```

### Filament Management

```bash
# Clear Filament cache
php artisan filament:cache

# Upgrade Filament
php artisan filament:upgrade

# List all resources
php artisan filament:list-resources
```

## 🛠️ Development Commands

### Asset Management

```bash
# Install npm dependencies
npm install

# Build for development
npm run dev

# Build for production
npm run build

# Watch for changes
npm run watch
```

### Testing Commands

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ExampleTest.php

# Run tests with coverage
php artisan test --coverage

# Run tests in parallel
php artisan test --parallel
```

## 📊 Utility Commands

### System Information

```bash
# Show Laravel version
php artisan --version

# Show application information
php artisan about

# List all commands
php artisan list

# Show command help
php artisan help laragrape:setup
```

### Debug Commands

```bash
# Show configuration
php artisan config:show

# Show routes
php artisan route:list

# Show environment
php artisan env

# Tinker (interactive shell)
php artisan tinker
```

## 🔍 Custom Commands

### Creating Custom Commands

You can create custom commands for your LaraGrape application:

```bash
# Create a new command
php artisan make:command MyCustomCommand
```

Example custom command:

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BlockService;

class GenerateBlockReport extends Command
{
    protected $signature = 'blocks:report {--format=json}';
    protected $description = 'Generate a report of all blocks';

    public function handle(BlockService $blockService)
    {
        $blocks = $blockService->getBlocks();
        $format = $this->option('format');
        
        $this->info("Generating block report in {$format} format...");
        
        // Generate report logic here
        
        $this->info('Report generated successfully!');
    }
}
```

### Registering Custom Commands

Add your custom commands to `app/Console/Kernel.php`:

```php
protected $commands = [
    \App\Console\Commands\GenerateBlockReport::class,
];
```

## 🎯 Command Best Practices

### When to Use Each Command

#### Setup Commands
- **`laragrape:setup --all`**: Initial installation
- **`laragrape:setup --migrate`**: After database changes
- **`laragrape:setup --force`**: When files are corrupted

#### Maintenance Commands
- **`tailwind:rebuild`**: After theme changes
- **`optimize:clear`**: When experiencing issues
- **`cache:clear`**: After configuration changes

#### Development Commands
- **`npm run dev`**: During development
- **`npm run build`**: Before deployment
- **`php artisan test`**: Before committing changes

### Command Chaining

You can chain commands for common workflows:

```bash
# Complete setup workflow
php artisan laragrape:setup --all && npm install && npm run build

# Development workflow
php artisan optimize:clear && npm run dev

# Deployment workflow
php artisan config:cache && php artisan route:cache && npm run build
```

### Error Handling

Most commands include error handling:

```bash
# Check if command succeeded
if php artisan laragrape:setup --all; then
    echo "Setup completed successfully"
else
    echo "Setup failed"
fi
```

## 📚 Command Examples

### Complete Installation Workflow

```bash
# 1. Install LaraGrape
composer require streats22/laragrape

# 2. Setup LaraGrape
php artisan laragrape:setup --all

# 3. Create admin user
php artisan make:filament-user

# 4. Install and build assets
npm install
npm run build

# 5. Start development server
php artisan serve
```

### Troubleshooting Workflow

```bash
# 1. Clear all caches
php artisan optimize:clear

# 2. Rebuild Tailwind
php artisan tailwind:rebuild

# 3. Rebuild assets
npm run build

# 4. Check for errors
php artisan about
```

### Development Workflow

```bash
# 1. Start development
npm run dev

# 2. In another terminal, start server
php artisan serve

# 3. Watch for changes
php artisan tailwind:rebuild --watch
```

## 🔍 Troubleshooting Commands

### Common Issues

#### Command Not Found
```bash
# Clear command cache
php artisan config:clear

# Check if command exists
php artisan list | grep laragrape
```

#### Permission Issues
```bash
# Fix file permissions
chmod -R 755 storage bootstrap/cache

# Clear cache
php artisan cache:clear
```

#### Database Issues
```bash
# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Reset database
php artisan migrate:fresh --seed
```

## 📚 Related Documentation

- [Installation Guide](../installation.md) - Complete setup instructions
- [API Reference](../api/overview.md) - Service classes and methods
- [Troubleshooting](../troubleshooting/common-issues.md) - Common issues and solutions
- [Customization](../development/customization.md) - Extending LaraGrape

---

**These commands provide powerful tools for managing and customizing your LaraGrape application! 📋**

Use them to streamline your development workflow and maintain your application effectively. 