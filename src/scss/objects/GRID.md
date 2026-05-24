# Page Grid System

A CSS Grid named-line layout system that replaces the classic `max-width + margin: auto` wrapper pattern. It provides the same contained-site feel while enabling asymmetric layouts — e.g. text pinned to the content column with an image bleeding to the viewport edge — without any extra wrapper markup.

---

## Column tracks

```
|<──────────────────────── viewport ────────────────────────>|
|                                                             |
| [full-start]                                   [full-end]  |
|   gutter  [wide-start]             [wide-end]   gutter     |
|           extra  [content-start content-end]  extra        |
|                  |← max 1180px →|                          |
```

| Named line | Value | Purpose |
|---|---|---|
| `full-start / full-end` | viewport edges | Edge-to-edge (full-bleed) |
| `wide-start / wide-end` | max 1400px centered | Wide-alignment zone |
| `content-start / content-end` | max 1180px centered | Default content column |

The gutter is fluid: `clamp(1rem, 5vw, 3rem)` (~16px mobile → ~48px wide desktop).
Width values are read directly from `theme.json` via WP's generated CSS variables — no duplication.

---

## Quick start

Add `o-page-grid` as an **Additional CSS class** to any Group block. All direct children automatically sit in the content track.

```html
<!-- wp:group {"className":"o-page-grid","layout":{"type":"constrained"}} -->
<div class="wp-block-group o-page-grid is-layout-constrained wp-block-group-is-layout-constrained">

    <!-- This paragraph sits in the content track (contained, 1180px max) -->
    <!-- wp:paragraph -->
    <p>Normal contained content.</p>
    <!-- /wp:paragraph -->

    <!-- This group bleeds to the right viewport edge -->
    <!-- wp:group {"className":"bleed-right",...} -->
    <div class="wp-block-group bleed-right ...">...</div>
    <!-- /wp:group -->

</div>
<!-- /wp:group -->
```

---

## Child placement classes

Apply these to **direct children** of `.o-page-grid` (or to any element inside a subgrid context):

| Class | Column span | Use for |
|---|---|---|
| *(default)* | `content` | Normal body content |
| `.grid-content` | `content` | Explicitly pin to content track |
| `.grid-wide` | `wide` | Wide-aligned blocks (like WP `alignwide`) |
| `.grid-full` | `full` | Full viewport width (like WP `alignfull`) |
| `.bleed-right` | `content-start → full-end` | Content on left, bleeds to right edge |
| `.bleed-left` | `full-start → content-end` | Bleeds from left edge, content on right |

WP's native `.alignwide` and `.alignfull` classes are also mapped automatically.

---

## Classic wrappers

For simple contained sections where you don't need asymmetric bleed, the classic wrappers still work:

| Class | Max width | Use for |
|---|---|---|
| `.o-wrapper` | 1180px | Standard contained content |
| `.o-wrapper-wide` | 1400px | Wide contained content |
| `.o-wrapper-narrow` | 760px | Narrow reading-width content |

All three now use `--grid-gutter` for side padding (fluid, matches `.o-page-grid`).

---

## Subgrid

Full-bleed or bleed children automatically get `display: grid; grid-template-columns: subgrid` applied, so their children can still align to the original named tracks.

Add `.o-subgrid` to any child that isn't a bleed class but still needs its children to align to the page tracks.

```html
<!-- A full-width coloured band with text pinned to the content column -->
<!-- wp:group {"className":"grid-full o-subgrid",...} -->
<div class="wp-block-group grid-full o-subgrid ...">

    <!-- wp:group {"className":"grid-content",...} -->
    <div class="wp-block-group grid-content ...">
        <!-- wp:heading -->
        <h2>This heading aligns with the 1180px content column</h2>
        <!-- /wp:heading -->
    </div>
    <!-- /wp:group -->

</div>
<!-- /wp:group -->
```

---

## Block Editor usage

1. Select a **Group** block
2. Open the **Settings** sidebar → **Advanced** panel
3. Enter the class(es) in **Additional CSS class(es)**
4. Examples: `o-page-grid`, `o-page-grid o-subgrid`, `bleed-right`

Child blocks inside the group inherit the grid context. Add placement classes to child Group blocks the same way.

---

## Example: Asymmetric hero (text + image bleed)

A common pattern: body copy on the left within the content column, a photograph that bleeds to the right viewport edge.

```html
<!-- wp:group {"className":"o-page-grid","layout":{"type":"constrained"}} -->
<div class="wp-block-group o-page-grid is-layout-constrained wp-block-group-is-layout-constrained">

    <!-- wp:columns -->
    <div class="wp-block-columns">

        <!-- Left: text in content track (default) -->
        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:heading -->
            <h2>Your headline here</h2>
            <!-- /wp:heading -->
            <!-- wp:paragraph -->
            <p>Supporting copy...</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->

        <!-- Right: image bleeds to viewport edge -->
        <!-- wp:column {"className":"bleed-right"} -->
        <div class="wp-block-column bleed-right">
            <!-- wp:image {"scale":"cover","sizeSlug":"full"} -->
            <figure class="wp-block-image size-full">
                <img src="..." alt="" style="object-fit:cover;width:100%;height:100%"/>
            </figure>
            <!-- /wp:image -->
        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

</div>
<!-- /wp:group -->
```

This pattern is best saved as a **Block Pattern** (`patterns/` directory) so editors can insert it from the pattern library in one click.
