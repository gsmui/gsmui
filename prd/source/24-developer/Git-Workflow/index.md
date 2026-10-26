# Git Workflow

> PRD — Volume 24: Developer Guide — Git Workflow

## Overview

This document defines the Git workflow for the gsmui platform using GitFlow branching strategy, commit conventions, PR process, and code review guidelines.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Branch naming | Convention compliance | 100% |
| Commit messages | Conventional Commits | 100% |
| PR review time | Time to first review | < 4 hours |
| PR merge time | Time from approval to merge | < 24 hours |
| Merge conflicts | Conflicts per PR | < 5% |

## Branching Strategy (GitFlow)

### Branch Types

| Branch | Purpose | Lifetime | Merges Into |
|--------|---------|----------|-------------|
| `main` | Production-ready code | Permanent | — |
| `develop` | Integration branch | Permanent | `main` |
| `feature/*` | New features | Temporary | `develop` |
| `bugfix/*` | Bug fixes | Temporary | `develop` |
| `hotfix/*` | Critical production fixes | Temporary | `main` + `develop` |
| `release/*` | Release preparation | Temporary | `main` + `develop` |
| `chore/*` | Maintenance tasks | Temporary | `develop` |

### Branch Naming Convention

```
feature/{ticket-id}-{short-description}
bugfix/{ticket-id}-{short-description}
hotfix/{ticket-id}-{short-description}
release/{version}
chore/{description}
```

### Examples

```
feature/PROJ-123-add-page-builder
bugfix/PROJ-456-fix-seo-meta
hotfix/PROJ-789-fix-auth-crash
release/2.0.0
chore/update-dependencies
```

## Commit Conventions

### Conventional Commits Format

```
<type>(<scope>): <subject>

[optional body]

[optional footer]
```

### Commit Types

| Type | Description | Example |
|------|-------------|---------|
| `feat` | New feature | `feat(blog): add comment system` |
| `fix` | Bug fix | `fix(seo): correct meta title length` |
| `docs` | Documentation | `docs(api): update endpoint docs` |
| `style` | Code style (no logic change) | `style: fix indentation` |
| `refactor` | Code refactoring | `refactor(models): extract trait` |
| `perf` | Performance improvement | `perf(cache): optimize query` |
| `test` | Adding tests | `test(posts): add unit tests` |
| `chore` | Build/tooling changes | `chore: update dependencies` |
| `ci` | CI/CD changes | `ci(actions): add browser tests` |
| `revert` | Revert commit | `revert: revert feature X` |

### Commit Scopes

| Scope | Description |
|-------|-------------|
| `blog` | Blog module |
| `pages` | Pages module |
| `seo` | SEO tools |
| `media` | Media library |
| `auth` | Authentication |
| `api` | API endpoints |
| `ui` | UI components |
| `db` | Database changes |
| `config` | Configuration |
| `deps` | Dependencies |

### Commit Examples

```
feat(blog): add rich text editor with block support

- Implement Tiptap-based editor
- Add heading, paragraph, image blocks
- Support drag-and-drop reordering

Closes #123
```

```
fix(seo): prevent duplicate meta descriptions

Previously, meta descriptions could be duplicated across pages.
This fix ensures uniqueness validation on save.

Fixes #456
```

## Pull Request Process

### PR Template

```markdown
## Description

Brief description of changes.

## Type of Change

- [ ] Bug fix (non-breaking change fixing an issue)
- [ ] New feature (non-breaking change adding functionality)
- [ ] Breaking change (fix or feature causing existing functionality to change)
- [ ] Documentation update

## Testing

- [ ] Unit tests pass
- [ ] Feature tests pass
- [ ] Browser tests pass
- [ ] Manual testing completed

## Checklist

- [ ] My code follows the project's coding standards
- [ ] I have performed a self-review of my code
- [ ] I have commented my code where necessary
- [ ] I have updated documentation accordingly
- [ ] My changes generate no new warnings
- [ ] I have added tests that prove my fix/feature works
- [ ] New and existing tests pass locally

## Screenshots (if applicable)

[Add screenshots here]
```

### PR Workflow

```
1. Create feature branch from develop
2. Make changes and commit
3. Push branch and create PR
4. Fill out PR template
5. Request review from 1-2 team members
6. Address review feedback
7. Get approval
8. Merge (squash) into develop
9. Delete feature branch
```

### PR Requirements

| Requirement | Status |
|-------------|--------|
| Title follows conventional commits | ☐ |
| Description filled out | ☐ |
| Tests added/updated | ☐ |
| Documentation updated | ☐ |
| No merge conflicts | ☐ |
| CI passes | ☐ |
| 1 approval minimum | ☐ |
| Branch is up-to-date with develop | ☐ |

## Code Review Guidelines

### Review Checklist

| Category | Check |
|----------|-------|
| **Correctness** | Does the code do what it's supposed to? |
| **Tests** | Are there adequate tests? |
| **Security** | Any security concerns? |
| **Performance** | Any performance issues? |
| **Readability** | Is the code easy to understand? |
| **Maintainability** | Will this be easy to maintain? |
| **Standards** | Does it follow coding standards? |
| **Documentation** | Is it properly documented? |

### Review Etiquette

| Do | Don't |
|----|-------|
| Be constructive | Be dismissive |
| Explain why | Just say "wrong" |
| Suggest alternatives | Demand specific changes |
| Praise good work | Only point out issues |
| Ask questions | Make assumptions |

### Review Response Times

| Priority | Response Time |
|----------|--------------|
| Critical/Hotfix | < 1 hour |
| Feature/Bugfix | < 4 hours |
| Chore/Documentation | < 24 hours |

## Merge Strategies

| Strategy | When to Use | Command |
|----------|-------------|---------|
| Squash | Feature branches (default) | `git merge --squash feature/branch` |
| Merge commit | Release branches | `git merge --no-ff release/1.0` |
| Rebase | Hotfix branches | `git rebase main` then `git merge` |

## Acceptance Criteria

- [ ] All branches follow naming convention
- [ ] All commits follow Conventional Commits
- [ ] PRs use the provided template
- [ ] Code reviews are completed within SLA
- [ ] CI passes before merge
- [ ] Squash merge used for feature branches
- [ ] Feature branches deleted after merge
- [ ] No force pushes to main/develop
- [ ] Commit history is clean and readable
- [ ] All changes have test coverage
