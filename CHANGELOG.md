# Changelog

All notable changes to LaraGrape are documented in this file.

## [1.5.0] - 2026-05-29

### Overview

Major release for the visual page builder, GrapesJS editor, and Filament admin. Adds optional portfolio support, an expanded block library, dynamic form blocks in the editor, and a more reliable save pipeline for block-specific data.

### Requirements

| Dependency | Version |
| --- | --- |
| PHP | `^8.3` |
| Laravel | 10, 11, 12, or 13 |
| Filament | `^5.0` |

---

### Added

#### Platform

- Filament 5 support
- Laravel 13 support (`illuminate/support` `^13.0`)
- PHP 8.3 minimum

#### GrapesJS editor

- Alpine.js in the canvas iframe for animated blocks (`x-data`, `x-intersect`, etc.)
- Animated portfolio block with per-card portfolio project ID traits
- Animated tech stack block with configurable tech picker (`config/laragrape.tech_stack`)
- Portfolio block data dialog when portfolio is enabled
- Canvas dark mode synced with admin theme
- Block preview via `/admin/block-preview?id={blockId}`
- `syncToFormBeforeSubmit` before saving page content

#### Save pipeline

- `DynamicBlockDataService` for per-block dynamic data (portfolio slots, tech items, etc.)
- `block_dynamic_data` storage in `GrapesJsConverterService`
- Stale CSRF token stripping from saved HTML
- Dynamic data passed into `@include` when rendering blocks
- `data-laragrape-block` attributes on blocks (replaces HTML comment markers)

#### Frontend forms

- `form-blocks.js` — AJAX validation, submission, and toasts for `.dynamic-form`
- Works on live pages and inside the GrapesJS canvas
- Integrated in `resources/js/app.js`

#### Optional portfolio module

- `portfolio_projects` table, model, and migrations
- Filament Portfolio Projects resource
- Public route `portfolio.show` (`/portfolio/{slug}`)
- Blocks: Animated Portfolio, Portfolio Grid, Portfolio Teaser
- `PortfolioProjectSeeder` and Portfolio CMS page when portfolio is enabled
- `LARAGRAPE_PORTFOLIO` env flag and `laragrape.portfolio_enabled` config

#### Blocks

**Animated**

- Animated hero
- Animated full-image hero
- Animated cards
- Animated FAQ
- Animated pricing (+ clean variant)
- Animated progress bars
- Animated stats
- Animated testimonials
- Animated timeline
- Animated tech stack
- Animated portfolio

**Portfolio**

- Portfolio grid
- Portfolio teaser

**Advanced**

- Technology stack
- Simple animated counter

**Other**

- Refreshed content, layout, and media blocks
- `TechStackRegistry` for editor and block configuration

#### Admin (Filament)

- Header, footer, and menu configuration resources and models
- Form builder resources (forms, fields, submissions)
- Block preview improvements (query `id` or path parameter)

#### Configuration

- `config/laragrape.php` — `debug`, `portfolio_enabled`, `tech_stack` defaults

#### Commands

- `laragrape:setup --all` installs Filament (base + panels) non-interactively
- `laragrape:setup --portfolio` publishes portfolio module and sets `LARAGRAPE_PORTFOLIO=true`
- `laragrape:update --portfolio` updates the portfolio module
- Namespace post-processing: published `app/` code rewritten from `LaraGrape\` to `App\`
- Route post-processing for `routes/web.php` and `routes/portfolio.php`
- Seeds portfolio page and sample projects when portfolio is enabled

---

### Changed

- README updated for Filament 5 and Laravel 12+
- `composer.json` version set to `1.5.0`
- Custom blocks: `html_content` nullable with safer defaults
- Block rendering uses `data-laragrape-block` and improved Blade resolution
- Active forms appear in GrapesJS under the **Forms** category (via `BlockService`)

---

### Fixed

- Duplicate class errors when published controllers kept `LaraGrape\` namespace
- `portfolio.show` route missing when portfolio was published but env flag was not set
- Forms not appearing in GrapesJS block panel (`BlockService` + `FormService` binding)
- Vite build failing when `bootstrap.js` was not published
- `AdminPanelProvider` setup crash on fresh installs without Filament panels directory
- Block preview and dynamic Blade includes for nested block paths

---

### Upgrade

```bash
composer require streats22/laragrape:^1.5
php artisan laragrape:update --assets --services --views --force
php artisan migrate
npm install && npm run build
```

**Optional portfolio:**

```bash
php artisan laragrape:update --portfolio --force
```

```env
LARAGRAPE_PORTFOLIO=true
```

```bash
php artisan migrate
php artisan config:clear
php artisan db:seed --class=Database\\Seeders\\PortfolioProjectSeeder
```

**Review overrides** (remove if not customized):

- `resources/js/grapesjs-editor.js`
- `resources/js/form-blocks.js`
- `app/Services/DynamicBlockDataService.php`
- `app/Support/TechStackRegistry.php`

---

### Breaking changes

| Change | Action required |
| --- | --- |
| PHP `^8.3` | Upgrade PHP |
| Filament `^5.0` | Upgrade Filament admin |
| Published code uses `App\` namespace | Re-run setup or fix namespaces in `app/` |
| `data-laragrape-block` markers | Re-save pages in editor if needed |
| Portfolio routes need `LARAGRAPE_PORTFOLIO=true` | Set env and `config:clear` |
| Forms in editor need `is_active` | Enable form and refresh editor |

---

### Test plan

- [ ] `php artisan laragrape:setup --migrate --all --force` on a fresh Laravel app
- [ ] Homepage returns HTTP 200
- [ ] `/portfolio` returns HTTP 200 with portfolio enabled
- [ ] `LARAGRAPE_PORTFOLIO=true` in `.env` after setup with `--all`
- [ ] Create active form → visible under **Forms** in page editor (after refresh)
- [ ] Animated portfolio / tech stack blocks save and render on frontend
- [ ] Dynamic form submit on live page shows toast
- [ ] Filament Forms and Portfolio Projects lists show records
- [ ] `npm run build` succeeds
