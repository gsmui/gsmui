# 25 - User Dashboard

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

The User Dashboard aggregates all user-specific data: profile, subscriptions, downloads, projects, billing, and settings in one personalized hub.

---

# Vision

Provide every GsmUi user with a powerful, intuitive dashboard that makes managing their account, projects, and subscription effortless.

---

# Core Features

## Profile Management

* Personal information
* Avatar upload
* Password change
* Two-factor authentication
* Connected accounts
* Notification preferences

## Project Management

* Saved projects
* Favorites
* Recent activity
* Playground sessions

## Subscription

* Current plan
* Usage metrics
* Upgrade/downgrade
* Billing history
* Payment methods

## Downloads

* Purchased templates
* Downloaded components
* License keys
* Update history

## API

* API keys
* Usage statistics
* Documentation

---

# Dashboard Layout

```text
┌─────────────────────────────────────────────────────┐
│ My Dashboard                        🔔 2  👤 John ▼ │
├───────────┬─────────────────────────────────────────┤
│           │                                         │
│ Sidebar   │        Content Area                     │
│           │                                         │
│ 👤 Profile│  Welcome back, John!                    │
│ 📁 Projects│  ────────────────────────────────      │
│ 📥 Downloads│                                        │
│ 💳 Subscription│ Quick Stats                         │
│ 💰 Billing│  ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐  │
│ 🔑 API Keys│ │ Pro  │ │ 12   │ │ 45   │ │ $49  │  │
│ ⚙️ Settings│ │ Plan │ │ Files│ │Hours │ │Saved │  │
│           │ └──────┘ └──────┘ └──────┘ └──────┘  │
│           │                                         │
│           │ Recent Activity                         │
│           │ ────────────────────────────────        │
│           │ • Downloaded Dashboard Template (2h)    │
│           │ • Updated profile (1d)                  │
│           │ • Created project (3d)                  │
│           │                                         │
│           │ Favorite Projects                       │
│           │ ────────────────────────────────        │
│           │ [Card] [Card] [Card]                    │
│           │                                         │
└───────────┴─────────────────────────────────────────┘
```

---

# Profile Management

## Profile Form

```text
Profile Settings
────────────────

Avatar
[Upload Avatar]

Name
[John Doe]

Email
[john@example.com]

Bio
[Full-stack developer passionate about Laravel...]

Location
[San Francisco, CA]

Website
[https://johndoe.com]

GitHub
[johndoe]

Twitter
[@johndoe]

[Save Changes]
```

## Security Settings

```text
Security
────────

Password
[Change Password]

Two-Factor Authentication
[Enable 2FA]

Connected Accounts
├── GitHub ✓ Connected
├── Google ○ Connect
└── Twitter ○ Connect

Active Sessions
├── Chrome on macOS (current)
├── Safari on iPhone
└── [Revoke All Other Sessions]
```

---

# Project Management

## Projects List

```text
My Projects (12)
────────────────
[Search projects...] [New Project] [Filter ▼]

Name              Type        Updated     Status
──────────────────────────────────────────────────
SaaS Dashboard    Template    2 hours ago Active
Landing Page      Template    1 day ago   Active
Blog Theme        Theme       3 days ago  Active
...
```

## Project Detail

```text
Project: SaaS Dashboard
────────────────────────

Files (24)
├── resources/
│   ├── views/
│   │   ├── dashboard.blade.php
│   │   └── components/
│   └── css/
│       └── app.css
├── routes/
│   └── web.php
└── README.md

Actions
├── [Open in Playground]
├── [Download ZIP]
├── [Share]
├── [Duplicate]
└── [Delete]
```

---

# Subscription Management

## Current Plan

```text
Current Plan: Pro
────────────────

Status: Active
Renewal: February 15, 2024
Payment: Visa •••• 4242

Features Included
├── ✓ Premium Components
├── ✓ Premium Templates
├── ✓ Advanced Themes
├── ✓ AI Assistant
├── ✓ Priority Support
└── ✓ Team Workspaces

Usage This Month
├── AI Credits: 45/100 used
├── API Calls: 12,000/50,000
└── Storage: 2.5GB/10GB

[Upgrade Plan] [Cancel Subscription]
```

## Plan Comparison

```text
Upgrade to Team
───────────────

Feature          Pro        Team
────────────────────────────────
Users            1          5
AI Credits       100/mo     500/mo
API Calls        50,000/mo  250,000/mo
Storage          10GB       50GB
Support          Priority   Dedicated

Price: $49/mo → $99/mo

[Upgrade to Team]
```

---

# Downloads

## Downloads List

```text
Downloads (24)
──────────────
[Search downloads...] [Filter ▼]

Name              Type       Version  Date       License
──────────────────────────────────────────────────────────
SaaS Starter      Template   1.2.0    Jan 2024   Pro
Dashboard Kit     Template   1.0.0    Dec 2023   Pro
Dark Theme        Theme      2.1.0    Nov 2023   Pro
...
```

## License Management

```text
Licenses (8)
────────────

SaaS Starter - Pro License
├── License Key: XXXX-XXXX-XXXX-XXXX
├── Valid Until: January 2025
├── Projects: 3/5 used
└── [View Details] [Manage Projects]

Dashboard Kit - Team License
├── License Key: YYYY-YYYY-YYYY-YYYY
├── Valid Until: December 2024
├── Projects: Unlimited
└── [View Details]
```

---

# API Management

## API Keys

```text
API Keys (2)
────────────

Production Key
├── Key: gsm_live_••••••••••••••••
├── Created: January 1, 2024
├── Last Used: 2 hours ago
├── Calls Today: 1,234
└── [Regenerate] [Revoke]

Development Key
├── Key: gsm_test_••••••••••••••••
├── Created: January 15, 2024
├── Last Used: 1 day ago
├── Calls Today: 456
└── [Regenerate] [Revoke]

[Create New Key]
```

## Usage Statistics

```text
API Usage (Last 30 Days)
─────────────────────────

Total Calls: 45,000
├── Components API: 25,000
├── Documentation API: 15,000
└── Search API: 5,000

Rate Limit: 1,000/hour
Current: 234/hour
```

---

# Notification Preferences

```text
Notifications
─────────────

Email Notifications
├── [✓] Product updates
├── [✓] Security alerts
├── [ ] Marketing emails
├── [✓] Billing reminders
└── [ ] Newsletter

In-App Notifications
├── [✓] System messages
├── [✓] Project updates
├── [✓] Subscription changes
└── [ ] Comments
```

---

# Technical Architecture

```text
Frontend (Livewire)
    ↓
Dashboard Service
    ├── Profile Service
    ├── Project Service
    ├── Subscription Service
    ├── Download Service
    ├── API Service
    └── Notification Service
    ↓
Database (MySQL)
Storage (S3)
Cache (Redis)
```

---

# Database Schema

Key tables:

* `user_profiles` — Extended profile data
* `user_projects` — Saved projects
* `user_favorites` — User favorites
* `user_api_keys` — API keys
* `user_notifications` — User notifications

---

# Success Metrics

* <200ms page load
* 90%+ task completion rate
* 85%+ user satisfaction
* 50%+ feature adoption
* Zero data loss

---

# Database Schema (Extended)

## user_profiles

```sql
CREATE TABLE user_profiles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED UNIQUE NOT NULL,
    avatar_url VARCHAR(500) NULL,
    bio TEXT NULL,
    location VARCHAR(255) NULL,
    website VARCHAR(500) NULL,
    github_username VARCHAR(255) NULL,
    twitter_handle VARCHAR(255) NULL,
    company VARCHAR(255) NULL,
    job_title VARCHAR(255) NULL,
    timezone VARCHAR(50) DEFAULT 'UTC',
    locale VARCHAR(10) DEFAULT 'en',
    two_factor_enabled BOOLEAN DEFAULT FALSE,
    two_factor_secret VARCHAR(255) NULL,
    two_factor_recovery_codes JSON NULL,
    last_login_at TIMESTAMP NULL,
    last_login_ip VARCHAR(45) NULL,
    login_count INT DEFAULT 0,
    email_verified_at TIMESTAMP NULL,
    onboarding_completed BOOLEAN DEFAULT FALSE,
    custom_fields JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## user_projects

```sql
CREATE TABLE user_projects (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT NULL,
    type ENUM('template','theme','component','custom') NOT NULL DEFAULT 'custom',
    status ENUM('active','archived','deleted') NOT NULL DEFAULT 'active',
    visibility ENUM('private','public','team') NOT NULL DEFAULT 'private',
    thumbnail_url VARCHAR(500) NULL,
    files JSON NULL,
    settings JSON NULL,
    last_opened_at TIMESTAMP NULL,
    forked_from_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_user (user_id),
    INDEX idx_type (type),
    INDEX idx_status (status),
    INDEX idx_last_opened (last_opened_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (forked_from_id) REFERENCES user_projects(id) ON DELETE SET NULL
);
```

## user_favorites

```sql
CREATE TABLE user_favorites (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    favoritable_type VARCHAR(255) NOT NULL,
    favoritable_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE INDEX idx_unique_favorite (user_id, favoritable_type, favoritable_id),
    INDEX idx_user (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## user_api_keys

```sql
CREATE TABLE user_api_keys (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    key_hash VARCHAR(255) NOT NULL,
    key_prefix VARCHAR(10) NOT NULL,
    type ENUM('live','test') NOT NULL DEFAULT 'test',
    abilities JSON NULL,
    last_used_at TIMESTAMP NULL,
    last_used_ip VARCHAR(45) NULL,
    expires_at TIMESTAMP NULL,
    revoked_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_key_hash (key_hash),
    INDEX idx_prefix (key_prefix),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## user_notifications

```sql
CREATE TABLE user_notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    type VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    data JSON NULL,
    read_at TIMESTAMP NULL,
    action_url VARCHAR(500) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_read (read_at),
    INDEX idx_created (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## user_sessions

```sql
CREATE TABLE user_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_last_activity (last_activity),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## user_activity_log

```sql
CREATE TABLE user_activity_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    action VARCHAR(255) NOT NULL,
    subject_type VARCHAR(255) NULL,
    subject_id BIGINT UNSIGNED NULL,
    description TEXT NULL,
    metadata JSON NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_action (action),
    INDEX idx_subject (subject_type, subject_id),
    INDEX idx_created (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## user_downloads

```sql
CREATE TABLE user_downloads (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    product_type VARCHAR(255) NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_version VARCHAR(50) NOT NULL,
    license_key VARCHAR(255) NULL,
    download_count INT DEFAULT 0,
    last_downloaded_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_product (product_type, product_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

# Dashboard Service Layer

## DashboardService

```php
<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Models\UserProfile;
use App\Services\Subscription\SubscriptionService;
use App\Services\Download\DownloadService;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function __construct(
        protected ProfileService $profileService,
        protected ProjectService $projectService,
        protected SubscriptionService $subscriptionService,
        protected DownloadService $downloadService,
        protected ApiKeyService $apiKeyService,
        protected NotificationService $notificationService,
    ) {}

    public function getDashboardData(User $user): array
    {
        $cacheKey = "dashboard:{$user->id}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($user) {
            return [
                'user' => $user->only(['id', 'name', 'email', 'created_at']),
                'profile' => $this->profileService->getProfile($user),
                'stats' => $this->getQuickStats($user),
                'recent_activity' => $this->getRecentActivity($user, 10),
                'favorite_projects' => $this->projectService->getFavorites($user, 6),
                'notifications' => $this->notificationService->getUnread($user, 5),
                'subscription' => $this->subscriptionService->getCurrentPlan($user),
                'usage' => $this->subscriptionService->getUsage($user),
            ];
        });
    }

    public function getQuickStats(User $user): array
    {
        return [
            'plan' => $this->subscriptionService->getPlanName($user),
            'projects_count' => $this->projectService->countActive($user),
            'downloads_count' => $this->downloadService->countDownloads($user),
            'api_calls_today' => $this->apiKeyService->getCallsToday($user),
            'savings' => $this->calculateSavings($user),
            'ai_credits_used' => $this->getAiCreditsUsed($user),
            'ai_credits_total' => $this->getAiCreditsTotal($user),
            'storage_used' => $this->getStorageUsed($user),
            'storage_total' => $this->getStorageTotal($user),
        ];
    }

    public function getRecentActivity(User $user, int $limit = 10): array
    {
        return $user->activity()
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn ($activity) => [
                'id' => $activity->id,
                'action' => $activity->action,
                'description' => $activity->description,
                'subject_type' => $activity->subject_type,
                'subject_id' => $activity->subject_id,
                'created_at' => $activity->created_at->diffForHumans(),
                'icon' => $this->getActivityIcon($activity->action),
            ])
            ->toArray();
    }

    protected function getActivityIcon(string $action): string
    {
        return match ($action) {
            'project.created' => 'folder-plus',
            'project.opened' => 'folder-open',
            'download.completed' => 'arrow-down-tray',
            'profile.updated' => 'user',
            'subscription.upgraded' => 'arrow-up',
            'api_key.created' => 'key',
            'theme.applied' => 'paint-brush',
            default => 'clock',
        };
    }

    protected function calculateSavings(User $user): float
    {
        $downloads = $this->downloadService->getTotalValue($user);
        $subscription = $this->subscriptionService->getTotalSpent($user);
        return max(0, $downloads - $subscription);
    }

    protected function getAiCreditsUsed(User $user): int
    {
        return Cache::remember("ai_credits:used:{$user->id}:{$this->currentMonth()}", now()->addMinutes(5), function () use ($user) {
            return $user->aiCredits()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('credits_used');
        });
    }

    protected function getAiCreditsTotal(User $user): int
    {
        $plan = $this->subscriptionService->getCurrentPlan($user);
        return $plan['ai_credits'] ?? 0;
    }

    protected function getStorageUsed(User $user): string
    {
        $bytes = Cache::remember("storage:used:{$user->id}", now()->addHour(), function () use ($user) {
            return $user->media()->sum('file_size');
        });
        return $this->formatBytes($bytes);
    }

    protected function getStorageTotal(User $user): string
    {
        $plan = $this->subscriptionService->getCurrentPlan($user);
        return $this->formatBytes(($plan['storage_bytes'] ?? 10 * 1024 * 1024 * 1024));
    }

    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 1) . ' ' . $units[$i];
    }

    protected function currentMonth(): string
    {
        return now()->format('Y-m');
    }
}
```

## ProfileService

```php
<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function getProfile(User $user): array
    {
        $profile = $user->profile ?? UserProfile::create(['user_id' => $user->id]);

        return [
            'name' => $user->name,
            'email' => $user->email,
            'avatar_url' => $profile->avatar_url,
            'bio' => $profile->bio,
            'location' => $profile->location,
            'website' => $profile->website,
            'github_username' => $profile->github_username,
            'twitter_handle' => $profile->twitter_handle,
            'company' => $profile->company,
            'job_title' => $profile->job_title,
            'timezone' => $profile->timezone,
            'locale' => $profile->locale,
            'two_factor_enabled' => $profile->two_factor_enabled,
            'email_verified_at' => $user->email_verified_at,
            'onboarding_completed' => $profile->onboarding_completed,
            'created_at' => $user->created_at,
        ];
    }

    public function updateProfile(User $user, array $data): array
    {
        $user->update(collect($data)->only(['name', 'email'])->toArray());

        $profile = $user->profile ?? UserProfile::create(['user_id' => $user->id]);
        $profile->update(collect($data)->only([
            'bio', 'location', 'website', 'github_username',
            'twitter_handle', 'company', 'job_title',
            'timezone', 'locale',
        ])->toArray());

        return $this->getProfile($user);
    }

    public function updateAvatar(User $user, UploadedFile $file): string
    {
        $profile = $user->profile ?? UserProfile::create(['user_id' => $user->id]);

        if ($profile->avatar_url) {
            Storage::disk('public')->delete($profile->avatar_url);
        }

        $path = $file->store('avatars', 'public');
        $profile->update(['avatar_url' => $path]);

        return Storage::disk('public')->url($path);
    }

    public function removeAvatar(User $user): void
    {
        $profile = $user->profile;
        if ($profile && $profile->avatar_url) {
            Storage::disk('public')->delete($profile->avatar_url);
            $profile->update(['avatar_url' => null]);
        }
    }

    public function changePassword(User $user, string $currentPassword, string $newPassword): bool
    {
        if (!Hash::check($currentPassword, $user->password)) {
            return false;
        }

        $user->update(['password' => Hash::make($newPassword)]);
        return true;
    }

    public function getSecuritySettings(User $user): array
    {
        $profile = $user->profile;
        return [
            'two_factor_enabled' => $profile?->two_factor_enabled ?? false,
            'email_verified' => $user->hasVerifiedEmail(),
            'last_login_at' => $profile?->last_login_at,
            'last_login_ip' => $profile?->last_login_ip,
            'login_count' => $profile?->login_count ?? 0,
            'active_sessions' => $this->getActiveSessions($user),
            'connected_accounts' => $this->getConnectedAccounts($user),
        ];
    }

    protected function getActiveSessions(User $user): array
    {
        return $user->sessions()
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(fn ($session) => [
                'id' => $session->id,
                'ip_address' => $session->ip_address,
                'user_agent' => $this->parseUserAgent($session->user_agent),
                'last_activity' => $session->last_activity,
                'is_current' => $session->id === session()->getId(),
            ])
            ->toArray();
    }

    protected function getConnectedAccounts(User $user): array
    {
        return $user->socialAccounts()
            ->get()
            ->map(fn ($account) => [
                'provider' => $account->provider,
                'provider_id' => $account->provider_id,
                'connected' => true,
            ])
            ->toArray();
    }

    protected function parseUserAgent(string $userAgent): array
    {
        $browser = 'Unknown Browser';
        $os = 'Unknown OS';

        if (str_contains($userAgent, 'Chrome')) $browser = 'Chrome';
        elseif (str_contains($userAgent, 'Firefox')) $browser = 'Firefox';
        elseif (str_contains($userAgent, 'Safari')) $browser = 'Safari';
        elseif (str_contains($userAgent, 'Edge')) $browser = 'Edge';

        if (str_contains($userAgent, 'Windows')) $os = 'Windows';
        elseif (str_contains($userAgent, 'Mac OS')) $os = 'macOS';
        elseif (str_contains($userAgent, 'Linux')) $os = 'Linux';
        elseif (str_contains($userAgent, 'iPhone')) $os = 'iPhone';
        elseif (str_contains($userAgent, 'Android')) $os = 'Android';

        return ['browser' => $browser, 'os' => $os];
    }
}
```

## ProjectService

```php
<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Models\UserProject;

class ProjectService
{
    public function getProjects(User $user, int $limit = 20, int $offset = 0, string $search = null, string $type = null, string $status = null): array
    {
        $query = $user->projects()
            ->orderBy('last_opened_at', 'desc');

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }
        if ($type) {
            $query->where('type', $type);
        }
        if ($status) {
            $query->where('status', $status);
        }

        $total = $query->count();
        $projects = $query->limit($limit)->offset($offset)->get();

        return [
            'total' => $total,
            'projects' => $projects->toArray(),
        ];
    }

    public function getProject(User $user, int $projectId): ?array
    {
        $project = $user->projects()->find($projectId);
        if (!$project) {
            return null;
        }

        return $project->toArray();
    }

    public function createProject(User $user, array $data): array
    {
        $project = $user->projects()->create([
            'name' => $data['name'],
            'slug' => $this->generateSlug($user, $data['name']),
            'description' => $data['description'] ?? null,
            'type' => $data['type'] ?? 'custom',
            'visibility' => $data['visibility'] ?? 'private',
            'settings' => $data['settings'] ?? null,
        ]);

        activity('project.created')
            ->causedBy($user)
            ->withProperties(['project_id' => $project->id])
            ->log('Project created');

        return $project->toArray();
    }

    public function updateProject(User $user, int $projectId, array $data): array
    {
        $project = $user->projects()->findOrFail($projectId);
        $project->update(collect($data)->only([
            'name', 'description', 'visibility', 'settings', 'thumbnail_url',
        ])->toArray());

        activity('project.updated')
            ->causedBy($user)
            ->withProperties(['project_id' => $project->id])
            ->log('Project updated');

        return $project->fresh()->toArray();
    }

    public function deleteProject(User $user, int $projectId): bool
    {
        $project = $user->projects()->findOrFail($projectId);
        $project->delete();

        activity('project.deleted')
            ->causedBy($user)
            ->withProperties(['project_id' => $projectId])
            ->log('Project deleted');

        return true;
    }

    public function archiveProject(User $user, int $projectId): array
    {
        $project = $user->projects()->findOrFail($projectId);
        $project->update(['status' => 'archived']);

        activity('project.archived')
            ->causedBy($user)
            ->withProperties(['project_id' => $projectId])
            ->log('Project archived');

        return $project->fresh()->toArray();
    }

    public function duplicateProject(User $user, int $projectId): array
    {
        $original = $user->projects()->findOrFail($projectId);
        $clone = $original->replicate();
        $clone->name = "{$original->name} (Copy)";
        $clone->slug = $this->generateSlug($user, $clone->name);
        $clone->status = 'active';
        $clone->save();

        activity('project.duplicated')
            ->causedBy($user)
            ->withProperties(['original_id' => $projectId, 'clone_id' => $clone->id])
            ->log('Project duplicated');

        return $clone->toArray();
    }

    public function toggleFavorite(User $user, int $projectId): bool
    {
        $exists = $user->favorites()
            ->where('favoritable_type', UserProject::class)
            ->where('favoritable_id', $projectId)
            ->exists();

        if ($exists) {
            $user->favorites()
                ->where('favoritable_type', UserProject::class)
                ->where('favoritable_id', $projectId)
                ->delete();
            return false;
        }

        $user->favorites()->create([
            'favoritable_type' => UserProject::class,
            'favoritable_id' => $projectId,
        ]);
        return true;
    }

    public function getFavorites(User $user, int $limit = 6): array
    {
        return $user->favorites()
            ->where('favoritable_type', UserProject::class)
            ->with('favoritable')
            ->limit($limit)
            ->get()
            ->pluck('favoritable')
            ->filter()
            ->toArray();
    }

    public function countActive(User $user): int
    {
        return $user->projects()->where('status', 'active')->count();
    }

    protected function generateSlug(User $user, string $name): string
    {
        $slug = str($name)->slug()->toString();
        $original = $slug;
        $counter = 1;
        while ($user->projects()->where('slug', $slug)->exists()) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }
        return $slug;
    }
}
```

## ApiKeyService

```php
<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Models\UserApiKey;
use Illuminate\Support\Str;

class ApiKeyService
{
    public function getKeys(User $user): array
    {
        return $user->apiKeys()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($key) => [
                'id' => $key->id,
                'name' => $key->name,
                'type' => $key->type,
                'key_prefix' => $key->key_prefix,
                'last_used_at' => $key->last_used_at,
                'last_used_ip' => $key->last_used_ip,
                'expires_at' => $key->expires_at,
                'created_at' => $key->created_at,
                'is_active' => is_null($key->revoked_at),
            ])
            ->toArray();
    }

    public function createKey(User $user, string $name, string $type = 'test', array $abilities = null): array
    {
        $plainKey = Str::random(40);
        $keyHash = hash('sha256', $plainKey);
        $keyPrefix = substr($plainKey, 0, 8);

        $apiKey = $user->apiKeys()->create([
            'name' => $name,
            'key_hash' => $keyHash,
            'key_prefix' => $keyPrefix,
            'type' => $type,
            'abilities' => $abilities,
        ]);

        activity('api_key.created')
            ->causedBy($user)
            ->withProperties(['key_id' => $apiKey->id, 'key_name' => $name])
            ->log('API key created');

        return [
            'id' => $apiKey->id,
            'name' => $apiKey->name,
            'key' => $plainKey,
            'type' => $apiKey->type,
            'created_at' => $apiKey->created_at,
        ];
    }

    public function revokeKey(User $user, int $keyId): bool
    {
        $key = $user->apiKeys()->findOrFail($keyId);
        $key->update(['revoked_at' => now()]);

        activity('api_key.revoked')
            ->causedBy($user)
            ->withProperties(['key_id' => $keyId])
            ->log('API key revoked');

        return true;
    }

    public function regenerateKey(User $user, int $keyId): array
    {
        $oldKey = $user->apiKeys()->findOrFail($keyId);
        $oldKey->update(['revoked_at' => now()]);

        return $this->createKey($user, $oldKey->name, $oldKey->type, $oldKey->abilities);
    }

    public function getUsageStats(User $user, int $days = 30): array
    {
        $from = now()->subDays($days);
        $keys = $user->apiKeys()->pluck('id');

        $logs = \App\Models\ApiLog::whereIn('api_key_id', $keys)
            ->where('created_at', '>=', $from)
            ->get();

        $totalCalls = $logs->count();
        $callsByDay = $logs->groupBy(fn ($log) => $log->created_at->format('Y-m-d'))
            ->map(fn ($dayLogs) => $dayLogs->count())
            ->toArray();
        $callsByKey = $logs->groupBy('api_key_id')
            ->map(fn ($keyLogs) => $keyLogs->count())
            ->toArray();
        $errorRate = $logs->where('status_code', '>=', 400)->count() / max($totalCalls, 1);
        $avgResponseTime = $logs->avg('response_time_ms');

        return [
            'total_calls' => $totalCalls,
            'calls_by_day' => $callsByDay,
            'calls_by_key' => $callsByKey,
            'error_rate' => round($errorRate * 100, 2),
            'avg_response_time_ms' => round($avgResponseTime, 2),
            'rate_limit' => $this->getRateLimit($user),
        ];
    }

    public function getCallsToday(User $user): int
    {
        $keys = $user->apiKeys()->pluck('id');
        return \App\Models\ApiLog::whereIn('api_key_id', $keys)
            ->whereDate('created_at', today())
            ->count();
    }

    protected function getRateLimit(User $user): array
    {
        $plan = app(SubscriptionService::class)->getCurrentPlan($user);
        return [
            'per_minute' => $plan['rate_limit_minute'] ?? 60,
            'per_hour' => $plan['rate_limit_hour'] ?? 1000,
            'per_day' => $plan['rate_limit_day'] ?? 10000,
        ];
    }
}
```

## NotificationService

```php
<?php

namespace App\Services\Dashboard;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class NotificationService
{
    public function getNotifications(User $user, int $limit = 20, bool $unreadOnly = false): array
    {
        $query = $user->notifications()->orderBy('created_at', 'desc');

        if ($unreadOnly) {
            $query->whereNull('read_at');
        }

        return $query->limit($limit)->get()->toArray();
    }

    public function getUnread(User $user, int $limit = 5): array
    {
        return $this->getNotifications($user, $limit, true);
    }

    public function getUnreadCount(User $user): int
    {
        $cacheKey = "notifications:unread:{$user->id}";
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($user) {
            return $user->notifications()->whereNull('read_at')->count();
        });
    }

    public function markAsRead(User $user, int $notificationId): bool
    {
        $notification = $user->notifications()->findOrFail($notificationId);
        $notification->update(['read_at' => now()]);
        Cache::forget("notifications:unread:{$user->id}");
        return true;
    }

    public function markAllAsRead(User $user): int
    {
        $count = $user->notifications()->whereNull('read_at')->update(['read_at' => now()]);
        Cache::forget("notifications:unread:{$user->id}");
        return $count;
    }

    public function deleteNotification(User $user, int $notificationId): bool
    {
        $user->notifications()->findOrFail($notificationId)->delete();
        Cache::forget("notifications:unread:{$user->id}");
        return true;
    }

    public function getPreferences(User $user): array
    {
        $profile = $user->profile;
        return $profile->notification_preferences ?? [
            'email' => [
                'product_updates' => true,
                'security_alerts' => true,
                'marketing' => false,
                'billing_reminders' => true,
                'newsletter' => false,
            ],
            'in_app' => [
                'system_messages' => true,
                'project_updates' => true,
                'subscription_changes' => true,
                'comments' => false,
            ],
        ];
    }

    public function updatePreferences(User $user, array $preferences): array
    {
        $profile = $user->profile ?? \App\Models\UserProfile::create(['user_id' => $user->id]);
        $profile->update(['notification_preferences' => $preferences]);
        return $preferences;
    }
}
```

---

# Dashboard Livewire Components

## DashboardIndex Component

```php
<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Services\Dashboard\DashboardService;

class DashboardIndex extends Component
{
    public $stats = [];
    public $recentActivity = [];
    public $favoriteProjects = [];
    public $notifications = [];
    public $subscription = [];
    public $usage = [];

    protected DashboardService $dashboardService;

    public function boot(DashboardService $dashboardService): void
    {
        $this->dashboardService = $dashboardService;
    }

    public function mount(): void
    {
        $this->loadDashboard();
    }

    public function loadDashboard(): void
    {
        $user = auth()->user();
        $data = $this->dashboardService->getDashboardData($user);

        $this->stats = $data['stats'];
        $this->recentActivity = $data['recent_activity'];
        $this->favoriteProjects = $data['favorite_projects'];
        $this->notifications = $data['notifications'];
        $this->subscription = $data['subscription'];
        $this->usage = $data['usage'];
    }

    public function refresh(): void
    {
        $this->loadDashboard();
    }

    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
```

## ProfileSettings Component

```php
<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\Dashboard\ProfileService;

class ProfileSettings extends Component
{
    use WithFileUploads;

    public $name = '';
    public $email = '';
    public $bio = '';
    public $location = '';
    public $website = '';
    public $github_username = '';
    public $twitter_handle = '';
    public $company = '';
    public $job_title = '';
    public $timezone = 'UTC';
    public $locale = 'en';
    public $avatar;
    public $avatarUrl;

    protected ProfileService $profileService;

    public function boot(ProfileService $profileService): void
    {
        $this->profileService = $profileService;
    }

    public function mount(): void
    {
        $profile = $this->profileService->getProfile(auth()->user());
        $this->fill($profile);
        $this->avatarUrl = $profile['avatar_url'];
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:500',
            'github_username' => 'nullable|string|max:255',
            'twitter_handle' => 'nullable|string|max:255',
            'timezone' => 'required|string',
            'locale' => 'required|string',
        ]);

        $this->profileService->updateProfile(auth()->user(), $this->only([
            'name', 'email', 'bio', 'location', 'website',
            'github_username', 'twitter_handle', 'company',
            'job_title', 'timezone', 'locale',
        ]));

        $this->dispatch('profile-saved');
    }

    public function updateAvatar(): void
    {
        $this->validate(['avatar' => 'required|image|max:2048']);
        $this->avatarUrl = $this->profileService->updateAvatar(auth()->user(), $this->avatar);
        $this->dispatch('avatar-updated');
    }

    public function removeAvatar(): void
    {
        $this->profileService->removeAvatar(auth()->user());
        $this->avatarUrl = null;
        $this->dispatch('avatar-removed');
    }

    public function render()
    {
        return view('livewire.dashboard.profile-settings');
    }
}
```

## ProjectsList Component

```php
<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Dashboard\ProjectService;

class ProjectsList extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $status = '';
    public $viewMode = 'grid';
    public $projects = [];
    public $total = 0;

    protected ProjectService $projectService;

    public function boot(ProjectService $projectService): void
    {
        $this->projectService = $projectService;
    }

    public function mount(): void
    {
        $this->loadProjects();
    }

    public function updatedSearch(): void
    {
        $this->loadProjects();
    }

    public function updatedType(): void
    {
        $this->loadProjects();
    }

    public function updatedStatus(): void
    {
        $this->loadProjects();
    }

    public function loadProjects(): void
    {
        $result = $this->projectService->getProjects(
            auth()->user(),
            20,
            ($this->page - 1) * 20,
            $this->search ?: null,
            $this->type ?: null,
            $this->status ?: null
        );

        $this->projects = $result['projects'];
        $this->total = $result['total'];
    }

    public function createProject(array $data): void
    {
        $this->projectService->createProject(auth()->user(), $data);
        $this->loadProjects();
        $this->dispatch('project-created');
    }

    public function deleteProject(int $projectId): void
    {
        $this->projectService->deleteProject(auth()->user(), $projectId);
        $this->loadProjects();
        $this->dispatch('project-deleted');
    }

    public function toggleFavorite(int $projectId): void
    {
        $this->projectService->toggleFavorite(auth()->user(), $projectId);
        $this->loadProjects();
    }

    public function render()
    {
        return view('livewire.dashboard.projects-list');
    }
}
```

---

# Dashboard Routes

```php
<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\DownloadController;
use App\Http\Controllers\Dashboard\SubscriptionController;
use App\Http\Controllers\Dashboard\BillingController;
use App\Http\Controllers\Dashboard\ApiKeyController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('dashboard.profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('dashboard.profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('dashboard.profile.avatar');
    Route::delete('/profile/avatar', [ProfileController::class, 'removeAvatar'])->name('dashboard.profile.avatar.remove');
    Route::get('/profile/security', [ProfileController::class, 'security'])->name('dashboard.profile.security');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('dashboard.profile.password');
    Route::post('/profile/2fa/enable', [ProfileController::class, 'enable2fa'])->name('dashboard.profile.2fa.enable');
    Route::post('/profile/2fa/disable', [ProfileController::class, 'disable2fa'])->name('dashboard.profile.2fa.disable');
    Route::delete('/profile/sessions/{session}', [ProfileController::class, 'revokeSession'])->name('dashboard.profile.sessions.revoke');
    Route::delete('/profile/sessions', [ProfileController::class, 'revokeAllSessions'])->name('dashboard.profile.sessions.revoke-all');

    // Projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('dashboard.projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('dashboard.projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('dashboard.projects.show');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('dashboard.projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('dashboard.projects.destroy');
    Route::post('/projects/{project}/duplicate', [ProjectController::class, 'duplicate'])->name('dashboard.projects.duplicate');
    Route::post('/projects/{project}/archive', [ProjectController::class, 'archive'])->name('dashboard.projects.archive');
    Route::post('/projects/{project}/favorite', [ProjectController::class, 'toggleFavorite'])->name('dashboard.projects.favorite');

    // Downloads
    Route::get('/downloads', [DownloadController::class, 'index'])->name('dashboard.downloads.index');
    Route::get('/downloads/{download}/download', [DownloadController::class, 'download'])->name('dashboard.downloads.download');
    Route::get('/licenses', [DownloadController::class, 'licenses'])->name('dashboard.licenses');

    // Subscription
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('dashboard.subscription.index');
    Route::post('/subscription/upgrade', [SubscriptionController::class, 'upgrade'])->name('dashboard.subscription.upgrade');
    Route::post('/subscription/downgrade', [SubscriptionController::class, 'downgrade'])->name('dashboard.subscription.downgrade');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('dashboard.subscription.cancel');

    // Billing
    Route::get('/billing', [BillingController::class, 'index'])->name('dashboard.billing.index');
    Route::get('/invoices', [BillingController::class, 'invoices'])->name('dashboard.billing.invoices');
    Route::get('/invoices/{invoice}/pdf', [BillingController::class, 'downloadPdf'])->name('dashboard.billing.invoice.pdf');
    Route::post('/payment-methods', [BillingController::class, 'addPaymentMethod'])->name('dashboard.billing.payment-methods.store');
    Route::delete('/payment-methods/{method}', [BillingController::class, 'removePaymentMethod'])->name('dashboard.billing.payment-methods.destroy');

    // API Keys
    Route::get('/api-keys', [ApiKeyController::class, 'index'])->name('dashboard.api-keys.index');
    Route::post('/api-keys', [ApiKeyController::class, 'store'])->name('dashboard.api-keys.store');
    Route::post('/api-keys/{key}/regenerate', [ApiKeyController::class, 'regenerate'])->name('dashboard.api-keys.regenerate');
    Route::delete('/api-keys/{key}', [ApiKeyController::class, 'destroy'])->name('dashboard.api-keys.destroy');

    // Notifications
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('dashboard.notifications');
    Route::post('/notifications/{notification}/read', [DashboardController::class, 'markRead'])->name('dashboard.notifications.read');
    Route::post('/notifications/read-all', [DashboardController::class, 'markAllRead'])->name('dashboard.notifications.read-all');

    // Settings
    Route::get('/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
    Route::put('/settings/notifications', [DashboardController::class, 'updateNotificationPreferences'])->name('dashboard.settings.notifications');
    Route::put('/settings/appearance', [DashboardController::class, 'updateAppearance'])->name('dashboard.settings.appearance');
});
```

---

# API Endpoints (Dashboard)

```
GET    /api/v1/user/profile            Get user profile
PUT    /api/v1/user/profile            Update user profile
POST   /api/v1/user/avatar             Upload avatar
DELETE /api/v1/user/avatar             Remove avatar
PUT    /api/v1/user/password           Change password
GET    /api/v1/user/2fa                Get 2FA status
POST   /api/v1/user/2fa/enable         Enable 2FA
POST   /api/v1/user/2fa/disable        Disable 2FA
GET    /api/v1/user/sessions           List active sessions
DELETE /api/v1/user/sessions/{id}      Revoke session
DELETE /api/v1/user/sessions           Revoke all sessions
GET    /api/v1/user/projects           List projects
POST   /api/v1/user/projects           Create project
GET    /api/v1/user/projects/{id}      Get project
PUT    /api/v1/user/projects/{id}      Update project
DELETE /api/v1/user/projects/{id}      Delete project
POST   /api/v1/user/projects/{id}/duplicate  Duplicate project
POST   /api/v1/user/projects/{id}/archive    Archive project
POST   /api/v1/user/projects/{id}/favorite   Toggle favorite
GET    /api/v1/user/downloads          List downloads
GET    /api/v1/user/licenses           List licenses
GET    /api/v1/user/subscription       Get subscription
POST   /api/v1/user/subscription/upgrade     Upgrade plan
POST   /api/v1/user/subscription/downgrade   Downgrade plan
POST   /api/v1/user/subscription/cancel      Cancel subscription
GET    /api/v1/user/billing            Get billing info
GET    /api/v1/user/invoices           List invoices
GET    /api/v1/user/api-keys           List API keys
POST   /api/v1/user/api-keys           Create API key
POST   /api/v1/user/api-keys/{id}/regenerate  Regenerate key
DELETE /api/v1/user/api-keys/{id}      Revoke API key
GET    /api/v1/user/notifications      List notifications
POST   /api/v1/user/notifications/{id}/read   Mark as read
POST   /api/v1/user/notifications/read-all    Mark all as read
GET    /api/v1/user/notification-preferences  Get preferences
PUT    /api/v1/user/notification-preferences  Update preferences
```

---

# Dashboard Caching Strategy

| Cache Key | TTL | Invalidation |
|-----------|-----|--------------|
| `dashboard:{user_id}` | 5 min | On any user action |
| `profile:{user_id}` | 15 min | On profile update |
| `projects:{user_id}:{page}` | 5 min | On project CRUD |
| `favorites:{user_id}` | 5 min | On favorite toggle |
| `notifications:unread:{user_id}` | 5 min | On notification read |
| `api_keys:{user_id}` | 15 min | On key CRUD |
| `api_usage:{user_id}:{month}` | 1 hour | On API call |
| `storage:used:{user_id}` | 1 hour | On upload/delete |
| `ai_credits:used:{user_id}:{month}` | 5 min | On AI usage |

---

# Dashboard Events

```php
<?php

namespace App\Events\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class ProfileUpdated
{
    use Dispatchable;

    public function __construct(
        public User $user,
        public array $changes
    ) {}
}
```

```php
<?php

namespace App\Events\Dashboard;

use App\Models\User;
use App\Models\UserProject;
use Illuminate\Foundation\Events\Dispatchable;

class ProjectCreated
{
    use Dispatchable;

    public function __construct(
        public User $user,
        public UserProject $project
    ) {}
}
```

```php
<?php

namespace App\Events\Dashboard;

use App\Models\User;
use App\Models\UserApiKey;
use Illuminate\Foundation\Events\Dispatchable;

class ApiKeyCreated
{
    use Dispatchable;

    public function __construct(
        public User $user,
        public UserApiKey $apiKey
    ) {}
}
```

---

# Dashboard Listeners

```php
<?php

namespace App\Listeners\Dashboard;

use App\Events\Dashboard\ProfileUpdated;
use Illuminate\Support\Facades\Cache;

class InvalidateProfileCache
{
    public function handle(ProfileUpdated $event): void
    {
        Cache::forget("profile:{$event->user->id}");
        Cache::forget("dashboard:{$event->user->id}");
    }
}
```

```php
<?php

namespace App\Listeners\Dashboard;

use App\Events\Dashboard\ProjectCreated;
use Illuminate\Support\Facades\Cache;

class InvalidateProjectCache
{
    public function handle(ProjectCreated $event): void
    {
        Cache::forget("projects:{$event->user->id}");
        Cache::forget("dashboard:{$event->user->id}");
    }
}
```

---

# User Flow: Update Profile

```text
User navigates to Dashboard > Profile
    ↓
Profile form loads with current data
    ├── Name (pre-filled)
    ├── Email (pre-filled)
    ├── Avatar (current image)
    ├── Bio, Location, Website
    └── Social links
    ↓
User edits fields
    ↓
User clicks "Save Changes"
    ├── Validation runs
    ├── Profile updated in database
    ├── Cache invalidated
    ├── Activity logged
    └── Success message shown
```

---

# User Flow: Manage Projects

```text
User navigates to Dashboard > Projects
    ↓
Project list loads (grid or list view)
    ├── Search bar
    ├── Filter by type (template/theme/component/custom)
    ├── Filter by status (active/archived)
    └── Sort options
    ↓
User can:
    ├── Click "New Project" → creation form
    ├── Click project → project detail
    ├── Click star → toggle favorite
    ├── Click duplicate → clone project
    ├── Click archive → archive project
    └── Click delete → confirm delete
    ↓
Project detail shows:
    ├── Files list
    ├── Settings
    ├── Activity history
    └── Actions (open/download/share)
```

---

# User Flow: Manage Subscription

```text
User navigates to Dashboard > Subscription
    ↓
Current plan displayed
    ├── Plan name and status
    ├── Renewal date
    ├── Payment method
    └── Features included
    ↓
Usage metrics shown
    ├── AI Credits (progress bar)
    ├── API Calls (progress bar)
    └── Storage (progress bar)
    ↓
User can:
    ├── Click "Upgrade Plan" → plan comparison
    ├── Click "Cancel Subscription" → confirmation
    └── View billing history
    ↓
Upgrade flow:
    ├── Select new plan
    ├── Review price change
    ├── Confirm payment
    └── Plan upgraded immediately
```

---

# User Flow: API Key Management

```text
User navigates to Dashboard > API Keys
    ↓
Key list displayed
    ├── Production keys
    └── Development keys
    ↓
User can:
    ├── Click "Create New Key"
    │   ├── Enter key name
    │   ├── Select type (live/test)
    │   ├── Set abilities
    │   └── Copy displayed key (shown once)
    ├── Click "Regenerate" on existing key
    │   ├── Confirmation dialog
    │   ├── Old key revoked
    │   └── New key displayed
    ├── Click "Revoke" on existing key
    │   ├── Confirmation dialog
    │   └── Key immediately invalidated
    └── View usage statistics
        ├── Calls per day chart
        ├── Error rate
        └── Average response time
```

---

# Dashboard Middleware

```php
<?php

namespace App\Http\Middleware\Dashboard;

use Closure;
use Illuminate\Http\Request;

class EnsureProfileComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $profile = $user->profile;

        if (!$profile || !$profile->onboarding_completed) {
            if (!$request->is('dashboard/settings*')) {
                return redirect()->route('dashboard.settings')
                    ->with('info', 'Please complete your profile setup.');
            }
        }

        return $next($request);
    }
}
```

---

# Dashboard Validation Rules

| Field | Rules |
|-------|-------|
| name | required, string, max:255 |
| email | required, email, max:255, unique:users,email,{id} |
| bio | nullable, string, max:500 |
| location | nullable, string, max:255 |
| website | nullable, url, max:500 |
| github_username | nullable, string, max:255, regex:/^[a-zA-Z0-9-]+$/ |
| twitter_handle | nullable, string, max:255, regex:/^@?[a-zA-Z0-9_]+$/ |
| company | nullable, string, max:255 |
| job_title | nullable, string, max:255 |
| timezone | required, string, in:valid_timezones |
| locale | required, string, in:en,ar,fr,de,es |
| avatar | required_with:avatar, image, max:2048, mimes:jpg,png,webp |
| project_name | required, string, max:255 |
| project_type | required, in:template,theme,component,custom |
| api_key_name | required, string, max:255 |
| api_key_type | required, in:live,test |

---

# Dashboard Testing Strategy

## Unit Tests

* ProfileService update methods
* ProjectService CRUD operations
* ApiKeyService key generation
* NotificationService read/unread
* DashboardService stats calculation
* Slug generation uniqueness
* User agent parsing

## Feature Tests

* Profile update flow
* Avatar upload and removal
* Password change
* 2FA enable/disable
* Project CRUD operations
* Project favorite toggle
* API key create/revoke/regenerate
* Subscription upgrade/downgrade
* Notification mark read

## Integration Tests

* Full dashboard data loading
* Cache invalidation on changes
* Activity logging on all actions
* Session management
* Connected account management

---

# Security Considerations

* CSRF on all forms
* Authorization checks (users can only access own data)
* Rate limiting on profile updates
* File upload validation (type, size)
* API key hashing (never stored plaintext)
* Session revocation on password change
* 2FA recovery codes encrypted
* Audit logging for security events

---

# Dashboard Widget System

## Available Widgets

| Widget | Description | Refresh Interval |
|--------|-------------|-----------------|
| QuickStats | Plan, projects, downloads, savings | 5 minutes |
| RecentActivity | Latest user actions | 5 minutes |
| FavoriteProjects | Starred projects grid | 5 minutes |
| SubscriptionStatus | Current plan and usage | 15 minutes |
| NotificationBell | Unread notification count | 1 minute |
| UsageMeter | AI credits, API calls, storage | 5 minutes |
| BillingSummary | Next payment and method | 1 hour |
| APIUsageChart | Daily API call chart | 30 minutes |

## Widget Configuration

```yaml
dashboard_widgets:
  enabled:
    - quick_stats
    - recent_activity
    - favorite_projects
    - subscription_status
    - notification_bell
    - usage_meter
  disabled:
    - billing_summary
    - api_usage_chart
  layout:
    row_1: [quick_stats, subscription_status]
    row_2: [recent_activity, favorite_projects]
    row_3: [usage_meter, notification_bell]
```

## Widget Livewire Component

```php
<?php

namespace App\Http\Livewire\Dashboard\Widgets;

use Livewire\Component;

abstract class DashboardWidget extends Component
{
    public string $widgetId;
    public bool $loading = false;
    public bool $error = false;
    public string $errorMessage = '';

    abstract public function loadData(): void;
    abstract public function getViewName(): string;

    public function boot(): void
    {
        $this->widgetId = static::class;
    }

    public function refresh(): void
    {
        $this->loading = true;
        try {
            $this->loadData();
            $this->error = false;
        } catch (\Exception $e) {
            $this->error = true;
            $this->errorMessage = $e->getMessage();
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view($this->getViewName());
    }
}
```

---

# Dashboard Error Handling

| Error | Display | Recovery |
|-------|---------|----------|
| Profile update fails | Inline validation errors | Fix and resubmit |
| Avatar upload fails | Toast error message | Check file size/type |
| Project not found | 404 page | Redirect to list |
| Subscription error | Banner error | Retry or contact support |
| API key error | Toast error | Retry operation |
| Cache miss | Silent reload | Data loaded from DB |
| Rate limit hit | Countdown timer | Wait and retry |

---

# Dashboard Accessibility

* All forms have associated labels
* Keyboard navigation for all interactive elements
* Focus management on modal open/close
* Screen reader announcements for status changes
* Color contrast ratio minimum 4.5:1
* ARIA landmarks for page structure
* Skip to main content link
* Error messages linked to form fields via aria-describedby
* Loading states announced via aria-live regions

---

# Next Document

**26 - Media Library** — Centralized media management system.
