# Context

I'm building a custom WordPress block library for my agency that brings Shadcn's design system to the Greenshift/GreenLight ecosystem. We want to use Shadcn's design tokens and component styles without Tailwind compilation—instead leveraging GreenLight's class registration system. This repo is forked and cloned copy of the Greenligh Addon Scaffold mentioned below. The goal is to read these instructions, decide which subagents should be created to effectively analyze the referenced repos and documentation, create the subagents to do so, and create a project plan with Claude.md file and instructions to track the list of todo's and project progress during each session.

**Key architectural decisions already made:**
- Using GreenLight's class-first approach (1 block = 1 HTML tag, clean output)
- Registering Shadcn design tokens via `greenshift_global_variables` PHP filter
- Registering component classes via `greenshift_preset_classes` PHP filter
- **Using the official greenlightaddon repo as the scaffold** (not building from scratch)
- Server-side rendering with `CSSRender: 1` for performance

## Helpful documentation
These docs will provide additional context for the project. If additional documentation is required, use the Context7 MCP server by adding "use context7" to the end of the agents system prompt.

1. **GreenLight Add Blocks Programmatically**:
https://greenshiftwp.com/adding-blocks-programatically-in-greenshift/

2. **Register Custom CSS Framework**:
https://greenshiftwp.com/documentation/for-developers/how-to-register-own-css-framework-or-enable-core-framework-addon-with-greenshift/

## Required Repositories to Analyze

Before generating any code, fetch and analyze these repositories to understand Greenshift's addon architecture:

1. **GreenLight Addon Scaffold** (PRIMARY - use this as your starting point):
   https://github.com/wpsoul/greenlightaddon
   
2. **React Rooter** (understand how React integration works):
   https://github.com/wpsoul/react-rooter
   
3. **Greenshift AI Lab** (reference for instruction patterns, secondary):
   https://github.com/wpsoul/greenshift-ai-lab

**Critical:** Base the plugin structure, block registration patterns, build configuration, and file organization on what you find in the greenlightaddon repo. Don't invent new patterns—adapt theirs.

## What I Need

Create a complete WordPress plugin that:

1. **Follows the greenlightaddon scaffold structure** exactly
2. **Registers Shadcn design tokens** as Greenshift global variables (colors, radius, ring)
3. **Registers button preset classes** for all variants and sizes
4. **Creates a custom "Shadcn Button" block** with editor controls matching the Shadcn React component's props

### Shadcn Button Component Reference

The Shadcn button has these configurable options:

**Variants (6):**
- `default` - Primary background, primary-foreground text
- `destructive` - Destructive background, destructive-foreground text  
- `outline` - Border only, background on hover
- `secondary` - Secondary background, secondary-foreground text
- `ghost` - Transparent, background on hover
- `link` - Text only with underline on hover

**Sizes (4):**
- `default` - h-9 px-4 py-2
- `sm` - h-8 px-3 text-xs
- `lg` - h-10 px-6
- `icon` - h-9 w-9 (square)

**Additional props to support:**
- `disabled` - Should add disabled state styling
- Link URL and target (open in new tab)
- Button text content

### Shadcn CSS Variables to Register

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

### Plugin Structure

**Follow the greenlightaddon repo structure.** After analyzing it, adapt it to include:

- Main plugin PHP file with Greenshift dependency check
- Token registration (via `greenshift_global_variables` filter)
- Preset class registration (via `greenshift_preset_classes` filter)
- Button block following their block registration patterns
- Build configuration matching their setup
- Any react-rooter integration patterns they use

### Editor UI Requirements

The block's sidebar (InspectorControls) should have:

1. **Button Settings Panel**
   - Variant dropdown (6 options)
   - Size dropdown (4 options)
   - Button text input

2. **Link Settings Panel**  
   - URL input
   - "Open in new tab" toggle

3. **Style integration** with Greenshift's existing styleAttributes system if the addon repo demonstrates this

### Technical Requirements

1. **PHP filters must use correct Greenshift format:**
```php
// Variables
['label' => 'Name', 'value' => 'var(--name)', 'variable' => '--name', 'variable_value' => 'actual', 'group' => 'color|size']

// Preset classes  
['value' => 'classname', 'label' => 'Display Name', 'type' => 'preset', 'css' => '.classname{styles}']
```

2. **Block must generate unique IDs** - follow whatever ID pattern the greenlightaddon uses

3. **Server-side render** should output clean semantic HTML:
```html
<a href="url" class="shadcn-btn shadcn-btn-default shadcn-btn-md" id="[generated-id]">
  Button Text
</a>
<!-- or <button> if no link -->
```

4. **CSS should use Shadcn variables** (var(--primary), var(--radius), etc.)

5. **Include focus-visible ring styles** for accessibility

## Deliverables

Please provide:

1. **Analysis summary** of the greenlightaddon repo structure - explain what you found and how it informs the plugin architecture

2. **User documentation** (README.md) explaining:
   - Installation steps
   - How to use the button block
   - How to customize tokens for different themes
   - How this extends the base greenlightaddon pattern

3. **Complete plugin code** for all files, following the greenlightaddon structure with clear comments explaining:
   - Which patterns came from the addon repo
   - Greenshift-specific conventions being used
   - Where Shadcn-specific customizations were made

4. **Claude prompt/skill file** I can save for future component development (Accordion, Tabs, Card, etc.) that:
   - References the same repos
   - Follows the established patterns
   - Can be used to generate additional Shadcn components consistently

Start by fetching and analyzing the three GitHub repos, then provide the analysis summary, documentation, code, and skill prompt in that order.
