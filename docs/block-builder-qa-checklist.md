# Block Builder QA checklist (test-laragrape)

For each block: add to a test page in Block Builder, then verify all four steps.

| Step | What to check |
|------|----------------|
| 1 Preview | Changing Filament fields updates the block preview (and fullscreen overlay). |
| 2 Page preview | Stacked page preview below the repeater reflects changes. |
| 3 Save + frontend | Save page, hard refresh public URL — content matches (no `[object Object]` on Alpine blocks). |
| 4 Reload admin | Re-open page — `dynamic_data` / `block_layout` round-trip intact. |

## Catalog blocks

| Block ID | Tier | Notes |
|----------|------|-------|
| animated-testimonials | A | |
| animated-faq | A | |
| animated-pricing | A | Features must render as strings on frontend |
| animated-pricing-clean | A | Same as animated-pricing |
| animated-cards | A | |
| animated-stats | A | |
| animated-progress-bars | A | |
| animated-timeline | A | Static editor preview (no Alpine in preview branch) |
| animated-portfolio | A | Project IDs + card overrides |
| animated-hero | A | |
| animated-full-image-hero | A | |
| animated-tech-stack | A | |
| simple-animated-counter | A | |
| hero | A | |
| button | A | |
| text | A | |
| heading | A | |
| portfolio-grid | A | DB-backed on frontend |
| portfolio-teaser | A | DB-backed on frontend |
| service-showcase | B | Dedicated schema + gjs patch |
| interactive-pricing | B | Reuses pricing schema/patcher |
| technology-stack | B | Title/subtitle patch |
| pricing | B | `plan-feature-*` gjs names |
| card | B | |
| alert | B | |
| testimonial | B | |
| image | B | src/alt/caption |
| video | B | |
| gallery | B | Title only in builder |
| icon | B | |
| spacer | B | Height label |
| divider | B | |
| list | B | |
| quote | B | |
| section | B | |
| grid | B | |
| columns | B | |
| container | B | |
| form-block | — | Use custom_html or skip |
| test-counter / debug-counter | Low | Optional smoke test |

## Frontend fallback

If `blade_content` is empty but `block_layout` is set, layout rendering compiles blocks on the fly (`app.blade.php` and `PageController::renderGrapesJsContent()`).

## Setup command

```bash
cd test-laragrape
composer update streats22/laragrape
php artisan laragrape:setup --all --force
php artisan migrate:fresh --seed
npm run build
php artisan view:clear
```
