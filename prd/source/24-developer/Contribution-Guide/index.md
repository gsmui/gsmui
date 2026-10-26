# Contributing Guide

> PRD — Volume 24: Developer Guide — Contributing Guide

## Overview

This document provides setup instructions, coding standards, PR template, and issue templates for contributing to the gsmui platform.

## Getting Started

### Prerequisites

| Requirement | Version |
|-------------|---------|
| PHP | 8.2+ |
| Composer | 2.0+ |
| Node.js | 20+ |
| MySQL | 8.0+ |
| Redis | 7.0+ |

### Local Setup

```bash
# Clone the repository
git clone https://github.com/user/gsmui.git
cd gsmui

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database
mysql -u root -e "CREATE DATABASE gsmui"

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Build assets
npm run dev

# Start development server
php artisan serve
```

### Running Tests

```bash
# Unit tests
php artisan test --testsuite=Unit

# Feature tests
php artisan test --testsuite=Feature

# Browser tests
npx playwright test

# All tests
php artisan test
```

## Coding Standards

### Code Style

- Follow PSR-12 coding standard
- Use Laravel conventions
- Run `vendor/bin/pint` before committing
- Run `vendor/bin/phpstan analyse` to check types

### Commit Messages

Follow Conventional Commits:

```
feat(blog): add comment system
fix(seo): correct meta title length
docs(api): update endpoint docs
test(posts): add unit tests
```

### Branch Naming

```
feature/{ticket-id}-{description}
bugfix/{ticket-id}-{description}
hotfix/{ticket-id}-{description}
```

## Pull Request Process

### Before Submitting

| Check | Status |
|-------|--------|
| Code follows style guide | ☐ |
| Tests pass locally | ☐ |
| No merge conflicts | ☐ |
| PR description filled out | ☐ |
| Documentation updated | ☐ |
| Screenshots added (if UI) | ☐ |

### PR Template

```markdown
## Description

[Describe your changes]

## Type of Change

- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing

[Describe tests you added/ran]

## Checklist

- [ ] Self-review completed
- [ ] Tests pass
- [ ] Documentation updated
- [ ] No new warnings
```

## Issue Templates

### Bug Report

```markdown
## Describe the bug

[Clear description]

## Steps to reproduce

1. Go to '...'
2. Click on '...'
3. See error

## Expected behavior

[What you expected]

## Screenshots

[If applicable]

## Environment

- OS: [e.g., Windows 11]
- Browser: [e.g., Chrome 120]
- PHP Version: [e.g., 8.3]
```

### Feature Request

```markdown
## Is your feature request related to a problem?

[Clear description]

## Describe the solution you'd like

[Solution description]

## Describe alternatives you've considered

[Alternatives]

## Additional context

[Other information]
```

## Code of Conduct

- Be respectful and inclusive
- Welcome newcomers
- Focus on constructive feedback
- Help others learn

## Acceptance Criteria

- [ ] Local setup instructions are clear
- [ ] Coding standards are documented
- [ ] PR template is provided
- [ ] Issue templates are available
- [ ] Test instructions are clear
- [ ] Code of conduct is defined
- [ ] Contributing steps are numbered
- [ ] Prerequisites are listed
- [ ] Examples are provided
- [ ] Contact info is available
