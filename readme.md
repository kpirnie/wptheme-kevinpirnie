# wptheme-kevinpirnie

Personal WordPress theme for [kevinpirnie.com](https://kevinpirnie.com): a dark theme built on Tailwind with a focus on performance.

---

## Requirements

- WordPress 6.8+
- PHP 8.4+
- Composer (build only)
- Node.js (build only)

---

## Installation

1. Download the latest release zip from [Releases](https://github.com/kpirnie/wptheme-kevinpirnie/releases)
2. Upload it under **Appearance → Themes → Add New → Upload Theme**
3. Activate it

---

## Build

```bash
composer install
npm install
npm run build
```

Outputs:
- `assets/css/theme.min.css`: Tailwind plus the FontAwesome SVG icons, minified
- `assets/js/theme.min.js`: the frontend modules, concatenated and minified

```bash
npm run build:tw          # Tailwind only
npm run build:minify-js   # esbuild only
```

---

## Release

Every push to `main` builds a zip and publishes it as a GitHub Release tagged from the `Version:` header in `style.css`. If that version's release already exists, it gets replaced.

These files are left out of the zip: `.github/`, `.gitignore`, `composer.json`, `esbuild.config.js`, `package.json`, `tailwind.config.js`.

---

## Features

### Custom Post Types
| CPT | Purpose |
|---|---|
| `kpt_portfolio` | Portfolio items |
| `kpt_cta` | Calls to action |
| `kpt_hero` | Page heroes / carousel |
| `kpt_contact` | Contact form submissions (with a spam toggle) |

### Blocks
- `kpt/portfolio-block`
- `kpt/cta-block`
- `kpt/contact-form-block`

### Shortcodes
- `[add_social_menu]`: renders the Social menu

### Menus
- Primary Menu
- Top Header Menu
- Social Menu
- Footer Bottom Menu

### Widget Areas
- Footer Column 1
- Footer Column 2
- Footer Column 3

### Settings
- reCAPTCHA site/secret keys for the contact form
- Hero page assignment and secondary titles
- Portfolio URL

Settings are built on [kpt-wpfieldframework](https://github.com/kevinpirnie/kpt-wpfieldframework).

---

## License

[MIT](LICENSE)
