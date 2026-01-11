# Altitude Blocks - Shadcn Design System for Greenshift

## Important Rules

1. **Keep PROJECT_PLAN.md in sync**: When completing tasks, always update the checkboxes in `docs/PROJECT_PLAN.md` to track progress between sessions and apps. This ensures continuity across different AI assistants and coding sessions.

2. **Use Bun for package management**: This project uses Bun instead of npm. Use `bun install`, `bun start`, `bun run build`, etc.

## Project Overview

A WordPress block library that brings Shadcn's design system to the Greenshift/GreenLight ecosystem. This plugin registers Shadcn design tokens as Greenshift global variables and provides Shadcn-styled blocks using GreenLight's class-first approach.

## Quick Reference

```bash
# Development
bun start          # Start development with hot reload
bun run build      # Production build

# Key directories
src/blocks/        # Block source files
blockrender/       # Server-side PHP rendering
build/             # Compiled output (auto-generated)
```

## Architecture Decisions

### Core Approach
- **GreenLight's class-first approach**: 1 block = 1 HTML tag, clean output
- **Server-side rendering** with `CSSRender: 1` for performance
- **No Tailwind compilation** - leverage GreenLight's class registration system
- **Design tokens via PHP filters** - not JavaScript/CSS imports

### Key PHP Filters Used
1. `greenshift_global_variables` - Register Shadcn CSS custom properties
2. `greenshift_preset_classes` - Register component class presets

### Design Token Format
```php
// Variables (colors, sizes)
['label' => 'Name', 'value' => 'var(--name)', 'variable' => '--name', 'variable_value' => 'oklch(value)', 'group' => 'color']

// Preset classes
['value' => 'classname', 'label' => 'Display Name', 'type' => 'preset', 'css' => '.classname{styles}']
```

## Block Development Pattern

### File Structure (per block)
```
src/blocks/[blockname]/
├── index.js          # Block registration
├── edit.js           # Editor component
├── save.js           # Frontend save (minimal)
├── inspector.js      # InspectorControls
├── attributes.js     # Block attributes schema
├── icon.js           # Block icon SVG
└── styles.editor.scss # Editor-only styles

blockrender/[blockname]/
├── block.json        # Block metadata
└── block.php         # Server-side render callback
```

### Required Attributes (every block)
```javascript
{
    id: { type: 'string', default: null },
    localId: { type: 'string' },
    inlineCssStyles: { type: 'string' },
    styleAttributes: { type: 'object' },
    animation: { type: 'object', default: collectionsObjects.animation }
}
```

### ID Generation Pattern
```javascript
useEffect(() => {
    gspb_setBlockId(props, 2);
}, []);
```

### CSS Generation Pipeline
```javascript
let css_selector = '.' + localId;
let final_css = '';

// 1. Dynamic local classes
final_css = getFinalCssFromDynamicLocalClasses(props, final_css);

// 2. Style attributes (responsive)
final_css = getCssFromStyleAttributes(styleAttributes, css_selector, final_css, enableSpecificity);

// 3. Custom properties (responsive - 4 breakpoints)
final_css = gspb_cssGen(css_selector, ['property'], [[desktop, tablet, mobileL, mobileP]], final_css);

// 4. Non-responsive properties
final_css = gspb_cssGen(css_selector, ['property'], [value], final_css);

// 5. Store for output
gspb_Css_Final(id, final_css, props);
```

## Shadcn Design Tokens

### Colors (OKLCH format)
```css
--background: oklch(1 0 0);
--foreground: oklch(0.145 0 0);
--primary: oklch(0.205 0 0);
--primary-foreground: oklch(0.985 0 0);
--secondary: oklch(0.97 0 0);
--secondary-foreground: oklch(0.205 0 0);
--destructive: oklch(0.577 0.245 27.325);
--destructive-foreground: oklch(0.577 0.245 27.325);
--muted: oklch(0.97 0 0);
--muted-foreground: oklch(0.556 0 0);
--accent: oklch(0.97 0 0);
--accent-foreground: oklch(0.205 0 0);
--border: oklch(0.922 0 0);
--ring: oklch(0.708 0 0);
--radius: 0.625rem;
```

## Button Component Reference

### Variants (6)
| Variant | Description |
|---------|-------------|
| default | Primary background, primary-foreground text |
| destructive | Destructive background, destructive-foreground text |
| outline | Border only, background on hover |
| secondary | Secondary background, secondary-foreground text |
| ghost | Transparent, background on hover |
| link | Text only with underline on hover |

### Sizes (4)
| Size | Dimensions |
|------|------------|
| default | h-9 px-4 py-2 |
| sm | h-8 px-3 text-xs |
| lg | h-10 px-6 |
| icon | h-9 w-9 (square) |

## Greenshift Library (gspblib) Reference

### Utilities
- `gspb_setBlockId(props, prefix)` - Generate unique ID
- `getDataAttributesfromDynamic(props)` - Data attributes from class panel
- `getFinalCssFromDynamicLocalClasses(props, css)` - CSS from global classes
- `getCssFromStyleAttributes(attrs, selector, css, specificity)` - CSS from styleAttributes
- `gspb_Css_Final(id, css, props)` - Store CSS for output

### Helpers
- `gspb_cssGen(selector, properties, values, css)` - Generate responsive CSS
- `gspb_convert_styles_for_editor(css)` - Convert for editor scoping
- `collectionsObjects` - Default attribute objects

### Components
- `BlockToolBar` - Floating toolbar
- `BlpgeColorPicker` - Color picker with presets
- `UnitControl` - Unit control with variables
- `Devices` - Breakpoint selector
- `GlobalClasses` - Global class picker

### Collections
- `AnimationWrapper` - Animation context wrapper
- `AnimationRenderProps` - Animation data attributes
- `AttributeTabs` - Full styling tabs
- `IconPicker` - SVG icon picker

## Dependencies

### Required Plugins
- **Greenshift** or **GreenLight Builder** (parent plugin)

### WordPress Dependencies (editor)
```javascript
['greenShift-editor-js', 'greenShift-library-script', 'wp-block-editor', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-data']
```

## Project Status

### Completed
- [x] Repository analysis (greenlightaddon, react-rooter, greenshift-ai-lab)
- [x] Documentation review
- [x] Project structure setup
- [x] Plugin renamed to Altitude Blocks
- [x] Token registration system (`includes/tokens.php`)
- [x] Button preset classes (`includes/presets/button.php`)

### In Progress
- [ ] Button block implementation

### Planned Components
1. Button (current focus)
2. Card
3. Accordion
4. Tabs
5. Dialog/Modal
6. Input
7. Select
8. Badge
9. Alert

## Resources

### Documentation
- [Adding Blocks Programmatically](https://greenshiftwp.com/adding-blocks-programatically-in-greenshift/)
- [Register Custom CSS Framework](https://greenshiftwp.com/documentation/for-developers/how-to-register-own-css-framework-or-enable-core-framework-addon-with-greenshift/)

### Repositories
- [GreenLight Addon Scaffold](https://github.com/wpsoul/greenlightaddon) - Base structure
- [React Rooter](https://github.com/wpsoul/react-rooter) - React integration
- [Greenshift AI Lab](https://github.com/wpsoul/greenshift-ai-lab) - Advanced patterns

## Development Notes

### Adding a New Block
1. Create directory: `src/blocks/[blockname]/`
2. Create files: index.js, edit.js, save.js, inspector.js, attributes.js, icon.js
3. Create server-side: `blockrender/[blockname]/block.json`, `block.php`
4. Import in `src/index.js`
5. Require in `altitude-blocks.php`

### CSS Class Naming Convention
- Prefix: `shadcn-`
- Component: `shadcn-btn`, `shadcn-card`, etc.
- Variants: `shadcn-btn-default`, `shadcn-btn-destructive`
- Sizes: `shadcn-btn-sm`, `shadcn-btn-lg`

### Server-Side Render Output
```html
<a href="url" class="shadcn-btn shadcn-btn-default shadcn-btn-md" id="[generated-id]">
  Button Text
</a>
<!-- or <button> if no link -->
```

IMPORTANT!!! When completing tasks, always update the checkboxes in `docs/PROJECT_PLAN.md` to track progress between sessions and apps. This ensures continuity across different AI assistants and coding sessions. DO NOT FORGET THIS!!!