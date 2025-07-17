# 🎯 Admin Panel Overview

LaraGrape uses [Filament 3](https://filamentphp.com/) to provide a modern, responsive admin interface for managing your website content and configuration.

## 🚀 Accessing the Admin Panel

### URL
```
http://your-site.test/admin
```

### Creating Admin Users
```bash
php artisan make:filament-user
```

Follow the prompts to create your admin credentials.

## 📋 Admin Panel Sections

### 1. Pages Management

**Location**: `Pages` in the admin navigation

**Features**:
- ✅ **Create Pages**: Build new pages with visual editor
- ✅ **Edit Pages**: Modify existing pages
- ✅ **Page List**: View all pages with search and filters
- ✅ **Publishing**: Control page visibility
- ✅ **SEO Management**: Meta tags and descriptions

**Page Editor Tabs**:
- **Basic Info**: Title, slug, meta information
- **Visual Editor**: GrapesJS drag-and-drop interface
- **Content**: Raw HTML content editing
- **SEO**: Meta tags, Open Graph, Twitter Cards

### 2. Custom Blocks Builder

**Location**: `Custom Blocks` in the admin navigation

**Features**:
- ✅ **Visual Block Builder**: Create blocks with live preview
- ✅ **HTML/CSS/JS Editors**: Separate tabs for each language
- ✅ **Category Management**: Organize blocks by type
- ✅ **Active/Inactive Toggle**: Control block availability
- ✅ **Sort Order**: Control block display order

**Block Builder Interface**:
- **HTML Tab**: Structure and content
- **CSS Tab**: Styling and animations
- **JavaScript Tab**: Interactivity and behavior
- **Preview Tab**: Live preview of the block

### 3. Site Settings

**Location**: `Site Settings` in the admin navigation

**Features**:
- ✅ **Grouped Settings**: Organized by category
- ✅ **Color Pickers**: Visual color selection
- ✅ **File Uploads**: Logo and image management
- ✅ **Rich Text Editors**: Formatted content
- ✅ **Toggle Switches**: Boolean settings

**Setting Categories**:
- **General**: Site name, contact info, address
- **Header**: Logo, colors, navigation settings
- **Footer**: Footer content, social links
- **SEO**: Meta tags, analytics
- **Social**: Social media URLs
- **Advanced**: Custom CSS, JavaScript

### 4. Tailwind Configuration

**Location**: `Tailwind Config` in the admin navigation

**Features**:
- ✅ **Color Palette**: Primary, secondary, and accent colors
- ✅ **Typography**: Font families, sizes, weights
- ✅ **Spacing**: Custom spacing scale
- ✅ **Dark Mode**: Dark theme configuration
- ✅ **Custom CSS**: Additional styles

**Configuration Tabs**:
- **Basic Info**: Name, description, active status
- **Colors**: Primary color palette and additional colors
- **Typography**: Font settings and line heights
- **Spacing & Layout**: Spacing units and breakpoints
- **Custom CSS**: Additional styles
- **Advanced**: Dark mode, animations, performance

## 🎨 Admin Panel Features

### Modern Interface
- **Responsive Design**: Works on all devices
- **Dark/Light Mode**: Toggle between themes
- **Fast Loading**: Optimized for performance
- **Intuitive Navigation**: Easy to find what you need

### User Experience
- **Drag & Drop**: Visual content management
- **Live Preview**: See changes in real-time
- **Auto-save**: Never lose your work
- **Keyboard Shortcuts**: Power user features

### Developer Friendly
- **Clean Code**: Well-structured resources
- **Extensible**: Easy to add new features
- **Customizable**: Modify to fit your needs
- **Documented**: Clear code comments

## 🔧 Filament Resources

### PageResource

**File**: `app/Filament/Resources/PageResource.php`

**Key Features**:
- Tabbed interface for different editing modes
- GrapesJS integration for visual editing
- SEO management tools
- Publishing controls

**Methods**:
- `form()`: Define the form structure
- `table()`: Define the list view
- `getPages()`: Define available pages

### CustomBlockResource

**File**: `app/Filament/Resources/CustomBlockResource.php`

**Key Features**:
- Visual block builder interface
- Live preview functionality
- Category management
- Active/inactive controls

### SiteSettingsResource

**File**: `app/Filament/Resources/SiteSettingsResource.php`

**Key Features**:
- Grouped settings interface
- Dynamic form fields
- File upload capabilities
- Color picker integration

### TailwindConfigResource

**File**: `app/Filament/Resources/TailwindConfigResource.php`

**Key Features**:
- Comprehensive theme configuration
- Color palette management
- Typography settings
- CSS generation

## 🛠️ Customization

### Adding New Resources

Create new Filament resources for additional functionality:

```bash
php artisan make:filament-resource YourModel
```

### Customizing Existing Resources

Modify resource files to add custom functionality:

```php
// In PageResource.php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            // Your custom form fields
        ]);
}
```

### Adding Custom Actions

Create custom actions for bulk operations:

```php
// In PageResource.php
public static function table(Table $table): Table
{
    return $table
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            // Your custom actions
        ]);
}
```

## 🔐 User Management

### Creating Users

```bash
php artisan make:filament-user
```

### User Roles (Future Feature)

Planned features for user role management:
- **Admin**: Full access to all features
- **Editor**: Can edit pages and blocks
- **Author**: Can create and edit their own content
- **Viewer**: Read-only access

### Permissions

Current permissions:
- **Full Access**: Admin users have access to everything
- **Page Management**: Create, edit, delete pages
- **Block Management**: Create, edit, delete blocks
- **Settings Management**: Modify site settings
- **Theme Management**: Configure Tailwind themes

## 📊 Dashboard

### Default Dashboard

The admin panel includes a dashboard with:
- **Recent Pages**: Latest created/updated pages
- **Quick Stats**: Page count, block count
- **System Status**: Laravel and package versions
- **Quick Actions**: Create new pages, blocks

### Customizing Dashboard

Modify `app/Filament/Pages/Dashboard.php` to customize:

```php
public function getHeaderWidgets(): array
{
    return [
        // Your custom widgets
    ];
}
```

## 🎯 Best Practices

### Content Management
- **Use Visual Editor**: Leverage GrapesJS for easy content creation
- **Create Reusable Blocks**: Build custom blocks for repeated content
- **Organize Content**: Use clear titles and descriptions
- **Preview Before Publishing**: Always preview changes

### Settings Management
- **Group Related Settings**: Keep related settings together
- **Use Descriptive Names**: Make settings easy to understand
- **Test Changes**: Verify settings work as expected
- **Backup Configurations**: Export important settings

### Performance
- **Optimize Images**: Use appropriate image sizes
- **Limit Block Complexity**: Keep blocks lightweight
- **Use Caching**: Enable Laravel caching
- **Monitor Usage**: Watch for performance issues

## 🔍 Troubleshooting

### Common Admin Issues

**Can't Access Admin Panel**
```bash
php artisan filament:install --panels
php artisan make:filament-user
```

**Resources Not Appearing**
```bash
php artisan filament:cache
php artisan optimize:clear
```

**Editor Not Loading**
```bash
npm run build
php artisan cache:clear
```

### Debug Mode

Enable debug mode in `.env`:
```
APP_DEBUG=true
```

Check logs in `storage/logs/laravel.log`

## 📚 Related Documentation

- [Page Management](pages.md) - Detailed page management guide
- [Custom Block Builder](custom-blocks.md) - Building custom blocks
- [Site Settings](site-settings.md) - Configuration management
- [Tailwind Configuration](tailwind-config.md) - Theme management
- [API Reference](../api/overview.md) - Service classes and methods

---

**The admin panel provides a powerful, user-friendly interface for managing your LaraGrape website! 🎯**

With Filament 3, you get a modern, responsive admin experience that makes content management intuitive and efficient. 