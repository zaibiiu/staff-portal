# 📁 CSS File Structure

The CSS has been organized into multiple files for easy maintenance and editing.

## File Organization

```
resources/css/filament/admin/
├── theme.css                    (Main file - imports all partials)
└── partials/
    ├── variables.css           (CSS Custom Properties - Colors, sizes, shadows)
    ├── base.css                (Global resets, body styles, main content)
    ├── sidebar.css             (Sidebar navigation, menu items, icons)
    ├── sidebar-profile.css     (User profile section at top of sidebar)
    ├── sidebar-collapse.css    (Collapse/expand functionality + HIDES PROFILE)
    ├── topbar.css              (Top header, breadcrumbs, user menu button)
    └── buttons.css             (All button styles - primary, danger, etc.)
```

---

## ✅ Key Changes

### 1. **Profile Section HIDDEN When Collapsed**
Location: `partials/sidebar-collapse.css`

```css
/* Hide entire profile section when collapsed */
aside.fi-sidebar[style*="4"] .sidebar-profile-section {
    display: none !important;
    height: 0 !important;
    padding: 0 !important;
    margin: 0 !important;
}
```

This completely removes the profile section when sidebar collapses, allowing the sidebar to properly shrink to 4.5rem width.

### 2. **Top Gap Added to Profile**
Location: `sidebar-user-profile.blade.php`

```html
<div class="sidebar-profile-section" 
     style="padding: 1.5rem 1rem 1.25rem 1rem; ...">
```

Top padding is now **1.5rem** so avatar doesn't touch navbar.

### 3. **Organized CSS Structure**
All CSS is now split into logical sections:
- **Variables**: All colors, sizes, shadows in one place
- **Base**: Global styles
- **Sidebar**: Navigation related
- **Sidebar Profile**: User info section
- **Sidebar Collapse**: Hide/show logic
- **Topbar**: Header and top navigation
- **Buttons**: All button variants

---

## 🎯 How to Edit

### To Change Colors:
**Edit:** `partials/variables.css`
```css
:root {
    --sp-sidebar-bg: #1e2d5a;  /* Change sidebar color here */
    --sp-blue: #3b82f6;         /* Change primary blue */
    --sp-amber: #f59e0b;        /* Change accent orange */
}
```

### To Change Sidebar Spacing:
**Edit:** `partials/sidebar.css`
```css
.fi-sidebar-item-btn {
    padding: 0.65rem 1rem !important;  /* Menu item height */
}

.fi-sidebar-group {
    margin: 0 0 0.3rem 0 !important;  /* Gap between groups */
}
```

### To Change Profile Section:
**Edit:** `partials/sidebar-profile.css`
```css
.fi-sidebar-user {
    padding: 1.5rem 1rem 1.25rem 1rem !important;  /* Profile spacing */
}
```

### To Change Collapse Behavior:
**Edit:** `partials/sidebar-collapse.css`

This file controls what happens when sidebar collapses/expands.

### To Change Buttons:
**Edit:** `partials/buttons.css`

All button styles (primary, danger, success, etc.) are here.

### To Change Top Bar:
**Edit:** `partials/topbar.css`

Header, breadcrumbs, user menu button styles.

---

## 🔨 Build Process

After editing ANY CSS file:

```bash
npm run build
php artisan view:clear
```

Then hard refresh browser: `Ctrl + F5`

---

## 📍 Import Order Matters!

The files are imported in this order in `theme.css`:

1. **variables.css** - Must be first (defines CSS variables)
2. **base.css** - Global styles
3. **sidebar.css** - Sidebar structure
4. **sidebar-profile.css** - Profile section
5. **sidebar-collapse.css** - Collapse behavior (must be after sidebar files)
6. **topbar.css** - Header
7. **buttons.css** - Buttons

Don't change the import order unless you know what you're doing!

---

## 🎨 CSS Variables Available

All these can be used anywhere in your CSS:

### Colors
- `var(--sp-sidebar-bg)` - Sidebar background
- `var(--sp-blue)` - Primary blue
- `var(--sp-amber)` - Orange accent
- `var(--sp-red)` - Danger red
- `var(--sp-green)` - Success green

### Spacing
- `var(--sp-radius)` - Border radius (0.75rem)
- `var(--sp-radius-sm)` - Small radius (0.5rem)
- `var(--sp-radius-lg)` - Large radius (1rem)

### Effects
- `var(--sp-shadow)` - Standard shadow
- `var(--sp-shadow-sm)` - Small shadow
- `var(--sp-shadow-lg)` - Large shadow
- `var(--sp-transition)` - Standard transition timing

---

## 🐛 Troubleshooting

### Sidebar not collapsing?
1. Check `partials/sidebar-collapse.css`
2. Make sure `.sidebar-profile-section` class exists in blade file
3. Check browser console for JavaScript errors
4. Hard refresh: `Ctrl + F5`

### Styles not applying?
1. Run `npm run build`
2. Run `php artisan view:clear`
3. Hard refresh browser
4. Check file imports in `theme.css`

### Can't find a style?
1. Search in `theme.css` - it might still be there (not all styles moved yet)
2. Check the appropriate partial file based on what you're looking for
3. Use browser DevTools to inspect the element

---

## 📝 Next Steps (Optional)

You can create MORE partial files if needed:

- `partials/tables.css` - All table styles
- `partials/forms.css` - All form/input styles
- `partials/modals.css` - Modal/dialog styles
- `partials/badges.css` - Badge/pill styles
- `partials/cards.css` - Card component styles

Just create the file, add styles, then import in `theme.css`!

---

**Last Updated:** August 1, 2026
**Status:** ✅ Organized and Working
