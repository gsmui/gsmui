# GsmUi KPI Dashboard

> PRD — Key Performance Indicators & OKR Framework
> Status: Draft | Owner: Product & Engineering | Last Updated: 2026-07-16

---

## 1. Executive Summary

This document defines the KPI framework for GsmUi, organized across four pillars: Revenue, User Growth, Engagement, and Technical Health. Each KPI includes definition, target, tracking cadence, and alerting thresholds. The OKR framework aligns quarterly objectives with these metrics.

---

## 2. Revenue KPIs

### 2.1 Primary Revenue Metrics

| KPI | Definition | Target (M6) | Target (M12) | Cadence |
|-----|-----------|-------------|--------------|---------|
| MRR | Monthly Recurring Revenue | $5,000 | $25,000 | Daily |
| ARR | Annual Recurring Revenue | $60,000 | $300,000 | Weekly |
| ARPU | Average Revenue Per User | $15 | $18 | Monthly |
| LTV | Customer Lifetime Value | $180 | $270 | Quarterly |
| CAC | Customer Acquisition Cost | $8 | $6 | Monthly |
| LTV:CAC Ratio | Return on acquisition spend | 22:1 | 45:1 | Quarterly |
| Net Revenue Retention | Revenue from existing customers | 105% | 115% | Monthly |
| Churn Rate | Monthly subscriber churn | 8% | 5% | Monthly |

### 2.2 Revenue Breakdown

| Revenue Stream | % of Total (Target) | Monthly Target (M12) |
|---------------|---------------------|---------------------|
| Pro Individual | 45% | $11,250 |
| Pro Team | 30% | $7,500 |
| Agency | 20% | $5,000 |
| Enterprise | 5% | $1,250 |

### 2.3 Revenue Alerting

| Metric | Green | Yellow | Red |
|--------|-------|--------|-----|
| MRR growth (MoM) | > 15% | 5–15% | < 5% |
| Churn rate | < 5% | 5–8% | > 8% |
| CAC payback | < 6 months | 6–12 months | > 12 months |
| ARPU trend | Increasing | Stable | Declining |

---

## 3. User KPIs

### 3.1 Acquisition Metrics

| KPI | Definition | Target (M6) | Target (M12) | Cadence |
|-----|-----------|-------------|--------------|---------|
| Total signups | Cumulative registered users | 3,000 | 10,000 | Weekly |
| New signups/month | Monthly new registrations | 600 | 2,000 | Daily |
| Signup conversion rate | Visitors → signups | 4% | 6% | Weekly |
| Organic signups % | Signups from organic channels | 60% | 70% | Monthly |
| Paid signups % | Signups from paid channels | 40% | 30% | Monthly |

### 3.2 Activation Metrics

| KPI | Definition | Target | Cadence |
|-----|-----------|--------|---------|
| Time to first component | Time from signup to first render | < 5 min | Weekly |
| First component rate | % who render a component within 24h | 60% | Weekly |
| Onboarding completion | % who complete all onboarding steps | 45% | Weekly |
| Package install rate | % who run composer require | 50% | Weekly |

### 3.3 Retention Metrics

| KPI | Definition | Target | Cadence |
|-----|-----------|--------|---------|
| Day 1 retention | Return within 24 hours | 40% | Daily |
| Day 7 retention | Return within 7 days | 25% | Weekly |
| Day 30 retention | Return within 30 days | 15% | Monthly |
| Day 90 retention | Return within 90 days | 10% | Quarterly |

---

## 4. Engagement KPIs

### 4.1 Product Usage

| KPI | Definition | Target | Cadence |
|-----|-----------|--------|---------|
| WAU | Weekly Active Users | 800 | Weekly |
| MAU | Monthly Active Users | 2,000 | Monthly |
| Components per project | Avg components used per project | 3.5 | Monthly |
| Component diversity | Unique components used per user | 4.0 | Monthly |
| Session duration | Avg time in docs/playground | 8 min | Weekly |
| Pages per session | Avg pages viewed per visit | 4.5 | Weekly |

### 4.2 Community Engagement

| KPI | Definition | Target | Cadence |
|-----|-----------|--------|---------|
| Discord members | Total community members | 500 | Weekly |
| Discord DAU | Daily active Discord users | 50 | Daily |
| GitHub stars | Repository stars | 1,000 | Weekly |
| GitHub issues opened | Community-reported issues | 20/mo | Monthly |
| PRs from community | External contributions | 5/mo | Monthly |
| Documentation pageviews | Docs site monthly views | 10,000 | Weekly |

### 4.3 Engagement Alerting

| Metric | Green | Yellow | Red |
|--------|-------|--------|-----|
| WAU/MAU ratio | > 40% | 25–40% | < 25% |
| Avg session duration | > 6 min | 3–6 min | < 3 min |
| Components per user | > 3 | 2–3 | < 2 |
| Discord DAU trend | Growing | Stable | Declining |

---

## 5. Technical KPIs

### 5.1 Performance

| KPI | Definition | Target | Cadence |
|-----|-----------|--------|---------|
| Docs page load (LCP) | Largest Contentful Paint | < 1.5s | Daily |
| Docs CLS | Cumulative Layout Shift | < 0.05 | Daily |
| Docs FID | First Input Delay | < 100ms | Daily |
| Bundle size (gsmui.js) | gzipped JS bundle | < 25KB | Weekly |
| Bundle size (CSS) | gzipped CSS bundle | < 15KB | Weekly |

### 5.2 Reliability

| KPI | Definition | Target | Cadence |
|-----|-----------|--------|---------|
| Uptime | Service availability | 99.9% | Monthly |
| API response time | p95 response latency | < 200ms | Daily |
| Error rate | 5xx errors / total requests | < 0.1% | Daily |
| Mean time to recovery | Avg time to resolve incidents | < 1 hour | Per incident |

### 5.3 Quality

| KPI | Definition | Target | Cadence |
|-----|-----------|--------|---------|
| Test coverage | Code coverage percentage | > 85% | Weekly |
| Component accessibility | WCAG 2.1 AA compliance | 100% | Per release |
| Browser support | Supported browser matrix | 95%+ | Monthly |
| Bug escape rate | Bugs found post-release | < 2/month | Monthly |
| Lighthouse score | Performance score | > 95 | Weekly |

---

## 6. OKR Framework

### 6.1 Q3 2026 Objectives

| Objective | Key Result | Target | Owner |
|-----------|-----------|--------|-------|
| **Achieve product-market fit** | Net Promoter Score (NPS) | > 50 | Product |
| | 30-day retention rate | > 15% | Product |
| | Feature request fulfillment rate | > 60% | Engineering |
| **Establish revenue foundation** | MRR | $5,000 | Growth |
| | Paying subscribers | 300 | Growth |
| | CAC payback period | < 6 months | Growth |
| **Build community** | Discord members | 500 | Community |
| | GitHub stars | 1,000 | Community |
| | Community PRs merged | 15 | Engineering |
| **Ship quality components** | Components shipped | 70 | Engineering |
| | WCAG 2.1 AA compliance | 100% | Engineering |
| | Average component bundle size | < 5KB | Engineering |

### 6.2 OKR Scoring

| Score | Definition |
|-------|-----------|
| 0.0 – 0.3 | Missed — did not achieve |
| 0.4 – 0.6 | Partial — significant progress |
| 0.7 – 1.0 | Achieved — target met or exceeded |

---

## 7. Tracking Cadence

### 7.1 Reporting Schedule

| Report | Frequency | Audience | Format |
|--------|----------|----------|--------|
| Daily standup metrics | Daily | Engineering | Slack bot |
| Weekly growth report | Weekly (Monday) | Leadership | Email digest |
| Monthly business review | Monthly | All hands | Notion doc |
| Quarterly OKR review | Quarterly | Leadership + team | Presentation |
| Annual strategic review | Annually | Board + advisors | Presentation |

### 7.2 Dashboard Tools

| Tool | Purpose | Access |
|------|---------|--------|
| PostHog | Product analytics, funnels | Engineering, Product |
| Stripe Dashboard | Revenue metrics | Leadership |
| Plausible | Website analytics | All team |
| GitHub Insights | Repository health | Engineering |
| Discord Analytics | Community health | Community |
| Custom KPI dashboard | Aggregated view | Leadership |

---

## 8. Alerting Thresholds

### 8.1 Critical Alerts (Immediate)

| Condition | Action | Channel |
|-----------|--------|---------|
| MRR drops > 10% week-over-week | Page on-call | Slack + PagerDuty |
| Uptime < 99% | Page on-call | Slack + PagerDuty |
| Error rate > 1% sustained 15min | Page on-call | Slack + PagerDuty |
| Security vulnerability reported | Page security lead | Slack + Email |

### 8.2 Warning Alerts (Same Day)

| Condition | Action | Channel |
|-----------|--------|---------|
| Churn rate > 8% monthly | Review retention tactics | Slack |
| Signup conversion < 3% | Review onboarding funnel | Slack |
| Docs LCP > 2s | Performance investigation | Slack |
| Bundle size increase > 10% | Size budget review | Slack |

### 8.3 Informational (Weekly Review)

| Condition | Action | Channel |
|-----------|--------|---------|
| NPS drops below 40 | User research sprint | Weekly report |
| Discord engagement drops 20% | Community initiative review | Weekly report |
| GitHub star growth stalls | Marketing amplification | Weekly report |
| Component usage skew (top 3 > 50%) | Promote underused components | Weekly report |
