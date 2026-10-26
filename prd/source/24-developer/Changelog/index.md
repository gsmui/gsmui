# Changelog

> PRD — Volume 24: Developer Guide — Changelog

## Overview

This document defines the changelog format, release categories, and linked issues for the gsmui platform.

## Changelog Format

### Standard Format

```markdown
# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/),
and this project adheres to [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Added
- Feature X description (#issue-number)
- Feature Y description (#issue-number)

### Changed
- Change X description (#issue-number)

### Deprecated
- Deprecation X description (#issue-number)

### Removed
- Removal X description (#issue-number)

### Fixed
- Fix X description (#issue-number)

### Security
- Security fix X description (#issue-number)
```

## Release Categories

| Category | Description | Example |
|----------|-------------|---------|
| **Added** | New features | New page builder component |
| **Changed** | Changes to existing functionality | Updated API response format |
| **Deprecated** | Soon-to-be removed features | `Flux::` facade deprecated |
| **Removed** | Removed features | Removed legacy config format |
| **Fixed** | Bug fixes | Fixed meta description saving |
| **Security** | Security improvements | Updated authentication flow |

## Changelog Entries

### Entry Format

```markdown
### Category

- Short description of change (#issue-number) [@contributor]
```

### Examples

```markdown
### Added

- Page Builder with drag-and-drop block support (#123) [@john-doe]
- SEO meta editor with live preview (#124) [@jane-smith]
- Media library with image editing (#125)

### Changed

- Updated Livewire to version 3.0 (#130)
- Improved page loading performance by 40% (#131)

### Fixed

- Fixed issue where meta descriptions were not saving (#140)
- Resolved image upload timeout on slow connections (#141)

### Security

- Updated authentication to prevent session fixation (#150)
```

## Release History

### [2.0.0] - 2026-07-15

#### Added

- Page Builder with drag-and-drop block support (#123)
- SEO tools with meta editor, sitemap, robots.txt (#124)
- Media library with image editing and collections (#125)
- Newsletter system with campaign editor (#126)
- Showcase/portfolio system (#127)
- Menu builder with mega menu support (#128)
- Category management with hierarchy (#129)

#### Changed

- Renamed `Flux::` to `Gsmui::` facade (#130)
- Updated CSS variables from `--flux-*` to `--gsmui-*` (#131)
- Updated component prefix from `flux:` to `gsmui:` (#132)
- Minimum PHP version now 8.2 (#133)
- Updated Livewire to version 3.0 (#134)

#### Fixed

- Fixed meta descriptions not saving correctly (#140)
- Resolved image upload timeout issues (#141)
- Corrected date formatting in blog posts (#142)
- Fixed SEO sitemap generation for large sites (#143)

#### Security

- Updated authentication flow to prevent session fixation (#150)
- Added CSP headers for all responses (#151)

### [1.8.0] - 2026-06-01

#### Added

- Added `Gsmui::` facade as alias for `Flux::` (#100)
- Added `gsmui:` component prefix as alias for `flux:` (#101)
- Added `--gsmui-*` CSS variable aliases (#102)

#### Deprecated

- `Flux::` facade deprecated, use `Gsmui::` (#103)
- `flux:` prefix deprecated, use `gsmui:` (#104)
- `--flux-*` CSS variables deprecated, use `--gsmui-*` (#105)

#### Fixed

- Fixed button hover state on Safari (#110)
- Resolved modal focus trap issue (#111)

### [1.7.0] - 2026-04-15

#### Added

- Added date picker component (#80)
- Added select component with search (#81)
- Added slider component (#82)

#### Fixed

- Fixed dropdown positioning on scroll (#90)
- Resolved input validation error display (#91)

### [1.6.0] - 2026-02-01

#### Added

- Added modal component (#60)
- Added dropdown component (#61)
- Added tooltip component (#62)

#### Changed

- Updated button component styling (#63)
- Improved component accessibility (#64)

## Linked Issues

### Issue Reference Format

| Reference | Description |
|-----------|-------------|
| `#123` | Links to issue #123 |
| `@john-doe` | Credits contributor |
| `Closes #123` | Auto-closes issue on merge |
| `Fixes #123` | Auto-fixes issue on merge |

### Auto-Linking

```markdown
# In commit message
fix(blog): correct meta description saving

Fixes #140

# In PR description
Closes #123, Closes #124
```

## Changelog Automation

### GitHub Actions

```yaml
name: Generate Changelog

on:
  release:
    types: [created]

jobs:
  changelog:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
        with:
          fetch-depth: 0
      - name: Generate Changelog
        uses: orhun/git-cliff@v1
        with:
          config: cliff.toml
          args: --latest
          output: CHANGELOG.md
      - name: Commit
        run: |
          git config --local user.email "action@github.com"
          git config --local user.name "GitHub Action"
          git add CHANGELOG.md
          git commit -m "docs: update changelog"
          git push
```

## Acceptance Criteria

- [ ] Changelog follows Keep a Changelog format
- [ ] All changes are categorized correctly
- [ ] Issue numbers are linked to GitHub
- [ ] Contributors are credited
- [ ] Breaking changes are highlighted
- [ ] Release dates are included
- [ ] Changelog is auto-generated on release
- [ ] Entry format is consistent
- [ ] Security fixes are marked appropriately
- [ ] Deprecation notices are clear
