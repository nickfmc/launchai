# Native WordPress Block Authoring Guide

> This document captures the pattern established while building and fixing the
> Accordion Section and Impact Slider blocks. Follow these rules for every
> **native custom block** (`blocks/{name}/`) in this theme — i.e. anything
> registered via `block.json` + `register_block_type()`, as opposed to
> GenerateBlocks patterns (see `PATTERNS.md`).
>
> Use a native block instead of a GB pattern when the section needs: repeatable
> structured content authored by editors (cards, slides, accordion items),
> server-side dynamic data (querying posts), or JS-driven front-end behaviour
> (carousel, toggle, flip).

---

## 1. The Golden Rule: render.php Is the Only Source of Truth

Every block in this theme is a **dynamic block**: PHP (`render.php`) produces
the real front-end markup, and `save()` in JS produces little to nothing.

- `save()` returns `<InnerBlocks.Content />` (parent blocks with children) or
  `null` (leaf blocks with no inner blocks). **Never** hand-write the final
  front-end HTML in `save()`. If `save()` is building `<div>`s with real
  classes and content, you are duplicating render.php and the two will drift.
- `edit()` is a **preview**, not a second implementation. It exists so authors
  can see roughly what they're building and edit text/images/links inline. It
  is allowed to differ from render.php's exact DOM where front-end-only
  behaviour (Swiper, sticky positioning, full-bleed breakout) doesn't apply
  in the constrained editor canvas — but it must not silently render *wrong*
  content (see §5 for the one big exception: dynamic data).

Why: render.php is what visitors see. If business logic, sanitization, or
markup lives in JS `save()` output instead, every existing post's saved HTML
is now frozen and out of sync the moment you change render.php. Dynamic
blocks avoid that entirely — there is nothing saved to drift.

---

## 2. File Anatomy

```
blocks/{block-name}/
  block.json      ← metadata, attributes schema, render path
  index.js         ← registerBlockType(): edit() + save()
  render.php       ← front-end (and editor ServerSideRender, if used) output
```

Plus, for every new block:

- **`webpack.config.js`** — add an entry: `'{block-name}': path.resolve(__dirname, 'blocks/{block-name}/index.js')`. Without this, the editor script never builds.
- **`inc/gdt-gutenberg.php`** — add `register_block_type( get_stylesheet_directory() . '/blocks/{block-name}/block.json' );` inside `launchpad_register_blocks()`. Without this, the block doesn't exist in WordPress at all, even if it builds fine.

Both steps are easy to forget — they are not implied by creating the block
folder. Check both before saying a new block is "done."

---

## 3. block.json Rules

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "mpsf/your-block",
    "title": "Human Title",
    "category": "myblocks",
    "description": "One sentence describing what it does and its structure.",
    "keywords": [ "relevant", "search", "terms" ],
    "supports": { "html": false, "align": [ "full", "wide" ] },
    "attributes": { /* see below */ },
    "textdomain": "mpsf",
    "editorScript": "file:../../build/{block-name}.js",
    "render": "file:./render.php"
}
```

- **Namespace** is always `mpsf/`. **Category** is always `myblocks` (registered in `inc/gdt-gutenberg.php`).
- **`apiVersion: 3`** always — required for `render` to work the way these blocks use it.
- **`supports.html: false`** always, unless the block genuinely needs the "Edit as HTML" escape hatch (it doesn't, for any block here).
- **Child blocks** (e.g. `impact-slide`, `accordion-item`) declare `"parent": [ "mpsf/parent-block" ]` and `"supports": { "inserter": true }` so they can't be added standalone but can still be reordered/duplicated inside the parent.
- **Attribute types must match how they're sanitized in render.php** (see §6). Don't declare `"type": "string"` for something that's really a numeric ID — use `"type": "number"`.
- Array attributes (e.g. `selectedPosts`) declare `"items": { "type": "number" }`.
- Every attribute needs a sensible `"default"` — render.php should never have to guess.

---

## 4. JS `edit()` Rules

- Always destructure `attributes`, `setAttributes`, and (when needed for
  cross-block awareness — see §7) `clientId` from the function signature.
- Use `useBlockProps()` for the root element's props — never build the wrapper
  div by hand.
- Inspector controls (`PanelBody`, `TextControl`, etc.) for: settings that
  aren't part of the main visual flow (CTA URL, content-source toggle, image
  position). Inline `RichText` for: anything that's actually displayed inline
  in the design (titles, body copy) — don't hide visible text behind a
  sidebar field.
- `MediaUpload`/`MediaUploadCheck` is the only accepted way to pick images.
  Always store all three: `imageId` (number, for `wp_get_attachment_image()`),
  `imageUrl` + `imageAlt` (string fallback for cases without an ID, e.g.
  external URLs). render.php should prefer the ID and fall back to the URL.
- Repeatable children → `InnerBlocks` with an explicit `allowedBlocks` array
  and a `TEMPLATE` constant giving sensible starting content. Don't leave an
  empty canvas — give authors 2–3 pre-filled example items to edit/duplicate.
- Don't import anything you don't use (dead imports were left behind by
  copy-pasting between blocks more than once here — clean them up).

---

## 5. Dynamic-Data Blocks: Use `ServerSideRender`, Not a Parallel JS Preview

If a block's content comes from a **query** rather than manual authoring
(e.g. Impact Slider's "Show Posts" mode pulling the latest/selected posts),
do **not** hand-build a second JS preview that reimplements the WP_Query
logic and card markup. It will drift from render.php the first time either
one changes.

Instead:

```jsx
import ServerSideRender from '@wordpress/server-side-render';

isPostsMode ? (
    <div { ...useBlockProps() }>
        <ServerSideRender block={ metadata.name } attributes={ attributes } />
    </div>
) : ( /* manual InnerBlocks editing experience */ )
```

This calls render.php live inside the editor, so the preview is always
pixel-accurate. Don't wrap it in a `blockProps` that re-applies the same
top-level class render.php's wrapper already outputs — you'll double up
backgrounds/padding (see Impact Slider's posts-mode wrapper for the fix).

This only replaces *manual editing* when there's nothing to manually edit
(querying posts has no per-item RichText fields). If the block mixes manual
child blocks with dynamic behaviour, keep `InnerBlocks` for editing and reach
for §7 (live JS preview) instead.

### Gotcha: disable links inside the rendered preview

`render.php` output almost always contains real `<a href="...">` tags (CTAs,
"Read more" links, post permalinks). The modern block editor canvas runs
inside an iframe — a real click on one of those links navigates *that
iframe* to the URL, which looks like the whole post editor just hijacked
itself. `ServerSideRender` does not sanitize this for you.

Fix it with CSS, scoped to a wrapper class you add around the
`<ServerSideRender>` call (never globally on `a`):

```scss
.c-your-block--ssr-preview a {
    pointer-events: none; // no click, and no hover status-bar URL either
}
```

```jsx
<div { ...blockProps } className={ `${ blockProps.className } c-your-block--ssr-preview` }>
    <ServerSideRender block={ metadata.name } attributes={ attributes } />
</div>
```

Add this any time a block's `edit()` renders real front-end HTML — either via
`ServerSideRender` or by echoing render.php-equivalent links directly in JSX.

---

## 6. PHP `render.php` Rules

```php
<?php
/**
 * {Block Title} — front-end render template.
 *
 * Variables available:
 *   $attributes  array     Block attributes
 *   $content     string    Rendered inner blocks (if any)
 *   $block       WP_Block
 */
```

**Sanitize/escape every attribute on the way in, by type:**

| Attribute came from… | Sanitize with |
|---|---|
| `RichText` (allows bold/italic/link) | `wp_kses_post()` |
| `TextControl` / plain text, no markup | `esc_html()` |
| URL (`ctaUrl`, image URL) | `esc_url()` |
| Numeric ID (`imageId`, post ID) | `absint()` or `intval()` |
| Array of IDs (`selectedPosts`) | `array_filter( array_map( 'intval', $attributes['x'] ?? [] ) )` |
| HTML attribute value (`alt` text) | `esc_attr()` |

Never `echo` a raw attribute. Sanitize once, near the top of the file, into a
local `$variable`, then echo the local variable — don't re-sanitize inline at
every echo site (inconsistent escaping is how XSS bugs creep in).

**Output the wrapper with `get_block_wrapper_attributes()`**, not a hand-built
class string, so `align`, `className`, and anchor support keep working:

```php
$wrapper_attrs = get_block_wrapper_attributes( [ 'class' => 'c-your-block' ] );
?>
<div <?php echo $wrapper_attrs; ?>>...</div>
```

**Images** — prefer the attachment ID path so WP can generate responsive
`srcset`s; only fall back to a raw `<img>` tag when there's no ID:

```php
if ( $image_id ) {
    echo wp_get_attachment_image( $image_id, 'large', false, [ 'class' => '...', 'loading' => 'lazy' ] );
} elseif ( $image_url ) {
    printf( '<img class="..." src="%s" alt="%s" loading="lazy">', esc_url( $image_url ), esc_attr( $image_alt ) );
}
```

**Reading child block data from the parent** (e.g. Accordion Section building
its image panel from each `accordion-item` child): use `$block->inner_blocks`
and `$child->attributes` — don't try to re-parse `$content` with regex unless
there's truly no structured-data path (the legacy-content unwrap regex in
Impact Slider's render.php is a one-off migration shim, not something to
copy into new blocks).

### Shared markup → a PHP helper, not copy-paste

When two blocks need to render the *same* sub-markup (e.g. Impact Slider's
posts mode and Impact Slide's manual mode both render a `.swiper-slide` card),
extract a helper function into `inc/gdt-content.php` (or a topically-named
`inc/` file) rather than duplicating the HTML block across two `render.php`
files:

```php
function mpsf_render_impact_slide_markup( $args ) { /* ... */ }
```

**Important:** never define a function directly inside `render.php`. WordPress
`include`s `render.php` every time the block renders — if the same block
appears twice on a page, a function defined in the file fatals on
"cannot redeclare." Helpers belong in `inc/`, which is `require_once`'d a
single time from `functions.php`.

---

## 7. Editor Preview Parity — the part that's easy to get wrong

This was the root cause of every "messy backend preview" bug fixed so far,
so read this section carefully before shipping a new block.

### The trap

`add_editor_style( 'build/editor-styles.css' )` (in `inc/gdt-cleanup.php`)
means **the block editor iframe loads `editor-styles.css` and *only*
`editor-styles.css`** — never `site.css`. If you write
`className="c-your-block"` in `edit()` and the matching CSS only exists in
`src/scss/components/_your-block.scss` (which compiles into `site.css`),
**the editor will render that markup completely unstyled.** This is exactly
what happened to Accordion Section and Impact Slider — the editor JSX was
correct, the front-end partial had real `--editor` rules already written,
and none of it ever loaded in `wp-admin` because nothing imported that
partial into `editor-styles.scss`.

### The rule

> Every class name used in `edit()` must have matching CSS authored directly
> in `src/editor-styles.scss` — not assumed to be inherited from a
> `src/scss/components/_*.scss` front-end partial, even if that partial
> already has rules for the same class names.

### How to structure it

1. **Reuse the real BEM class names** (`c-your-block__title`, not some
   parallel `c-your-block-editor-title`) for anything that looks *identical*
   in both contexts — typography, color, card layout, spacing. This keeps the
   editor and front end conceptually in sync and avoids inventing a second
   naming scheme.
2. **Add a `--editor` modifier class alongside the base class** (e.g.
   `className="c-your-block c-your-block--editor"`) for the *root* element
   only, when the front-end version of that root does something that's
   actively wrong or unsafe inside the constrained, scrollable editor canvas:
   full-viewport breakout (`width: 100vw; margin-left: calc(50% - 50vw)`),
   `position: sticky` tied to page scroll, swiper/carousel-only CSS, fixed
   aspect ratios that assume a Swiper has measured the viewport. Override
   *only* those specific properties under `&--editor` — don't recreate the
   rule from scratch.
3. **Write the CSS in `src/editor-styles.scss`**, in its own clearly
   commented block (see the existing Flip Card / Accordion Section / Impact
   Slider sections there for the format). Do **not** add an `@import` of the
   component partial as a shortcut — front-end partials assume `site.scss`'s
   full settings/media-query context and frequently contain rules (full-bleed,
   sticky, JS-dependent state classes) that are wrong or risky inside the
   editor iframe. Hand-port only what the editor preview actually needs.
4. If the block has genuine **interactive state** that the front end derives
   from JS (accordion open/closed, active carousel slide), replicate a
   *simplified* version of that state in `edit()` with local React state
   (`useState`) so authors see something closer to the real behaviour — e.g.
   Accordion Item's open/close toggle, or Accordion Section's image panel
   that follows whichever child is currently selected (via
   `useSelect( 'core/block-editor' )`). This is a nice-to-have for clarity,
   not a requirement for every block — use judgment based on how confusing a
   static preview would be.

### Before marking a new block done, check:

- [ ] Open the block in the actual WP post editor (not just "the build
      succeeded") and confirm it looks intentional, not like an unstyled
      bullet list.
- [ ] Every `className` in `edit()` has a corresponding rule in
      `editor-styles.scss`.
- [ ] No full-bleed/sticky/carousel-only CSS leaked into the editor without a
      `--editor` override.

---

## 8. Accessibility & Semantics

- Toggle/accordion triggers: real `<button type="button">`, `aria-expanded`
  reflecting actual state, `aria-label` when the visible content alone
  doesn't describe the action (e.g. an icon-only toggle).
- Decorative icons/SVGs: `aria-hidden="true"` and (for inline SVGs)
  `focusable="false"`.
- Images: always pass real `alt` text through (`imageAlt` attribute) — never
  hardcode `alt=""` unless the image is genuinely decorative and already
  marked `aria-hidden` on its container.
- Heading levels in render.php should follow document structure (the block's
  own "section heading" is usually an `<h2>`; card/item titles inside it are
  `<h3>`) — don't pick a heading level just because it matches a Figma font
  size; use CSS for sizing and reserve the tag for structure.
- Interactive elements need `:focus-visible` styles (see `.c-accordion-item__trigger:focus-visible` for the pattern: visible outline, no removal of focus rings).

---

## 9. Naming Conventions

- Block name: `mpsf/kebab-case-name`.
- CSS root class: `.c-{kebab-case-name}` (BEM `c-` prefix = "component").
- BEM descendant: `__` (`.c-accordion-item__title`).
- BEM modifier / state: `--` for context variants (`--editor`, `--image-right`), `is-` for transient state (`is-active`, `is-collapsed`, `is-open`).
- Don't invent a second prefix system for a new block — follow this exactly so QA/devtools selectors stay predictable theme-wide.

---

## 10. New Block Checklist

Copy this into your task list when starting a new block:

- [ ] `blocks/{name}/block.json` — `apiVersion: 3`, `mpsf/` namespace, `myblocks` category, accurate attribute types/defaults, `render: file:./render.php`.
- [ ] `blocks/{name}/index.js` — `edit()` builds an honest preview using `useBlockProps`, `InspectorControls`, `RichText`/`MediaUpload` as needed; `save()` returns `InnerBlocks.Content` or `null` only.
- [ ] `blocks/{name}/render.php` — sanitizes every attribute per §6's table, uses `get_block_wrapper_attributes()`, prefers attachment-ID images, no functions defined inline (helpers go in `inc/`).
- [ ] `webpack.config.js` — entry added.
- [ ] `inc/gdt-gutenberg.php` — `register_block_type()` call added inside `launchpad_register_blocks()`.
- [ ] `src/editor-styles.scss` — every `edit()` class name has matching CSS; full-bleed/sticky/carousel rules are overridden under a `--editor` modifier, not inherited.
- [ ] Dynamic/queried content uses `ServerSideRender`, not a hand-rolled JS preview of the query.
- [ ] Shared markup between blocks lives in an `inc/` helper, not copy-pasted `render.php` HTML.
- [ ] `npx wp-scripts build` runs clean (no new errors — pre-existing Sass deprecation warnings are fine).
- [ ] Opened the block in the real wp-admin post editor and it looks like the design, not a bare list.
