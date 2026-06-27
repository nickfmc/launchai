# WordPress Block Pattern Authoring Guide

> This document captures everything learned building the MPSF homepage patterns.
> Follow these rules on every project using **GenerateBlocks Pro v2 (Blocks 2.0)** + a classic/hybrid WordPress theme.

---

## 1. How WordPress Discovers Patterns

Any `.php` file placed in `{theme}/patterns/` is **auto-registered** by WordPress 6.0+.  
No call to `register_block_pattern()` is needed — the file header is enough.

### Required file header

```php
<?php
/**
 * Title: Section — Hero
 * Slug: mytheme/section-hero
 * Categories: featured, text
 * Description: One-line description of what this pattern does.
 */
?>
<!-- block markup starts here -->
```

**Rules:**
- `Title` — shown in the block inserter. Use `Section — Name` convention.
- `Slug` — must be globally unique. Use `{theme-slug}/{pattern-name}` format. Hyphens only, no spaces.
- `Categories` — comma-separated. Built-ins: `featured`, `text`, `columns`, `header`, `footer`, `buttons`. You can also use a custom category registered in `functions.php`.
- No PHP code after `?>` — the pattern content is pure HTML block markup.

### Custom category registration (functions.php)

```php
function mytheme_register_pattern_category() {
    register_block_pattern_category(
        'mytheme',
        array( 'label' => __( 'My Theme', 'mytheme' ) )
    );
}
add_action( 'init', 'mytheme_register_pattern_category' );
```

### Troubleshooting: patterns not appearing

1. Hard-reload the WordPress admin (`Ctrl+Shift+R`) — the block editor caches patterns in the browser session.
2. Navigate to **Appearance → Editor → Patterns** (not the page editor) for a definitive test.
3. Run `php -l patterns/your-file.php` to check for PHP syntax errors.
4. Confirm the file header has a `Title:` and `Slug:` field — WordPress silently skips files missing either.

---

## 2. GenerateBlocks Pro v2 — Block Structure

GB Pro v2 uses a single block type for all containers: `generateblocks/element`.  
A heading/text element uses: `generateblocks/text`.

### The Two-Shell Row Pattern

Every horizontal section on the page uses this structure:

```
[outer: full-width wrapper]     ← background colour, vertical padding live here
  [inner: max-width container]  ← centres content to --gb-container-width
    [content]                   ← headings, paragraphs, grids, etc.
```

#### Outer wrapper block

```html
<!-- wp:generateblocks/element {"uniqueId":"XXXXXXXX","tagName":"div","align":"full","className":"alignfull pat-section-name"} -->
<div class="alignfull pat-section-name">
  [inner container]
</div>
<!-- /wp:generateblocks/element -->
```

- `"align":"full"` makes the block full-width in the editor.
- `"className":"alignfull"` applies the CSS class that removes the max-width constraint.
- When you add styles (background, padding), append `gb-element-{uniqueId}` to the HTML class list.

#### Inner container block (max-width centering)

```html
<!-- wp:generateblocks/element {"uniqueId":"YYYYYYYY","tagName":"div","className":"pat-section-name__inner","styles":{"maxWidth":"var(--gb-container-width)","marginLeft":"auto","marginRight":"auto"},"css":".gb-element-YYYYYYYY{margin-left:auto;margin-right:auto;max-width:var(--gb-container-width))"} -->
<div class="pat-section-name__inner gb-element-YYYYYYYY">
  [content]
</div>
<!-- /wp:generateblocks/element -->
```

- `--gb-container-width` is set globally in GenerateBlocks plugin settings (typically 1240px).
- The inner container handles **horizontal** centering only. Vertical padding goes on the outer wrapper.

---

## 3. The `styles` and `css` Attributes

GB Pro v2 stores layout CSS in two parallel attributes:

| Attribute | Purpose |
|-----------|---------|
| `styles` | JSON object GB uses internally (camelCase property names) |
| `css` | Rendered CSS string (kebab-case, alphabetically ordered properties) |

**They must stay in sync.** If you add a property to `styles`, add it to `css` too.

### CSS string rules

- Properties are **alphabetically ordered**.
- No spaces inside values: `repeat(2,minmax(0,1fr))` not `repeat(2, minmax(0, 1fr))`.
- Media queries appended at the end: `@media (max-width:767px){.gb-element-ID{...}}`.
- The CSS class selector is always `.gb-element-{uniqueId}`.

### Example — outer wrapper with background and padding

```json
"styles": {
  "backgroundColor": "#8c3641",
  "paddingTop": "120px",
  "paddingBottom": "60px"
}
"css": ".gb-element-XXXXXXXX{background-color:#8c3641;padding-bottom:60px;padding-top:120px}"
```

HTML output: `<div class="alignfull pat-section-name gb-element-XXXXXXXX">`

### Example — CSS grid (2 columns, responsive)

```json
"styles": {
  "display": "grid",
  "gridTemplateColumns": "1fr 344px",
  "columnGap": "54px",
  "rowGap": "2em",
  "alignItems": "end",
  "@media (max-width:767px)": {
    "gridTemplateColumns": "1fr"
  }
}
"css": ".gb-element-XXXXXXXX{align-items:end;column-gap:54px;display:grid;grid-template-columns:1fr 344px;row-gap:2em}@media (max-width:767px){.gb-element-XXXXXXXX{grid-template-columns:1fr}}"
```

### When the CSS class appears on the HTML element

| Has `css` attribute? | Has `className`? | HTML output |
|---|---|---|
| No | No | `<div>` |
| No | Yes (`alignfull`) | `<div class="alignfull">` |
| Yes | No | `<div class="gb-element-ID">` |
| Yes | Yes (`alignfull pat-hero`) | `<div class="alignfull pat-hero gb-element-ID">` |

---

## 4. The `uniqueId` Field

- Every `generateblocks/element` and `generateblocks/text` block requires a **unique 8-character hexadecimal ID**.
- Valid characters: `0–9`, `a–f`.
- IDs must be unique **across all pattern files** to prevent CSS class collisions.

### Recommended ID scheme

Use a per-pattern prefix to guarantee uniqueness at a glance:

```
a0100001  ← pattern 01 (hero), block 001
a0100002  ← pattern 01 (hero), block 002
a0200001  ← pattern 02 (quote), block 001
```

Or generate random 8-char hex (e.g. `f3a8c120`) — just keep a project-level log to avoid duplicates.

### IDs to avoid

Never reuse the IDs from the user's own editor content. If the user pastes their GB markup as a template, use different IDs in the pattern files.

---

## 5. Common Layout Patterns

### Single column (no grid)

```html
<!-- wp:generateblocks/element {outer} -->
<div class="alignfull pat-section gb-element-outer">
  <!-- wp:generateblocks/element {inner: max-width} -->
  <div class="pat-section__inner gb-element-inner">
    <!-- wp:heading ... -->
    <!-- wp:paragraph ... -->
    <!-- wp:buttons ... -->
  </div>
  <!-- /wp:generateblocks/element -->
</div>
<!-- /wp:generateblocks/element -->
```

### Two columns — image left, text right

```
gridTemplateColumns: "1fr 344px"
```

### Two columns — text left, image right

```
gridTemplateColumns: "344px 1fr"
```

### Three columns (equal)

```
gridTemplateColumns: "repeat(3, minmax(0, 1fr))"
```

### Flex column with gap (for stacked content with controlled spacing)

```json
"styles": {"display":"flex","flexDirection":"column","gap":"40px"}
"css": ".gb-element-ID{display:flex;flex-direction:column;gap:40px}"
```

### CTA card (dark background, rounded, flex row)

```json
"styles": {
  "backgroundColor": "#8c3641",
  "borderRadius": "8px",
  "display": "flex",
  "justifyContent": "space-between",
  "alignItems": "flex-end",
  "paddingTop": "48px",
  "paddingBottom": "48px",
  "paddingLeft": "56px",
  "paddingRight": "56px"
}
```

---

## 6. QA Classes — the `pat-` Prefix

Every `generateblocks/element` block must carry a `pat-` prefixed `className`. This makes elements selectable in DevTools, browser automation, and QA scripts without relying on generated `gb-element-{id}` hashes.

### Naming convention (BEM-style)

```
pat-{section}               ← outer wrapper
pat-{section}__inner        ← max-width container
pat-{section}__grid         ← CSS grid wrapper
pat-{section}__col-image    ← image column
pat-{section}__col-text     ← text column
pat-{section}__card         ← repeating card item
pat-{section}__stat         ← stat item
pat-{section}__stat-line    ← decorative accent line
```

### How to add to the block attribute

```json
{"uniqueId":"a0100001","tagName":"div","align":"full","className":"alignfull pat-hero","styles":{...},"css":"..."}
```

HTML: `<div class="alignfull pat-hero gb-element-a0100001">`

For elements with **no styles** (plain structural divs):

```json
{"uniqueId":"a0300004","tagName":"div","className":"pat-who-we-are__col-image"}
```

HTML: `<div class="pat-who-we-are__col-image">`

**The `pat-` prefix guarantees no collision** with WP core classes (`wp-block-*`), GB classes (`gb-element-*`), or theme utility classes.

---

## 7. Core WordPress Blocks Inside GB Elements

Content inside `generateblocks/element` containers uses standard core WP blocks. No special treatment required.

### Heading with custom colour and size

```html
<!-- wp:heading {"level":2,"style":{"typography":{"fontSize":"60px","lineHeight":"1.3"},"color":{"text":"#fffef7"}}} -->
<h2 class="wp-block-heading has-text-color" style="color:#fffef7;font-size:60px;line-height:1.3">Section Title</h2>
<!-- /wp:heading -->
```

### Paragraph with colour

```html
<!-- wp:paragraph {"style":{"color":{"text":"#fffef7"},"typography":{"fontSize":"16px","lineHeight":"1.5"}}} -->
<p class="has-text-color" style="color:#fffef7;font-size:16px;line-height:1.5">Body text here.</p>
<!-- /wp:paragraph -->
```

### Filled button (primary)

```html
<!-- wp:button {"style":{"color":{"background":"#8c3641","text":"#ffffff"},"border":{"radius":"5px"},"spacing":{"padding":{"top":"14px","bottom":"14px","left":"20px","right":"20px"}},"typography":{"fontSize":"16px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" style="background-color:#8c3641;border-radius:5px;color:#ffffff;font-size:16px;padding-bottom:14px;padding-left:20px;padding-right:20px;padding-top:14px">Button Label</a></div>
<!-- /wp:button -->
```

### Inline text link (underline style)

Used for subtle "Learn More →" style links in body copy — add `is-style-text-link` class and let the theme CSS handle the decorative underline.

```html
<!-- wp:paragraph {"className":"is-style-text-link","style":{"color":{"text":"#fffef7"},"typography":{"fontSize":"16px","fontWeight":"500"}}} -->
<p class="has-text-color is-style-text-link" style="color:#fffef7;font-size:16px;font-weight:500"><a href="#" style="color:inherit">Link Label</a></p>
<!-- /wp:paragraph -->
```

### Image with rounded corners

```html
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":"8px"}}} -->
<figure class="wp-block-image size-large" style="border-radius:8px"><img src="" alt="Describe the image"/></figure>
<!-- /wp:image -->
```

### `generateblocks/text` (heading inside a GB element)

Used when GB needs to own the element (e.g. for GB-level styling on the text node itself):

```html
<!-- wp:generateblocks/text {"uniqueId":"XXXXXXXX","tagName":"h2"} -->
<h2 class="gb-text">Heading Text</h2>
<!-- /wp:generateblocks/text -->
```

---

## 8. Getting Layout from Figma

Use the **Figma Dev Mode MCP** to pull exact values before writing patterns.

### Workflow

1. Select the frame or section in Figma.
2. Call `get_screenshot` for a visual reference.
3. Call `get_metadata` on the frame to get the layer tree and node IDs.
4. Call `get_design_context` on each key section node ID.
5. Read the generated React/Tailwind output and **convert** to WP block markup:
   - Tailwind `bg-[#8c3641]` → `backgroundColor: "#8c3641"` in GB `styles`
   - Tailwind `gap-[54px]` → `columnGap: "54px"`
   - Tailwind `rounded-[8px]` → `border-radius:8px` on core image/group
   - Tailwind `text-[60px]` → `fontSize: "60px"` in WP heading style
   - Tailwind `font-['Playfair_Display']` → set font via theme.json or inline (font-family not needed if theme handles it via `--wp--preset--font-family--*`)

### Key things to extract from Figma

| Figma value | Where it goes in the pattern |
|---|---|
| Frame padding (`px-[205px]`, `py-[120px]`) | `paddingTop/Bottom` on outer wrapper |
| Gap between sections (`gap-[88px]`) | `gap` on inner flex container |
| Column gap (`gap-[54px]`) | `columnGap` on grid element |
| Fixed column width (`w-[344px]`) | `gridTemplateColumns: "344px 1fr"` |
| Background colour (`bg-[#8c3641]`) | `backgroundColor` on outer wrapper |
| Border radius (`rounded-[8px]`) | `borderRadius` on card/image element |
| Text colour (`text-[#fffef7]`) | `color.text` in WP block style |
| Font size (`text-[60px]`) | `typography.fontSize` in WP block style |
| Line height (`leading-[1.3]`) | `typography.lineHeight` in WP block style |

---

## 9. Design Token Reference (MPSF)

| Token | Value | Usage |
|---|---|---|
| Bordeaux | `#59262c` | Body text on light backgrounds |
| Burnt-Rose | `#8c3641` | Dark section backgrounds, primary button |
| Wine | `#722f37` | Stat numbers and accent lines |
| Coral | `#d56e68` | Secondary/CTA button, card button |
| Ivory | `#fffef7` | Text on dark backgrounds |
| Pure-White | `#ffffff` | Button text |
| Display (H0) | Playfair Display Regular, 72px, lh 1.1 | Hero headline |
| H1 | Playfair Display Regular, 60px, lh 1.3 | Section heading on dark bg |
| H2 | Playfair Display Regular, 48px, lh 1.2 | CTA / quote heading |
| Body Large | DM Sans Regular, 18px, lh 1.4, ls 0.18px | Hero sub-text, CTA body |
| Body | DM Sans Regular, 16px, lh 1.5, ls 0.16px | Section body copy |
| Body Light | DM Sans Light 300, 18px | Attribution / captions |
| Body Medium | DM Sans Medium 500, 16px | Inline text links, button labels |

---

## 10. Full Minimal Pattern Template

Copy this as the starting point for any new section pattern:

```php
<?php
/**
 * Title: Section — Name Here
 * Slug: mytheme/section-name-here
 * Categories: featured, text
 * Description: Brief description of this section.
 */
?>
<!-- wp:generateblocks/element {"uniqueId":"XXXXXXXX","tagName":"div","align":"full","className":"alignfull pat-name-here","styles":{"paddingTop":"60px","paddingBottom":"60px"},"css":".gb-element-XXXXXXXX{padding-bottom:60px;padding-top:60px}"} -->
<div class="alignfull pat-name-here gb-element-XXXXXXXX"><!-- wp:generateblocks/element {"uniqueId":"YYYYYYYY","tagName":"div","className":"pat-name-here__inner","styles":{"marginLeft":"auto","marginRight":"auto","maxWidth":"var(--gb-container-width)"},"css":".gb-element-YYYYYYYY{margin-left:auto;margin-right:auto;max-width:var(--gb-container-width))"} -->
<div class="pat-name-here__inner gb-element-YYYYYYYY">

  <!-- content goes here -->

</div>
<!-- /wp:generateblocks/element --></div>
<!-- /wp:generateblocks/element -->
```

**Checklist before saving:**
- [ ] File header has `Title:`, `Slug:`, `Categories:`, `Description:`
- [ ] Slug follows `{theme-slug}/{pattern-name}` and is unique across all patterns
- [ ] Every `generateblocks/element` has a unique 8-char hex `uniqueId`
- [ ] Every `generateblocks/element` has a `className` with a `pat-` prefixed class
- [ ] `styles` and `css` attributes are in sync
- [ ] CSS properties in `css` string are alphabetically ordered
- [ ] `gb-element-{uniqueId}` class appears in the HTML element (only when `css` attribute is present)
- [ ] `alignfull` class is on the outer wrapper HTML element (only when `align:"full"` is set)
- [ ] All images have meaningful `alt` text placeholders
- [ ] Button links have `href="#"` as placeholder
- [ ] Run `php -l patterns/your-file.php` — no syntax errors
