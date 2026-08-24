# Whitelisted Blocks Reference

This file is generated from `docs/block/block-registry.json`.

It contains only the blocks currently marked as allowed by the theme block availability system, together with the metadata exported in the registry JSON.

## Source

- Input JSON: `/var/www/html/wp-content/themes/d11/docs/block/block-registry.json`
- Output file: `/var/www/html/wp-content/themes/d11/docs/block/whitelisted-blocks.md`
- Generated at UTC: `2026-08-24T13:17:49+00:00`
- Whitelisted blocks: `54`

## Accordion (`core/accordion`)

- `title`: `Accordion`
- `description`: `Displays a foldable layout that groups content in collapsible sections.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `render_block_core_accordion`
- `has_render_callback`: `true`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- `core/accordion-icon-position`: `iconPosition`
- `core/accordion-show-icon`: `showIcon`
- `core/accordion-heading-level`: `headingLevel`

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "html": false,
    "align": [
        "wide",
        "full"
    ],
    "background": {
        "backgroundImage": true,
        "backgroundSize": true,
        "gradient": true,
        "__experimentalDefaultControls": {
            "backgroundImage": true
        }
    },
    "color": {
        "background": true,
        "gradients": true
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "spacing": {
        "padding": true,
        "margin": [
            "top",
            "bottom"
        ],
        "blockGap": true
    },
    "shadow": true,
    "layout": true,
    "ariaLabel": true,
    "interactivity": true,
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "contentRole": true,
    "listView": true
}
```

### Attributes

```json
{
    "iconPosition": {
        "type": "string",
        "default": "right"
    },
    "showIcon": {
        "type": "boolean",
        "default": true
    },
    "autoclose": {
        "type": "boolean",
        "default": false
    },
    "headingLevel": {
        "type": "number",
        "default": 3
    },
    "levelOptions": {
        "type": "array"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    },
    "ariaLabel": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-accordion`
- `wp-block-accordion-theme`

### Editor Style Handles

- `wp-block-accordion-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Accordion Heading (`core/accordion-heading`)

- `title`: `Accordion Heading`
- `description`: `Displays a heading that toggles the accordion panel.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- `core/accordion-item`

### Ancestor

- None

### Uses Context

- `core/accordion-icon-position`
- `core/accordion-show-icon`
- `core/accordion-heading-level`

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "color": {
        "background": true,
        "gradients": true
    },
    "align": false,
    "interactivity": true,
    "spacing": {
        "padding": true,
        "__experimentalDefaultControls": {
            "padding": true
        },
        "__experimentalSkipSerialization": true,
        "__experimentalSelector": ".wp-block-accordion-heading__toggle"
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "typography": {
        "__experimentalSkipSerialization": [
            "textDecoration",
            "letterSpacing"
        ],
        "fontSize": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true,
            "fontFamily": true
        }
    },
    "shadow": true,
    "visibility": false,
    "lock": false
}
```

### Attributes

```json
{
    "openByDefault": {
        "type": "boolean",
        "default": false
    },
    "title": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": ".wp-block-accordion-heading__toggle-title",
        "role": "content"
    },
    "level": {
        "type": "number"
    },
    "iconPosition": {
        "type": "string",
        "enum": [
            "left",
            "right"
        ],
        "default": "right"
    },
    "showIcon": {
        "type": "boolean",
        "default": true
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- `typography`:
```json
{
    "letterSpacing": ".wp-block-accordion-heading .wp-block-accordion-heading__toggle-title",
    "textDecoration": ".wp-block-accordion-heading .wp-block-accordion-heading__toggle-title"
}
```

### Style Handles

- `wp-block-accordion-heading`
- `wp-block-accordion-heading-theme`

### Editor Style Handles

- `wp-block-accordion-heading-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Accordion Item (`core/accordion-item`)

- `title`: `Accordion Item`
- `description`: `Wraps the heading and panel in one unit.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `block_core_accordion_item_render`
- `has_render_callback`: `true`

### Keywords

- None

### Parent

- `core/accordion`

### Ancestor

- None

### Uses Context

- None

### Provides Context

- `core/accordion-open-by-default`: `openByDefault`

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "html": false,
    "color": {
        "background": true,
        "gradients": true
    },
    "interactivity": true,
    "spacing": {
        "margin": [
            "top",
            "bottom"
        ],
        "padding": true,
        "blockGap": true
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "shadow": true,
    "layout": {
        "allowEditing": false
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "contentRole": true
}
```

### Attributes

```json
{
    "openByDefault": {
        "type": "boolean",
        "default": false
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-accordion-item`
- `wp-block-accordion-item-theme`

### Editor Style Handles

- `wp-block-accordion-item-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Accordion Panel (`core/accordion-panel`)

- `title`: `Accordion Panel`
- `description`: `Contains the hidden or revealed content beneath the heading.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- `core/accordion-item`

### Ancestor

- None

### Uses Context

- `core/accordion-open-by-default`

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "html": false,
    "color": {
        "background": true,
        "gradients": true
    },
    "interactivity": true,
    "spacing": {
        "padding": true,
        "blockGap": true,
        "__experimentalDefaultControls": {
            "padding": true,
            "blockGap": true
        }
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "shadow": true,
    "layout": {
        "allowEditing": false
    },
    "visibility": false,
    "contentRole": true,
    "allowedBlocks": true,
    "lock": false
}
```

### Attributes

```json
{
    "templateLock": {
        "type": [
            "string",
            "boolean"
        ],
        "enum": [
            "all",
            "insert",
            "contentOnly",
            false
        ],
        "default": false
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-accordion-panel`
- `wp-block-accordion-panel-theme`

### Editor Style Handles

- `wp-block-accordion-panel-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Audio (`core/audio`)

- `title`: `Audio`
- `description`: `Embed a simple audio player.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `media`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `music`
- `sound`
- `podcast`
- `recording`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": true,
    "spacing": {
        "margin": true,
        "padding": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "blob": {
        "type": "string",
        "role": "local"
    },
    "src": {
        "type": "string",
        "source": "attribute",
        "selector": "audio",
        "attribute": "src",
        "role": "content"
    },
    "caption": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "figcaption",
        "role": "content"
    },
    "id": {
        "type": "number",
        "role": "content"
    },
    "autoplay": {
        "type": "boolean",
        "source": "attribute",
        "selector": "audio",
        "attribute": "autoplay"
    },
    "loop": {
        "type": "boolean",
        "source": "attribute",
        "selector": "audio",
        "attribute": "loop"
    },
    "preload": {
        "type": "string",
        "source": "attribute",
        "selector": "audio",
        "attribute": "preload"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-audio`
- `wp-block-audio-theme`

### Editor Style Handles

- `wp-block-audio-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Button (`core/button`)

- `title`: `Button`
- `description`: `Prompt visitors to take action with a button-style link.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `render_block_core_button`
- `has_render_callback`: `true`

### Keywords

- `link`

### Parent

- `core/buttons`

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "splitting": true,
    "align": false,
    "alignWide": false,
    "color": {
        "__experimentalSkipSerialization": true,
        "gradients": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "dimensions": {
        "width": true,
        "__experimentalSkipSerialization": [
            "width"
        ],
        "__experimentalDefaultControls": {
            "width": true
        }
    },
    "typography": {
        "__experimentalSkipSerialization": [
            "fontSize",
            "lineHeight",
            "textAlign",
            "fontFamily",
            "fontWeight",
            "fontStyle",
            "textTransform",
            "textDecoration",
            "letterSpacing"
        ],
        "fontSize": true,
        "lineHeight": true,
        "textAlign": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalWritingMode": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "reusable": false,
    "shadow": {
        "__experimentalSkipSerialization": true
    },
    "spacing": {
        "__experimentalSkipSerialization": true,
        "padding": [
            "horizontal",
            "vertical"
        ],
        "__experimentalDefaultControls": {
            "padding": true
        }
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalSkipSerialization": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "tagName": {
        "type": "string",
        "enum": [
            "a",
            "button"
        ],
        "default": "a"
    },
    "type": {
        "type": "string",
        "default": "button"
    },
    "url": {
        "type": "string",
        "source": "attribute",
        "selector": "a",
        "attribute": "href",
        "role": "content"
    },
    "title": {
        "type": "string",
        "source": "attribute",
        "selector": "a,button",
        "attribute": "title",
        "role": "content"
    },
    "text": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "a,button",
        "role": "content"
    },
    "linkTarget": {
        "type": "string",
        "source": "attribute",
        "selector": "a",
        "attribute": "target",
        "role": "content"
    },
    "rel": {
        "type": "string",
        "source": "attribute",
        "selector": "a",
        "attribute": "rel",
        "role": "content"
    },
    "placeholder": {
        "type": "string"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- `root`: `.wp-block-button .wp-block-button__link`
- `typography`:
```json
{
    "writingMode": ".wp-block-button"
}
```
- `dimensions`:
```json
{
    "root": ".wp-block-button",
    "width": ".wp-block-button"
}
```

### Style Handles

- `wp-block-button`
- `wp-block-button-theme`

### Editor Style Handles

- `wp-block-button-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Buttons (`core/buttons`)

- `title`: `Buttons`
- `description`: `Prompt visitors to take action with a group of button-style links.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `link`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": [
        "wide",
        "full"
    ],
    "html": false,
    "__experimentalExposeControlsToChildren": true,
    "color": {
        "gradients": true,
        "text": false,
        "__experimentalDefaultControls": {
            "background": true
        }
    },
    "spacing": {
        "blockGap": [
            "horizontal",
            "vertical"
        ],
        "padding": true,
        "margin": [
            "top",
            "bottom"
        ],
        "__experimentalDefaultControls": {
            "blockGap": true
        }
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "layout": {
        "allowSwitching": false,
        "allowInheriting": false,
        "default": {
            "type": "flex"
        }
    },
    "interactivity": {
        "clientNavigation": true
    },
    "listView": true,
    "contentRole": true
}
```

### Attributes

```json
{
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-buttons`
- `wp-block-buttons-theme`

### Editor Style Handles

- `wp-block-buttons-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Code (`core/code`)

- `title`: `Code`
- `description`: `Display code snippets that respect your spacing and tabs.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "align": [
        "wide"
    ],
    "anchor": true,
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "spacing": {
        "margin": [
            "top",
            "bottom"
        ],
        "padding": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "__experimentalBorder": {
        "radius": true,
        "color": true,
        "width": true,
        "style": true,
        "__experimentalDefaultControls": {
            "width": true,
            "color": true
        }
    },
    "color": {
        "text": true,
        "background": true,
        "gradients": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "content": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "code",
        "__unstablePreserveWhiteSpace": true,
        "role": "content"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-code`
- `wp-block-code-theme`

### Editor Style Handles

- `wp-block-code-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Column (`core/column`)

- `title`: `Column`
- `description`: `A single column within a columns block.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- `core/columns`

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "__experimentalOnEnter": true,
    "anchor": true,
    "reusable": false,
    "html": false,
    "color": {
        "gradients": true,
        "heading": true,
        "button": true,
        "link": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "shadow": true,
    "spacing": {
        "blockGap": true,
        "padding": true,
        "__experimentalDefaultControls": {
            "padding": true,
            "blockGap": true
        }
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "layout": true,
    "interactivity": {
        "clientNavigation": true
    },
    "allowedBlocks": true
}
```

### Attributes

```json
{
    "verticalAlignment": {
        "type": "string"
    },
    "width": {
        "type": "string"
    },
    "templateLock": {
        "type": [
            "string",
            "boolean"
        ],
        "enum": [
            "all",
            "insert",
            "contentOnly",
            false
        ]
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-column`
- `wp-block-column-theme`

### Editor Style Handles

- `wp-block-column-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Columns (`core/columns`)

- `title`: `Columns`
- `description`: `Display content in multiple columns, with blocks added to each column.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": [
        "wide",
        "full"
    ],
    "html": false,
    "color": {
        "gradients": true,
        "link": true,
        "heading": true,
        "button": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "spacing": {
        "blockGap": {
            "__experimentalDefault": "2em",
            "sides": [
                "horizontal",
                "vertical"
            ]
        },
        "margin": [
            "top",
            "bottom"
        ],
        "padding": true,
        "__experimentalDefaultControls": {
            "padding": true,
            "blockGap": true
        }
    },
    "layout": {
        "allowSwitching": false,
        "allowInheriting": false,
        "allowEditing": false,
        "default": {
            "type": "flex",
            "flexWrap": "nowrap"
        }
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "interactivity": {
        "clientNavigation": true
    },
    "shadow": true
}
```

### Attributes

```json
{
    "verticalAlignment": {
        "type": "string"
    },
    "isStackedOnMobile": {
        "type": "boolean",
        "default": true
    },
    "templateLock": {
        "type": [
            "string",
            "boolean"
        ],
        "enum": [
            "all",
            "insert",
            "contentOnly",
            false
        ]
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-columns`
- `wp-block-columns-theme`

### Editor Style Handles

- `wp-block-columns-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Cover (`core/cover`)

- `title`: `Cover`
- `description`: `Add an image or video with a text overlay.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `media`
- `icon`: `null`
- `render_callback`: `render_block_core_cover`
- `has_render_callback`: `true`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- `postId`
- `postType`

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": true,
    "html": false,
    "shadow": true,
    "spacing": {
        "padding": true,
        "margin": [
            "top",
            "bottom"
        ],
        "blockGap": true,
        "__experimentalDefaultControls": {
            "padding": true,
            "blockGap": true
        }
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "color": {
        "heading": true,
        "text": true,
        "background": false,
        "__experimentalSkipSerialization": [
            "gradients"
        ],
        "enableContrastChecker": false
    },
    "dimensions": {
        "aspectRatio": true
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "layout": {
        "allowJustification": false
    },
    "interactivity": {
        "clientNavigation": true
    },
    "filter": {
        "duotone": true
    },
    "allowedBlocks": true
}
```

### Attributes

```json
{
    "url": {
        "type": "string",
        "role": "content"
    },
    "useFeaturedImage": {
        "type": "boolean",
        "default": false
    },
    "id": {
        "type": "number"
    },
    "alt": {
        "type": "string",
        "default": ""
    },
    "hasParallax": {
        "type": "boolean",
        "default": false
    },
    "isRepeated": {
        "type": "boolean",
        "default": false
    },
    "dimRatio": {
        "type": "number",
        "default": 100
    },
    "overlayColor": {
        "type": "string"
    },
    "customOverlayColor": {
        "type": "string"
    },
    "isUserOverlayColor": {
        "type": "boolean"
    },
    "backgroundType": {
        "type": "string",
        "default": "image"
    },
    "focalPoint": {
        "type": "object"
    },
    "minHeight": {
        "type": "number"
    },
    "minHeightUnit": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "customGradient": {
        "type": "string"
    },
    "contentPosition": {
        "type": "string"
    },
    "isDark": {
        "type": "boolean",
        "default": true
    },
    "templateLock": {
        "type": [
            "string",
            "boolean"
        ],
        "enum": [
            "all",
            "insert",
            "contentOnly",
            false
        ]
    },
    "tagName": {
        "type": "string",
        "default": "div"
    },
    "sizeSlug": {
        "type": "string"
    },
    "poster": {
        "type": "string",
        "source": "attribute",
        "selector": "video",
        "attribute": "poster"
    },
    "allowedVideoProviders": {
        "type": "array",
        "default": [
            "youtube",
            "vimeo",
            "videopress",
            "animoto",
            "tiktok",
            "wordpress-tv"
        ]
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "textColor": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- `filter`:
```json
{
    "duotone": ".wp-block-cover > .wp-block-cover__image-background, .wp-block-cover > .wp-block-cover__video-background"
}
```

### Style Handles

- `wp-block-cover`
- `wp-block-cover-theme`

### Editor Style Handles

- `wp-block-cover-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Details (`core/details`)

- `title`: `Details`
- `description`: `Hide and show additional content.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `summary`
- `toggle`
- `disclosure`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "__experimentalOnEnter": true,
    "align": [
        "wide",
        "full"
    ],
    "anchor": true,
    "color": {
        "gradients": true,
        "link": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "__experimentalBorder": {
        "color": true,
        "width": true,
        "style": true
    },
    "html": false,
    "spacing": {
        "margin": true,
        "padding": true,
        "blockGap": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "layout": {
        "allowEditing": false
    },
    "interactivity": {
        "clientNavigation": true
    },
    "allowedBlocks": true
}
```

### Attributes

```json
{
    "showContent": {
        "type": "boolean",
        "default": false
    },
    "summary": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "summary",
        "role": "content"
    },
    "name": {
        "type": "string",
        "source": "attribute",
        "attribute": "name",
        "selector": ".wp-block-details"
    },
    "placeholder": {
        "type": "string"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-details`
- `wp-block-details-theme`

### Editor Style Handles

- `wp-block-details-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Embed (`core/embed`)

- `title`: `Embed`
- `description`: `Add a block that displays content pulled from other sites, like Twitter or YouTube.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `embed`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": true,
    "spacing": {
        "margin": true
    },
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "url": {
        "type": "string",
        "role": "content"
    },
    "caption": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "figcaption",
        "role": "content"
    },
    "type": {
        "type": "string",
        "role": "content"
    },
    "providerNameSlug": {
        "type": "string",
        "role": "content"
    },
    "allowResponsive": {
        "type": "boolean",
        "default": true
    },
    "responsive": {
        "type": "boolean",
        "default": false,
        "role": "content"
    },
    "previewable": {
        "type": "boolean",
        "default": true,
        "role": "content"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-embed`
- `wp-block-embed-theme`

### Editor Style Handles

- `wp-block-embed-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Classic (`core/freeform`)

- `title`: `Classic`
- `description`: `Use the classic WordPress editor.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "className": false,
    "customClassName": false,
    "lock": false,
    "reusable": false,
    "renaming": false,
    "visibility": false,
    "customCSS": false
}
```

### Attributes

```json
{
    "content": {
        "type": "string",
        "source": "raw"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-freeform`
- `wp-block-freeform-theme`

### Editor Style Handles

- `wp-block-freeform-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Gallery (`core/gallery`)

- `title`: `Gallery`
- `description`: `Display multiple images in a rich gallery.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `media`
- `icon`: `null`
- `render_callback`: `block_core_gallery_render`
- `has_render_callback`: `true`

### Keywords

- `images`
- `photos`

### Parent

- None

### Ancestor

- None

### Uses Context

- `galleryId`
- `postId`
- `postType`

### Provides Context

- `allowResize`: `allowResize`
- `imageCrop`: `imageCrop`
- `fixedHeight`: `fixedHeight`
- `navigationButtonType`: `navigationButtonType`

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": true,
    "__experimentalBorder": {
        "radius": true,
        "color": true,
        "width": true,
        "style": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true
        }
    },
    "html": false,
    "units": [
        "px",
        "em",
        "rem",
        "vh",
        "vw"
    ],
    "spacing": {
        "margin": true,
        "padding": true,
        "blockGap": {
            "sides": [
                "horizontal",
                "vertical"
            ],
            "__experimentalDefault": "var( --wp--style--gallery-gap-default, var( --gallery-block--gutter-size, var( --wp--style--block-gap, 0.5em ) ) )"
        },
        "__experimentalDefaultControls": {
            "blockGap": true,
            "margin": false,
            "padding": false
        }
    },
    "color": {
        "text": false,
        "background": true,
        "gradients": true
    },
    "layout": {
        "allowSwitching": false,
        "allowInheriting": false,
        "allowEditing": false,
        "default": {
            "type": "flex"
        }
    },
    "interactivity": {
        "clientNavigation": true
    },
    "listView": true
}
```

### Attributes

```json
{
    "images": {
        "type": "array",
        "default": [],
        "source": "query",
        "selector": ".blocks-gallery-item",
        "query": {
            "url": {
                "type": "string",
                "source": "attribute",
                "selector": "img",
                "attribute": "src"
            },
            "fullUrl": {
                "type": "string",
                "source": "attribute",
                "selector": "img",
                "attribute": "data-full-url"
            },
            "link": {
                "type": "string",
                "source": "attribute",
                "selector": "img",
                "attribute": "data-link"
            },
            "alt": {
                "type": "string",
                "source": "attribute",
                "selector": "img",
                "attribute": "alt",
                "default": ""
            },
            "id": {
                "type": "string",
                "source": "attribute",
                "selector": "img",
                "attribute": "data-id"
            },
            "caption": {
                "type": "rich-text",
                "source": "rich-text",
                "selector": ".blocks-gallery-item__caption"
            }
        }
    },
    "ids": {
        "type": "array",
        "items": {
            "type": "number"
        },
        "default": []
    },
    "dynamicContent": {
        "type": "object"
    },
    "navigationButtonType": {
        "type": "string",
        "default": "icon",
        "enum": [
            "icon",
            "text",
            "both"
        ]
    },
    "shortCodeTransforms": {
        "type": "array",
        "items": {
            "type": "object"
        },
        "default": []
    },
    "columns": {
        "type": "number",
        "minimum": 1,
        "maximum": 8
    },
    "caption": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": ".blocks-gallery-caption",
        "role": "content"
    },
    "imageCrop": {
        "type": "boolean",
        "default": true
    },
    "randomOrder": {
        "type": "boolean",
        "default": false
    },
    "fixedHeight": {
        "type": "boolean",
        "default": true
    },
    "linkTarget": {
        "type": "string"
    },
    "linkTo": {
        "type": "string"
    },
    "sizeSlug": {
        "type": "string",
        "default": "large"
    },
    "allowResize": {
        "type": "boolean",
        "default": false
    },
    "aspectRatio": {
        "type": "string",
        "default": "auto"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-gallery`
- `wp-block-gallery-theme`

### Editor Style Handles

- `wp-block-gallery-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Group (`core/group`)

- `title`: `Group`
- `description`: `Gather blocks in a layout container.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `container`
- `wrapper`
- `row`
- `section`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "__experimentalOnEnter": true,
    "__experimentalOnMerge": true,
    "__experimentalSettings": true,
    "align": [
        "wide",
        "full"
    ],
    "anchor": true,
    "ariaLabel": true,
    "html": false,
    "background": {
        "backgroundImage": true,
        "backgroundSize": true,
        "gradient": true,
        "__experimentalDefaultControls": {
            "backgroundImage": true,
            "gradient": true
        }
    },
    "color": {
        "gradients": true,
        "heading": true,
        "button": true,
        "link": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "shadow": true,
    "spacing": {
        "margin": [
            "top",
            "bottom"
        ],
        "padding": true,
        "blockGap": true,
        "__experimentalDefaultControls": {
            "padding": true,
            "blockGap": true
        }
    },
    "dimensions": {
        "minHeight": true,
        "minWidth": true
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "position": {
        "sticky": true
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "layout": {
        "allowSizingOnChildren": true
    },
    "interactivity": {
        "clientNavigation": true
    },
    "allowedBlocks": true
}
```

### Attributes

```json
{
    "tagName": {
        "type": "string",
        "default": "div"
    },
    "templateLock": {
        "type": [
            "string",
            "boolean"
        ],
        "enum": [
            "all",
            "insert",
            "contentOnly",
            false
        ]
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    },
    "ariaLabel": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-group`
- `wp-block-group-theme`

### Editor Style Handles

- `wp-block-group-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Heading (`core/heading`)

- `title`: `Heading`
- `description`: `Introduce new sections and organize content to help visitors (and search engines) understand the structure of your content.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `block_core_heading_render`
- `has_render_callback`: `true`

### Keywords

- `title`
- `subtitle`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "align": [
        "wide",
        "full"
    ],
    "anchor": true,
    "className": true,
    "splitting": true,
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true
    },
    "color": {
        "gradients": true,
        "link": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "spacing": {
        "margin": true,
        "padding": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "textAlign": true,
        "__experimentalFontFamily": true,
        "__experimentalFontStyle": true,
        "__experimentalFontWeight": true,
        "__experimentalLetterSpacing": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalWritingMode": true,
        "fitText": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "__unstablePasteTextInline": true,
    "__experimentalSlashInserter": true,
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "content": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "h1,h2,h3,h4,h5,h6",
        "role": "content"
    },
    "level": {
        "type": "number",
        "default": 2
    },
    "levelOptions": {
        "type": "array"
    },
    "placeholder": {
        "type": "string"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-heading`
- `wp-block-heading-theme`

### Editor Style Handles

- `wp-block-heading-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Home Link (`core/home-link`)

- `title`: `Home Link`
- `description`: `Create a link that always points to the homepage of the site. Usually not necessary if there is already a site title link present in the header.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `render_block_core_home_link`
- `has_render_callback`: `true`

### Keywords

- None

### Parent

- `core/navigation`

### Ancestor

- None

### Uses Context

- `textColor`
- `customTextColor`
- `backgroundColor`
- `customBackgroundColor`
- `fontSize`
- `customFontSize`
- `style`

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "reusable": false,
    "html": false,
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "label": {
        "type": "string",
        "role": "content"
    },
    "opensInNewTab": {
        "type": "boolean",
        "default": false
    },
    "description": {
        "type": "string"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-home-link`
- `wp-block-home-link-theme`

### Editor Style Handles

- `wp-block-home-link-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Custom HTML (`core/html`)

- `title`: `Custom HTML`
- `description`: `Add custom HTML code and preview it as you edit.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `widgets`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `embed`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "customClassName": false,
    "className": false,
    "html": false,
    "interactivity": {
        "clientNavigation": true
    },
    "listView": true,
    "customCSS": false,
    "visibility": false
}
```

### Attributes

```json
{
    "content": {
        "type": "string",
        "role": "local"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-html`
- `wp-block-html-theme`

### Editor Style Handles

- `wp-block-html-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Image (`core/image`)

- `title`: `Image`
- `description`: `Insert an image to make a visual statement.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `media`
- `icon`: `null`
- `render_callback`: `render_block_core_image`
- `has_render_callback`: `true`

### Keywords

- `img`
- `photo`
- `picture`

### Parent

- None

### Ancestor

- None

### Uses Context

- `allowResize`
- `imageCrop`
- `fixedHeight`
- `navigationButtonType`
- `postId`
- `postType`
- `queryId`
- `galleryId`

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "interactivity": true,
    "align": [
        "left",
        "center",
        "right",
        "wide",
        "full"
    ],
    "anchor": true,
    "color": {
        "text": false,
        "background": false
    },
    "filter": {
        "duotone": true
    },
    "spacing": {
        "margin": true
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "width": true,
        "__experimentalSkipSerialization": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "width": true
        }
    },
    "shadow": {
        "__experimentalSkipSerialization": true
    }
}
```

### Attributes

```json
{
    "blob": {
        "type": "string",
        "role": "local"
    },
    "url": {
        "type": "string",
        "source": "attribute",
        "selector": "img",
        "attribute": "src",
        "role": "content"
    },
    "alt": {
        "type": "string",
        "source": "attribute",
        "selector": "img",
        "attribute": "alt",
        "default": "",
        "role": "content"
    },
    "caption": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "figcaption",
        "role": "content"
    },
    "lightbox": {
        "type": "object",
        "enabled": {
            "type": "boolean"
        }
    },
    "title": {
        "type": "string",
        "source": "attribute",
        "selector": "img",
        "attribute": "title",
        "role": "content"
    },
    "href": {
        "type": "string",
        "source": "attribute",
        "selector": "figure > a",
        "attribute": "href",
        "role": "content"
    },
    "rel": {
        "type": "string",
        "source": "attribute",
        "selector": "figure > a",
        "attribute": "rel"
    },
    "linkClass": {
        "type": "string",
        "source": "attribute",
        "selector": "figure > a",
        "attribute": "class"
    },
    "id": {
        "type": "number",
        "role": "content"
    },
    "width": {
        "type": "string"
    },
    "height": {
        "type": "string"
    },
    "aspectRatio": {
        "type": "string"
    },
    "scale": {
        "type": "string"
    },
    "focalPoint": {
        "type": "object"
    },
    "sizeSlug": {
        "type": "string"
    },
    "linkDestination": {
        "type": "string"
    },
    "linkTarget": {
        "type": "string",
        "source": "attribute",
        "selector": "figure > a",
        "attribute": "target"
    },
    "isDecorative": {
        "type": "boolean",
        "default": false
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- `dimensions`: `.wp-block-image img, .wp-block-image .components-placeholder`
- `border`: `.wp-block-image img, .wp-block-image .wp-block-image__crop-area, .wp-block-image .components-placeholder`
- `shadow`: `.wp-block-image img, .wp-block-image .wp-block-image__crop-area, .wp-block-image .components-placeholder`
- `filter`:
```json
{
    "duotone": ".wp-block-image img, .wp-block-image .components-placeholder"
}
```

### Style Handles

- `wp-block-image`
- `wp-block-image-theme`

### Editor Style Handles

- `wp-block-image-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## List (`core/list`)

- `title`: `List`
- `description`: `An organized collection of items displayed in a specific order.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `block_core_list_render`
- `has_render_callback`: `true`

### Keywords

- `bullet list`
- `ordered list`
- `numbered list`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "html": false,
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "color": {
        "gradients": true,
        "link": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "spacing": {
        "margin": true,
        "padding": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "__unstablePasteTextInline": true,
    "__experimentalOnMerge": true,
    "__experimentalSlashInserter": true,
    "interactivity": {
        "clientNavigation": true
    },
    "listView": true
}
```

### Attributes

```json
{
    "ordered": {
        "type": "boolean",
        "default": false,
        "role": "content"
    },
    "values": {
        "type": "string",
        "source": "html",
        "selector": "ol,ul",
        "multiline": "li",
        "default": "",
        "role": "content"
    },
    "type": {
        "type": "string"
    },
    "start": {
        "type": "number"
    },
    "reversed": {
        "type": "boolean"
    },
    "placeholder": {
        "type": "string"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- `border`: `.wp-block-list:not(.wp-block-list .wp-block-list)`

### Style Handles

- `wp-block-list`
- `wp-block-list-theme`

### Editor Style Handles

- `wp-block-list-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## List Item (`core/list-item`)

- `title`: `List Item`
- `description`: `An individual item within a list.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- `core/list`

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "html": false,
    "className": false,
    "splitting": true,
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true
    },
    "color": {
        "gradients": true,
        "link": true,
        "background": true,
        "__experimentalDefaultControls": {
            "text": true
        }
    },
    "spacing": {
        "margin": true,
        "padding": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "placeholder": {
        "type": "string"
    },
    "content": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "li",
        "role": "content"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- `root`: `.wp-block-list > li`
- `border`: `.wp-block-list:not(.wp-block-list .wp-block-list) > li`

### Style Handles

- `wp-block-list-item`
- `wp-block-list-item-theme`

### Editor Style Handles

- `wp-block-list-item-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Math (`core/math`)

- `title`: `Math`
- `description`: `Display mathematical notation using LaTeX.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `equation`
- `formula`
- `latex`
- `mathematics`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "html": false,
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true
    },
    "color": {
        "gradients": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "spacing": {
        "margin": true,
        "padding": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "typography": {
        "fontSize": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    }
}
```

### Attributes

```json
{
    "latex": {
        "type": "string",
        "role": "content"
    },
    "mathML": {
        "type": "string",
        "source": "html",
        "selector": "math"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-math`
- `wp-block-math-theme`

### Editor Style Handles

- `wp-block-math-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Media & Text (`core/media-text`)

- `title`: `Media & Text`
- `description`: `Set media and words side-by-side for a richer layout.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `media`
- `icon`: `null`
- `render_callback`: `render_block_core_media_text`
- `has_render_callback`: `true`

### Keywords

- `image`
- `video`

### Parent

- None

### Ancestor

- None

### Uses Context

- `postId`
- `postType`

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": [
        "wide",
        "full"
    ],
    "html": false,
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "color": {
        "gradients": true,
        "heading": true,
        "link": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "spacing": {
        "margin": true,
        "padding": true
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "interactivity": {
        "clientNavigation": true
    },
    "allowedBlocks": true
}
```

### Attributes

```json
{
    "align": {
        "type": "string",
        "default": "none"
    },
    "mediaAlt": {
        "type": "string",
        "source": "attribute",
        "selector": "figure img",
        "attribute": "alt",
        "default": "",
        "role": "content"
    },
    "mediaPosition": {
        "type": "string",
        "default": "left"
    },
    "mediaId": {
        "type": "number",
        "role": "content"
    },
    "mediaUrl": {
        "type": "string",
        "source": "attribute",
        "selector": "figure video,figure img",
        "attribute": "src",
        "role": "content"
    },
    "mediaLink": {
        "type": "string"
    },
    "linkDestination": {
        "type": "string"
    },
    "linkTarget": {
        "type": "string",
        "source": "attribute",
        "selector": "figure a",
        "attribute": "target"
    },
    "href": {
        "type": "string",
        "source": "attribute",
        "selector": "figure a",
        "attribute": "href",
        "role": "content"
    },
    "rel": {
        "type": "string",
        "source": "attribute",
        "selector": "figure a",
        "attribute": "rel"
    },
    "linkClass": {
        "type": "string",
        "source": "attribute",
        "selector": "figure a",
        "attribute": "class"
    },
    "mediaType": {
        "type": "string",
        "role": "content"
    },
    "mediaWidth": {
        "type": "number",
        "default": 50
    },
    "mediaSizeSlug": {
        "type": "string"
    },
    "isStackedOnMobile": {
        "type": "boolean",
        "default": true
    },
    "verticalAlignment": {
        "type": "string"
    },
    "imageFill": {
        "type": "boolean"
    },
    "focalPoint": {
        "type": "object"
    },
    "useFeaturedImage": {
        "type": "boolean",
        "default": false
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-media-text`
- `wp-block-media-text-theme`

### Editor Style Handles

- `wp-block-media-text-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Unsupported (`core/missing`)

- `title`: `Unsupported`
- `description`: `Your site doesn’t include support for this block.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "className": false,
    "customClassName": false,
    "inserter": false,
    "html": false,
    "lock": false,
    "reusable": false,
    "renaming": false,
    "visibility": false,
    "interactivity": {
        "clientNavigation": true
    },
    "customCSS": false
}
```

### Attributes

```json
{
    "originalName": {
        "type": "string"
    },
    "originalUndelimitedContent": {
        "type": "string"
    },
    "originalContent": {
        "type": "string",
        "source": "raw"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-missing`
- `wp-block-missing-theme`

### Editor Style Handles

- `wp-block-missing-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## More (`core/more`)

- `title`: `More`
- `description`: `Content before this block will be shown in the excerpt on your archives page.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `read more`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "customClassName": false,
    "className": false,
    "html": false,
    "multiple": false,
    "visibility": false,
    "interactivity": {
        "clientNavigation": true
    },
    "customCSS": false
}
```

### Attributes

```json
{
    "customText": {
        "type": "string",
        "default": "",
        "role": "content"
    },
    "noTeaser": {
        "type": "boolean",
        "default": false
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-more`
- `wp-block-more-theme`

### Editor Style Handles

- `wp-block-more-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Navigation (`core/navigation`)

- `title`: `Navigation`
- `description`: `A collection of blocks that allow visitors to get around your site.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `theme`
- `icon`: `null`
- `render_callback`: `render_block_core_navigation`
- `has_render_callback`: `true`

### Keywords

- `menu`
- `navigation`
- `links`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- `textColor`: `textColor`
- `customTextColor`: `customTextColor`
- `backgroundColor`: `backgroundColor`
- `customBackgroundColor`: `customBackgroundColor`
- `overlayTextColor`: `overlayTextColor`
- `customOverlayTextColor`: `customOverlayTextColor`
- `overlayBackgroundColor`: `overlayBackgroundColor`
- `customOverlayBackgroundColor`: `customOverlayBackgroundColor`
- `fontSize`: `fontSize`
- `customFontSize`: `customFontSize`
- `showSubmenuIcon`: `showSubmenuIcon`
- `submenuVisibility`: `submenuVisibility`
- `openSubmenusOnClick`: `openSubmenusOnClick`
- `style`: `style`
- `maxNestingLevel`: `maxNestingLevel`

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `false`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": [
        "wide",
        "full"
    ],
    "ariaLabel": true,
    "contentRole": true,
    "html": false,
    "inserter": true,
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontStyle": true,
        "__experimentalFontWeight": true,
        "__experimentalTextTransform": true,
        "__experimentalFontFamily": true,
        "__experimentalLetterSpacing": true,
        "__experimentalTextDecoration": true,
        "__experimentalSkipSerialization": [
            "textDecoration"
        ],
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "spacing": {
        "blockGap": true,
        "units": [
            "px",
            "em",
            "rem",
            "vh",
            "vw"
        ],
        "__experimentalDefaultControls": {
            "blockGap": true
        }
    },
    "layout": {
        "allowSwitching": false,
        "allowInheriting": false,
        "allowVerticalAlignment": false,
        "allowSizingOnChildren": true,
        "default": {
            "type": "flex"
        }
    },
    "interactivity": true,
    "renaming": false
}
```

### Attributes

```json
{
    "ref": {
        "type": "number"
    },
    "textColor": {
        "type": "string"
    },
    "customTextColor": {
        "type": "string"
    },
    "rgbTextColor": {
        "type": "string"
    },
    "backgroundColor": {
        "type": "string"
    },
    "customBackgroundColor": {
        "type": "string"
    },
    "rgbBackgroundColor": {
        "type": "string"
    },
    "showSubmenuIcon": {
        "type": "boolean",
        "default": true
    },
    "submenuVisibility": {
        "type": "string",
        "enum": [
            "hover",
            "click",
            "always"
        ],
        "default": "hover"
    },
    "overlayMenu": {
        "type": "string",
        "default": "mobile"
    },
    "overlay": {
        "type": "string"
    },
    "icon": {
        "type": "string",
        "default": "handle"
    },
    "hasIcon": {
        "type": "boolean",
        "default": true
    },
    "__unstableLocation": {
        "type": "string"
    },
    "overlayBackgroundColor": {
        "type": "string"
    },
    "customOverlayBackgroundColor": {
        "type": "string"
    },
    "overlayTextColor": {
        "type": "string"
    },
    "customOverlayTextColor": {
        "type": "string"
    },
    "maxNestingLevel": {
        "type": "number",
        "default": 5
    },
    "templateLock": {
        "type": [
            "string",
            "boolean"
        ],
        "enum": [
            "all",
            "insert",
            "contentOnly",
            false
        ]
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    },
    "ariaLabel": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-navigation`
- `wp-block-navigation-theme`

### Editor Style Handles

- `wp-block-navigation-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Custom Link (`core/navigation-link`)

- `title`: `Custom Link`
- `description`: `Add a page, link, or another item to your navigation.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `render_block_core_navigation_link`
- `has_render_callback`: `true`

### Keywords

- None

### Parent

- `core/navigation`

### Ancestor

- None

### Uses Context

- `textColor`
- `customTextColor`
- `backgroundColor`
- `customBackgroundColor`
- `overlayTextColor`
- `customOverlayTextColor`
- `overlayBackgroundColor`
- `customOverlayBackgroundColor`
- `fontSize`
- `customFontSize`
- `showSubmenuIcon`
- `maxNestingLevel`
- `style`

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "reusable": false,
    "html": false,
    "__experimentalSlashInserter": true,
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "renaming": false,
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "label": {
        "type": "string",
        "role": "content"
    },
    "type": {
        "type": "string"
    },
    "description": {
        "type": "string"
    },
    "rel": {
        "type": "string"
    },
    "id": {
        "type": "number"
    },
    "opensInNewTab": {
        "type": "boolean",
        "default": false
    },
    "url": {
        "type": "string",
        "role": "content"
    },
    "title": {
        "type": "string"
    },
    "kind": {
        "type": "string"
    },
    "isTopLevelLink": {
        "type": "boolean"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- `states`:
```json
{
    "-current": ".wp-block-navigation .current-menu-item"
}
```

### Style Handles

- `wp-block-navigation-link`
- `wp-block-navigation-link-theme`

### Editor Style Handles

- `wp-block-navigation-link-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Submenu (`core/navigation-submenu`)

- `title`: `Submenu`
- `description`: `Add a submenu to your navigation.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `render_block_core_navigation_submenu`
- `has_render_callback`: `true`

### Keywords

- None

### Parent

- `core/navigation`

### Ancestor

- None

### Uses Context

- `textColor`
- `customTextColor`
- `backgroundColor`
- `customBackgroundColor`
- `overlayTextColor`
- `customOverlayTextColor`
- `overlayBackgroundColor`
- `customOverlayBackgroundColor`
- `fontSize`
- `customFontSize`
- `showSubmenuIcon`
- `maxNestingLevel`
- `openSubmenusOnClick`
- `submenuVisibility`
- `style`

### Provides Context

- `core/isInsideSubmenu`: `isParentSubmenu`

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "reusable": false,
    "html": false,
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "label": {
        "type": "string",
        "role": "content"
    },
    "type": {
        "type": "string"
    },
    "description": {
        "type": "string"
    },
    "rel": {
        "type": "string"
    },
    "id": {
        "type": "number"
    },
    "opensInNewTab": {
        "type": "boolean",
        "default": false
    },
    "url": {
        "type": "string",
        "role": "content"
    },
    "title": {
        "type": "string"
    },
    "kind": {
        "type": "string"
    },
    "isTopLevelItem": {
        "type": "boolean"
    },
    "isParentSubmenu": {
        "type": "boolean",
        "default": true
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-navigation-submenu`
- `wp-block-navigation-submenu-theme`

### Editor Style Handles

- `wp-block-navigation-submenu-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Page Break (`core/nextpage`)

- `title`: `Page Break`
- `description`: `Separate your content into a multi-page experience.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `next page`
- `pagination`

### Parent

- `core/post-content`

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "customClassName": false,
    "className": false,
    "html": false,
    "visibility": false,
    "interactivity": {
        "clientNavigation": true
    },
    "customCSS": false
}
```

### Attributes

```json
{
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-nextpage`
- `wp-block-nextpage-theme`

### Editor Style Handles

- `wp-block-nextpage-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Page List Item (`core/page-list-item`)

- `title`: `Page List Item`
- `description`: `Displays a page inside a list of all pages.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `widgets`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `page`
- `menu`
- `navigation`

### Parent

- `core/page-list`

### Ancestor

- None

### Uses Context

- `textColor`
- `customTextColor`
- `backgroundColor`
- `customBackgroundColor`
- `overlayTextColor`
- `customOverlayTextColor`
- `overlayBackgroundColor`
- `customOverlayBackgroundColor`
- `fontSize`
- `customFontSize`
- `showSubmenuIcon`
- `style`
- `openSubmenusOnClick`
- `submenuVisibility`

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "reusable": false,
    "html": false,
    "lock": false,
    "inserter": false,
    "__experimentalToolbar": false,
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "id": {
        "type": "number"
    },
    "label": {
        "type": "string"
    },
    "title": {
        "type": "string"
    },
    "link": {
        "type": "string"
    },
    "hasChildren": {
        "type": "boolean"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    },
    "style": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-page-list-item`
- `wp-block-page-list-item-theme`

### Editor Style Handles

- `wp-block-page-list-item-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Paragraph (`core/paragraph`)

- `title`: `Paragraph`
- `description`: `Start with the basic building block of all narrative.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `text`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "align": [
        "wide",
        "full"
    ],
    "splitting": true,
    "anchor": true,
    "className": false,
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true
    },
    "color": {
        "gradients": true,
        "link": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "spacing": {
        "margin": true,
        "padding": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "textAlign": true,
        "textColumns": true,
        "textIndent": true,
        "__experimentalFontFamily": true,
        "__experimentalTextDecoration": true,
        "__experimentalFontStyle": true,
        "__experimentalFontWeight": true,
        "__experimentalLetterSpacing": true,
        "__experimentalTextTransform": true,
        "__experimentalWritingMode": true,
        "fitText": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "__experimentalSelector": "p",
    "__unstablePasteTextInline": true,
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "content": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "p",
        "role": "content"
    },
    "dropCap": {
        "type": "boolean",
        "default": false
    },
    "placeholder": {
        "type": "string"
    },
    "direction": {
        "type": "string",
        "enum": [
            "ltr",
            "rtl"
        ]
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- `root`: `p`
- `typography`:
```json
{
    "textIndent": ".wp-block-paragraph + .wp-block-paragraph"
}
```

### Style Handles

- `wp-block-paragraph`
- `wp-block-paragraph-theme`

### Editor Style Handles

- `wp-block-paragraph-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Preformatted (`core/preformatted`)

- `title`: `Preformatted`
- `description`: `Add text that respects your spacing and tabs, and also allows styling.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "color": {
        "gradients": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "spacing": {
        "padding": true,
        "margin": true
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "interactivity": {
        "clientNavigation": true
    },
    "__experimentalBorder": {
        "radius": true,
        "color": true,
        "width": true,
        "style": true,
        "__experimentalDefaultControls": {
            "radius": true,
            "color": true,
            "width": true,
            "style": true
        }
    }
}
```

### Attributes

```json
{
    "content": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "pre",
        "__unstablePreserveWhiteSpace": true,
        "role": "content"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-preformatted`
- `wp-block-preformatted-theme`

### Editor Style Handles

- `wp-block-preformatted-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Pullquote (`core/pullquote`)

- `title`: `Pullquote`
- `description`: `Give special visual emphasis to a quote from your text.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": [
        "left",
        "right",
        "wide",
        "full"
    ],
    "background": {
        "backgroundImage": true,
        "backgroundSize": true,
        "gradient": true,
        "__experimentalDefaultControls": {
            "backgroundImage": true,
            "gradient": true
        }
    },
    "color": {
        "gradients": true,
        "background": true,
        "link": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "dimensions": {
        "minHeight": true
    },
    "spacing": {
        "margin": true,
        "padding": true
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "textAlign": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "__experimentalStyle": {
        "typography": {
            "fontSize": "1.5em",
            "lineHeight": "1.6"
        }
    },
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "value": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "p",
        "role": "content"
    },
    "citation": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "cite",
        "role": "content"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-pullquote`
- `wp-block-pullquote-theme`

### Editor Style Handles

- `wp-block-pullquote-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Quote (`core/quote`)

- `title`: `Quote`
- `description`: `Give quoted text visual emphasis. "In quoting others, we cite ourselves." — Julio Cortázar`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `blockquote`
- `cite`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": [
        "left",
        "right",
        "wide",
        "full"
    ],
    "html": false,
    "background": {
        "backgroundImage": true,
        "backgroundSize": true,
        "gradient": true,
        "__experimentalDefaultControls": {
            "backgroundImage": true,
            "gradient": true
        }
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    },
    "dimensions": {
        "minHeight": true,
        "__experimentalDefaultControls": {
            "minHeight": false
        }
    },
    "__experimentalOnEnter": true,
    "__experimentalOnMerge": true,
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "color": {
        "gradients": true,
        "heading": true,
        "link": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "layout": {
        "allowEditing": false
    },
    "spacing": {
        "blockGap": true,
        "padding": true,
        "margin": true
    },
    "interactivity": {
        "clientNavigation": true
    },
    "allowedBlocks": true
}
```

### Attributes

```json
{
    "value": {
        "type": "string",
        "source": "html",
        "selector": "blockquote",
        "multiline": "p",
        "default": "",
        "role": "content"
    },
    "citation": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "cite",
        "role": "content"
    },
    "textAlign": {
        "type": "string"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-quote`
- `wp-block-quote-theme`

### Editor Style Handles

- `wp-block-quote-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Search (`core/search`)

- `title`: `Search`
- `description`: `Help visitors find your content.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `widgets`
- `icon`: `null`
- `render_callback`: `render_block_core_search`
- `has_render_callback`: `true`

### Keywords

- `find`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": [
        "left",
        "center",
        "right"
    ],
    "color": {
        "gradients": true,
        "__experimentalSkipSerialization": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "interactivity": true,
    "typography": {
        "__experimentalSkipSerialization": true,
        "__experimentalSelector": ".wp-block-search__label, .wp-block-search__input, .wp-block-search__button",
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontWeight": true,
        "__experimentalFontStyle": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalLetterSpacing": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "__experimentalBorder": {
        "color": true,
        "radius": true,
        "width": true,
        "__experimentalSkipSerialization": true,
        "__experimentalDefaultControls": {
            "color": true,
            "radius": true,
            "width": true
        }
    },
    "spacing": {
        "margin": true
    },
    "html": false
}
```

### Attributes

```json
{
    "label": {
        "type": "string",
        "role": "content"
    },
    "showLabel": {
        "type": "boolean",
        "default": true
    },
    "placeholder": {
        "type": "string",
        "default": "",
        "role": "content"
    },
    "width": {
        "type": "number"
    },
    "widthUnit": {
        "type": "string"
    },
    "buttonText": {
        "type": "string",
        "role": "content"
    },
    "buttonPosition": {
        "type": "string",
        "default": "button-outside"
    },
    "buttonUseIcon": {
        "type": "boolean",
        "default": false
    },
    "query": {
        "type": "object",
        "default": []
    },
    "tagName": {
        "type": "string",
        "default": ""
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- `color`: `.wp-block-search .wp-block-search__button, .wp-block-search.wp-block-search__no-button .wp-block-search__input`
- `border`: `.wp-block-search.wp-block-search__button-outside .wp-block-search__input, .wp-block-search.wp-block-search__button-outside .wp-block-search__button, .wp-block-search.wp-block-search__no-button .wp-block-search__input, .wp-block-search.wp-block-search__button-only .wp-block-search__input, .wp-block-search.wp-block-search__button-only .wp-block-search__button, .wp-block-search.wp-block-search__button-inside .wp-block-search__inside-wrapper`

### Style Handles

- `wp-block-search`
- `wp-block-search-theme`

### Editor Style Handles

- `wp-block-search-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Separator (`core/separator`)

- `title`: `Separator`
- `description`: `Create a break between ideas or sections with a horizontal separator.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `horizontal-line`
- `hr`
- `divider`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": [
        "center",
        "wide",
        "full"
    ],
    "color": {
        "enableContrastChecker": false,
        "__experimentalSkipSerialization": true,
        "gradients": true,
        "background": true,
        "text": false,
        "__experimentalDefaultControls": {
            "background": true
        }
    },
    "spacing": {
        "margin": [
            "top",
            "bottom"
        ]
    },
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "opacity": {
        "type": "string",
        "default": "alpha-channel"
    },
    "tagName": {
        "type": "string",
        "enum": [
            "hr",
            "div"
        ],
        "default": "hr"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-separator`
- `wp-block-separator-theme`

### Editor Style Handles

- `wp-block-separator-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Site Logo (`core/site-logo`)

- `title`: `Site Logo`
- `description`: `Display an image to represent this site. Update this block and the changes apply everywhere.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `theme`
- `icon`: `null`
- `render_callback`: `render_block_core_site_logo`
- `has_render_callback`: `true`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "html": false,
    "align": true,
    "alignWide": false,
    "color": {
        "text": false,
        "background": false
    },
    "spacing": {
        "margin": true,
        "padding": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "interactivity": {
        "clientNavigation": true
    },
    "filter": {
        "duotone": true
    }
}
```

### Attributes

```json
{
    "width": {
        "type": "number"
    },
    "isLink": {
        "type": "boolean",
        "default": true,
        "role": "content"
    },
    "linkTarget": {
        "type": "string",
        "default": "_self",
        "role": "content"
    },
    "shouldSyncIcon": {
        "type": "boolean"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

```json
{
    "viewportWidth": 500,
    "attributes": {
        "width": 350,
        "className": "block-editor-block-types-list__site-logo-example"
    }
}
```

### Selectors

- `filter`:
```json
{
    "duotone": ".wp-block-site-logo img, .wp-block-site-logo .components-placeholder__illustration, .wp-block-site-logo .components-placeholder::before"
}
```

### Style Handles

- `wp-block-site-logo`
- `wp-block-site-logo-theme`

### Editor Style Handles

- `wp-block-site-logo-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Site Tagline (`core/site-tagline`)

- `title`: `Site Tagline`
- `description`: `Describe in a few words what this site is about. This is important for search results, sharing on social media, and gives overall clarity to visitors.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `theme`
- `icon`: `null`
- `render_callback`: `render_block_core_site_tagline`
- `has_render_callback`: `true`

### Keywords

- `description`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": [
        "wide",
        "full"
    ],
    "html": false,
    "color": {
        "gradients": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "contentRole": true,
    "spacing": {
        "margin": true,
        "padding": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "textAlign": true,
        "__experimentalFontFamily": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalFontStyle": true,
        "__experimentalFontWeight": true,
        "__experimentalLetterSpacing": true,
        "__experimentalWritingMode": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "interactivity": {
        "clientNavigation": true
    },
    "__experimentalBorder": {
        "radius": true,
        "color": true,
        "width": true,
        "style": true
    }
}
```

### Attributes

```json
{
    "level": {
        "type": "number",
        "default": 0
    },
    "levelOptions": {
        "type": "array",
        "default": [
            0,
            1,
            2,
            3,
            4,
            5,
            6
        ]
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

```json
{
    "viewportWidth": 350,
    "attributes": {
        "style": {
            "typography": {
                "textAlign": "center"
            }
        }
    }
}
```

### Selectors

- None

### Style Handles

- `wp-block-site-tagline`
- `wp-block-site-tagline-theme`

### Editor Style Handles

- `wp-block-site-tagline-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Site Title (`core/site-title`)

- `title`: `Site Title`
- `description`: `Displays the name of this site. Update the block, and the changes apply everywhere it’s used. This will also appear in the browser title bar and in search results.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `theme`
- `icon`: `null`
- `render_callback`: `render_block_core_site_title`
- `has_render_callback`: `true`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": [
        "wide",
        "full"
    ],
    "html": false,
    "color": {
        "gradients": true,
        "link": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true,
            "link": true
        }
    },
    "spacing": {
        "padding": true,
        "margin": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "textAlign": true,
        "__experimentalFontFamily": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalFontStyle": true,
        "__experimentalFontWeight": true,
        "__experimentalLetterSpacing": true,
        "__experimentalWritingMode": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "interactivity": {
        "clientNavigation": true
    },
    "__experimentalBorder": {
        "radius": true,
        "color": true,
        "width": true,
        "style": true
    }
}
```

### Attributes

```json
{
    "level": {
        "type": "number",
        "default": 1
    },
    "levelOptions": {
        "type": "array",
        "default": [
            0,
            1,
            2,
            3,
            4,
            5,
            6
        ]
    },
    "isLink": {
        "type": "boolean",
        "default": true,
        "role": "content"
    },
    "linkTarget": {
        "type": "string",
        "default": "_self",
        "role": "content"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

```json
{
    "viewportWidth": 500
}
```

### Selectors

- None

### Style Handles

- `wp-block-site-title`
- `wp-block-site-title-theme`

### Editor Style Handles

- `wp-block-site-title-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Social Icon (`core/social-link`)

- `title`: `Social Icon`
- `description`: `Display an icon linking to a social profile or site.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `widgets`
- `icon`: `null`
- `render_callback`: `render_block_core_social_link`
- `has_render_callback`: `true`

### Keywords

- None

### Parent

- `core/social-links`

### Ancestor

- None

### Uses Context

- `openInNewTab`
- `showLabels`
- `iconColor`
- `iconColorValue`
- `iconBackgroundColor`
- `iconBackgroundColorValue`

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "reusable": false,
    "html": false,
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "url": {
        "type": "string",
        "role": "content"
    },
    "service": {
        "type": "string"
    },
    "label": {
        "type": "string",
        "role": "content"
    },
    "rel": {
        "type": "string"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    },
    "style": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-social-link`
- `wp-block-social-link-theme`

### Editor Style Handles

- `wp-block-social-link-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Social Icons (`core/social-links`)

- `title`: `Social Icons`
- `description`: `Display icons linking to your social profiles or sites.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `widgets`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `links`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- `openInNewTab`: `openInNewTab`
- `showLabels`: `showLabels`
- `iconColor`: `iconColor`
- `iconColorValue`: `iconColorValue`
- `iconBackgroundColor`: `iconBackgroundColor`
- `iconBackgroundColorValue`: `iconBackgroundColorValue`

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "align": [
        "left",
        "center",
        "right"
    ],
    "anchor": true,
    "html": false,
    "__experimentalExposeControlsToChildren": true,
    "layout": {
        "allowSwitching": false,
        "allowInheriting": false,
        "allowVerticalAlignment": false,
        "default": {
            "type": "flex"
        }
    },
    "color": {
        "enableContrastChecker": false,
        "background": true,
        "gradients": true,
        "text": false,
        "__experimentalDefaultControls": {
            "background": false
        }
    },
    "spacing": {
        "blockGap": [
            "horizontal",
            "vertical"
        ],
        "margin": true,
        "padding": true,
        "units": [
            "px",
            "em",
            "rem",
            "vh",
            "vw"
        ],
        "__experimentalDefaultControls": {
            "blockGap": true,
            "margin": true,
            "padding": false
        }
    },
    "interactivity": {
        "clientNavigation": true
    },
    "__experimentalBorder": {
        "radius": true,
        "color": true,
        "width": true,
        "style": true,
        "__experimentalDefaultControls": {
            "radius": true,
            "color": true,
            "width": true,
            "style": true
        }
    },
    "contentRole": true,
    "listView": true
}
```

### Attributes

```json
{
    "iconColor": {
        "type": "string"
    },
    "customIconColor": {
        "type": "string"
    },
    "iconColorValue": {
        "type": "string"
    },
    "iconBackgroundColor": {
        "type": "string"
    },
    "customIconBackgroundColor": {
        "type": "string"
    },
    "iconBackgroundColorValue": {
        "type": "string"
    },
    "openInNewTab": {
        "type": "boolean",
        "default": false
    },
    "showLabels": {
        "type": "boolean",
        "default": false
    },
    "size": {
        "type": "string"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-social-links`
- `wp-block-social-links-theme`

### Editor Style Handles

- `wp-block-social-links-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Spacer (`core/spacer`)

- `title`: `Spacer`
- `description`: `Add white space between blocks and customize its height.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- `orientation`

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `true`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "spacing": {
        "margin": [
            "top",
            "bottom"
        ],
        "__experimentalDefaultControls": {
            "margin": true
        }
    },
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "height": {
        "type": "string",
        "default": "100px"
    },
    "width": {
        "type": "string"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-spacer`
- `wp-block-spacer-theme`

### Editor Style Handles

- `wp-block-spacer-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Tab Panels (`core/tab-panels`)

- `title`: `Tab Panels`
- `description`: `Container for tab panel content in a tabbed interface.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `design`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- `core/tabs`

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "html": false,
    "visibility": false,
    "lock": false,
    "color": {
        "background": true,
        "text": true,
        "heading": true,
        "link": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "spacing": {
        "padding": true
    },
    "typography": {
        "fontSize": true,
        "__experimentalFontFamily": true
    },
    "__experimentalBorder": {
        "radius": true,
        "color": true,
        "width": true,
        "style": true
    }
}
```

### Attributes

```json
{
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-tab-panels`
- `wp-block-tab-panels-theme`

### Editor Style Handles

- `wp-block-tab-panels-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Table (`core/table`)

- `title`: `Table`
- `description`: `Create structured content in rows and columns to display information.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": true,
    "color": {
        "__experimentalSkipSerialization": true,
        "gradients": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "spacing": {
        "margin": true,
        "padding": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "typography": {
        "fontSize": true,
        "lineHeight": true,
        "__experimentalFontFamily": true,
        "__experimentalFontStyle": true,
        "__experimentalFontWeight": true,
        "__experimentalLetterSpacing": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "__experimentalBorder": {
        "__experimentalSkipSerialization": true,
        "color": true,
        "style": true,
        "width": true,
        "__experimentalDefaultControls": {
            "color": true,
            "style": true,
            "width": true
        }
    },
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "hasFixedLayout": {
        "type": "boolean",
        "default": true
    },
    "caption": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "figcaption",
        "role": "content"
    },
    "head": {
        "type": "array",
        "default": [],
        "source": "query",
        "selector": "thead tr",
        "query": {
            "cells": {
                "type": "array",
                "default": [],
                "source": "query",
                "selector": "td,th",
                "query": {
                    "content": {
                        "type": "rich-text",
                        "source": "rich-text",
                        "role": "content"
                    },
                    "tag": {
                        "type": "string",
                        "default": "td",
                        "source": "tag"
                    },
                    "scope": {
                        "type": "string",
                        "source": "attribute",
                        "attribute": "scope"
                    },
                    "align": {
                        "type": "string",
                        "source": "attribute",
                        "attribute": "data-align"
                    },
                    "colspan": {
                        "type": "string",
                        "source": "attribute",
                        "attribute": "colspan"
                    },
                    "rowspan": {
                        "type": "string",
                        "source": "attribute",
                        "attribute": "rowspan"
                    }
                }
            }
        }
    },
    "body": {
        "type": "array",
        "default": [],
        "source": "query",
        "selector": "tbody tr",
        "query": {
            "cells": {
                "type": "array",
                "default": [],
                "source": "query",
                "selector": "td,th",
                "query": {
                    "content": {
                        "type": "rich-text",
                        "source": "rich-text",
                        "role": "content"
                    },
                    "tag": {
                        "type": "string",
                        "default": "td",
                        "source": "tag"
                    },
                    "scope": {
                        "type": "string",
                        "source": "attribute",
                        "attribute": "scope"
                    },
                    "align": {
                        "type": "string",
                        "source": "attribute",
                        "attribute": "data-align"
                    },
                    "colspan": {
                        "type": "string",
                        "source": "attribute",
                        "attribute": "colspan"
                    },
                    "rowspan": {
                        "type": "string",
                        "source": "attribute",
                        "attribute": "rowspan"
                    }
                }
            }
        }
    },
    "foot": {
        "type": "array",
        "default": [],
        "source": "query",
        "selector": "tfoot tr",
        "query": {
            "cells": {
                "type": "array",
                "default": [],
                "source": "query",
                "selector": "td,th",
                "query": {
                    "content": {
                        "type": "rich-text",
                        "source": "rich-text",
                        "role": "content"
                    },
                    "tag": {
                        "type": "string",
                        "default": "td",
                        "source": "tag"
                    },
                    "scope": {
                        "type": "string",
                        "source": "attribute",
                        "attribute": "scope"
                    },
                    "align": {
                        "type": "string",
                        "source": "attribute",
                        "attribute": "data-align"
                    },
                    "colspan": {
                        "type": "string",
                        "source": "attribute",
                        "attribute": "colspan"
                    },
                    "rowspan": {
                        "type": "string",
                        "source": "attribute",
                        "attribute": "rowspan"
                    }
                }
            }
        }
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- `root`: `.wp-block-table > table`
- `spacing`: `.wp-block-table`

### Style Handles

- `wp-block-table`
- `wp-block-table-theme`

### Editor Style Handles

- `wp-block-table-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Template Part (`core/template-part`)

- `title`: `Template Part`
- `description`: `Edit the different global regions of your site, like the header, footer, sidebar, or create your own.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `theme`
- `icon`: `null`
- `render_callback`: `render_block_core_template_part`
- `has_render_callback`: `true`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `true`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "align": true,
    "html": false,
    "reusable": false,
    "renaming": false,
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "slug": {
        "type": "string"
    },
    "theme": {
        "type": "string"
    },
    "tagName": {
        "type": "string"
    },
    "area": {
        "type": "string"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-template-part`
- `wp-block-template-part-theme`

### Editor Style Handles

- `wp-block-template-part-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Terms Query (`core/terms-query`)

- `title`: `Terms Query`
- `description`: `An advanced block that allows displaying taxonomy terms based on different query parameters and visual configurations.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `theme`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `terms`
- `taxonomy`
- `categories`
- `tags`
- `list`

### Parent

- None

### Ancestor

- None

### Uses Context

- `templateSlug`

### Provides Context

- `termQuery`: `termQuery`

### Supports Summary

- `anchor`: `true`
- `align`: `true`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "align": [
        "wide",
        "full"
    ],
    "html": false,
    "layout": true,
    "interactivity": true
}
```

### Attributes

```json
{
    "termQuery": {
        "type": "object",
        "default": {
            "perPage": 10,
            "taxonomy": "category",
            "order": "asc",
            "orderBy": "name",
            "include": [],
            "hideEmpty": true,
            "showNested": false,
            "inherit": false
        }
    },
    "tagName": {
        "type": "string",
        "default": "div"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "align": {
        "type": "string",
        "enum": [
            "left",
            "center",
            "right",
            "wide",
            "full",
            ""
        ]
    },
    "className": {
        "type": "string"
    },
    "layout": {
        "type": "object"
    },
    "anchor": {
        "type": "string"
    },
    "style": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-terms-query`
- `wp-block-terms-query-theme`

### Editor Style Handles

- `wp-block-terms-query-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Text Columns (deprecated) (`core/text-columns`)

- `title`: `Text Columns (deprecated)`
- `description`: `This block is deprecated. Please use the Columns block instead.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `design`
- `icon`: `columns`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "inserter": false,
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "content": {
        "type": "array",
        "source": "query",
        "selector": "p",
        "query": {
            "children": {
                "type": "string",
                "source": "html"
            }
        },
        "default": [
            [],
            []
        ]
    },
    "columns": {
        "type": "number",
        "default": 2
    },
    "width": {
        "type": "string"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-text-columns`
- `wp-block-text-columns-theme`

### Editor Style Handles

- `wp-block-text-columns-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Poetry (`core/verse`)

- `title`: `Poetry`
- `description`: `Insert poetry. Use special spacing formats. Or quote song lyrics.`
- `origin`: `core`
- `category_bucket`: `core`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `text`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `poetry`
- `poem`
- `verse`
- `stanza`
- `song`
- `lyrics`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `true`
- `align`: `false`
- `spacing`: `true`
- `color`: `true`
- `typography`: `true`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "anchor": true,
    "background": {
        "backgroundImage": true,
        "backgroundSize": true,
        "gradient": true,
        "__experimentalDefaultControls": {
            "backgroundImage": true,
            "gradient": true
        }
    },
    "color": {
        "gradients": true,
        "link": true,
        "__experimentalDefaultControls": {
            "background": true,
            "text": true
        }
    },
    "dimensions": {
        "minHeight": true,
        "__experimentalDefaultControls": {
            "minHeight": false
        }
    },
    "typography": {
        "fontSize": true,
        "__experimentalFontFamily": true,
        "lineHeight": true,
        "textAlign": true,
        "__experimentalFontStyle": true,
        "__experimentalFontWeight": true,
        "__experimentalLetterSpacing": true,
        "__experimentalTextTransform": true,
        "__experimentalTextDecoration": true,
        "__experimentalWritingMode": true,
        "__experimentalDefaultControls": {
            "fontSize": true
        }
    },
    "spacing": {
        "margin": true,
        "padding": true,
        "__experimentalDefaultControls": {
            "margin": false,
            "padding": false
        }
    },
    "__experimentalBorder": {
        "radius": true,
        "width": true,
        "color": true,
        "style": true
    },
    "interactivity": {
        "clientNavigation": true
    }
}
```

### Attributes

```json
{
    "content": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "pre",
        "__unstablePreserveWhiteSpace": true,
        "role": "content"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    },
    "backgroundColor": {
        "type": "string"
    },
    "textColor": {
        "type": "string"
    },
    "gradient": {
        "type": "string"
    },
    "fontSize": {
        "type": "string"
    },
    "fontFamily": {
        "type": "string"
    },
    "borderColor": {
        "type": "string"
    },
    "anchor": {
        "type": "string"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `wp-block-verse`
- `wp-block-verse-theme`

### Editor Style Handles

- `wp-block-verse-editor`

### Script Handles

- None

### Editor Script Handles

- None

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Breadcrumbs (`custom/breadcrumbs`)

- `title`: `Breadcrumbs`
- `description`: `Contextual navigation trail for the current view.`
- `origin`: `custom`
- `category_bucket`: `custom`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `widgets`
- `icon`: `ellipsis`
- `render_callback`: `Closure`
- `has_render_callback`: `true`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "html": false
}
```

### Attributes

```json
{
    "showCurrent": {
        "type": "boolean",
        "default": true
    },
    "separator": {
        "type": "string",
        "default": "/"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `d11-blocks-style`

### Editor Style Handles

- None

### Script Handles

- None

### Editor Script Handles

- `d11-blocks-editor`

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

```json
{
    "path": "blocks/breadcrumbs/block.json",
    "block_json": {
        "$schema": "https://schemas.wp.org/trunk/block.json",
        "apiVersion": 3,
        "name": "custom/breadcrumbs",
        "version": "0.1.0",
        "title": "Breadcrumbs",
        "category": "widgets",
        "icon": "ellipsis",
        "description": "Contextual navigation trail for the current view.",
        "textdomain": "d11",
        "attributes": {
            "showCurrent": {
                "type": "boolean",
                "default": true
            },
            "separator": {
                "type": "string",
                "default": "/"
            }
        },
        "supports": {
            "html": false
        },
        "style": "d11-blocks-style",
        "editorScript": "d11-blocks-editor"
    }
}
```

## Social Share (`custom/social-share`)

- `title`: `Social Share`
- `description`: `Social sharing buttons for the current content.`
- `origin`: `custom`
- `category_bucket`: `custom`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `widgets`
- `icon`: `share`
- `render_callback`: `Closure`
- `has_render_callback`: `true`

### Keywords

- None

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "html": false
}
```

### Attributes

```json
{
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `d11-blocks-style`

### Editor Style Handles

- None

### Script Handles

- None

### Editor Script Handles

- `d11-blocks-editor`

### View Script Handles

- `d11-blocks-view`

### View Style Handles

- None

### Custom Metadata

```json
{
    "path": "blocks/social-share/block.json",
    "block_json": {
        "$schema": "https://schemas.wp.org/trunk/block.json",
        "apiVersion": 3,
        "name": "custom/social-share",
        "version": "0.1.0",
        "title": "Social Share",
        "category": "widgets",
        "icon": "share",
        "description": "Social sharing buttons for the current content.",
        "textdomain": "d11",
        "supports": {
            "html": false
        },
        "style": "d11-blocks-style",
        "editorScript": "d11-blocks-editor",
        "viewScript": "d11-blocks-view"
    }
}
```

## Contact Form 7 (`contact-form-7/contact-form-selector`)

- `title`: `Contact Form 7`
- `description`: `Insert a contact form you have created with Contact Form 7.`
- `origin`: `third_party`
- `category_bucket`: `third_party`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `false`
- `api_version`: `3`
- `category`: `widgets`
- `icon`: `null`
- `render_callback`: `null`
- `has_render_callback`: `false`

### Keywords

- `form`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

- None

### Attributes

```json
{
    "id": {
        "type": "integer"
    },
    "hash": {
        "type": "string"
    },
    "title": {
        "type": "string"
    },
    "htmlId": {
        "type": "string"
    },
    "htmlName": {
        "type": "string"
    },
    "htmlTitle": {
        "type": "string"
    },
    "htmlClass": {
        "type": "string"
    },
    "output": {
        "enum": [
            "form",
            "raw_form"
        ],
        "default": "form"
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- None

### Editor Style Handles

- None

### Script Handles

- None

### Editor Script Handles

- `contact-form-7-contact-form-selector-editor-script`
- `contact-form-7-block-editor`

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Cookie Banner (`d11/privacy-banner`)

- `title`: `Cookie Banner`
- `description`: `Displays the theme-managed cookie consent banner.`
- `origin`: `third_party`
- `category_bucket`: `third_party`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `widgets`
- `icon`: `shield`
- `render_callback`: `D11_Privacy::render_banner_block`
- `has_render_callback`: `true`

### Keywords

- `cookie`
- `privacy`
- `consent`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "html": false,
    "multiple": false
}
```

### Attributes

```json
{
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `d11-privacy`

### Editor Style Handles

- None

### Script Handles

- None

### Editor Script Handles

- `d11-privacy-editor`

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

## Cookie Table (`d11/privacy-cookie-table`)

- `title`: `Cookie Table`
- `description`: `Displays the registered cookies as a table or card list.`
- `origin`: `third_party`
- `category_bucket`: `third_party`
- `currently_allowed`: `true`
- `currently_blacklisted`: `false`
- `is_dynamic`: `true`
- `api_version`: `3`
- `category`: `widgets`
- `icon`: `table-col-after`
- `render_callback`: `D11_Privacy::render_cookie_table_block`
- `has_render_callback`: `true`

### Keywords

- `cookie`
- `table`
- `privacy`

### Parent

- None

### Ancestor

- None

### Uses Context

- None

### Provides Context

- None

### Supports Summary

- `anchor`: `false`
- `align`: `false`
- `spacing`: `false`
- `color`: `false`
- `typography`: `false`
- `html`: `false`
- `multiple`: `false`
- `reusable`: `false`

### Supports

```json
{
    "html": false
}
```

### Attributes

```json
{
    "layout": {
        "type": "string",
        "default": "table"
    },
    "category": {
        "type": "string",
        "default": ""
    },
    "showCategory": {
        "type": "boolean",
        "default": true
    },
    "showDuration": {
        "type": "boolean",
        "default": true
    },
    "lock": {
        "type": "object"
    },
    "metadata": {
        "type": "object"
    },
    "className": {
        "type": "string"
    },
    "style": {
        "type": "object"
    }
}
```

### Example

- None

### Selectors

- None

### Style Handles

- `d11-privacy`

### Editor Style Handles

- None

### Script Handles

- None

### Editor Script Handles

- `d11-privacy-editor`

### View Script Handles

- None

### View Style Handles

- None

### Custom Metadata

- None

