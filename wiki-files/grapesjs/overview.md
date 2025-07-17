# 🎨 GrapesJS Integration

LaraGrape integrates [GrapesJS](https://grapesjs.com/) to provide a powerful visual page builder with drag-and-drop functionality, real-time editing, and responsive design capabilities.

## 🚀 Overview

GrapesJS is a free and open-source Web Builder Framework that allows you to create HTML templates without coding knowledge. In LaraGrape, it provides:

- ✅ **Visual Page Building**: Drag-and-drop interface
- ✅ **Real-time Editing**: See changes instantly
- ✅ **Responsive Design**: Mobile-first approach
- ✅ **Block Management**: Organized component library
- ✅ **Style Management**: Visual style editing
- ✅ **Code Export**: Clean HTML/CSS output

## 🎯 Getting Started

### Accessing the Editor

1. **Login to Admin Panel**
   - Go to `/admin`
   - Use your admin credentials

2. **Create or Edit a Page**
   - Navigate to **Pages** → **Create Page** or **Edit Page**
   - Switch to the **Visual Editor** tab

3. **Start Building**
   - Drag blocks from the left sidebar to the canvas
   - Click on elements to edit content
   - Use the right panel for styling and properties

## 🧩 Block System

### Available Blocks

Blocks are organized by category in the left sidebar:

#### Components
- **Button**: Interactive buttons with variants
- **Card**: Content cards with images and text
- **Alert**: Notification and alert components
- **Pricing**: Pricing table components
- **Testimonial**: Customer testimonial blocks

#### Content
- **Text**: Simple text content
- **Heading**: Page headings and titles
- **List**: Ordered and unordered lists
- **Quote**: Blockquote components
- **Divider**: Horizontal separators
- **Spacer**: Vertical spacing elements

#### Layouts
- **Container**: Content wrapper
- **Section**: Page sections
- **Grid**: CSS Grid layouts
- **Columns**: Multi-column layouts
- **Hero**: Hero section with background

#### Media
- **Image**: Image components
- **Gallery**: Image galleries
- **Video**: Video embed components

#### Forms
- **Contact Form**: Contact form with fields

### Adding Blocks

1. **Drag and Drop**: Click and drag blocks from the sidebar to the canvas
2. **Click to Add**: Click on a block to add it to the current selection
3. **Keyboard Shortcuts**: Use keyboard shortcuts for quick access

### Editing Blocks

#### Text Editing
- **Double-click** on text elements to edit
- **Click** and start typing to replace content
- **Use the right panel** for advanced text formatting

#### Image Editing
- **Click** on images to select them
- **Use the right panel** to change source, alt text, and dimensions
- **Drag** to resize or move images

#### Style Editing
- **Select** any element
- **Use the right panel** to modify:
  - Colors and backgrounds
  - Typography (font, size, weight)
  - Spacing (padding, margin)
  - Borders and shadows
  - Effects and animations

## 🎨 Style Management

### Visual Style Editor

The right panel provides visual controls for styling:

#### Typography
- **Font Family**: Choose from available fonts
- **Font Size**: Set text size with slider or input
- **Font Weight**: Bold, normal, light options
- **Line Height**: Control line spacing
- **Text Align**: Left, center, right, justify

#### Colors
- **Text Color**: Change text color
- **Background Color**: Set background color
- **Border Color**: Modify border colors
- **Color Picker**: Visual color selection

#### Spacing
- **Padding**: Internal spacing
- **Margin**: External spacing
- **Individual Sides**: Control top, right, bottom, left separately

#### Effects
- **Border**: Width, style, color
- **Border Radius**: Rounded corners
- **Box Shadow**: Drop shadows and effects
- **Opacity**: Transparency control

### CSS Classes

You can also apply CSS classes:

1. **Select an element**
2. **Open the right panel**
3. **Go to the "Classes" section**
4. **Add or remove CSS classes**

Common Tailwind classes:
```css
/* Spacing */
p-4          /* padding: 1rem */
m-2          /* margin: 0.5rem */
mt-8         /* margin-top: 2rem */

/* Colors */
bg-blue-500  /* background-color: #3b82f6 */
text-white   /* color: white */
border-gray-300 /* border-color: #d1d5db */

/* Typography */
text-xl      /* font-size: 1.25rem */
font-bold    /* font-weight: 700 */
text-center  /* text-align: center */

/* Layout */
flex         /* display: flex */
grid         /* display: grid */
hidden       /* display: none */

/* Responsive */
md:flex      /* display: flex on medium screens and up */
lg:hidden    /* display: none on large screens and up */
```

## 📱 Responsive Design

### Device Preview

Switch between device views:

1. **Desktop**: Default view (1024px+)
2. **Tablet**: Medium screens (768px - 1023px)
3. **Mobile**: Small screens (up to 767px)

### Responsive Editing

- **Select elements** in different device views
- **Adjust styles** for each breakpoint
- **Preview changes** in real-time
- **Test interactions** across devices

### Mobile-First Approach

Design for mobile first, then enhance for larger screens:

```css
/* Mobile styles (default) */
.container {
    padding: 1rem;
    margin: 0.5rem;
}

/* Tablet styles */
@media (min-width: 768px) {
    .container {
        padding: 1.5rem;
        margin: 1rem;
    }
}

/* Desktop styles */
@media (min-width: 1024px) {
    .container {
        padding: 2rem;
        margin: 1.5rem;
    }
}
```

## 🔧 Advanced Features

### Custom CSS

Add custom CSS to elements:

1. **Select an element**
2. **Open the right panel**
3. **Go to "CSS" section**
4. **Add custom CSS rules**

Example:
```css
.my-custom-class {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.my-custom-class:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}
```

### JavaScript Integration

Add JavaScript to elements:

1. **Select an element**
2. **Open the right panel**
3. **Go to "Scripts" section**
4. **Add JavaScript code**

Example:
```javascript
// Add click handler
this.addEventListener('click', function() {
    console.log('Element clicked!');
    // Add your custom functionality
});

// Add animation on scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
});

this.style.opacity = '0';
this.style.transform = 'translateY(20px)';
this.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
observer.observe(this);
```

### Component Management

#### Creating Components

1. **Select multiple elements**
2. **Right-click** and choose "Create Component"
3. **Name your component**
4. **Use it** in other parts of your page

#### Editing Components

1. **Double-click** on a component instance
2. **Edit the component** structure
3. **Changes apply** to all instances

## 🎯 Best Practices

### Design Principles

1. **Mobile-First**: Design for mobile, enhance for desktop
2. **Consistency**: Use consistent spacing, colors, and typography
3. **Accessibility**: Include proper alt text and semantic HTML
4. **Performance**: Optimize images and keep code clean

### Content Organization

1. **Logical Structure**: Use proper heading hierarchy
2. **Clear Sections**: Separate content into logical sections
3. **Visual Hierarchy**: Use size and color to guide attention
4. **Whitespace**: Use spacing to improve readability

### Code Quality

1. **Semantic HTML**: Use proper HTML elements
2. **Clean CSS**: Avoid inline styles when possible
3. **Responsive**: Test on different screen sizes
4. **Performance**: Optimize for fast loading

## 🔍 Troubleshooting

### Common Issues

#### Editor Not Loading
1. **Check JavaScript**: Ensure JavaScript is enabled
2. **Clear Cache**: `php artisan cache:clear`
3. **Check Console**: Look for JavaScript errors
4. **Refresh Page**: Hard refresh (Ctrl+F5)

#### Blocks Not Appearing
1. **Check Block Files**: Ensure block files exist
2. **Clear Cache**: `php artisan cache:clear`
3. **Check Permissions**: Verify file permissions
4. **Check Console**: Look for loading errors

#### Styling Issues
1. **CSS Conflicts**: Check for conflicting styles
2. **Specificity**: Use more specific selectors
3. **Responsive Issues**: Test on different devices
4. **Browser Compatibility**: Test in different browsers

#### Save Issues
1. **Check Network**: Ensure stable internet connection
2. **Clear Cache**: `php artisan cache:clear`
3. **Check Permissions**: Verify write permissions
4. **Try Again**: Sometimes retrying works

### Debug Mode

Enable debug mode to see more information:

```javascript
// In browser console
localStorage.setItem('gjs-debug', 'true');
location.reload();
```

## 📚 Keyboard Shortcuts

### Navigation
- **Esc**: Deselect current element
- **Delete**: Delete selected element
- **Ctrl+Z**: Undo
- **Ctrl+Y**: Redo
- **Ctrl+C**: Copy element
- **Ctrl+V**: Paste element

### Editing
- **Enter**: Edit text content
- **Tab**: Navigate between elements
- **Shift+Tab**: Navigate backwards
- **Arrow Keys**: Move selected element

### View
- **Ctrl+Shift+M**: Toggle mobile view
- **Ctrl+Shift+T**: Toggle tablet view
- **Ctrl+Shift+D**: Toggle desktop view

## 🎨 Customization

### Adding Custom Blocks

Create custom blocks in `resources/views/filament/blocks/`:

```blade
{{-- @block id="my-block" label="My Block" description="A custom block" --}}
<div class="my-custom-block">
    <h3 data-gjs-type="text" data-gjs-name="title">Block Title</h3>
    <p data-gjs-type="text" data-gjs-name="content">Block content</p>
</div>
```

### Customizing the Editor

Modify editor settings in `resources/js/grapesjs-editor.js`:

```javascript
// Customize editor options
const editor = grapesjs.init({
    container: '#gjs',
    height: '100vh',
    storageManager: false,
    panels: {
        defaults: [
            // Custom panels
        ]
    },
    // Add your customizations here
});
```

## 📚 Related Documentation

- [Block System](../blocks/overview.md) - Understanding blocks
- [Custom Blocks](../custom-blocks/overview.md) - Creating custom blocks
- [Admin Panel](../admin-panel/overview.md) - Admin interface
- [API Reference](../api/overview.md) - Service classes

---

**GrapesJS provides a powerful, user-friendly visual editor that makes page building intuitive and efficient! 🎨**

With drag-and-drop functionality, real-time editing, and responsive design tools, you can create professional websites without writing code. 