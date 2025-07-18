# LaraGrape Update Command

The `laragrape:update` command allows you to selectively update LaraGrape components without doing a full installation. This is useful when you want to update specific parts of your LaraGrape installation or when new versions of components are available.

## Basic Usage

```bash
php artisan laragrape:update
```

When run without options, the command will show an interactive menu where you can select which components to update.

## Command Options

### Specific Component Updates

You can update specific component groups using these options:

```bash
# Update configuration files only
php artisan laragrape:update --config

# Update view files only
php artisan laragrape:update --views

# Update database migrations only
php artisan laragrape:update --migrations

# Update Filament admin panel components only
php artisan laragrape:update --filament

# Update frontend assets (CSS/JS) only
php artisan laragrape:update --assets

# Update controllers only
php artisan laragrape:update --controllers

# Update services only
php artisan laragrape:update --services

# Update routes only
php artisan laragrape:update --routes

# Update models only
php artisan laragrape:update --models

# Update database seeders only
php artisan laragrape:update --seeders

# Update console commands only
php artisan laragrape:update --console
```

### Update Everything

To update all components at once:

```bash
php artisan laragrape:update --all
```

### Force Overwrite

To overwrite existing files without asking for confirmation:

```bash
php artisan laragrape:update --force
```

You can combine this with other options:

```bash
php artisan laragrape:update --filament --force
```

## Component Groups

The update command organizes components into the following groups:

### Configuration Files
- **Description**: Laravel configuration files
- **Includes**: `config/LaraGrape.php`
- **Option**: `--config`

### View Files
- **Description**: Blade templates and components
- **Includes**: All view files, layout components, block views, custom pages
- **Option**: `--views`

### Database Migrations
- **Description**: Database migration files
- **Includes**: All LaraGrape migration files
- **Option**: `--migrations`

### Filament Admin Panel
- **Description**: Filament resources, pages, and components
- **Includes**: All Filament resources, pages, forms, and admin components
- **Option**: `--filament`

### Frontend Assets
- **Description**: CSS, JavaScript, and other frontend files
- **Includes**: CSS files, JS files, Vite config
- **Option**: `--assets`

### Controllers
- **Description**: HTTP controllers
- **Includes**: All LaraGrape controllers
- **Option**: `--controllers`

### Services
- **Description**: Service classes and business logic
- **Includes**: BlockService, GrapesJsConverterService, SiteSettingsService
- **Option**: `--services`

### Routes
- **Description**: Web routes and route definitions
- **Includes**: `routes/web.php`
- **Option**: `--routes`

### Models
- **Description**: Eloquent model classes
- **Includes**: All LaraGrape models
- **Option**: `--models`

### Database Seeders
- **Description**: Database seeder classes
- **Includes**: All LaraGrape seeders
- **Option**: `--seeders`

### Console Commands
- **Description**: Artisan console commands and kernel
- **Includes**: Console commands and kernel
- **Option**: `--console`

## Interactive Mode

When you run the command without any options, it will show an interactive menu:

```
📝 Select components to update:

  [0] Configuration Files - Laravel configuration files
  [1] View Files - Blade templates and components
  [2] Database Migrations - Database migration files
  [3] Filament Admin Panel - Filament resources, pages, and components
  [4] Frontend Assets - CSS, JavaScript, and other frontend files
  [5] Controllers - HTTP controllers
  [6] Services - Service classes and business logic
  [7] Routes - Web routes and route definitions
  [8] Models - Eloquent model classes
  [9] Database Seeders - Database seeder classes
  [10] Console Commands - Artisan console commands and kernel

Which components would you like to update? (Use space to select, enter to confirm)
```

You can use the spacebar to select multiple components and press Enter to confirm.

## What Happens During Update

For each selected component group, the update command will:

1. **Publish Files**: Use Laravel's `vendor:publish` command to copy files from the package to your application
2. **Update Namespaces**: Convert all `LaraGrape\` namespaces to `App\` namespaces
3. **Remove Prefixes**: Remove 'Lara' prefixes from class names and file names where applicable
4. **Post-process**: Apply any additional transformations needed for the specific component type

## Post-Update Steps

After running the update command, you may need to:

1. **Run Migrations**: If database structure changed
   ```bash
   php artisan migrate
   ```

2. **Compile Assets**: If frontend assets were updated
   ```bash
   npm run dev
   ```

3. **Clear Cache**: If you experience any issues
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

## Examples

### Update Only Filament Components
```bash
php artisan laragrape:update --filament
```

### Update Frontend Assets and Force Overwrite
```bash
php artisan laragrape:update --assets --force
```

### Update Multiple Components
```bash
php artisan laragrape:update --views --controllers --services
```

### Interactive Update with Confirmation
```bash
php artisan laragrape:update
# Then select components from the menu
```

## Troubleshooting

### Files Not Updated
If files are not being updated, try using the `--force` option:

```bash
php artisan laragrape:update --all --force
```

### Namespace Issues
If you encounter namespace-related errors after updating, clear the autoload cache:

```bash
composer dump-autoload
```

### Permission Issues
Make sure your application has write permissions to the directories being updated.

## Differences from Setup Command

The update command differs from the setup command in several ways:

- **No Filament Installation**: The update command doesn't install Filament (assumes it's already installed)
- **Selective Updates**: You can choose which components to update
- **Interactive Mode**: Provides a user-friendly menu for component selection
- **Focused Scope**: Only updates existing components, doesn't set up new installations
- **No Auto Re-run**: Doesn't automatically re-run with `--all` option

Use the setup command for initial installation and the update command for maintaining and updating existing installations. 