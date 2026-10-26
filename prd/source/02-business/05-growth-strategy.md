# GsmUi Growth Strategy

> PRD — Growth & Acquisition Plan
> Status: Draft | Owner: Growth Team | Last Updated: 2026-07-16

---

## 1. Executive Summary

GsmUi targets the Laravel/Livewire ecosystem with a premium UI component library. Our growth strategy focuses on developer acquisition through content-led SEO, community engagement, and strategic partnerships within the Laravel ecosystem. The goal is to reach 10,000 registered developers and 500 paying subscribers within 12 months of launch.

---

## 2. Acquisition Channels

### 2.1 Organic Search (SEO)

| Priority | Content Type | Target Keywords | Monthly Volume | Difficulty |
|----------|-------------|-----------------|----------------|------------|
| P0 | Blog posts | "laravel ui components" | 2,400 | Medium |
| P0 | Tutorial | "livewire components tutorial" | 1,800 | Medium |
| P1 | Comparison | "tailwind ui vs flux" | 900 | Low |
| P1 | Guide | "laravel blade components" | 3,100 | High |
| P2 | Case study | "laravel admin panel" | 1,200 | Medium |

### 2.2 Developer Communities

- **Laravel Discord** — Active participation, weekly tips, component showcases
- **Laravel.io** — Forum answers with GsmUi examples
- **Reddit r/laravel** — Weekly "Show r/laravel" posts
- **Twitter/X** — #LaravelTips with component demos
- **YouTube** — Component walkthroughs and comparison videos

### 2.3 Paid Acquisition

| Channel | Budget (Monthly) | Target CPA | Expected Signups |
|---------|-----------------|------------|------------------|
| Google Ads (brand) | $500 | $2.00 | 250 |
| Twitter Ads (dev audience) | $1,000 | $4.00 | 250 |
| Laravel News sponsor | $2,000 | $3.00 | 667 |
| Dev.to promoted | $500 | $1.50 | 333 |

### 2.4 Referral Programs

- **Developer referral**: Give $20 credit, get $20 credit per paid conversion
- **Agency referral**: 15% recurring commission for first 12 months
- **Open-source contrib**: Free Pro license for 3+ merged PRs

---

## 3. Activation Funnel

```
Visitor → Signup → First Component → First Project → Paid Conversion
  100%      40%         25%              15%              8%
```

### 3.1 Funnel Stages

| Stage | Definition | Target Rate | Key Metric |
|-------|-----------|-------------|------------|
| Awareness | Site visit or docs page view | — | Unique visitors |
| Interest | Signup for free account | 40% | Signup rate |
| Onboarding | Install package, render first component | 60% | Activation rate |
| Engagement | Use 3+ components in a project | 45% | Component adoption |
| Conversion | Upgrade to Pro | 12% | Paid conversion |
| Retention | Active usage after 30 days | 80% | 30-day retention |

### 3.2 Onboarding Optimization

1. **Zero-config start**: `composer require gsmui/gsmui-pro` → working component in < 2 minutes
2. **Interactive playground**: Browser-based component sandbox (no install required)
3. **Copy-paste starters**: Pre-built layouts for common patterns (dashboard, login, settings)
4. **Progressive disclosure**: Show 3 components first, unlock more as usage grows

---

## 4. Retention Tactics

### 4.1 Engagement Hooks

- **Weekly component drops**: New component every Tuesday (creates anticipation)
- **Monthly themes**: Focus on one component family per month (e.g., "Form Month")
- **Usage dashboards**: Show developers which components they use most
- **Project integrations**: Auto-detect GsmUi in `composer.json` and suggest components

### 4.2 Churn Prevention

| Risk Signal | Intervention | Timeline |
|-------------|-------------|----------|
| No login for 14 days | Email with "new this week" digest | Day 14 |
| Removed package | Exit survey + 30-day winback offer | Day 1 |
| Support ticket unresolved | Escalation to engineering | 24 hours |
| Low component usage | Personal outreach from founder | Day 30 |

### 4.3 Feature Roadmap as Retention

Publish a public roadmap with voting. When users see their requested features shipping, they stay.

---

## 5. Viral Loops

### 5.1 Built-in Virality

- **"Powered by GsmUi"** footer badge (opt-in, Pro users can disable)
- **Component marketplace**: Developers submit and sell custom components
- **Embeddable demos**: Share component previews via URL (auto-embeds in Slack, Discord, Twitter)
- **Open-source core**: Free tier drives awareness, Pro tier monetizes

### 5.2 Network Effects

- **Team seats**: One developer adopts → invites team → team license
- **Agency standardization**: Agency adopts → all client projects use it → recurring revenue
- **Template ecosystem**: Community templates drive signups → template authors become advocates

---

## 6. Content Marketing Strategy

### 6.1 Content Calendar

| Week | Content Type | Topic | Channel |
|------|-------------|-------|---------|
| 1 | Blog post | "Building a Laravel Dashboard with GsmUi" | Blog, Twitter |
| 2 | Video tutorial | "Date Picker Deep Dive" | YouTube |
| 3 | Case study | "How Agency X Reduced Dev Time 40%" | Blog, Email |
| 4 | Component release | "New: Multi-Select with Search" | All channels |

### 6.2 Content Pillars

1. **Educational**: Laravel/Livewire best practices with GsmUi examples
2. **Comparative**: "GsmUi vs [Alternative]" honest comparisons
3. **Showcase**: Real projects built with GsmUi
4. **Thought leadership**: Future of Laravel UI, component architecture opinions

---

## 7. SEO Strategy

### 7.1 Technical SEO

- Static docs site (VitePress) for fast load times
- Structured data on all component pages (HowTo schema)
- Auto-generated sitemap from component registry
- Core Web Vitals targets: LCP < 1.5s, CLS < 0.05

### 7.2 Link Building

- Guest posts on Laravel News, Laracasts forum
- Component mentions in "Best Laravel packages" roundups
- Open-source backlinks from GitHub README references
- Conference talk slides linking back to docs

---

## 8. Community Building

### 8.1 Community Tiers

| Tier | Access | Requirements |
|------|--------|-------------|
| Public | Docs, GitHub issues | None |
| Member | Discord, forums | Free signup |
| Pro | Priority support, beta access | Paid subscription |
| Contributor | Merge access, revenue share | 3+ merged PRs |

### 8.2 Community Programs

- **Component of the Month**: Community-voted best component use case
- **Bug Bounty**: $25-$500 for security vulnerabilities
- **Documentation Sprint**: Monthly doc improvements with swag rewards
- **Office Hours**: Weekly 30-min video call with maintainers

---

## 9. Partnership Channels

### 9.1 Strategic Partnerships

| Partner Type | Value Exchange | Target Partners |
|-------------|---------------|-----------------|
| Laravel hosting | Co-marketing, bundled offers | Forge, Vapor, Ploi |
| Component marketplaces | Distribution channel | Laravel Packages |
| Training platforms | Course content, affiliate revenue | Laracasts, Udemy |
| Design tools | Figma-to-code integration | Figma, Sketch |

### 9.2 Integration Partners

- **Livewire**: Official component library recommendation
- **Jetstream**: Pre-built dashboard templates
- **Filament**: Complementary admin panel components
- **Inertia.js**: Adapter for non-Livewire users

---

## 10. Growth Metrics Dashboard

### 10.1 North Star Metric

**Weekly Active Developers Using GsmUi** (WADU) — combines adoption and engagement.

### 10.2 Supporting Metrics

| Category | Metric | Target (Month 6) | Target (Month 12) |
|----------|--------|------------------|-------------------|
| Acquisition | Unique visitors/month | 15,000 | 40,000 |
| Acquisition | New signups/month | 600 | 2,000 |
| Activation | First component installed | 55% | 65% |
| Engagement | Components per project | 2.5 | 4.0 |
| Revenue | MRR | $5,000 | $25,000 |
| Revenue | ARPU | $15 | $18 |
| Retention | 30-day retention | 75% | 85% |
| Referral | Viral coefficient | 0.3 | 0.6 |

### 10.3 Tracking Stack

- **Analytics**: Plausible (privacy-first) + custom events
- **Product analytics**: PostHog for funnel tracking
- **Revenue**: Stripe dashboard + custom webhook
- **Community**: Discord analytics + GitHub Insights
- **SEO**: Ahrefs for keyword tracking and backlinks
