# Marketplace Strategy — GsmUi

> **Last updated:** 2026-07-16
> **Owner:** Product & Ecosystem Team
> **Status:** Active

---

## 1. Marketplace Vision

GsmUi Marketplace is a community-driven platform where developers publish, discover, and install third-party GsmUi component packs, themes, and integrations. It extends the core library without bloating it.

---

## 2. Marketplace Dynamics

### 2.1 Ecosystem Model

| Participant | Role | Value Exchange |
|-------------|------|----------------|
| **Component creators** | Build and publish packs | Revenue share, exposure, community |
| **Consumers** | Install and use packs | Access to extended components |
| **Gsmui team** | Platform, curation, support | Revenue share, ecosystem growth |
| **Reviewers** | Quality assurance | Reputation, community status |

### 2.2 Supply & Demand

| Metric | Target (Y1) | Target (Y2) | Target (Y3) |
|--------|------------|------------|------------|
| **Published packs** | 10 | 50 | 150 |
| **Active creators** | 5 | 25 | 75 |
| **Monthly installs** | 1,000 | 10,000 | 50,000 |
| **Average pack price** | $29 | $35 | $40 |

---

## 3. Creator Ecosystem

### 3.1 Creator Tiers

| Tier | Requirements | Benefits |
|------|-------------|----------|
| **Contributor** | 1 published pack | Marketplace listing, basic analytics |
| **Verified** | 3+ packs, 100+ installs | Featured placement, 85% revenue share |
| **Partner** | 10+ packs, 1,000+ installs | Co-marketing, 90% revenue share, early API access |

### 3.2 Creator Incentives

| Incentive | Description | Impact |
|-----------|-------------|--------|
| **Revenue share** | 80–90% to creator | Financial motivation |
| **Featured placement** | Top packs highlighted | Exposure, installs |
| **Creator badge** | Profile badge for verified | Social proof |
| **Early API access** | Beta features before public | Competitive advantage |
| **Co-marketing** | Joint announcements, blog posts | Reach |

### 3.3 Creator Support

| Support Type | Description | Availability |
|-------------|-------------|--------------|
| **Documentation** | Pack development guide | Always |
| **Discord channel** | Creator-specific support | Always |
| **Office hours** | Weekly Q&A with team | Weekly |
| **Code review** | Pre-submission review | On request |
| **Design review** | Visual quality check | On request |

---

## 4. Commission Structure

### 4.1 Revenue Share

| Tier | Creator Share | Platform Share | Minimum Payout |
|------|--------------|----------------|----------------|
| **Standard** | 80% | 20% | $50 |
| **Verified** | 85% | 15% | $50 |
| **Partner** | 90% | 10% | $25 |

### 4.2 Pricing Models for Packs

| Model | Description | Example |
|-------|-------------|---------|
| **One-time purchase** | Single payment,永久 access | $29 one-time |
| **Subscription** | Monthly/annual recurring | $9/mo or $79/yr |
| **Free + Pro** | Free core, paid advanced features | Free basic, $19 Pro |
| **Pay what you want** | Minimum price, optional tip | $10+ |

### 4.3 Fee Structure

| Fee Type | Amount | Notes |
|----------|--------|-------|
| **Platform commission** | 10–20% | Based on creator tier |
| **Payment processing** | 2.9% + $0.30 | Stripe fees |
| **Refund fee** | $0 | Full refund to buyer |
| **Payout fee** | $0 | Free payouts |

---

## 5. Quality Standards

### 5.1 Submission Requirements

| Requirement | Description | Enforcement |
|-------------|-------------|-------------|
| **Accessibility** | WCAG 2.1 AA compliance | Automated audit |
| **Dark mode** | Full dark mode support | Manual review |
| **Documentation** | README with examples | Required for listing |
| **Tests** | Unit + integration tests | CI pipeline |
| **License** | Compatible license (MIT, GPL, etc.) | Legal review |
| **Security** | No known vulnerabilities | Security scan |

### 5.2 Quality Tiers

| Tier | Criteria | Badge |
|------|----------|-------|
| **Basic** | Meets all submission requirements | ✅ |
| **Quality** | + 90% test coverage, full docs | ⭐ |
| **Premium** | + Accessibility audit, performance benchmark | 🏆 |

### 5.3 Review Process

| Step | Duration | Owner |
|------|----------|-------|
| **Automated checks** | Instant | CI pipeline |
| **Code review** | 3–5 days | Community reviewer |
| **Design review** | 2–3 days | Design team |
| **Security review** | 2–3 days | Security team |
| **Publish** | 1 day | Marketplace team |

---

## 6. Pack Categories

| Category | Description | Examples |
|----------|-------------|----------|
| **Data visualization** | Charts, graphs, dashboards | Charts, sparklines, heatmaps |
| **Rich content** | Editor, media, code | WYSIWYG, video player, syntax highlighter |
| **Navigation** | Menus, breadcrumbs, sidebars | Mega menu, command palette |
| **Layout** | Grids, panels, cards | Masonry grid, split view |
| **Feedback** | Notifications, progress, status | Toast, spinner, progress bar |
| **Forms** | Advanced inputs, validation | Multi-select, file upload, color picker |
| **Theming** | Pre-built themes, customizers | Dark theme, brand theme |
| **Integrations** | Third-party service connectors | Stripe, Algolia, Mapbox |

---

## 7. Discovery & Distribution

### 7.1 Discovery Channels

| Channel | Description | Priority |
|---------|-------------|----------|
| **Marketplace website** | Search, browse, categories | P0 |
| **CLI integration** | `gsmui install <pack>` | P0 |
| **Documentation** | Pack pages in docs | P1 |
| **Social media** | Featured packs, creator spotlights | P1 |
| **Newsletter** | Monthly pack roundups | P2 |
| **Discord** | Pack announcements | P2 |

### 7.2 Search & Ranking

| Factor | Weight | Description |
|--------|--------|-------------|
| **Installs** | 30% | Total install count |
| **Rating** | 25% | User ratings (1–5) |
| **Recency** | 15% | Last update date |
| **Quality tier** | 15% | Basic/Quality/Premium |
| **Creator tier** | 10% | Contributor/Verified/Partner |
| **Relevance** | 5% | Search term match |

---

## 8. Governance

### 8.1 Content Policy

| Policy | Rule | Enforcement |
|--------|------|-------------|
| **Quality** | Must meet submission requirements | Pre-publish review |
| **Security** | No known vulnerabilities | Automated scan |
| **Accessibility** | WCAG 2.1 AA minimum | Automated + manual |
| **Licensing** | Compatible license required | Legal review |
| **Spam** | No duplicate or low-effort packs | Manual review |
| **Malware** | No malicious code | Security scan |

### 8.2 Takedown Policy

| Trigger | Action | Appeal |
|---------|--------|--------|
| **Security vulnerability** | Immediate takedown | Fix + resubmit |
| **Accessibility failure** | 7-day fix window | Appeal within 7 days |
| **License violation** | Immediate takedown | Legal review |
| **Spam/duplicate** | Immediate takedown | Appeal within 14 days |
| **User complaint** | Investigation within 7 days | Appeal within 14 days |

### 8.3 Dispute Resolution

| Step | Duration | Owner |
|------|----------|-------|
| **Complaint filed** | Day 0 | User |
| **Investigation** | 7 days | Marketplace team |
| **Decision** | 14 days | Marketplace team |
| **Appeal** | 21 days | Leadership team |
| **Resolution** | 30 days | Final decision |

---

## 9. Technical Architecture

### 9.1 Pack Structure

```
gsmui-pack-name/
├── src/
│   ├── index.blade.php
│   └── index.js
├── dist/
├── tests/
├── docs/
├── README.md
├── package.json
└── gsmui-pack.json
```

### 9.2 Installation Flow

```bash
# Search for packs
gsmui search chart

# Install a pack
gsmui install @gsmui/charts

# Update all packs
gsmui update

# List installed packs
gsmui list
```

### 9.3 Dependency Management

| Feature | Description |
|---------|-------------|
| **Version pinning** | Lock to specific versions |
| **Auto-update** | Optional auto-updates |
| **Conflict detection** | Warn on conflicting packs |
| **Peer dependencies** | Require specific Gsmui versions |

---

## 10. Revenue Projections

### 10.1 Marketplace Revenue

| Year | Packs | Installs/mo | GMV/mo | Platform rev/mo |
|------|-------|-------------|--------|-----------------|
| **Y1** | 10 | 1,000 | $2,900 | $580 |
| **Y2** | 50 | 10,000 | $35,000 | $7,000 |
| **Y3** | 150 | 50,000 | $200,000 | $40,000 |

### 10.2 Creator Earnings

| Year | Active creators | Avg earnings/creator/mo | Total creator rev/mo |
|------|----------------|------------------------|---------------------|
| **Y1** | 5 | $464 | $2,320 |
| **Y2** | 25 | $2,800 | $70,000 |
| **Y3** | 75 | $10,667 | $800,000 |

---

*Review marketplace strategy quarterly. Adjust based on creator feedback and market dynamics.*
