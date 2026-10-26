# Newsletter System

> PRD — Volume 21: CMS & Content — Newsletter

## Overview

The Newsletter System provides subscriber management, campaign creation with a visual editor, email templates, scheduling, A/B testing, and analytics. It integrates with popular email providers and supports automated drip campaigns.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Delivery rate | Emails successfully delivered | 98%+ |
| Open rate | Average campaign open rate | 25%+ |
| Click rate | Average campaign click rate | 3%+ |
| Unsubscribe rate | Unsubscribe per campaign | < 0.5% |
| Send speed | Emails sent per minute | 10,000+ |
| Template render | Template compilation time | < 100ms |

## Subscriber Management

### Subscriber Schema

```sql
CREATE TABLE subscribers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    name VARCHAR(255) NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    source VARCHAR(50) NULL,
    tags JSON NULL,
    metadata JSON NULL,
    subscribed_at TIMESTAMP NULL,
    unsubscribed_at TIMESTAMP NULL,
    last_sent_at TIMESTAMP NULL,
    bounce_count INT UNSIGNED NOT NULL DEFAULT 0,
    open_count INT UNSIGNED NOT NULL DEFAULT 0,
    click_count INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY subscribers_email_unique (email),
    KEY subscribers_status_index (status)
);

CREATE TABLE subscriber_lists (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    description TEXT NULL,
    subscribers_count INT UNSIGNED NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY subscriber_lists_slug_unique (slug)
);

CREATE TABLE subscriber_list_pivot (
    subscriber_id BIGINT UNSIGNED NOT NULL,
    list_id BIGINT UNSIGNED NOT NULL,
    subscribed_at TIMESTAMP NULL,
    PRIMARY KEY (subscriber_id, list_id),
    CONSTRAINT slp_subscriber FOREIGN KEY (subscriber_id) REFERENCES subscribers(id) ON DELETE CASCADE,
    CONSTRAINT slp_list FOREIGN KEY (list_id) REFERENCES subscriber_lists(id) ON DELETE CASCADE
);
```

### Subscriber Statuses

| Status | Description | Can Receive |
|--------|-------------|-------------|
| `pending` | Awaiting confirmation | No |
| `active` | Confirmed and subscribed | Yes |
| `unsubscribed` | Opted out | No |
| `bounced` | Email bounced | No |
| `complained` | Marked as spam | No |
| `cleaned` | Removed due to bounces | No |

### Subscriber Import

```php
class SubscriberImport extends Component
{
    public ?UploadedFile $file = null;
    public ?int $listId = null;
    public string $source = 'csv-import';
    public bool $sendWelcomeEmail = false;
    public int $importedCount = 0;
    public int $skippedCount = 0;

    public function import(): void
    {
        $this->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240',
            'listId' => 'required|exists:subscriber_lists,id',
        ]);

        $rows = $this->parseCsv();
        $emailValidator = Validator::make(['email' => 'required|email']);

        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                if ($emailValidator->fails()) {
                    $this->skippedCount++;
                    continue;
                }

                $subscriber = Subscriber::updateOrCreate(
                    ['email' => strtolower(trim($row['email']))],
                    [
                        'name' => $row['name'] ?? null,
                        'status' => 'active',
                        'source' => $this->source,
                        'subscribed_at' => now(),
                    ]
                );

                $subscriber->lists()->syncWithoutDetaching([
                    $this->listId => ['subscribed_at' => now()],
                ]);

                $this->importedCount++;

                if ($this->sendWelcomeEmail) {
                    WelcomeEmail::dispatch($subscriber);
                }
            }
        });
    }
}
```

## Campaign Editor

### Campaign Schema

```sql
CREATE TABLE campaigns (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    preview_text VARCHAR(255) NULL,
    from_name VARCHAR(100) NOT NULL,
    from_email VARCHAR(255) NOT NULL,
    reply_to VARCHAR(255) NULL,
    list_id BIGINT UNSIGNED NOT NULL,
    template_id BIGINT UNSIGNED NULL,
    content LONGTEXT NULL,
    blocks JSON NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'draft',
    scheduled_at TIMESTAMP NULL,
    sent_at TIMESTAMP NULL,
    ab_test JSON NULL,
    metadata JSON NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    KEY campaigns_status_index (status),
    KEY campaigns_scheduled_index (scheduled_at),
    CONSTRAINT campaigns_list FOREIGN KEY (list_id) REFERENCES subscriber_lists(id),
    CONSTRAINT campaigns_creator FOREIGN KEY (created_by) REFERENCES users(id)
);
```

### Campaign Content Blocks

| Block | Description |
|-------|-------------|
| `text` | Rich text paragraph |
| `heading` | Email heading (H1–H3) |
| `image` | Single image with link |
| `button` | CTA button |
| `divider` | Horizontal rule |
| `spacer` | Vertical spacer |
| `social` | Social media links |
| `columns` | 2-column layout |
| `html` | Custom HTML block |
| `post` | Blog post preview card |
| `products` | Product grid |

### Campaign Livewire Component

```php
class CampaignEditor extends Component
{
    public ?Campaign $campaign;
    public string $subject = '';
    public string $previewText = '';
    public string $fromName = '';
    public string $fromEmail = '';
    public ?int $listId = null;
    public array $blocks = [];
    public ?int $templateId = null;

    public function mount(?int $campaignId = null): void
    {
        $this->campaign = $campaignId ? Campaign::findOrFail($campaignId) : null;
        if ($this->campaign) {
            $this->subject = $this->campaign->subject;
            $this->blocks = $this->campaign->blocks ?? [];
        }
    }

    public function sendTest(string $testEmail): void
    {
        $this->validate([
            'testEmail' => 'required|email',
        ]);

        TestEmail::dispatch(
            $this->campaign,
            $testEmail,
            $this->buildHtml()
        );

        $this->dispatch('test-sent', email: $testEmail);
    }

    public function schedule(Carbon $scheduledAt): void
    {
        $this->save();
        $this->campaign->update([
            'status' => 'scheduled',
            'scheduled_at' => $scheduledAt,
        ]);

        ScheduleCampaign::dispatch($this->campaign)
            ->delay($scheduledAt);
    }

    public function sendNow(): void
    {
        $this->save();
        $this->campaign->update(['status' => 'sending']);

        SendCampaign::dispatch($this->campaign);
    }
}
```

## Email Templates

### Template Types

| Type | Description | Use Case |
|------|-------------|----------|
| `basic` | Simple text + image layout | General newsletters |
| `branded` | Company branded header/footer | Marketing campaigns |
| `transactional` | System-triggered emails | Welcome, password reset |
| `digest` | Content digest with multiple items | Weekly roundup |
| `product` | Product showcase template | Product announcements |

### Template Variables

| Variable | Description |
|----------|-------------|
| `{{name}}` | Subscriber name |
| `{{email}}` | Subscriber email |
| `{{unsubscribe_url}}` | One-click unsubscribe link |
| `{{preferences_url}}` | Email preferences page |
| `{{current_year}}` | Current year |
| `{{site_url}}` | Website base URL |

## Analytics

### Campaign Metrics

| Metric | Description | Calculation |
|--------|-------------|-------------|
| `sent` | Total emails sent | Count of sends |
| `delivered` | Successfully delivered | Sent - bounces |
| `opens` | Unique email opens | Pixel tracking |
| `open_rate` | Open rate percentage | (opens / delivered) × 100 |
| `clicks` | Unique link clicks | Click tracking |
| `click_rate` | Click rate percentage | (clicks / delivered) × 100 |
| `click_through_rate` | CTR from opens | (clicks / opens) × 100 |
| `unsubscribes` | Unsubscribe count | Unsubscribe link clicks |
| `unsubscribe_rate` | Unsubscribe percentage | (unsubscribes / delivered) × 100 |
| `bounces` | Hard + soft bounces | Bounce webhook |
| `bounce_rate` | Bounce percentage | (bounces / sent) × 100 |
| `spam_reports` | Spam complaints | Feedback loop |

### Analytics Dashboard

```php
class CampaignAnalytics extends Component
{
    public Campaign $campaign;
    public array $metrics = [];
    public array $timeline = [];
    public array $topLinks = [];
    public array $deviceBreakdown = [];

    public function mount(int $campaignId): void
    {
        $this->campaign = Campaign::with('stats')->findOrFail($campaignId);
        $this->metrics = $this->calculateMetrics();
        $this->timeline = $this->getOpenTimeline();
        $this->topLinks = $this->getTopLinks();
        $this->deviceBreakdown = $this->getDeviceBreakdown();
    }

    private function calculateMetrics(): array
    {
        $stats = $this->campaign->stats;
        $delivered = $stats->sent - $stats->bounces;

        return [
            'sent' => $stats->sent,
            'delivered' => $delivered,
            'delivery_rate' => $delivered > 0 ? round(($delivered / $stats->sent) * 100, 1) : 0,
            'opens' => $stats->unique_opens,
            'open_rate' => $delivered > 0 ? round(($stats->unique_opens / $delivered) * 100, 1) : 0,
            'clicks' => $stats->unique_clicks,
            'click_rate' => $delivered > 0 ? round(($stats->unique_clicks / $delivered) * 100, 1) : 0,
            'unsubscribes' => $stats->unsubscribes,
            'unsubscribe_rate' => $delivered > 0 ? round(($stats->unsubscribes / $delivered) * 100, 2) : 0,
            'bounces' => $stats->bounces,
            'bounce_rate' => $stats->sent > 0 ? round(($stats->bounces / $stats->sent) * 100, 2) : 0,
        ];
    }
}
```

## Integrations

| Provider | Features | Configuration |
|----------|----------|---------------|
| Mailgun | Send, track, webhooks | API key, domain |
| SendGrid | Send, templates, analytics | API key |
| SES (AWS) | Send, bounce/complaint handling | Access key, secret, region |
| Postmark | Transactional + broadcast | Server token |
| Resend | Modern API, webhooks | API key |

### Webhook Handlers

| Event | Source | Action |
|-------|--------|--------|
| `email.delivered` | Provider | Update delivery status |
| `email.opened` | Provider | Record open event |
| `email.clicked` | Provider | Record click event |
| `email.bounced` | Provider | Mark subscriber as bounced |
| `email.complained` | Provider | Mark subscriber as complained |
| `unsubscribe` | Provider | Mark subscriber as unsubscribed |

## Access Control

| Permission | Description | Default Role |
|------------|-------------|-------------|
| `newsletters.subscribers.manage` | Manage subscribers | Editor |
| `newsletters.campaigns.create` | Create campaigns | Editor |
| `newsletters.campaigns.send` | Send campaigns | Admin |
| `newsletters.campaigns.schedule` | Schedule campaigns | Editor |
| `newsletters.templates.manage` | Manage templates | Admin |
| `newsletters.analytics.view` | View campaign analytics | Editor |
| `newsletters.lists.manage` | Manage subscriber lists | Admin |

## Acceptance Criteria

- [ ] Subscriber import handles CSV with validation
- [ ] Double opt-in confirmation flow works end-to-end
- [ ] Campaign editor supports all content block types
- [ ] Test emails send and render correctly
- [ ] Scheduling sends campaigns at the specified time
- [ ] Analytics track opens via pixel and clicks via link wrapping
- [ ] Unsubscribe links comply with CAN-SPAM/GDPR
- [ ] Bounce handling automatically updates subscriber status
- [ ] Template variables are replaced with subscriber data
- [ ] A/B testing splits traffic and determines winner
