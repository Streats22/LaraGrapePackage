# 🧩 Custom Blocks System

The Custom Blocks system allows you to create reusable, visual components using a built-in block builder with live preview functionality.

## 🚀 Overview

Custom Blocks are user-created components that can be:
- ✅ **Built Visually**: Use the block builder interface
- ✅ **Reused**: Add to multiple pages
- ✅ **Customized**: HTML, CSS, and JavaScript support
- ✅ **Organized**: Categorized for easy management
- ✅ **Previewed**: Live preview during creation

## 🎯 Creating Custom Blocks

### 1. Access the Block Builder

1. **Login to Admin Panel**
   - Go to `/admin`
   - Use your admin credentials

2. **Navigate to Custom Blocks**
   - Click **Custom Blocks** in the navigation
   - Click **Create Custom Block**

### 2. Basic Information

Fill in the basic information:

- **Name**: Descriptive name for your block (e.g., "Feature Card")
- **Description**: Brief description of what the block does
- **Category**: Choose from available categories (components, layouts, etc.)
- **Sort Order**: Control display order in the block manager

### 3. Building Your Block

The block builder has four main tabs:

#### HTML Tab
Write the structure of your block:

```html
<div class="feature-card">
    <div class="icon">
        <i class="fas fa-star"></i>
    </div>
    <h3 data-gjs-type="text" data-gjs-name="title">Feature Title</h3>
    <p data-gjs-type="text" data-gjs-name="description">Feature description goes here</p>
    <button data-gjs-type="text" data-gjs-name="button-text">Learn More</button>
</div>
```

**Key Points:**
- Use `data-gjs-type="text"` for editable text elements
- Use `data-gjs-name="unique-name"` to identify editable areas
- Structure your HTML semantically

#### CSS Tab
Add styling to your block:

```css
.feature-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.feature-card .icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}

.feature-card .icon i {
    color: white;
    font-size: 1.5rem;
}

.feature-card h3 {
    color: #2d3748;
    margin-bottom: 0.5rem;
    font-size: 1.25rem;
    font-weight: 600;
}

.feature-card p {
    color: #718096;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.feature-card button {
    background: #4299e1;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s ease;
}

.feature-card button:hover {
    background: #3182ce;
}
```

**CSS Best Practices:**
- Use descriptive class names
- Include hover states and transitions
- Make blocks responsive with media queries
- Use CSS variables for consistent theming

#### JavaScript Tab
Add interactivity to your block:

```javascript
// Feature card interactions
document.addEventListener('DOMContentLoaded', function() {
    const featureCards = document.querySelectorAll('.feature-card');
    
    featureCards.forEach(card => {
        // Add click handler for the button
        const button = card.querySelector('button');
        if (button) {
            button.addEventListener('click', function() {
                // Get the title for analytics or navigation
                const title = card.querySelector('h3').textContent;
                console.log('Feature clicked:', title);
                
                // You can add navigation, analytics, or other functionality
                // window.location.href = '/features/' + title.toLowerCase().replace(/\s+/g, '-');
            });
        }
        
        // Add animation on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });
        
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
```

**JavaScript Best Practices:**
- Use event delegation for dynamic content
- Include error handling
- Keep code modular and reusable
- Consider performance implications

#### Preview Tab
See your block in action:
- **Live Preview**: See how your block looks
- **Responsive Testing**: Test on different screen sizes
- **Interaction Testing**: Test JavaScript functionality

## 🎨 Block Categories

### Components
UI components like buttons, cards, alerts, etc.

### Layouts
Structural blocks like containers, grids, sections

### Content
Content-focused blocks like text, headings, lists

### Media
Media blocks like galleries, videos, sliders

### Forms
Form-related blocks like contact forms, newsletters

### Custom
User-defined categories for specific needs

## 🔧 Advanced Features

### GrapesJS Integration

Custom blocks automatically integrate with GrapesJS:

```html
<!-- Make elements editable in GrapesJS -->
<h3 data-gjs-type="text" data-gjs-name="title">Editable Title</h3>
<p data-gjs-type="text" data-gjs-name="content">Editable content</p>
<img data-gjs-type="image" data-gjs-name="image" src="placeholder.jpg" alt="Editable image">
```

### Responsive Design

Make your blocks responsive:

```css
.feature-card {
    /* Mobile first */
    padding: 1rem;
    margin-bottom: 1rem;
}

/* Tablet */
@media (min-width: 768px) {
    .feature-card {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
}

/* Desktop */
@media (min-width: 1024px) {
    .feature-card {
        padding: 2rem;
        margin-bottom: 2rem;
    }
}
```

### Dynamic Content

Use JavaScript to make content dynamic:

```javascript
// Example: Dynamic pricing display
function updatePricing() {
    const priceElements = document.querySelectorAll('.price');
    const currency = 'USD'; // Could be dynamic
    
    priceElements.forEach(element => {
        const basePrice = element.dataset.price;
        const formattedPrice = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: currency
        }).format(basePrice);
        
        element.textContent = formattedPrice;
    });
}

// Call on page load
document.addEventListener('DOMContentLoaded', updatePricing);
```

## 📱 Mobile Considerations

### Touch-Friendly Design

```css
/* Ensure touch targets are large enough */
.feature-card button {
    min-height: 44px; /* iOS minimum touch target */
    min-width: 44px;
    padding: 12px 20px;
}

/* Add touch feedback */
.feature-card button:active {
    transform: scale(0.98);
}
```

### Performance Optimization

```javascript
// Lazy load images
const images = document.querySelectorAll('img[data-src]');
const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.classList.remove('lazy');
            imageObserver.unobserve(img);
        }
    });
});

images.forEach(img => imageObserver.observe(img));
```

## 🎯 Best Practices

### Design Principles

1. **Consistency**: Use consistent spacing, colors, and typography
2. **Accessibility**: Include proper ARIA labels and keyboard navigation
3. **Performance**: Keep blocks lightweight and optimized
4. **Reusability**: Design blocks to work in different contexts

### Code Quality

1. **Semantic HTML**: Use proper HTML structure
2. **Clean CSS**: Organize styles logically
3. **Modular JavaScript**: Keep functions focused and reusable
4. **Error Handling**: Include fallbacks and error states

### User Experience

1. **Loading States**: Show loading indicators for dynamic content
2. **Error States**: Handle errors gracefully
3. **Feedback**: Provide visual feedback for interactions
4. **Progressive Enhancement**: Work without JavaScript

## 🔍 Troubleshooting

### Common Issues

#### Block Not Appearing
1. **Check Active Status**: Ensure block is marked as active
2. **Clear Cache**: `php artisan cache:clear`
3. **Check Category**: Verify block is in correct category
4. **Preview Block**: Test in preview mode

#### Styling Issues
1. **CSS Conflicts**: Check for conflicting styles
2. **Specificity**: Use more specific selectors if needed
3. **Responsive Issues**: Test on different screen sizes
4. **Browser Compatibility**: Test in different browsers

#### JavaScript Errors
1. **Console Errors**: Check browser console for errors
2. **Event Listeners**: Ensure proper event handling
3. **DOM Ready**: Wait for DOM to be ready
4. **Scope Issues**: Check variable scope and naming

### Debug Mode

Enable debug mode to see more information:

```javascript
// Add debug logging
const DEBUG = true;

if (DEBUG) {
    console.log('Custom block loaded:', blockName);
    console.log('Block elements:', document.querySelectorAll('.feature-card'));
}
```

## 📚 Examples

### Simple Card Block

```html
<!-- HTML -->
<div class="simple-card">
    <img data-gjs-type="image" data-gjs-name="image" src="placeholder.jpg" alt="Card image">
    <div class="content">
        <h3 data-gjs-type="text" data-gjs-name="title">Card Title</h3>
        <p data-gjs-type="text" data-gjs-name="description">Card description</p>
    </div>
</div>
```

```css
/* CSS */
.simple-card {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}

.simple-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.simple-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.simple-card .content {
    padding: 1rem;
}

.simple-card h3 {
    margin: 0 0 0.5rem 0;
    color: #2d3748;
}

.simple-card p {
    margin: 0;
    color: #718096;
    line-height: 1.5;
}
```

### Interactive Button Block

```html
<!-- HTML -->
<button class="interactive-button" data-gjs-type="text" data-gjs-name="button-text">
    Click Me
</button>
```

```css
/* CSS */
.interactive-button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.interactive-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.interactive-button:active {
    transform: translateY(0);
}

.interactive-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.interactive-button:hover::before {
    left: 100%;
}
```

```javascript
// JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.interactive-button');
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Add your custom functionality here
            console.log('Button clicked:', this.textContent);
        });
    });
});
```

## 📚 Related Documentation

- [Block System](../blocks/overview.md) - Understanding the block system
- [Admin Panel](../admin-panel/overview.md) - Admin interface guide
- [GrapesJS Integration](../grapesjs/overview.md) - Visual editor integration
- [API Reference](../api/overview.md) - Service classes and methods

---

**Custom Blocks give you the power to create reusable, interactive components that enhance your LaraGrape website! 🧩**

With the visual block builder, you can create professional components without writing complex code, while still having full control over HTML, CSS, and JavaScript when needed. 