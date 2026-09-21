# Nhaka Properties

Property listing marketplace for Zimbabwe — rentals, sales, stands and commercial space.
Landlords and agents submit listings, an admin approves them, and the public browses them.

- **Live:** https://nhaka-properties.onrender.com
- **Repo:** https://github.com/tapiwamukucha2-sys/NhakaProperties
- **Stack:** Laravel 13 / PHP 8.3 · Blade · Tailwind + Alpine · Vite · Postgres (prod) · Docker on Render

---

## Running it locally

```sh
composer install && npm install
cp .env.example .env && php artisan key:generate   # first time only
php artisan migrate
npm run build            # or: npm run dev
php artisan serve --port=8001
```

Admin panel is at `/admin/login` (separate from the customer login at `/login`).

---

## Architecture

| Path | What lives there |
|---|---|
| `app/Models/` | `Property`, `User`, `Subscription`, `HeroSlide`, `SiteSetting`, `NewsletterSubscriber` |
| `app/Http/Controllers/` | Public: `Home`, `Browse`, `Listing`, `Page`, `Sitemap`, `Newsletter`. Authed: `Property`, `Profile`, `Subscription`. `Admin/` is the CMS. |
| `routes/web.php` | Public + authed routes. `routes/auth.php` is Breeze scaffolding. |
| `resources/views/layouts/` | `site` (public), `app` (dashboard), `admin` (CMS), `navigation` (dashboard nav) |

### Two styling systems — know which one you are in

This trips people up. The project deliberately runs both:

1. **Public site** (`layouts/site.blade.php`) — hand-written CSS in a single `<style>` block.
   Home, browse, listing detail, agents, about, map, legal pages. Tailwind classes do **not**
   apply here.
2. **Dashboard + admin** (`layouts/app.blade.php`, `layouts/admin.blade.php`) — Tailwind
   utilities, compiled from `resources/css/app.css` through Vite.

Both read the same CSS custom properties, so the two halves stay visually consistent.

---

## Design system

**`design-system/nhaka-properties/MASTER.md` is the reference — read the
"As Implemented (authoritative)" box at the top and ignore the generated sections
below it where they disagree.** The generated baseline proposed Cinzel/Josefin Sans, a teal
palette and Glassmorphism; none of that was adopted, and the box explains why.

Identity: **navy `#123A6B` + gold `#C08A28`**, headings in **Fraunces**, body in **Archivo**.

### Tokens live in three places and must stay in sync

| File | Role |
|---|---|
| `resources/views/layouts/site.blade.php` `:root` | Source of truth (public site) |
| `resources/css/app.css` `:root` | Mirror for the Tailwind side |
| `tailwind.config.js` | Re-exports them as utilities (`text-ink-soft`, `shadow-brand-2`, `font-brand`, …) |

Adding or changing a token means editing all three.

### Rules that are load-bearing

- **Never write a raw hex in a component.** Use a token; add one if it is missing.
- **Gold is the conversion colour.** `.btn-gold` is for the single primary CTA (nav "Get Started",
  hero search). Navy `.btn-primary` for everything else. Don't add a third gold button to a view.
- **Never write a bare `outline:none`.** A global `:focus-visible` ring is defined in both
  stylesheets; suppress pointer focus with `:focus:not(:focus-visible)` only.
- **All motion sits behind `prefers-reduced-motion`.**
  - Above the fold → `.reveal-now` (animates on load).
  - Below the fold → `.reveal` (IntersectionObserver adds `.in`).
  - `.reveal` starts at `opacity:0`, so never wrap content in it that must survive JS failing.
    The `no-js` → `js` swap in `<head>` is what guards this — don't move it to the end of `<body>`.
- **Touch targets are 44×44 minimum** — buttons, chips, pagination, social icons, share row.
- **Listing images:** grid thumbnails get `loading="lazy" decoding="async"` plus explicit
  `width`/`height`. The listing-detail hero is the LCP — it gets `fetchpriority="high"` and is
  never lazy.
- **Icons are inline SVG.** No emoji, no icon fonts.

---

## Deploying

Push to `main`. Render builds `Dockerfile` per `render.yaml` and redeploys automatically.
Health check is `/up`.

### Gotchas that have bitten before

- **Uploaded photos do not survive a redeploy.** Render's free tier has no persistent disk.
  `render.yaml` sets `FILESYSTEM_DISK=r2` expecting Cloudflare R2, but the `AWS_*` values are
  `sync: false` — they must be set by hand in the Render dashboard. `config/filesystems.php`
  only switches the `public` disk to S3/R2 when `FILESYSTEM_DISK === 'r2'`, and that disk is
  configured with `throw => false, report => false`, so **a missing bucket fails silently rather
  than erroring**. If uploads vanish in production, check those env vars first.
- Render's free tier sleeps. The first request after idle takes ~50s.
- The app sits behind Render's proxy; `TrustProxies` is already configured so HTTPS is detected.

---

## Payments

Subscriptions are **manually verified**, on purpose. A user submits a plan, a payment method and a
transaction reference; an admin confirms it in the admin panel, which unlocks their `listing_limit`.

Automatic activation is blocked on Paynow (their signup endpoint returns a server error on their
side). Don't build the auto-activation path speculatively, and don't remove the admin approval
step — it is the fraud control.

---

## Conventions

- Match the surrounding style rather than introducing a new one — the public CSS is plain
  hand-written CSS, not utilities.
- Listing queries must stay paginated. An unpaginated browse page has already broken once.
- Contact links (WhatsApp/phone) must resolve to **the user who posted the listing**, never a
  hardcoded number. That was a real bug.
- Don't display invented stats, agents or testimonials. Pull real counts, or label an example
  honestly as an example.
