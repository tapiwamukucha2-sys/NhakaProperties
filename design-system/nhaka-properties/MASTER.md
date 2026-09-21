# Design System Master File

> **LOGIC:** When building a specific page, first check `design-system/pages/[page-name].md`.
> If that file exists, its rules **override** this Master file.
> If not, strictly follow the rules below.

---

> ### ⚠ READ THIS FIRST — the sections below are the *generated* baseline.
> Where this box and the generated sections disagree, **this box wins**. It records what is
> actually implemented in `resources/views/layouts/site.blade.php` and `resources/css/app.css`.

## As Implemented (authoritative)

Nhaka already had a coherent identity before this system was generated, and it was kept.
Three generated recommendations were deliberately **not** adopted:

| Generated | Implemented | Why |
|---|---|---|
| Cinzel / Josefin Sans | **Fraunces / Archivo** | Cinzel is an all-caps Roman inscriptional face — it reads poorly at UI sizes. Josefin Sans has a small x-height that hurts body legibility. Fraunces (variable optical size) + Archivo carry the same premium tone and stay readable in listing cards. |
| Teal `#0F766E` + `#F0FDFA` ground | **Navy `#123A6B` + gold `#C08A28` on `#F2F5F9`** | The navy/gold pairing was the existing brand and reads as "trust + property" at least as well. Changing it would have cost brand recognition for no measurable gain. |
| Glassmorphism | **Soft layered elevation** (`--sh-1/2/3`) | Frosted panels over listing photography fight text contrast (the style's own rating is `risk:conditional`), and `backdrop-filter` is expensive on the low-end Android hardware that dominates the Zimbabwe market. |

**Kept from the generated system:** the Hero-Centric pattern, the sticky-nav CTA, the standard
motion tier (scroll stagger, 300–450ms), the standard density spacing scale, and the
pre-delivery accessibility checklist.

### Token source of truth
Tokens live in `:root` in `resources/views/layouts/site.blade.php` (public site) and are
mirrored in `resources/css/app.css` (Tailwind dashboard/admin side). **Keep the two in sync.**
`tailwind.config.js` re-exports them as utilities (`text-ink-soft`, `bg-paper-raised`,
`shadow-brand-2`, `font-brand`, …).

| Group | Tokens |
|---|---|
| Brand | `--ink` `--paper` `--paper-2` `--forest` `--forest-dark` `--gold` `--gold-light` `--brick` |
| Text (all ≥ 4.5:1) | `--ink-soft` (6.4:1) `--ink-mute` (5.9:1) `--on-dark-soft` `--on-dark-mute` |
| Line / tint | `--line` `--line-strong` `--tint-forest` `--tint-gold` |
| Spacing | `--space-1`…`--space-7` (4 → 64px) |
| Radius | `--r-sm` `--r-md` `--r-lg` `--r-xl` `--r-pill` |
| Elevation | `--sh-1` `--sh-2` `--sh-3` `--sh-gold` |
| Motion | `--ease` `--ease-out-back` `--dur-1/2/3` (160/240/380ms) |

### Rules that are load-bearing
- **Gold is the conversion colour.** `.btn-gold` is for the single primary CTA (nav "Get Started",
  hero search). Navy `.btn-primary` is for everything else. Do not add a third gold button to a view.
- **Never write a raw hex in a component.** Use a token; add one if it is missing.
- **Focus rings are non-negotiable.** `:focus-visible` is defined globally in both stylesheets.
  Never write a bare `outline:none` — use `:focus:not(:focus-visible)`.
- **Motion is opt-out.** Every animation sits behind `prefers-reduced-motion`. Above-the-fold
  content uses `.reveal-now` (animates on load); below-the-fold uses `.reveal` (IntersectionObserver).
  `.reveal` starts at `opacity:0`, so it must never wrap content that has to survive JS failing —
  the `no-js` → `js` swap in `<head>` guards this.
- **Touch targets are 44×44 minimum** (buttons, chips, pagination, social icons, share row).
- **Listing images:** grid thumbnails are `loading="lazy" decoding="async"` with explicit
  `width`/`height`; the listing-detail hero is `fetchpriority="high"` and never lazy (it is the LCP).

---

**Project:** Nhaka Properties
**Generated:** 2026-09-21 22:45:44
**Category:** Real Estate/Property
**Design Dials:** Variance 4/10 (Balanced / Modern) | Motion 4/10 (Standard) | Density 5/10 (Standard)

---

## Global Rules

### Color Palette

| Role | Hex | CSS Variable |
|------|-----|--------------|
| Primary | `#0F766E` | `--color-primary` |
| On Primary | `#FFFFFF` | `--color-on-primary` |
| Secondary | `#14B8A6` | `--color-secondary` |
| On Secondary | `#0F172A` | `--color-on-secondary` |
| Accent/CTA | `#0369A1` | `--color-accent` |
| On Accent/CTA | `#FFFFFF` | `--color-on-accent` |
| Background | `#F0FDFA` | `--color-background` |
| Foreground | `#134E4A` | `--color-foreground` |
| Card | `#FFFFFF` | `--color-card` |
| Card Foreground | `#134E4A` | `--color-card-foreground` |
| Muted | `#E8F0F3` | `--color-muted` |
| Muted Foreground | `#475569` | `--color-muted-foreground` |
| Border | `#99F6E4` | `--color-border` |
| Destructive | `#DC2626` | `--color-destructive` |
| On Destructive | `#FFFFFF` | `--color-on-destructive` |
| Ring | `#0F766E` | `--color-ring` |

**Color Notes:** Trust teal + professional blue

### Typography

- **Heading Font:** Cinzel
- **Body Font:** Josefin Sans
- **Mood:** real estate, luxury, elegant, sophisticated, property, premium
- **Google Fonts:** [Cinzel + Josefin Sans](https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Josefin+Sans:wght@300;400;500;600;700&display=swap)

**CSS Import:**
```css
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Josefin+Sans:wght@300;400;500;600;700&display=swap');
```

### Spacing Variables

*Density: 5/10 — Standard*

| Token | Value | Usage |
|-------|-------|-------|
| `--space-xs` | `4px` / `0.25rem` | Tight gaps |
| `--space-sm` | `8px` / `0.5rem` | Icon gaps, inline spacing |
| `--space-md` | `16px` / `1rem` | Standard padding |
| `--space-lg` | `24px` / `1.5rem` | Section padding |
| `--space-xl` | `32px` / `2rem` | Large gaps |
| `--space-2xl` | `48px` / `3rem` | Section margins |
| `--space-3xl` | `64px` / `4rem` | Hero padding |

### Shadow Depths

| Level | Value | Usage |
|-------|-------|-------|
| `--shadow-sm` | `0 1px 2px rgba(0,0,0,0.05)` | Subtle lift |
| `--shadow-md` | `0 4px 6px rgba(0,0,0,0.1)` | Cards, buttons |
| `--shadow-lg` | `0 10px 15px rgba(0,0,0,0.1)` | Modals, dropdowns |
| `--shadow-xl` | `0 20px 25px rgba(0,0,0,0.15)` | Hero images, featured cards |

---

## Component Specs

### Buttons

```css
/* Primary Button */
.btn-primary {
  background: #0369A1;
  color: white;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  transition: all 200ms ease;
  cursor: pointer;
}

.btn-primary:hover {
  opacity: 0.9;
  transform: translateY(-1px);
}

/* Secondary Button */
.btn-secondary {
  background: transparent;
  color: #0F766E;
  border: 2px solid #0F766E;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  transition: all 200ms ease;
  cursor: pointer;
}
```

### Cards

```css
.card {
  background: #F0FDFA;
  border-radius: 12px;
  padding: 24px;
  box-shadow: var(--shadow-md);
  transition: all 200ms ease;
  cursor: pointer;
}

.card:hover {
  box-shadow: var(--shadow-lg);
  transform: translateY(-2px);
}
```

### Inputs

```css
.input {
  padding: 12px 16px;
  border: 1px solid #E2E8F0;
  border-radius: 8px;
  font-size: 16px;
  transition: border-color 200ms ease;
}

.input:focus {
  border-color: #0F766E;
  outline: none;
  box-shadow: 0 0 0 3px #0F766E20;
}
```

### Modals

```css
.modal-overlay {
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
}

.modal {
  background: white;
  border-radius: 16px;
  padding: 32px;
  box-shadow: var(--shadow-xl);
  max-width: 500px;
  width: 90%;
}
```

---

## Style Guidelines

**Style:** Glassmorphism

**Keywords:** Frosted glass, transparent, blurred background, layered, vibrant background, light source, depth, multi-layer

**Best For:** Modern SaaS, financial dashboards, high-end corporate, lifestyle apps, modal overlays, navigation

**Key Effects:** Backdrop blur (10-20px), subtle border (1px solid rgba white 0.2), light reflection, Z-depth

### Page Pattern

**Pattern Name:** Hero-Centric Design

- **Conversion Strategy:** One primary CTA. Let the hero dominate the initial viewport without hiding the next content cue. Use a static hero and non-pulsing CTA when reduced motion is requested; provide video controls. Pause hero media offscreen/hidden and keep the final hero message and CTA static under reduced motion.
- **CTA Placement:** Hero dominant (center/bottom) + Sticky nav CTA
- **Section Order:** Full-bleed Hero (headline + visual) > Single value prop strip > Key benefit or proof > Primary CTA

---

## Motion

**Stagger List** (Standard) — Trigger: load or scroll | Duration: 300-450ms | Easing: `back.out(1.4)`

```js
gsap.from('.grid-item', { opacity: 0, scale: 0.92, y: 16, duration: 0.4, stagger: { each: 0.06, from: 'start', grid: 'auto' }, ease: 'back.out(1.4)' });
```

**Framework notes:** grid: 'auto' lets GSAP infer rows/columns from a CSS grid layout for a natural wave stagger; Use matchMedia('(prefers-reduced-motion: reduce)') to skip non-essential motion and render the final state immediately

- ✅ Combine with from: 'center' for a bento-grid layout to draw the eye inward first
- ❌ Don't use back.out on dense data tables; the overshoot reads as sloppy on informational UI
- ⚡ Group DOM writes; avoid interleaving layout reads (getBoundingClientRect) between staggered tweens

---

## Anti-Patterns (Do NOT Use)

- ❌ Poor photos
- ❌ No virtual tours

### Additional Forbidden Patterns

- ❌ **Emojis as icons** — Use SVG icons (Heroicons, Lucide, Simple Icons)
- ❌ **Missing cursor:pointer** — All clickable elements must have cursor:pointer
- ❌ **Layout-shifting hovers** — Avoid scale transforms that shift layout
- ❌ **Low contrast text** — Maintain 4.5:1 minimum contrast ratio
- ❌ **Instant state changes** — Always use transitions (150-300ms)
- ❌ **Invisible focus states** — Focus states must be visible for a11y

---

## Pre-Delivery Checklist

Before delivering any UI code, verify:

- [ ] No emojis used as icons (use SVG instead)
- [ ] All icons from consistent icon set (Heroicons/Lucide)
- [ ] `cursor-pointer` on all clickable elements
- [ ] Hover states with smooth transitions (150-300ms)
- [ ] Light mode: text contrast 4.5:1 minimum
- [ ] Focus states visible for keyboard navigation
- [ ] `prefers-reduced-motion` respected
- [ ] Responsive: 375px, 768px, 1024px, 1440px
- [ ] No content hidden behind fixed navbars
- [ ] No horizontal scroll on mobile
