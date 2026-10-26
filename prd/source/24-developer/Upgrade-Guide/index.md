# Upgrade Guide

> PRD — Volume 24: Developer Guide — Upgrade Guide

## Overview

This document provides version migration paths, breaking changes documentation, deprecation notices, and tooling for upgrading the gsmui platform.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Migration clarity | Steps per upgrade | < 10 steps |
| Breaking changes | Documented per release | 100% |
| Deprecation notice | Advance warning | 2 minor versions |
| Upgrade success | Successful upgrades | 95%+ |
| Downtime | Upgrade completion time | < 30 minutes |

## Version Upgrade Paths

### 1.x → 2.0 Migration

| Step | Action | Command |
|------|--------|---------|
| 1 | Backup database | `php artisan backup:database` |
| 2 | Backup files | `tar -czf storage-backup.tar.gz storage/` |
| 3 | Update composer.json | Change `"gsmui/gsmui-pro": "^2.0"` |
| 4 | Run composer update | `composer update gsmui/gsmui-pro` |
| 5 | Publish new config | `php artisan vendor:publish --tag=gsmui-config --force` |
| 6 | Run migrations | `php artisan migrate --force` |
| 7 | Clear cache | `php artisan cache:clear && php artisan config:cache` |
| 8 | Rebuild assets | `npm ci && npm run build` |
| 9 | Test application | Run test suite |
| 10 | Monitor logs | Check for errors |

### Breaking Changes

#### 2.0.0

| Change | Impact | Migration |
|--------|--------|-----------|
| `Flux::` renamed to `Gsmui::` | High | Find/replace `Flux` → `Gsmui` |
| CSS variables `--flux-*` → `--gsmui-*` | Medium | Find/replace in CSS/Blade |
| PHP minimum version 8.2 | High | Upgrade PHP |
| Livewire 3.0 required | High | Upgrade Livewire |
| Component prefix `flux:` → `gsmui:` | Medium | Find/replace in Blade |
| Config file renamed | Low | Republish config |

#### Migration Script

```php
<?php
// Upgrade command: php artisan gsmui:upgrade

use Illuminate\Console\Command;

class UpgradeCommand extends Command
{
    protected $signature = 'gsmui:upgrade {--from= : Current version}';
    protected $description = 'Upgrade gsmui to latest version';

    public function handle(): int
    {
        $from = $this->option('from') ?? $this->getCurrentVersion();

        $this->info("Upgrading from v{$from}...");

        match (true) {
            str_starts_with($from, '1.') => $this->upgradeFrom1x(),
            str_starts_with($from, '2.0') => $this->upgradeFrom20(),
            default => $this->error('Unknown version'),
        };

        $this->info('Upgrade complete!');
        return 0;
    }

    private function upgradeFrom1x(): void
    {
        $this->info('Running 1.x → 2.0 migrations...');

        // Replace Flux with Gsmui
        $this->call('find-replace', [
            'find' => 'Flux',
            'replace' => 'Gsmui',
            'path' => 'app/',
        ]);

        // Replace CSS variables
        $this->call('find-replace', [
            'find' => '--flux-',
            'replace' => '--gsmui-',
            'path' => 'resources/',
        ]);

        // Replace component prefix
        $this->call('find-replace', [
            'find' => 'flux:',
            'replace' => 'gsmui:',
            'path' => 'resources/views/',
        ]);

        // Publish new config
        $this->call('vendor:publish', [
            '--tag' => 'gsmui-config',
            '--force' => true,
        ]);
    }
}
```

## Deprecation Notices

### Deprecation Policy

| Version | Deprecation | Removal |
|---------|-------------|---------|
| 1.8 | `Flux::` facade deprecated | 2.0 |
| 1.8 | `flux:` prefix deprecated | 2.0 |
| 1.9 | `--flux-*` CSS vars deprecated | 2.0 |
| 2.1 | Old config format deprecated | 3.0 |
| 2.2 | PHP 8.1 support deprecated | 3.0 |

### Deprecation Warnings

```php
// In code
if (method_exists($this, 'oldMethod')) {
    trigger_deprecation(
        'gsmui/gsmui-pro',
        '%s() is deprecated since gsmui 1.8, use %s() instead.',
        __METHOD__,
        'newMethod'
    );
    return $this->newMethod(...func_get_args());
}
```

## Tooling

### Upgrade Helper Commands

```bash
# Check for deprecated usage
php artisan gsmui:check-deprecations

# Dry run upgrade
php artisan gsmui:upgrade --dry-run

# Run upgrade
php artisan gsmui:upgrade

# Verify upgrade
php artisan gsmui:verify
```

### Automated Migration Script

```php
class FindReplaceCommand extends Command
{
    protected $signature = 'find-replace {find} {replace} {path}';

    public function handle(): int
    {
        $find = $this->argument('find');
        $replace = $this->argument('replace');
        $path = $this->argument('path');

        $files = glob($path . '**/*.{php,blade.php,css,js}', GLOB_BRACE);
        $replaced = 0;

        foreach ($files as $file) {
            $content = file_get_contents($file);
            $newContent = str_replace($find, $replace, $content);

            if ($content !== $newContent) {
                file_put_contents($file, $newContent);
                $this->line("Replaced in: {$file}");
                $replaced++;
            }
        }

        $this->info("Replaced {$replaced} occurrences in {$find} → {$replace}");
        return 0;
    }
}
```

## Upgrade Checklist

| Version | Steps | Estimated Time |
|---------|-------|----------------|
| 1.x → 2.0 | 10 | 30 minutes |
| 2.0 → 2.1 | 5 | 15 minutes |
| 2.1 → 2.2 | 5 | 15 minutes |
| 2.2 → 3.0 | 15 | 60 minutes |

## Acceptance Criteria

- [ ] Upgrade path documented for each version
- [ ] Breaking changes listed with migration steps
- [ ] Deprecation notices have 2-version advance warning
- [ ] Migration script automates common changes
- [ ] Backup instructions provided before upgrade
- [ ] Test suite runs after upgrade
- [ ] Rollback procedure documented
- [ ] Performance impact assessed
- [ ] Dependencies compatibility verified
- [ ] Documentation updated for new version
