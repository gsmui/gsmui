# Release Process

> PRD — Volume 24: Developer Guide — Release Process

## Overview

This document defines the release process for the gsmui platform including versioning (SemVer), release notes, changelog, tagging, and publishing.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Versioning | SemVer compliance | 100% |
| Release notes | Completeness | 100% |
| Changelog | Up-to-date entries | 100% |
| Tagging | Consistent tags | 100% |
| Publishing | Successful releases | 100% |

## Semantic Versioning

### Version Format

```
MAJOR.MINOR.PATCH
```

| Component | When to Increment | Example |
|-----------|-------------------|---------|
| MAJOR | Breaking changes | 1.0.0 → 2.0.0 |
| MINOR | New features (backward compatible) | 1.0.0 → 1.1.0 |
| PATCH | Bug fixes (backward compatible) | 1.0.0 → 1.0.1 |

### Pre-release Versions

| Type | Format | Example |
|------|--------|---------|
| Alpha | `MAJOR.MINOR.PATCH-alpha.N` | 2.0.0-alpha.1 |
| Beta | `MAJOR.MINOR.PATCH-beta.N` | 2.0.0-beta.1 |
| Release Candidate | `MAJOR.MINOR.PATCH-rc.N` | 2.0.0-rc.1 |

### Version Decision Tree

```
Is it a breaking change?
├── Yes → MAJOR increment
└── No → Is it a new feature?
    ├── Yes → MINOR increment
    └── No → Is it a bug fix?
        ├── Yes → PATCH increment
        └── No → No version change
```

## Release Notes

### Template

```markdown
# Release v2.0.0

## 🚀 New Features

- **Page Builder**: Drag-and-drop page builder with block support
- **SEO Tools**: Meta editor, sitemap, robots.txt management
- **Media Library**: Upload, organize, and edit images

## 🐛 Bug Fixes

- Fixed issue where meta descriptions were not saving
- Resolved image upload timeout on slow connections
- Corrected date formatting in blog posts

## 💥 Breaking Changes

- Minimum PHP version is now 8.2
- Removed deprecated `Flux::` facade (use `Gsmui::`)
- Renamed CSS variables from `--flux-*` to `--gsmui-*`

## 📦 Dependencies

- Updated Laravel to 11.0
- Updated Livewire to 3.0
- Updated Alpine.js to 3.13

## 🔧 Configuration

New config options added:
- `gsmui.components` - Component registration
- `gsmui.themes` - Theme configuration

Run: `php artisan vendor:publish --tag=gsmui-config`

## 📝 Migration Guide

1. Update `composer.json` to require `gsmui/gsmui-pro: ^2.0`
2. Replace `Flux::` with `Gsmui::` throughout
3. Update CSS variables from `--flux-*` to `--gsmui-*`
4. Run `php artisan vendor:publish --tag=gsmui-config`

## 🙏 Contributors

Thanks to all contributors who helped with this release!
```

## Changelog

### CHANGELOG.md Format

```markdown
# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/),
and this project adheres to [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Added
- New feature X
- New feature Y

### Changed
- Updated feature Z

### Fixed
- Fixed bug A
- Fixed bug B

### Removed
- Removed deprecated feature C

## [2.0.0] - 2026-07-15

### Added
- Page Builder with drag-and-drop blocks
- SEO tools with meta editor
- Media library with image editing

### Changed
- Updated minimum PHP version to 8.2
- Renamed Flux to Gsmui

### Fixed
- Meta descriptions not saving
- Image upload timeouts
```

## Release Process

### Pre-Release Checklist

| Check | Status |
|-------|--------|
| All tests pass | ☐ |
| Changelog updated | ☐ |
| Version bumped | ☐ |
| Dependencies updated | ☐ |
| Documentation updated | ☐ |
| Breaking changes documented | ☐ |
| Migration guide written | ☐ |
| Performance tested | ☐ |
| Security reviewed | ☐ |

### Release Steps

```bash
# 1. Create release branch
git checkout develop
git checkout -b release/2.0.0

# 2. Update version
# Update version in:
# - composer.json
# - config/gsmui.php
# - package.json

# 3. Update CHANGELOG.md

# 4. Commit changes
git add .
git commit -m "chore: prepare release v2.0.0"

# 5. Create PR to main
# Wait for approval and CI

# 6. Merge to main
git checkout main
git merge --no-ff release/2.0.0

# 7. Tag release
git tag -a v2.0.0 -m "Release v2.0.0"
git push origin v2.0.0

# 8. Merge back to develop
git checkout develop
git merge --no-ff release/2.0.0

# 9. Clean up
git branch -d release/2.0.0
git push origin --delete release/2.0.0

# 10. Publish
composer publish
```

### Publishing

| Platform | Command | Notes |
|----------|---------|-------|
| Packagist | `composer publish` | Auto-updates on tag |
| npm | `npm publish` | Manual publish |
| GitHub | Create Release | From tag |

## Hotfix Process

```bash
# 1. Create hotfix from main
git checkout main
git checkout -b hotfix/2.0.1

# 2. Fix the bug
# Make changes

# 3. Commit fix
git commit -m "fix: resolve critical auth issue"

# 4. Update version and changelog

# 5. Merge to main
git checkout main
git merge --no-ff hotfix/2.0.1

# 6. Tag
git tag -a v2.0.1 -m "Hotfix v2.0.1"
git push origin v2.0.1

# 7. Merge to develop
git checkout develop
git merge --no-ff hotfix/2.0.1

# 8. Clean up
git branch -d hotfix/2.0.1
```

## Acceptance Criteria

- [ ] Version numbers follow SemVer
- [ ] Changelog is updated for every release
- [ ] Release notes document all changes
- [ ] Breaking changes are clearly marked
- [ ] Migration guide is provided for major versions
- [ ] Tags are annotated with version
- [ ] Release PR is reviewed before merge
- [ ] Package is published after tagging
- [ ] Hotfix process is documented
- [ ] Dependencies are updated in release notes
