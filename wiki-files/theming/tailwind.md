# 🎨 Tailwind CSS Integration

LaraGrape includes a dynamic Tailwind CSS system that allows you to customize themes through the admin panel without touching code.

## 🚀 Overview

The Tailwind CSS integration provides:

- ✅ **Dynamic Configuration**: Change themes through admin panel
- ✅ **Real-time Updates**: See changes instantly
- ✅ **Multiple Themes**: Create and switch between themes
- ✅ **Dark Mode Support**: Built-in dark mode configuration
- ✅ **Custom CSS**: Add custom styles and animations
- ✅ **Performance Optimized**: Efficient CSS generation

## 🎯 Getting Started

### Accessing Theme Management

1. **Login to Admin Panel**
   - Go to `/admin`
   - Use your admin credentials

2. **Navigate to Tailwind Config**
   - Click **Tailwind Config** in the navigation
   - Create a new configuration or edit existing

3. **Configure Your Theme**
   - Set colors, typography, spacing
   - Configure dark mode
   - Add custom CSS

### Creating Your First Theme

1. **Click "Create Tailwind Config"**
2. **Fill in Basic Information**:
   - **Name**: "My Custom Theme"
   - **Description**: "A beautiful custom theme"
   - **Active**: Check to make this the active theme

3. **Configure Colors**:
   - Set primary color palette (50-950)
   - Add secondary and accent colors
   - Configure status colors (success, warning, error)

4. **Set Typography**:
   - Choose font families
   - Set base font size and line height
   - Configure font weights

5. **Configure Spacing**:
   - Set base spacing unit
   - Configure container padding
   - Set border radius values

6. **Save and Rebuild**:
   - Click **Save**
   - Run `php artisan tailwind:rebuild`

## 🎨 Color System

### Primary Colors

Configure your primary color palette with 11 shades (50-950):

```css
/* Generated CSS */
:root {
    --primary-50: #eff6ff;
    --primary-100: #dbeafe;
    --primary-200: #bfdbfe;
    --primary-300: #93c5fd;
    --primary-400: #60a5fa;
    --primary-500: #3b82f6;
    --primary-600: #2563eb;
    --primary-700: #1d4ed8;
    --primary-800: #1e40af;
    --primary-900: #1e3a8a;
    --primary-950: #172554;
}
```

### Additional Colors

Configure additional color categories:

- **Secondary Color**: Used for secondary elements
- **Accent Color**: Used for highlights and CTAs
- **Success Color**: Used for success states
- **Warning Color**: Used for warning states
- **Error Color**: Used for error states
- **Info Color**: Used for informational elements

### Color Usage

Use colors in your blocks and components:

```html
<!-- Primary colors -->
<div class="bg-primary-500 text-primary-50">Primary background</div>
<button class="bg-primary-600 hover:bg-primary-700">Primary button</button>

<!-- Status colors -->
<div class="bg-success-500 text-white">Success message</div>
<div class="bg-warning-500 text-white">Warning message</div>
<div class="bg-error-500 text-white">Error message</div>

<!-- Custom colors -->
<div class="bg-secondary-500 text-white">Secondary element</div>
<div class="bg-accent-500 text-white">Accent element</div>
```

## 📝 Typography

### Font Families

Configure three main font families:

- **Sans Font Family**: Primary font for body text
- **Serif Font Family**: Used for headings and quotes
- **Monospace Font Family**: Used for code and technical content

### Typography Settings

- **Base Font Size**: Default font size (usually 1rem)
- **Base Line Height**: Default line height (usually 1.5)
- **Base Font Weight**: Default font weight (usually 400)

### Typography Usage

```html
<!-- Default typography -->
<p class="text-base leading-relaxed">Body text with default settings</p>

<!-- Custom typography -->
<h1 class="text-4xl font-bold text-primary-900">Large heading</h1>
<h2 class="text-2xl font-semibold text-secondary-700">Medium heading</h2>
<p class="text-lg text-gray-600">Large body text</p>

<!-- Font families -->
<p class="font-sans">Sans-serif text</p>
<p class="font-serif">Serif text</p>
<code class="font-mono">Monospace code</code>
```

## 📏 Spacing & Layout

### Spacing Scale

Configure your spacing system:

- **Spacing Unit**: Base spacing unit (usually 0.25rem = 4px)
- **Container Padding**: Default container padding
- **Border Radius**: Default and large border radius values

### Breakpoints

Configure responsive breakpoints:

- **Small**: 640px (mobile landscape)
- **Medium**: 768px (tablet)
- **Large**: 1024px (desktop)
- **Extra Large**: 1280px (large desktop)

### Spacing Usage

```html
<!-- Spacing utilities -->
<div class="p-4">Padding using spacing scale</div>
<div class="m-2">Margin using spacing scale</div>
<div class="space-y-4">Vertical spacing between children</div>

<!-- Responsive spacing -->
<div class="p-4 md:p-6 lg:p-8">Responsive padding</div>

<!-- Border radius -->
<div class="rounded">Default border radius</div>
<div class="rounded-lg">Large border radius</div>
```

## 🌙 Dark Mode

### Dark Mode Configuration

Enable and configure dark mode:

1. **Enable Dark Mode**: Toggle dark mode support
2. **Dark Primary Colors**: Configure dark mode primary palette
3. **Dark Additional Colors**: Set dark mode colors for other categories

### Dark Mode Usage

```html
<!-- Dark mode classes -->
<div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
    Content that adapts to dark mode
</div>

<!-- Dark mode with custom colors -->
<div class="bg-primary-500 dark:bg-dark-primary-500 text-white">
    Custom dark mode colors
</div>
```

### Dark Mode Toggle

Add a dark mode toggle to your site:

```html
<button 
    class="dark-mode-toggle"
    onclick="toggleDarkMode()"
    aria-label="Toggle dark mode">
    <svg class="sun-icon" width="24" height="24">
        <!-- Sun icon -->
    </svg>
    <svg class="moon-icon" width="24" height="24">
        <!-- Moon icon -->
    </svg>
</button>
```

```javascript
// Dark mode toggle functionality
function toggleDarkMode() {
    const html = document.documentElement;
    const isDark = html.classList.contains('dark');
    
    if (isDark) {
        html.classList.remove('dark');
        localStorage.setItem('darkMode', 'light');
    } else {
        html.classList.add('dark');
        localStorage.setItem('darkMode', 'dark');
    }
}

// Check for saved preference
const savedMode = localStorage.getItem('darkMode');
if (savedMode === 'dark' || 
    (!savedMode && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
}
```

## 🎨 Custom CSS

### Adding Custom CSS

Add custom CSS to your theme:

1. **Enable Custom CSS**: Toggle custom CSS injection
2. **Add CSS Rules**: Write your custom CSS
3. **Use CSS Variables**: Reference theme variables

### Custom CSS Examples

```css
/* Custom animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

/* Custom components */
.gradient-button {
    background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    color: white;
    font-weight: 500;
    transition: all 0.3s ease;
}

.gradient-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

/* Custom utilities */
.text-gradient {
    background: linear-gradient(135deg, var(--primary-500), var(--accent-500));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Dark mode custom styles */
.dark .custom-card {
    background: var(--dark-primary-800);
    border-color: var(--dark-primary-700);
}
```

## 🔧 Advanced Configuration

### Performance Settings

Configure performance options:

- **Purge CSS**: Remove unused CSS in production
- **Minify CSS**: Compress CSS for faster loading

### CSS Variables Prefix

Set custom prefix for CSS variables:

```css
/* Default prefix */
:root {
    --laralgrape-primary-500: #3b82f6;
}

/* Custom prefix */
:root {
    --myapp-primary-500: #3b82f6;
}
```

### Animation Settings

Configure animation support:

- **Enable Animations**: Toggle CSS animations and transitions
- **Custom Animation Classes**: Add animation utilities

## 🚀 Rebuilding Themes

### Manual Rebuild

Rebuild your theme manually:

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

### Automatic Rebuild

Themes are automatically rebuilt when:

- ✅ Configuration is saved in admin panel
- ✅ Active theme is changed
- ✅ Theme settings are updated

### Rebuild Process

1. **Load Configuration**: Retrieve active theme from database
2. **Generate CSS**: Create utility classes and theme CSS
3. **Write Files**: Save to public directory
4. **Update Assets**: Ensure proper file permissions

## 📱 Responsive Design

### Mobile-First Approach

Design for mobile first, then enhance for larger screens:

```html
<!-- Mobile-first responsive design -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <div class="p-4 md:p-6 lg:p-8">Content</div>
    <div class="p-4 md:p-6 lg:p-8">Content</div>
    <div class="p-4 md:p-6 lg:p-8">Content</div>
</div>

<!-- Responsive typography -->
<h1 class="text-2xl md:text-3xl lg:text-4xl">Responsive heading</h1>
<p class="text-sm md:text-base lg:text-lg">Responsive text</p>
```

### Breakpoint Usage

Use configured breakpoints:

```html
<!-- Small screens (640px+) -->
<div class="sm:block">Visible on small screens and up</div>

<!-- Medium screens (768px+) -->
<div class="md:flex">Flex layout on medium screens and up</div>

<!-- Large screens (1024px+) -->
<div class="lg:grid lg:grid-cols-3">Grid on large screens</div>

<!-- Extra large screens (1280px+) -->
<div class="xl:container xl:mx-auto">Container on extra large screens</div>
```

## 🎯 Best Practices

### Color Usage

1. **Consistency**: Use consistent color palette throughout
2. **Accessibility**: Ensure sufficient color contrast
3. **Semantic Colors**: Use colors for their intended purpose
4. **Dark Mode**: Always consider dark mode variants

### Typography

1. **Hierarchy**: Use proper heading hierarchy
2. **Readability**: Choose readable font sizes and line heights
3. **Consistency**: Use consistent typography across components
4. **Performance**: Use web-safe fonts or optimize custom fonts

### Performance

1. **Purge Unused CSS**: Enable CSS purging in production
2. **Minify CSS**: Compress CSS for faster loading
3. **Optimize Images**: Use appropriate image formats and sizes
4. **Lazy Loading**: Implement lazy loading for heavy components

### Accessibility

1. **Color Contrast**: Ensure sufficient contrast ratios
2. **Focus States**: Provide clear focus indicators
3. **Screen Readers**: Use semantic HTML and ARIA labels
4. **Keyboard Navigation**: Ensure keyboard accessibility

## 🔍 Troubleshooting

### Common Issues

#### Theme Not Updating
```bash
# Clear cache and rebuild
php artisan optimize:clear
php artisan tailwind:rebuild

# Check file permissions
chmod -R 755 public/css/
```

#### Colors Not Applying
1. **Check CSS Variables**: Ensure variables are properly defined
2. **Clear Browser Cache**: Hard refresh (Ctrl+F5)
3. **Check File Paths**: Verify CSS files are being loaded
4. **Inspect Elements**: Use browser dev tools to debug

#### Dark Mode Not Working
1. **Check Configuration**: Ensure dark mode is enabled
2. **Verify CSS**: Check dark mode classes are generated
3. **JavaScript**: Ensure dark mode toggle is working
4. **Local Storage**: Check for saved preferences

### Debug Mode

Enable debug mode to see more information:

```bash
# Enable debug mode
php artisan tailwind:rebuild --debug

# Check generated CSS
cat public/css/laralgrape-site-theme.css
```

## 📚 Related Documentation

- [Admin Panel](../admin-panel/overview.md) - Admin interface guide
- [Customization](../development/customization.md) - Extending themes
- [Commands Reference](../reference/commands.md) - Artisan commands
- [Troubleshooting](../troubleshooting/common-issues.md) - Common issues

---

**The dynamic Tailwind CSS system gives you complete control over your site's appearance! 🎨**

Create beautiful, responsive themes without touching code, and switch between themes instantly through the admin panel. 