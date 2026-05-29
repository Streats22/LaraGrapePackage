# LaraGrape 1.5.0 — Release notes

**Release date:** 29 May 2026  
**Packagist:** `streats22/laragrape:^1.5`

LaraGrape 1.5.0 is a major update to the GrapesJS page builder and Filament admin. You get a stronger editor, optional portfolio CMS, dynamic forms in the block panel, and a smoother install path for new projects.

---

## What’s new

### A better page editor

- **Alpine.js in the canvas** — Animated blocks (heroes, cards, FAQ, pricing, and more) behave in the editor like they do on the live site.
- **Dark mode** — The canvas follows your admin theme.
- **Reliable saves** — Block-specific settings (portfolio picks, tech stack items) are stored and restored correctly via `block_dynamic_data`.
- **Clearer blocks** — Blocks use `data-laragrape-block` so saves and previews stay stable.

### Forms in the builder

Create forms in **Form Builder → Forms**, mark them **Active**, and they appear under **Forms** in the GrapesJS sidebar. Drag them onto a page; submissions work on the live site and in the canvas with AJAX and toast feedback.

### Optional portfolio module

Turn on a full portfolio workflow:

- Manage **Portfolio Projects** in Filament
- Public project pages at `/portfolio/{slug}`
- Blocks: **Animated Portfolio**, **Portfolio Grid**, **Portfolio Teaser**
- Sample projects and a **Portfolio** page when you run setup with portfolio enabled

Enable with:

```bash
php artisan laragrape:setup --portfolio --migrate --all --force
```

Or use `--all` (portfolio is included). Setup sets `LARAGRAPE_PORTFOLIO=true` in your `.env`.

### New blocks

| Category | Examples |
| --- | --- |
| Animated | Hero, full-image hero, cards, FAQ, pricing, stats, testimonials, timeline, tech stack, portfolio |
| Portfolio | Grid, teaser |
| Advanced | Technology stack, animated counter |

Tech stack icons and labels are configurable in `config/laragrape.php`.

### Easier setup

`laragrape:setup --all` now:

- Installs **Filament** (base + admin panel)
- Publishes assets and rewrites code to **`App\`** namespaces in your application
- Runs migrations and seeders
- Enables portfolio and seeds demo content when included

Fresh install:

```bash
composer require streats22/laragrape:^1.5
php artisan laragrape:setup --migrate --all --force
php artisan db:seed
npm install && npm run build
php artisan make:filament-user
```

---

## Requirements

- **PHP** 8.3+
- **Laravel** 10, 11, 12, or 13
- **Filament** 5

---

## Upgrading from 1.4.x

```bash
composer require streats22/laragrape:^1.5
php artisan laragrape:update --assets --services --views --force
php artisan migrate
npm install && npm run build
```

**Portfolio (optional):**

```bash
php artisan laragrape:update --portfolio --force
```

Add to `.env`:

```env
LARAGRAPE_PORTFOLIO=true
```

Then:

```bash
php artisan migrate
php artisan config:clear
```

If you copied package files into your app earlier, remove overrides you no longer customize:

- `resources/js/grapesjs-editor.js`
- `resources/js/form-blocks.js`
- `app/Services/DynamicBlockDataService.php`
- `app/Support/TechStackRegistry.php` (unless you only use config)

---

## Important changes

| Topic | Note |
| --- | --- |
| PHP 8.3 | Required for this release |
| Filament 5 | Admin resources target Filament 5 |
| Namespaces | Published files under `app/` must use `App\`, not `LaraGrape\` |
| Portfolio | Set `LARAGRAPE_PORTFOLIO=true` or portfolio routes will not register |
| Forms in editor | Only **active** forms show in GrapesJS; refresh the editor after creating one |
| Saved pages | Re-save pages in the editor if you relied on old HTML comment block markers |

---

## Bug fixes

- Resolved duplicate class errors after setup when namespaces were not rewritten
- Portfolio blocks no longer fail with missing `portfolio.show` when env was not set
- Forms now appear in the GrapesJS block list after creation
- Fresh installs no longer fail on missing Filament panel paths or `bootstrap.js`
- Improved block preview and nested block rendering

---

## Links

- Full technical list: [CHANGELOG.md](./CHANGELOG.md#150---2026-05-29)
- Documentation: [README.md](./README.md)

---

**Thank you** for using LaraGrape. Report issues on the project repository.
