# wptheme-kevinpirnie

[![Last Commit](https://img.shields.io/github/last-commit/kpirnie/wptheme-kevinpirnie?style=for-the-badge&labelColor=000&logoColor=white&logo=data:image/svg%2Bxml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSIxLjgiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHJlY3QgeD0iMyIgeT0iNC41IiB3aWR0aD0iMTgiIGhlaWdodD0iMTYuNSIgcng9IjIiLz48bGluZSB4MT0iMyIgeTE9IjkuNSIgeDI9IjIxIiB5Mj0iOS41Ii8+PGxpbmUgeDE9IjgiIHkxPSIyLjUiIHgyPSI4IiB5Mj0iNi41Ii8+PGxpbmUgeDE9IjE2IiB5MT0iMi41IiB4Mj0iMTYiIHkyPSI2LjUiLz48L3N2Zz4=)](https://github.com/kpirnie/wptheme-kevinpirnie/commits/main)
[![License: MIT](https://img.shields.io/badge/License-MIT-orange.svg?style=for-the-badge&logo=opensourceinitiative&logoColor=white&labelColor=000)](LICENSE)
[![WordPress](https://img.shields.io/badge/Min.%20WP-7.0-3858e9?logo=wordpress&logoColor=white&style=for-the-badge&labelColor=000)](https://wordpress.org)
[![Kevin Pirnie](https://img.shields.io/badge/-KevinPirnie.com-000d2d?style=for-the-badge&labelColor=000&logoColor=white&logo=data:image/svg%2Bxml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSIxLjgiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+CiAgPGNpcmNsZSBjeD0iMTIiIGN5PSIxMiIgcj0iMTAiLz4KICA8ZWxsaXBzZSBjeD0iMTIiIGN5PSIxMiIgcng9IjQuNSIgcnk9IjEwIi8+CiAgPGxpbmUgeDE9IjIiIHkxPSIxMiIgeDI9IjIyIiB5Mj0iMTIiLz4KICA8bGluZSB4MT0iNC41IiB5MT0iNi41IiB4Mj0iMTkuNSIgeTI9IjYuNSIvPgogIDxsaW5lIHgxPSI0LjUiIHkxPSIxNy41IiB4Mj0iMTkuNSIgeTI9IjE3LjUiLz4KPC9zdmc+Cg==)](https://kevinpirnie.com/)

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
