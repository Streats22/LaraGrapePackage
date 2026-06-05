# Block Builder capabilities

Single source of truth: `LaraGrape\Support\BlockBuilderSchema::blockRegistry()`.

| Block ID | Dedicated schema | Live HTML patch | Dynamic Blade (`$dynamicData`) | Live normalizer |
|----------|------------------|-----------------|--------------------------------|-----------------|
| animated-testimonials | Yes | Yes | Yes | — |
| animated-faq | Yes | Yes | Yes | — |
| animated-pricing | Yes | Yes | Yes | pricing |
| animated-pricing-clean | Yes | Yes | Yes | pricing |
| animated-cards | Yes | Yes | Yes | — |
| animated-stats | Yes | Yes | Yes | — |
| simple-animated-counter | Yes | Yes | No | — |
| animated-timeline | Yes | Yes | Yes | — |
| animated-progress-bars | Yes | Yes | Yes | — |
| animated-portfolio | Yes | Yes | Yes | portfolio |
| animated-hero | Yes | Yes | Yes | — |
| animated-full-image-hero | Yes | Yes | Yes | — |
| animated-tech-stack | Yes | Yes | Yes | — |
| hero | Yes | Yes | No | — |
| button | Yes | Yes | No | — |
| text | Yes | Yes | No | — |
| heading | Yes | Yes | No | — |
| portfolio-grid | Yes | Yes | No | — |
| portfolio-teaser | Yes | Yes | No | — |
| service-showcase | Yes | Yes | No | — |
| interactive-pricing | Yes | Yes | No | pricing |
| technology-stack | Yes | Yes | No | — |
| pricing | Yes | Yes | No | pricing |
| card | Yes | Yes | No | — |
| alert | Yes | Yes | No | — |
| testimonial | Yes | Yes | No | — |
| image | Yes | Yes | No | — |
| video | Yes | Yes | No | — |
| gallery | Yes | Yes | No | — |
| icon | Yes | Yes | No | — |
| spacer | Yes | Yes | No | — |
| divider | Yes | Yes | No | — |
| list | Yes | Yes | No | — |
| quote | Yes | Yes | No | — |
| section | Yes | Yes | No | — |
| grid | Yes | Yes | No | — |
| columns | Yes | Yes | No | — |
| container | Yes | Yes | No | — |
| Other catalog blocks | Generic (title/body/button/custom_html) | Generic patch | Varies | — |

Helper methods derived from the registry:

- `fieldsFor()` — Filament form fields per block
- `blocksWithLivePreviewPatch()` — blocks that run `BlockHtmlPatcher::patchForBlockBuilder()`
- `supportsLivePreviewPatch()` — used in `BlockService::renderBlockPreviewForBuilder()`
- `dynamicBladeBlocks()` — blocks that use Alpine/`$dynamicData` on the public site
- `normalizeDynamicDataForLiveRender()` — flattens repeater `{text: ...}` shapes before Blade `var_export`
