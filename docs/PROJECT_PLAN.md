# Altitude Blocks - Project Plan

## Overview

This document outlines the implementation plan for bringing Shadcn's design system to the Greenshift/GreenLight WordPress ecosystem.

---

## Phase 1: Foundation Setup

### 1.1 Rename Plugin and Update Identifiers

**Tasks:**
- [x] Rename plugin from "GreenLight Boilerplate Addon" to "Altitude Blocks"
- [x] Update text domain from `greenlightaddon` to `altitude-blocks`
- [x] Update block category slug to `altitude-blocks`
- [x] Update all PHP function prefixes from `gspb_greenLightAddon_` to `altitude_blocks_`
- [x] Update JavaScript namespace
- [x] Update package.json name and description

**Files modified:**
- `greenlightaddon.php` → deleted, replaced with `altitude-blocks.php`
- `package.json`
- `readme.txt`
- `src/blocks/example/index.js`
- `src/blocks/example/edit.js`
- `src/blocks/example/inspector.js`
- `src/blocks/example/codeinspector.js`
- `src/blocks/example/placeholders.js`
- `blockrender/example/block.json`

### 1.2 Register Shadcn Design Tokens

**Tasks:**
- [x] Create `includes/tokens.php` for design token registration
- [x] Register colors via `greenshift_global_variables` filter
- [x] Register size tokens (radius, spacing)
- [x] Verify tokens appear in Greenshift color/variable pickers (fixed: use HEX for variable_value)

**Design Tokens to Register:**
```php
// Colors
--background, --foreground
--primary, --primary-foreground
--secondary, --secondary-foreground
--destructive, --destructive-foreground
--muted, --muted-foreground
--accent, --accent-foreground
--border, --ring

// Sizes
--radius
```

**Filter Format:**
```php
add_filter('greenshift_global_variables', 'altitude_register_shadcn_tokens');
function altitude_register_shadcn_tokens($variables) {
    $variables[] = [
        'label' => 'Primary',
        'value' => 'var(--primary)',
        'variable' => '--primary',
        'variable_value' => '#171717', // Use HEX for picker preview
        'group' => 'color'
    ];
    // ... more tokens
    return $variables;
}
```

### 1.3 Register Button Preset Classes

**Tasks:**
- [x] Create `includes/presets/button.php`
- [x] Register base button class via `greenshift_preset_classes` filter
- [x] Register 6 variant classes
- [x] Register 4 size classes
- [x] Include focus-visible ring styles for accessibility
- [x] Ensure CSS loads on frontend (created `assets/css/button.css` with conditional enqueue)

**Preset Classes:**
```php
// Base
.shadcn-btn { /* base styles */ }

// Variants
.shadcn-btn-default
.shadcn-btn-destructive
.shadcn-btn-outline
.shadcn-btn-secondary
.shadcn-btn-ghost
.shadcn-btn-link

// Sizes
.shadcn-btn-default-size
.shadcn-btn-sm
.shadcn-btn-lg
.shadcn-btn-icon
```

---

## Phase 2: Button Block Implementation

### 2.1 Create Block Structure

**Tasks:**
- [x] Create `src/blocks/button/` directory
- [x] Create `blockrender/button/` directory
- [x] Import button block in `src/index.js`
- [x] Require server-side file in main PHP

**Files to create:**
```
src/blocks/button/
├── index.js
├── edit.js
├── save.js
├── inspector.js
├── attributes.js
├── icon.js
└── styles.editor.scss

blockrender/button/
├── block.json
└── block.php
```

### 2.2 Define Block Attributes

**Tasks:**
- [x] Create attributes.js with block schema
- [x] Include standard Greenshift attributes (id, localId, styleAttributes, animation)
- [x] Add button-specific attributes

**Button Attributes:**
```javascript
{
    // Standard Greenshift
    id: { type: 'string', default: null },
    localId: { type: 'string' },
    styleAttributes: { type: 'object' },
    animation: { type: 'object', default: collectionsObjects.animation },

    // Button specific
    text: { type: 'string', default: 'Button' },
    variant: { type: 'string', default: 'default' },
    size: { type: 'string', default: 'default' },
    href: { type: 'string', default: '' },
    target: { type: 'string', default: '_self' },
    disabled: { type: 'boolean', default: false },
    fullWidth: { type: 'boolean', default: false }
}
```

### 2.3 Implement Editor Component

**Tasks:**
- [x] Implement edit.js following scaffold pattern
- [x] Use `gspb_setBlockId` for ID generation
- [x] Generate CSS using gspblib utilities
- [x] Render button preview with RichText
- [x] Support variant/size switching in editor

**Edit Component Structure:**
```javascript
export default function edit(props) {
    // 1. ID Generation
    useEffect(() => { gspb_setBlockId(props, 2); }, []);

    // 2. CSS Generation
    let final_css = generateButtonCSS(props);
    gspb_Css_Final(id, final_css, props);

    // 3. Block Props
    const blockProps = useBlockProps({...});

    // 4. Render
    return (
        <>
            <Inspector {...props} />
            <BlockToolBar {...props} />
            <ElementTag {...blockProps}>
                <RichText ... />
            </ElementTag>
            <style>{editor_css}</style>
        </>
    );
}
```

### 2.4 Implement Inspector Controls

**Tasks:**
- [x] Create inspector.js with settings panels
- [x] Add Button Settings panel (variant, size, text)
- [x] Add Link Settings panel (URL, target)
- [x] Add Local Styles panel with AttributeTabs
- [x] Add Animation panel

**Panel Structure:**
```javascript
<InspectorControls>
    <PanelBody title="Button Settings">
        <SelectControl label="Variant" options={variants} />
        <SelectControl label="Size" options={sizes} />
        <ToggleControl label="Full Width" />
    </PanelBody>

    <PanelBody title="Link Settings">
        <TextControl label="URL" />
        <ToggleControl label="Open in new tab" />
    </PanelBody>

    <PanelBody title="Local Styles">
        <AttributeTabs includes={['color', 'spacing', 'border']} />
    </PanelBody>

    <PanelBody title="Animation">
        <Animation attributeName="animation" {...props} />
    </PanelBody>
</InspectorControls>
```

### 2.5 Implement Save Component

**Tasks:**
- [x] Create minimal save.js
- [x] Output clean semantic HTML
- [x] Include animation props
- [x] Handle localId for styling

### 2.6 Implement Server-Side Rendering

**Tasks:**
- [x] Create block.json with proper metadata
- [x] Create block.php with ButtonBlock class
- [x] Handle dynamic link rendering
- [x] Output semantic `<a>` or `<button>` based on href
- [x] Apply variant and size classes

**Render Output:**
```php
// With link
<a href="..." class="shadcn-btn shadcn-btn-default shadcn-btn-md" id="...">Text</a>

// Without link
<button class="shadcn-btn shadcn-btn-default shadcn-btn-md" id="...">Text</button>
```

---

## Phase 3: Testing & Documentation

### 3.1 Testing

**Tasks:**
- [x] Test plugin activation/deactivation
- [x] Verify dependency check works (requires Greenshift)
- [x] Test token registration in Greenshift variable picker
- [x] Test preset class registration
- [x] Test button block in editor
- [ ] Test all variant/size combinations
- [ ] Test link functionality
- [ ] Test responsive behavior
- [ ] Test animation integration
- [ ] Verify frontend rendering matches editor
- [ ] Test accessibility (focus-visible, keyboard navigation)

### 3.2 Documentation

**Tasks:**
- [ ] Update README.md with installation instructions
- [ ] Document how to use the button block
- [ ] Document how to customize tokens for themes
- [ ] Add screenshots/examples

---

## Phase 4: Future Components

### Planned Components (Priority Order)

1. **Card** - Container component
2. **Badge** - Status indicators
3. **Alert** - Notification messages
4. **Input** - Form input field
5. **Textarea** - Multi-line input
6. **Select** - Dropdown selection
7. **Checkbox** - Toggle option
8. **Switch** - Toggle control
9. **Accordion** - Collapsible content
10. **Tabs** - Tabbed content
11. **Dialog/Modal** - Overlay content
12. **Tooltip** - Hover hints
13. **Dropdown Menu** - Action menus
14. **Avatar** - User images

### Component Template

For each new component, follow the same structure:

1. Create `includes/presets/[component].php` for preset classes
2. Create `src/blocks/[component]/` with standard files
3. Create `blockrender/[component]/` for server-side
4. Update imports in `src/index.js`
5. Update requires in main PHP
6. Test and document

---

## Session Tracking

Use this section to track progress across sessions.

### Current Session Goals
- [x] Fix color tokens appearing in picker (HEX format fix)
- [x] Create button block (Phase 2 complete)
- [x] Fix frontend CSS loading for preset classes

### Blockers/Questions
- None currently

### Notes
- Color picker requires HEX format for `variable_value` to display preview swatches
- OKLCH values work in CSS output but not in picker preview
- Button styles now load via dedicated `assets/css/button.css` file
- CSS is conditionally enqueued when button block is used on a page

---

## File Checklist

### Core Files
- [x] `CLAUDE.md` - Project reference
- [x] `docs/PROJECT_PLAN.md` - This file
- [x] `includes/tokens.php` - Design token registration
- [x] `includes/presets/button.php` - Button preset classes

### Button Block Files
- [x] `src/blocks/button/index.js`
- [x] `src/blocks/button/edit.js`
- [x] `src/blocks/button/save.js`
- [x] `src/blocks/button/inspector.js`
- [x] `src/blocks/button/attributes.js`
- [x] `src/blocks/button/icon.js`
- [ ] `src/blocks/button/styles.editor.scss` (optional)
- [x] `blockrender/button/block.json`
- [x] `blockrender/button/block.php`
