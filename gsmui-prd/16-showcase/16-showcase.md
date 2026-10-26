# 16 - Showcase

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

The Showcase is a community-driven gallery where developers submit and browse projects built with GsmUi. It serves as inspiration, social proof, and a learning resource.

---

# Vision

Build the most inspiring collection of Laravel applications built with GsmUi, demonstrating the framework's capabilities and the community's creativity.

---

# Core Features

## For Submitters

* Project submission form
* Multiple screenshots
* Live demo link
* Source code link
* Technology stack tags
* Category selection
* Edit submissions
* Analytics dashboard

## For Viewers

* Browse projects
* Filter by category/technology
* Search projects
* Like/favorite projects
* Share projects
* View details
* Leave comments

## For Admin

* Featured projects
* Moderation queue
* Category management
* Analytics
* Community highlights

---

# Showcase Categories

```text
Showcase

├── Application Type
│   ├── SaaS
│   ├── E-commerce
│   ├── Portfolio
│   ├── Blog
│   ├── Dashboard
│   ├── Admin Panel
│   ├── Learning Platform
│   ├── Community
│   └── Other
├── Industry
│   ├── Technology
│   ├── Finance
│   ├── Healthcare
│   ├── Education
│   ├── Entertainment
│   └── Other
└── Complexity
    ├── Beginner
    ├── Intermediate
    └── Advanced
```

---

# Project Submission

## Required Fields

```yaml
title: "My Awesome App"
slug: my-awesome-app
description: "A brief description of the project"
url: "https://myapp.com"
github_url: "https://github.com/user/repo"
screenshots:
  - url: "/screenshots/home.png"
    caption: "Homepage"
  - url: "/screenshots/dashboard.png"
    caption: "Dashboard"
technologies:
  - Laravel 11
  - Livewire 3
  - Tailwind CSS
  - Alpine.js
category: saas
complexity: intermediate
```

## Optional Fields

* Video demo URL
* Case study link
* Author bio
* Development time
* Team size
* Launch date

---

# Project Card

```text
┌─────────────────────────────────────┐
│ [Screenshot]                        │
│                                     │
├─────────────────────────────────────┤
│ Project Title                       │
│ Brief description...                │
│                                     │
│ [Technology Tags]                   │
│                                     │
│ ❤️ 124  👁️ 1.2k  💬 23             │
└─────────────────────────────────────┘
```

---

# Project Detail Page

```text
Project Title
─────────────
Author Name · Category · Date

[Live Demo] [Source Code]

Screenshot Gallery
─────────────────
[Main Screenshot]
[Thumbnail 1] [Thumbnail 2] [Thumbnail 3]

Description
───────────
Detailed project description...

Technology Stack
────────────────
[Technology Tags]

Development Details
───────────────────
- Development Time: 3 months
- Team Size: 2 developers
- Launch Date: January 2024

Comments
────────
[Comment List]
[Add Comment]

Related Projects
────────────────
[Project Cards]
```

---

# Engagement Features

## Likes/Favorites

* Toggle like button
* Like count display
* "Most Liked" sorting
* Personal favorites list

## Comments

* Threaded comments
* Markdown support
* @mentions
* Edit/delete own comments
* Moderation queue

## Sharing

* Social media sharing
* Direct link sharing
* Embed code for blogs
* QR code generation

---

# Discovery Features

## Browse

* Category pages
* Technology pages
* Featured projects
* Trending projects
* New submissions
* Random project

## Search

* Full-text search
* Technology filter
* Category filter
* Complexity filter
* Date range

## Curated Collections

* Editor's picks
* Best of 2024
* SaaS showcase
* Open source gems
* Beginner friendly

---

# Analytics for Submitters

Track project performance:

* Page views
* Unique visitors
* Like count
* Comment count
* Click-through to demo
* Click-through to source
* Share count
* Geographic data

---

# Gamification

## Badges

* First Submission
* Featured Project
* 100 Likes
* 1000 Views
* Top Creator
* Community Star

## Leaderboards

* Most liked projects
* Top creators
* Most active commenters
* Technology leaders

---

# Technical Architecture

```text
Frontend (Livewire)
    ↓
Showcase Service
    ├── Submission Service
    ├── Gallery Service
    ├── Engagement Service
    └── Analytics Service
    ↓
Database (MySQL)
Storage (S3 - screenshots)
Cache (Redis)
Search (Meilisearch)
CDN (CloudFront)
```

---

# Database Schema

Key tables:

* `showcase_projects` — Project listings
* `showcase_screenshots` — Project screenshots
* `showcase_technologies` — Technology tags
* `showcase_likes` — User likes
* `showcase_comments` — Project comments
* `showcase_featured` — Featured projects

---

# Moderation

## Submission Review

* Automated content checks
* Screenshot validation
* URL verification
* Spam detection
* Manual review queue

## Comment Moderation

* Spam filtering
* Profanity filter
* Report system
* Moderator queue

---

# Admin Features

* Featured project management
* Category management
* Technology tag management
* Moderation queue
* Analytics dashboard
* Creator management
* Content guidelines

---

# SEO Optimization

* Project-specific meta tags
* Open Graph images
* Structured data
* Sitemap integration
* Clean URLs

---

# Success Metrics

* 1,000+ showcased projects
* 10,000+ monthly visitors
* 500+ likes per featured project
* 50+ comments per featured project
* 80%+ submission approval rate

---

# Detailed Submission Workflow

## Submission Process

```text
Submitter initiates project submission
    ↓
Fills project information
    ├── Basic info (title, description, category)
    ├── Technology stack
    ├── Live demo URL
    ├── Source code URL
    └── Development details
    ↓
Uploads screenshots
    ├── Minimum 3 screenshots
    ├── Maximum 10 screenshots
    ├── Minimum 1200x800 resolution
    ├── Maximum 5MB per screenshot
    └── Supported formats: PNG, JPG, WebP
    ↓
Automated validation
    ├── URL verification (demo and source)
    ├── Screenshot validation
    ├── Content quality check
    ├── Spam detection
    └── Duplicate detection
    ↓
Manual review (optional for new submitters)
    ├── Content appropriateness
    ├── Screenshot quality
    ├── Description completeness
    └── Technology accuracy
    ↓
Published to showcase
    ↓
Featured consideration
    ↓
Social sharing triggered
```

## Submission Form Structure

```php
class ShowcaseSubmission
{
    public function getFormFields(): array
    {
        return [
            'basic' => [
                'title' => 'required|string|max:100',
                'slug' => 'required|string|max:100|unique:showcase_projects',
                'description' => 'required|string|max:2000',
                'short_description' => 'required|string|max:200',
                'category' => 'required|in:saas,ecommerce,portfolio,blog,dashboard,admin,learning,community,other',
                'complexity' => 'required|in:beginner,intermediate,advanced',
            ],
            'urls' => [
                'demo_url' => 'required|url',
                'github_url' => 'sometimes|url',
                'website_url' => 'sometimes|url',
                'video_url' => 'sometimes|url|youtube.com|vimeo.com',
            ],
            'technologies' => [
                'laravel_version' => 'required|string',
                'php_version' => 'required|string',
                'frontend_framework' => 'sometimes|string',
                'css_framework' => 'sometimes|string',
                'database' => 'sometimes|string',
                'other_technologies' => 'sometimes|array',
            ],
            'development' => [
                'development_time' => 'sometimes|string',
                'team_size' => 'sometimes|integer|min:1|max:100',
                'launch_date' => 'sometimes|date',
                'repository_type' => 'sometimes|in:public,private,none',
            ],
            'screenshots' => [
                'screenshots' => 'required|array|min:3|max:10',
                'screenshots.*' => 'image|max:5120',
                'screenshots.*.caption' => 'sometimes|string|max:100',
            ],
            'meta' => [
                'author_bio' => 'sometimes|string|max:500',
                'author_url' => 'sometimes|url',
                'case_study_url' => 'sometimes|url',
                'tags' => 'sometimes|array',
                'tags.*' => 'string|max:50',
            ],
        ];
    }
}
```

## Automated Validation

```php
class SubmissionValidator
{
    public function validate(ShowcaseSubmission $submission): ValidationResult
    {
        $results = [];
        
        $results[] = $this->validateUrls($submission);
        $results[] = $this->validateScreenshots($submission);
        $results[] = $this->validateContent($submission);
        $results[] = $this->checkDuplicates($submission);
        $results[] = $this->checkSpam($submission);
        
        return new ValidationResult($results);
    }
    
    private function validateUrls(ShowcaseSubmission $submission): CheckResult
    {
        $urls = [
            'demo_url' => $submission->demo_url,
            'github_url' => $submission->github_url,
        ];
        
        $results = [];
        
        foreach ($urls as $key => $url) {
            if (!$url) continue;
            
            try {
                $response = Http::timeout(10)->head($url);
                $results[$key] = [
                    'valid' => $response->successful(),
                    'status' => $response->status(),
                    'redirects' => $response->effectiveUri(),
                ];
            } catch (\Exception $e) {
                $results[$key] = [
                    'valid' => false,
                    'error' => $e->getMessage(),
                ];
            }
        }
        
        return new CheckResult('urls', !in_array(false, array_column($results, 'valid')), $results);
    }
    
    private function validateScreenshots(ShowcaseSubmission $submission): CheckResult
    {
        $screenshots = $submission->screenshots;
        $results = [];
        
        foreach ($screenshots as $index => $screenshot) {
            $imageInfo = getimagesize($screenshot->getPathname());
            
            $results[] = [
                'index' => $index,
                'valid' => $imageInfo[0] >= 1200 && $imageInfo[1] >= 800,
                'width' => $imageInfo[0],
                'height' => $imageInfo[1],
                'size' => $screenshot->getSize(),
            ];
        }
        
        $valid = !in_array(false, array_column($results, 'valid'));
        
        return new CheckResult('screenshots', $valid, $results);
    }
    
    private function validateContent(ShowcaseSubmission $submission): CheckResult
    {
        $issues = [];
        
        // Check description quality
        $wordCount = str_word_count($submission->description);
        if ($wordCount < 50) {
            $issues[] = 'Description too short (minimum 50 words)';
        }
        
        // Check for placeholder text
        $placeholders = ['lorem ipsum', 'todo', 'fixme', 'placeholder'];
        foreach ($placeholders as $placeholder) {
            if (str_contains(strtolower($submission->description), $placeholder)) {
                $issues[] = "Description contains placeholder text: {$placeholder}";
            }
        }
        
        // Check title quality
        if (strlen($submission->title) < 5) {
            $issues[] = 'Title too short';
        }
        
        return new CheckResult('content', empty($issues), $issues);
    }
    
    private function checkDuplicates(ShowcaseSubmission $submission): CheckResult
    {
        $duplicate = DB::table('showcase_projects')
            ->where('demo_url', $submission->demo_url)
            ->orWhere('github_url', $submission->github_url)
            ->first();
        
        if ($duplicate) {
            return new CheckResult('duplicates', false, [
                'existing_project' => $duplicate->title,
                'existing_url' => $duplicate->demo_url,
            ]);
        }
        
        return new CheckResult('duplicates', true, []);
    }
}
```

---

# Gallery Features

## Project Card Component

```blade
<x-showcase.project-card :project="$project">
    <x-slot:screenshot>
        <img 
            src="{{ $project->primaryScreenshot->url }}" 
            alt="{{ $project->title }}"
            class="w-full h-48 object-cover"
        />
    </x-slot:screenshot>
    
    <x-slot:title>
        {{ $project->title }}
    </x-slot:title>
    
    <x-slot:description>
        {{ $project->short_description }}
    </x-slot:description>
    
    <x-slot:technologies>
        @foreach($project->technologies as $technology)
            <x-showcase.tech-badge :technology="$technology" />
        @endforeach
    </x-slot:technologies>
    
    <x-slot:stats>
        <span class="flex items-center gap-1">
            <x-heroicon-s-heart class="w-4 h-4" />
            {{ $project->likes_count }}
        </span>
        <span class="flex items-center gap-1">
            <x-heroicon-s-eye class="w-4 h-4" />
            {{ number_format($project->views_count) }}
        </span>
        <span class="flex items-center gap-1">
            <x-heroicon-s-chat-bubble-left class="w-4 h-4" />
            {{ $project->comments_count }}
        </span>
    </x-slot:stats>
</x-showcase.project-card>
```

## Gallery Grid Layout

```php
class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Project::where('status', 'published');
        
        // Apply filters
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->has('technologies')) {
            $query->whereHas('technologies', function ($q) use ($request) {
                $q->whereIn('slug', $request->technologies);
            });
        }
        
        if ($request->has('complexity')) {
            $query->where('complexity', $request->complexity);
        }
        
        // Apply sorting
        $query = match ($request->get('sort', 'newest')) {
            'newest' => $query->orderBy('created_at', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            'popular' => $query->orderBy('likes_count', 'desc'),
            'most_viewed' => $query->orderBy('views_count', 'desc'),
            'most_commented' => $query->orderBy('comments_count', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };
        
        $projects = $query->paginate(12)->withQueryString();
        
        return view('showcase.index', compact('projects'));
    }
}
```

## Screenshot Gallery

```php
class ScreenshotGallery
{
    public function getProjectScreenshots(Project $project): array
    {
        $screenshots = $project->screenshots()
            ->orderBy('order')
            ->get();
        
        return $screenshots->map(function ($screenshot) {
            return [
                'id' => $screenshot->id,
                'url' => $screenshot->url,
                'thumbnail' => $screenshot->thumbnail,
                'caption' => $screenshot->caption,
                'width' => $screenshot->width,
                'height' => $screenshot->height,
            ];
        })->toArray();
    }
    
    public function processScreenshot(UploadedFile $file): Screenshot
    {
        // Resize and optimize
        $image = Image::make($file);
        
        // Create thumbnail
        $thumbnail = $image->resize(400, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        // Store original
        $path = $file->store('showcase/screenshots', 's3');
        
        // Store thumbnail
        $thumbnailPath = Storage::disk('s3')->put(
            'showcase/thumbnails/' . basename($path),
            $thumbnail->encode('webp', 80)
        );
        
        return Screenshot::create([
            'url' => Storage::disk('s3')->url($path),
            'thumbnail' => Storage::disk('s3')->url($thumbnailPath),
            'width' => $image->width(),
            'height' => $image->height(),
            'size' => $file->getSize(),
        ]);
    }
}
```

---

# Engagement Features Details

## Likes/Favorites System

```php
class LikeService
{
    public function toggleLike(Project $project, User $user): bool
    {
        $existingLike = Like::where('project_id', $project->id)
            ->where('user_id', $user->id)
            ->first();
        
        if ($existingLike) {
            $existingLike->delete();
            $project->decrement('likes_count');
            return false;
        }
        
        Like::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
        ]);
        
        $project->increment('likes_count');
        
        // Notify project owner
        if ($project->user_id !== $user->id) {
            Notification::send($project->user, new ProjectLikedNotification($project, $user));
        }
        
        return true;
    }
    
    public function getMostLikedProjects(int $limit = 10): Collection
    {
        return Cache::remember('most_liked_projects', 3600, function () use ($limit) {
            return Project::where('status', 'published')
                ->orderBy('likes_count', 'desc')
                ->limit($limit)
                ->get();
        });
    }
    
    public function getUserFavorites(User $user): Collection
    {
        return Like::where('user_id', $user->id)
            ->with('project')
            ->orderBy('created_at', 'desc')
            ->get()
            ->pluck('project');
    }
}
```

## Comment System

```php
class CommentService
{
    public function addComment(Project $project, User $user, array $data): Comment
    {
        $comment = Comment::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'parent_id' => $data['parent_id'] ?? null,
            'content' => $data['content'],
        ]);
        
        $project->increment('comments_count');
        
        // Notify project owner
        if ($project->user_id !== $user->id) {
            Notification::send($project->user, new CommentAddedNotification($comment));
        }
        
        // Notify parent comment author
        if ($comment->parent_id) {
            $parentComment = Comment::find($comment->parent_id);
            if ($parentComment && $parentComment->user_id !== $user->id) {
                Notification::send($parentComment->user, new ReplyAddedNotification($comment));
            }
        }
        
        // Extract and notify mentions
        $mentions = $this->extractMentions($data['content']);
        foreach ($mentions as $mention) {
            $mentionedUser = User::where('username', $mention)->first();
            if ($mentionedUser && $mentionedUser->id !== $user->id) {
                Notification::send($mentionedUser, new MentionedNotification($comment));
            }
        }
        
        return $comment;
    }
    
    public function getComments(Project $project, int $limit = 50): Collection
    {
        return Comment::where('project_id', $project->id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
    
    private function extractMentions(string $content): array
    {
        preg_match_all('/@(\w+)/', $content, $matches);
        return $matches[1];
    }
}
```

## Sharing System

```php
class ShareService
{
    public function getShareUrls(Project $project): array
    {
        $url = route('showcase.project', $project->slug);
        $title = urlencode($project->title);
        $description = urlencode($project->short_description);
        $image = urlencode($project->primaryScreenshot->url);
        
        return [
            'twitter' => "https://twitter.com/intent/tweet?url={$url}&text={$title}&image={$image}",
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$url}",
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
            'reddit' => "https://reddit.com/submit?url={$url}&title={$title}",
            'hacker_news' => "https://news.ycombinator.com/submitlink?u={$url}&t={$title}",
            'product_hunt' => "https://www.producthunt.com/posts/new?url={$url}&title={$title}",
        ];
    }
    
    public function trackShare(Project $project, string $platform, User $user = null): void
    {
        Share::create([
            'project_id' => $project->id,
            'platform' => $platform,
            'user_id' => $user?->id,
            'ip_address' => request()->ip(),
        ]);
        
        $project->increment('shares_count');
    }
    
    public function generateEmbedCode(Project $project): string
    {
        $url = route('showcase.project', $project->slug);
        $screenshot = $project->primaryScreenshot->url;
        
        return <<<HTML
        <div class="gsmui-showcase-embed" style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; max-width: 400px;">
            <a href="{$url}" target="_blank" rel="noopener">
                <img src="{$screenshot}" alt="{$project->title}" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 16px;">
                    <h3 style="margin: 0 0 8px 0; font-size: 18px;">{$project->title}</h3>
                    <p style="margin: 0; color: #6b7280;">{$project->short_description}</p>
                </div>
            </a>
        </div>
        HTML;
    }
}
```

---

# Discovery Features Details

## Category Pages

```php
class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('projects')
            ->orderBy('projects_count', 'desc')
            ->get();
        
        return view('showcase.categories', compact('categories'));
    }
    
    public function show(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $projects = Project::where('category', $category->slug)
            ->where('status', 'published')
            ->with(['user', 'screenshots'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('showcase.category', compact('category', 'projects'));
    }
}
```

## Technology Pages

```php
class TechnologyController extends Controller
{
    public function index(): View
    {
        $technologies = Technology::withCount('projects')
            ->orderBy('projects_count', 'desc')
            ->get();
        
        return view('showcase.technologies', compact('technologies'));
    }
    
    public function show(string $slug): View
    {
        $technology = Technology::where('slug', $slug)->firstOrFail();
        
        $projects = Project::whereHas('technologies', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })
        ->where('status', 'published')
        ->with(['user', 'screenshots'])
        ->orderBy('created_at', 'desc')
        ->paginate(12);
        
        return view('showcase.technology', compact('technology', 'projects'));
    }
}
```

## Curated Collections

```php
class CollectionService
{
    public function getEditorsPicks(int $limit = 6): array
    {
        return Cache::remember('editors_picks', 3600, function () use ($limit) {
            return Project::where('status', 'published')
                ->where('is_featured', true)
                ->with(['user', 'screenshots'])
                ->withCount('likes')
                ->orderByDesc('likes_count')
                ->limit($limit)
                ->get()
                ->toArray();
        });
    }
    
    public function getBestOfYear(int $year, int $limit = 10): array
    {
        return Cache::remember("best_of_{$year}", 3600, function () use ($year, $limit) {
            return Project::where('status', 'published')
                ->whereYear('created_at', $year)
                ->with(['user', 'screenshots'])
                ->withCount('likes')
                ->orderByDesc('likes_count')
                ->limit($limit)
                ->get()
                ->toArray();
        });
    }
    
    public function getBeginnerFriendly(int $limit = 10): array
    {
        return Cache::remember('beginner_friendly', 3600, function () use ($limit) {
            return Project::where('status', 'published')
                ->where('complexity', 'beginner')
                ->with(['user', 'screenshots'])
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->toArray();
        });
    }
    
    public function createCollection(string $name, string $description, array $projectIds): Collection
    {
        $collection = Collection::create([
            'name' => $name,
            'description' => $description,
            'user_id' => auth()->id(),
        ]);
        
        $collection->projects()->sync($projectIds);
        
        return $collection;
    }
}
```

---

# Analytics for Submitters

## Analytics Dashboard

```php
class ProjectAnalytics
{
    public function getProjectMetrics(Project $project, int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        return [
            'views' => $this->getViews($project, $startDate),
            'unique_visitors' => $this->getUniqueVisitors($project, $startDate),
            'likes' => $this->getLikes($project, $startDate),
            'comments' => $this->getComments($project, $startDate),
            'shares' => $this->getShares($project, $startDate),
            'demo_clicks' => $this->getDemoClicks($project, $startDate),
            'source_clicks' => $this->getSourceClicks($project, $startDate),
            'referrer_sources' => $this->getReferrerSources($project, $startDate),
            'geographic_data' => $this->getGeographicData($project, $startDate),
        ];
    }
    
    public function getViewsChart(Project $project, int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        $views = DB::table('showcase_views')
            ->where('project_id', $project->id)
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as views'),
                DB::raw('COUNT(DISTINCT ip_address) as unique_visitors')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return [
            'labels' => $views->pluck('date'),
            'views' => $views->pluck('views'),
            'unique_visitors' => $views->pluck('unique_visitors'),
        ];
    }
    
    private function getReferrerSources(Project $project, Carbon $startDate): array
    {
        return DB::table('showcase_views')
            ->where('project_id', $project->id)
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('referrer')
            ->select('referrer', DB::raw('COUNT(*) as count'))
            ->groupBy('referrer')
            ->orderByDesc('count')
            ->limit(10)
            ->get()
            ->toArray();
    }
    
    private function getGeographicData(Project $project, Carbon $startDate): array
    {
        return DB::table('showcase_views')
            ->where('project_id', $project->id)
            ->where('created_at', '>=', $startDate)
            ->select('country_code', DB::raw('COUNT(*) as count'))
            ->groupBy('country_code')
            ->orderByDesc('count')
            ->get()
            ->toArray();
    }
}
```

---

# Gamification Details

## Badges System

```php
class BadgeService
{
    private const BADGES = [
        'first_submission' => [
            'name' => 'First Submission',
            'description' => 'Submitted your first project',
            'icon' => 'rocket',
            'color' => 'blue',
        ],
        'featured_project' => [
            'name' => 'Featured Project',
            'description' => 'Project was featured by editors',
            'icon' => 'star',
            'color' => 'yellow',
        ],
        'hundred_likes' => [
            'name' => '100 Likes',
            'description' => 'Project received 100 likes',
            'icon' => 'heart',
            'color' => 'red',
        ],
        'thousand_views' => [
            'name' => '1000 Views',
            'description' => 'Project received 1000 views',
            'icon' => 'eye',
            'color' => 'green',
        ],
        'top_creator' => [
            'name' => 'Top Creator',
            'description' => 'Has 5+ projects in showcase',
            'icon' => 'trophy',
            'color' => 'purple',
        ],
        'community_star' => [
            => 'Community Star',
            'description' => 'Received 50+ helpful votes on comments',
            'icon' => 'academic-cap',
            'color' => 'indigo',
        ],
    ];
    
    public function checkAndAwardBadges(User $user): array
    {
        $awarded = [];
        
        // Check first submission
        if (!$this->hasBadge($user, 'first_submission') && $user->projects()->count() > 0) {
            $this->awardBadge($user, 'first_submission');
            $awarded[] = 'first_submission';
        }
        
        // Check featured project
        if (!$this->hasBadge($user, 'featured_project') && $user->projects()->where('is_featured', true)->exists()) {
            $this->awardBadge($user, 'featured_project');
            $awarded[] = 'featured_project';
        }
        
        // Check 100 likes
        $totalLikes = $user->projects()->sum('likes_count');
        if (!$this->hasBadge($user, 'hundred_likes') && $totalLikes >= 100) {
            $this->awardBadge($user, 'hundred_likes');
            $awarded[] = 'hundred_likes';
        }
        
        // Check 1000 views
        $totalViews = $user->projects()->sum('views_count');
        if (!$this->hasBadge($user, 'thousand_views') && $totalViews >= 1000) {
            $this->awardBadge($user, 'thousand_views');
            $awarded[] = 'thousand_views';
        }
        
        // Check top creator
        if (!$this->hasBadge($user, 'top_creator') && $user->projects()->count() >= 5) {
            $this->awardBadge($user, 'top_creator');
            $awarded[] = 'top_creator';
        }
        
        return $awarded;
    }
    
    private function awardBadge(User $user, string $badgeSlug): void
    {
        $badge = self::BADGES[$badgeSlug];
        
        UserBadge::create([
            'user_id' => $user->id,
            'badge_slug' => $badgeSlug,
            'awarded_at' => now(),
        ]);
        
        Notification::send($user, new BadgeAwardedNotification($badge));
    }
    
    private function hasBadge(User $user, string $badgeSlug): bool
    {
        return UserBadge::where('user_id', $user->id)
            ->where('badge_slug', $badgeSlug)
            ->exists();
    }
}
```

## Leaderboards

```php
class LeaderboardService
{
    public function getMostLikedProjects(int $limit = 10): array
    {
        return Cache::remember('leaderboard_liked', 3600, function () use ($limit) {
            return Project::where('status', 'published')
                ->with('user')
                ->orderBy('likes_count', 'desc')
                ->limit($limit)
                ->get()
                ->toArray();
        });
    }
    
    public function getTopCreators(int $limit = 10): array
    {
        return Cache::remember('leaderboard_creators', 3600, function () use ($limit) {
            return User::has('projects')
                ->withCount('projects')
                ->withSum('projects', 'likes_count')
                ->orderByDesc('projects_likes_count_sum')
                ->limit($limit)
                ->get()
                ->toArray();
        });
    }
    
    public function getMostActiveCommenters(int $limit = 10): array
    {
        return Cache::remember('leaderboard_commenters', 3600, function () use ($limit) {
            return User::has('comments')
                ->withCount('comments')
                ->orderByDesc('comments_count')
                ->limit($limit)
                ->get()
                ->toArray();
        });
    }
    
    public function getTechnologyLeaders(int $limit = 10): array
    {
        return Cache::remember('leaderboard_technologies', 3600, function () use ($limit) {
            return Technology::withCount('projects')
                ->orderByDesc('projects_count')
                ->limit($limit)
                ->get()
                ->toArray();
        });
    }
}
```

---

# Moderation Details

## Submission Review

```php
class SubmissionModeration
{
    public function reviewSubmission(Project $project, User $moderator, string $action, string $reason = null): void
    {
        match ($action) {
            'approve' => $this->approve($project, $moderator),
            'reject' => $this->reject($project, $moderator, $reason),
            'request_changes' => $this->requestChanges($project, $moderator, $reason),
        };
    }
    
    private function approve(Project $project, User $moderator): void
    {
        $project->update([
            'status' => 'published',
            'published_at' => now(),
            'approved_by' => $moderator->id,
        ]);
        
        Notification::send($project->user, new ProjectApprovedNotification($project));
        
        // Trigger social sharing
        $this->shareService->shareNewProject($project);
    }
    
    private function reject(Project $project, User $moderator, string $reason): void
    {
        $project->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'rejected_by' => $moderator->id,
        ]);
        
        Notification::send($project->user, new ProjectRejectedNotification($project, $reason));
    }
    
    private function requestChanges(Project $project, User $moderator, string $reason): void
    {
        $project->update([
            'status' => 'changes_requested',
            'changes_requested_by' => $moderator->id,
            'changes_requested_reason' => $reason,
        ]);
        
        Notification::send($project->user, new ChangesRequestedNotification($project, $reason));
    }
}
```

## Comment Moderation

```php
class CommentModeration
{
    public function moderateComment(Comment $comment, User $moderator, string $action): void
    {
        match ($action) {
            'approve' => $this->approve($comment),
            'flag' => $this->flag($comment, $moderator),
            'delete' => $this->delete($comment, $moderator),
        };
    }
    
    private function approve(Comment $comment): void
    {
        $comment->update(['status' => 'approved']);
    }
    
    private function flag(Comment $comment, User $moderator): void
    {
        $comment->update([
            'status' => 'flagged',
            'flagged_by' => $moderator->id,
        ]);
        
        Notification::send($comment->user, new CommentFlaggedNotification($comment));
    }
    
    private function delete(Comment $comment, User $moderator): void
    {
        $comment->update([
            'status' => 'deleted',
            'deleted_by' => $moderator->id,
            'deleted_at' => now(),
        ]);
        
        $comment->project->decrement('comments_count');
    }
    
    public function autoModerate(Comment $comment): void
    {
        // Check for spam
        $spamScore = $this->calculateSpamScore($comment);
        if ($spamScore > 0.8) {
            $comment->update(['status' => 'spam']);
            return;
        }
        
        // Check for profanity
        if ($this->containsProfanity($comment->content)) {
            $comment->update(['status' => 'pending']);
            return;
        }
        
        // Auto-approve if user has good history
        if ($comment->user->comments()->where('status', 'approved')->count() > 10) {
            $comment->update(['status' => 'approved']);
            return;
        }
        
        $comment->update(['status' => 'pending']);
    }
}
```

---

# Technical Architecture Details

## Database Schema

```sql
-- Showcase Projects
CREATE TABLE showcase_projects (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    short_description VARCHAR(255),
    category ENUM('saas', 'ecommerce', 'portfolio', 'blog', 'dashboard', 'admin', 'learning', 'community', 'other') NOT NULL,
    complexity ENUM('beginner', 'intermediate', 'advanced') NOT NULL,
    demo_url VARCHAR(500),
    github_url VARCHAR(500),
    website_url VARCHAR(500),
    video_url VARCHAR(500),
    laravel_version VARCHAR(20),
    php_version VARCHAR(20),
    frontend_framework VARCHAR(100),
    css_framework VARCHAR(100),
    database VARCHAR(100),
    other_technologies JSON,
    development_time VARCHAR(100),
    team_size INT UNSIGNED,
    launch_date DATE,
    repository_type ENUM('public', 'private', 'none'),
    author_bio TEXT,
    author_url VARCHAR(500),
    case_study_url VARCHAR(500),
    tags JSON,
    status ENUM('draft', 'pending', 'published', 'rejected', 'archived') NOT NULL DEFAULT 'draft',
    is_featured BOOLEAN NOT NULL DEFAULT FALSE,
    views_count INT UNSIGNED NOT NULL DEFAULT 0,
    likes_count INT UNSIGNED NOT NULL DEFAULT 0,
    comments_count INT UNSIGNED NOT NULL DEFAULT 0,
    shares_count INT UNSIGNED NOT NULL DEFAULT 0,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_status (status),
    INDEX idx_category (category),
    INDEX idx_user (user_id),
    FULLTEXT INDEX ft_search (title, description, short_description)
);

-- Showcase Screenshots
CREATE TABLE showcase_screenshots (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    url VARCHAR(500) NOT NULL,
    thumbnail VARCHAR(500),
    caption VARCHAR(255),
    width INT UNSIGNED,
    height INT UNSIGNED,
    size INT UNSIGNED,
    order INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (project_id) REFERENCES showcase_projects(id) ON DELETE CASCADE,
    INDEX idx_project (project_id)
);

-- Showcase Technologies
CREATE TABLE showcase_technologies (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    icon VARCHAR(100),
    url VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE INDEX idx_slug (slug)
);

-- Showcase Project Technology Pivot
CREATE TABLE showcase_project_technology (
    project_id BIGINT UNSIGNED NOT NULL,
    technology_id BIGINT UNSIGNED NOT NULL,
    
    PRIMARY KEY (project_id, technology_id),
    FOREIGN KEY (project_id) REFERENCES showcase_projects(id) ON DELETE CASCADE,
    FOREIGN KEY (technology_id) REFERENCES showcase_technologies(id) ON DELETE CASCADE
);

-- Showcase Likes
CREATE TABLE showcase_likes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (project_id) REFERENCES showcase_projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE INDEX idx_project_user (project_id, user_id)
);

-- Showcase Comments
CREATE TABLE showcase_comments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    parent_id BIGINT UNSIGNED,
    content TEXT NOT NULL,
    status ENUM('pending', 'approved', 'flagged', 'deleted', 'spam') NOT NULL DEFAULT 'pending',
    flagged_by BIGINT UNSIGNED,
    deleted_by BIGINT UNSIGNED,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (project_id) REFERENCES showcase_projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES showcase_comments(id) ON DELETE CASCADE,
    INDEX idx_project (project_id),
    INDEX idx_status (status)
);

-- Showcase Views
CREATE TABLE showcase_views (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED,
    ip_address VARCHAR(45),
    user_agent TEXT,
    referrer VARCHAR(500),
    country_code VARCHAR(2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (project_id) REFERENCES showcase_projects(id) ON DELETE CASCADE,
    INDEX idx_project (project_id),
    INDEX idx_created (created_at)
);

-- Showcase Shares
CREATE TABLE showcase_shares (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    platform VARCHAR(50) NOT NULL,
    user_id BIGINT UNSIGNED,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (project_id) REFERENCES showcase_projects(id) ON DELETE CASCADE,
    INDEX idx_project (project_id)
);
```

---

# User Flows

## Submitter Flow

```text
Submitter logs in
    ↓
Navigates to showcase
    ↓
Clicks "Submit Project"
    ↓
Fills project form
    ├── Title and description
    ├── URLs (demo, source)
    ├── Technology stack
    ├── Development details
    └── Screenshots
    ↓
Previews submission
    ↓
Submits for review
    ↓
Receives confirmation email
    ↓
Waits for review (optional)
    ↓
Project published
    ↓
Receives notification
    ↓
Shares on social media
    ↓
Monitors analytics
```

## Viewer Flow

```text
Viewer arrives at showcase
    ↓
Browses featured projects
    ↓
Filters by category/technology
    ↓
Views project details
    ├── Screenshots
    ├── Description
    ├── Technology stack
    ├── Live demo
    └── Source code
    ↓
Likes project
    ↓
Leaves comment
    ↓
Shares project
    ↓
Views related projects
    ↓
Submits own project
```

---

# Success Metrics Details

## Key Performance Indicators

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Total Projects | 500 | 1,000+ | Database count |
| Monthly Visitors | 5,000 | 10,000+ | Analytics |
| Average Likes per Featured | 200 | 500+ | Like count |
| Average Comments per Featured | 20 | 50+ | Comment count |
| Submission Approval Rate | 75% | 80%+ | Approved / Submitted |
| Return Visitor Rate | 30% | 40%+ | Analytics |
| Average Time on Site | 3 minutes | 5 minutes | Analytics |

## Engagement Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Like Rate | 5% | 10% | Likes / Views |
| Comment Rate | 1% | 2% | Comments / Views |
| Share Rate | 2% | 5% | Shares / Views |
| Demo Click Rate | 15% | 25% | Demo clicks / Views |
| Source Click Rate | 10% | 20% | Source clicks / Views |

---

# Admin Features Details

## Featured Project Management

```php
class FeaturedManager
{
    public function setFeatured(Project $project, User $admin): void
    {
        $project->update([
            'is_featured' => true,
            'featured_at' => now(),
            'featured_by' => $admin->id,
        ]);
        
        // Notify project owner
        Notification::send($project->user, new ProjectFeaturedNotification($project));
        
        // Share on social media
        $this->shareService->shareFeaturedProject($project);
        
        // Clear cache
        Cache::forget('featured_projects');
        Cache::forget('editors_picks');
    }
    
    public function removeFeatured(Project $project): void
    {
        $project->update([
            'is_featured' => false,
            'featured_at' => null,
            'featured_by' => null,
        ]);
        
        Cache::forget('featured_projects');
        Cache::forget('editors_picks');
    }
    
    public function getFeaturedProjects(): Collection
    {
        return Cache::remember('featured_projects', 3600, function () {
            return Project::where('is_featured', true)
                ->where('status', 'published')
                ->with(['user', 'screenshots'])
                ->orderBy('featured_at', 'desc')
                ->get();
        });
    }
}
```

## Category Management

```php
class CategoryManagement
{
    public function createCategory(array $data): Category
    {
        return Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
            'icon' => $data['icon'] ?? null,
            'color' => $data['color'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);
    }
    
    public function updateCategory(Category $category, array $data): Category
    {
        $category->update($data);
        
        if (isset($data['name'])) {
            $category->update(['slug' => Str::slug($data['name'])]);
        }
        
        return $category;
    }
    
    public function deleteCategory(Category $category): void
    {
        // Move projects to "other" category
        Project::where('category', $category->slug)
            ->update(['category' => 'other']);
        
        $category->delete();
    }
    
    public function reorderCategories(array $categoryIds): void
    {
        foreach ($categoryIds as $index => $categoryId) {
            Category::where('id', $categoryId)->update(['sort_order' => $index]);
        }
    }
}
```

## Technology Tag Management

```php
class TechnologyManagement
{
    public function createTechnology(array $data): Technology
    {
        return Technology::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'icon' => $data['icon'] ?? null,
            'url' => $data['url'] ?? null,
        ]);
    }
    
    public function mergeTechnologies(Technology $source, Technology $target): void
    {
        // Move all projects from source to target
        $source->projects()->detach();
        
        $target->projects()->sync($source->projects()->pluck('projects.id'));
        
        $source->delete();
    }
    
    public function getUnusedTechnologies(): Collection
    {
        return Technology::whereDoesntHave('projects')
            ->get();
    }
}
```

## Moderation Queue

```php
class ModerationQueue
{
    public function getPendingSubmissions(): Collection
    {
        return Project::where('status', 'pending')
            ->with('user')
            ->orderBy('created_at')
            ->get();
    }
    
    public function getFlaggedComments(): Collection
    {
        return Comment::where('status', 'flagged')
            ->with(['project', 'user'])
            ->orderBy('created_at')
            ->get();
    }
    
    public function getReportedContent(): Collection
    {
        return Report::where('status', 'pending')
            ->with(['reportable', 'reporter'])
            ->orderBy('created_at')
            ->get();
    }
    
    public function resolveReport(Report $report, string $action, User $moderator): void
    {
        match ($action) {
            'dismiss' => $report->update(['status' => 'dismissed', 'resolved_by' => $moderator->id]),
            'remove' => $this->removeContent($report, $moderator),
            'warn' => $this->warnUser($report, $moderator),
        };
    }
    
    private function removeContent(Report $report, User $moderator): void
    {
        $reportable = $report->reportable;
        
        if ($reportable instanceof Comment) {
            $reportable->update(['status' => 'deleted', 'deleted_by' => $moderator->id]);
        } elseif ($reportable instanceof Project) {
            $reportable->update(['status' => 'archived', 'archived_by' => $moderator->id]);
        }
        
        $report->update(['status' => 'resolved', 'resolved_by' => $moderator->id]);
    }
}
```

## Analytics Dashboard

```php
class ShowcaseAnalytics
{
    public function getOverview(int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        return [
            'total_projects' => Project::count(),
            'new_projects' => Project::where('created_at', '>=', $startDate)->count(),
            'total_views' => DB::table('showcase_views')
                ->where('created_at', '>=', $startDate)
                ->count(),
            'unique_visitors' => DB::table('showcase_views')
                ->where('created_at', '>=', $startDate)
                ->distinct('ip_address')
                ->count(),
            'total_likes' => Like::where('created_at', '>=', $startDate)->count(),
            'total_comments' => Comment::where('created_at', '>=', $startDate)->count(),
            'total_shares' => Share::where('created_at', '>=', $startDate)->count(),
        ];
    }
    
    public function getTopProjects(int $limit = 10): array
    {
        return Project::where('status', 'published')
            ->with('user')
            ->orderBy('views_count', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
    
    public function getTopCreators(int $limit = 10): array
    {
        return User::has('projects')
            ->withCount('projects')
            ->withSum('projects', 'views_count')
            ->orderByDesc('projects_views_count_sum')
            ->limit($limit)
            ->get()
            ->toArray();
    }
    
    public function getTechnologyStats(): array
    {
        return Technology::withCount('projects')
            ->orderByDesc('projects_count')
            ->get()
            ->toArray();
    }
    
    public function getCategoryStats(): array
    {
        return Project::select('category', DB::raw('COUNT(*) as count'))
            ->where('status', 'published')
            ->groupBy('category')
            ->orderByDesc('count')
            ->get()
            ->toArray();
    }
}
```

---

# SEO Optimization Details

## Structured Data

```php
class ShowcaseSeo
{
    public function getProjectSchema(Project $project): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareSourceCode',
            'name' => $project->title,
            'description' => $project->description,
            'url' => route('showcase.project', $project->slug),
            'codeRepository' => $project->github_url,
            'programmingLanguage' => 'PHP',
            'runtimePlatform' => 'Laravel',
            'datePublished' => $project->published_at->toIso8601String(),
            'dateModified' => $project->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $project->user->name,
                'url' => $project->user->profile_url,
            ],
            'image' => $project->primaryScreenshot?->url,
        ];
    }
    
    public function getCollectionSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'GsmUi Showcase',
            'description' => 'Community projects built with GsmUi',
            'url' => route('showcase.index'),
        ];
    }
    
    public function getMetaTags(Project $project): array
    {
        return [
            'title' => "{$project->title} - GsmUi Showcase",
            'description' => $project->short_description,
            'og:title' => $project->title,
            'og:description' => $project->short_description,
            'og:image' => $project->primaryScreenshot?->url,
            'og:url' => route('showcase.project', $project->slug),
            'og:type' => 'article',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $project->title,
            'twitter:description' => $project->short_description,
            'twitter:image' => $project->primaryScreenshot?->url,
            'canonical' => route('showcase.project', $project->slug),
        ];
    }
}
```

## Sitemap Generation

```php
class ShowcaseSitemap
{
    public function generate(): string
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
        
        $urlset = $xml->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        
        // Add index page
        $url = $this->createUrl($xml, route('showcase.index'), now(), '1.0');
        $urlset->appendChild($url);
        
        // Add category pages
        $categories = Category::all();
        foreach ($categories as $category) {
            $url = $this->createUrl($xml, route('showcase.category', $category->slug), now(), '0.8');
            $urlset->appendChild($url);
        }
        
        // Add project pages
        $projects = Project::where('status', 'published')->get();
        foreach ($projects as $project) {
            $url = $this->createUrl($xml, route('showcase.project', $project->slug), $project->updated_at, '0.7');
            $urlset->appendChild($url);
        }
        
        $xml->appendChild($urlset);
        
        return $xml->saveXML();
    }
    
    private function createUrl(DOMDocument $xml, string $loc, Carbon $lastmod, string $priority): DOMElement
    {
        $url = $xml->createElement('url');
        $url->appendChild($xml->createElement('loc', $loc));
        $url->appendChild($xml->createElement('lastmod', $lastmod->format('Y-m-d')));
        $url->appendChild($xml->createElement('priority', $priority));
        
        return $url;
    }
}
```

---

# API Contracts Details

## Showcase API Specification

```yaml
openapi: 3.0.0
info:
  title: GsmUi Showcase API
  version: 1.0.0
  description: API for the GsmUi Showcase

paths:
  /api/showcase/projects:
    get:
      summary: List showcase projects
      tags: [Projects]
      parameters:
        - name: category
          in: query
          schema:
            type: string
        - name: technology
          in: query
          schema:
            type: string
        - name: complexity
          in: query
          schema:
            type: string
            enum: [beginner, intermediate, advanced]
        - name: sort
          in: query
          schema:
            type: string
            enum: [newest, popular, most_viewed, most_commented]
        - name: search
          in: query
          schema:
            type: string
        - name: page
          in: query
          schema:
            type: integer
        - name: per_page
          in: query
          schema:
            type: integer
      responses:
        '200':
          description: Successful response
          content:
            application/json:
              schema:
                type: object
                properties:
                  data:
                    type: array
                    items:
                      $ref: '#/components/schemas/Project'
                  meta:
                    $ref: '#/components/schemas/PaginationMeta'

  /api/showcase/projects/{slug}:
    get:
      summary: Get project details
      tags: [Projects]
      parameters:
        - name: slug
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Successful response
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/ProjectDetail'
        '404':
          description: Project not found

  /api/showcase/projects:
    post:
      summary: Submit project
      tags: [Projects]
      security:
        - bearerAuth: []
      requestBody:
        required: true
        content:
          multipart/form-data:
            schema:
              type: object
              required:
                - title
                - description
                - category
                - demo_url
                - screenshots
              properties:
                title:
                  type: string
                description:
                  type: string
                short_description:
                  type: string
                category:
                  type: string
                complexity:
                  type: string
                demo_url:
                  type: string
                  format: uri
                github_url:
                  type: string
                  format: uri
                technologies:
                  type: array
                  items:
                    type: string
                screenshots:
                  type: array
                  items:
                    type: string
                    format: binary
      responses:
        '201':
          description: Project submitted
        '422':
          description: Validation error

  /api/showcase/projects/{id}/like:
    post:
      summary: Toggle like
      tags: [Engagement]
      security:
        - bearerAuth: []
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: integer
      responses:
        '200':
          description: Like toggled
          content:
            application/json:
              schema:
                type: object
                properties:
                  liked:
                    type: boolean
                  likes_count:
                    type: integer

  /api/showcase/projects/{id}/comments:
    get:
      summary: Get comments
      tags: [Comments]
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: integer
        - name: page
          in: query
          schema:
            type: integer
      responses:
        '200':
          description: Comments list

    post:
      summary: Add comment
      tags: [Comments]
      security:
        - bearerAuth: []
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: integer
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - content
              properties:
                content:
                  type: string
                parent_id:
                  type: integer
      responses:
        '201':
          description: Comment added

components:
  schemas:
    Project:
      type: object
      properties:
        id:
          type: integer
        title:
          type: string
        slug:
          type: string
        short_description:
          type: string
        category:
          type: string
        complexity:
          type: string
        demo_url:
          type: string
        github_url:
          type: string
        primary_screenshot:
          type: string
        technologies:
          type: array
          items:
            type: string
        user:
          type: object
          properties:
            name:
              type: string
            avatar:
              type: string
        views_count:
          type: integer
        likes_count:
          type: integer
        comments_count:
          type: integer
        is_featured:
          type: boolean
        created_at:
          type: string
          format: date-time

    ProjectDetail:
      allOf:
        - $ref: '#/components/schemas/Project'
        - type: object
          properties:
            description:
              type: string
            screenshots:
              type: array
              items:
                type: object
                properties:
                  url:
                    type: string
                  caption:
                    type: string
            development_time:
              type: string
            team_size:
              type: integer
            launch_date:
              type: string
              format: date
            author_bio:
              type: string
            comments:
              type: array
              items:
                $ref: '#/components/schemas/Comment'

    Comment:
      type: object
      properties:
        id:
          type: integer
        user:
          type: object
          properties:
            name:
              type: string
            avatar:
              type: string
        content:
          type: string
        parent_id:
          type: integer
        replies:
          type: array
          items:
            $ref: '#/components/schemas/Comment'
        created_at:
          type: string
          format: date-time

    PaginationMeta:
      type: object
      properties:
        current_page:
          type: integer
        last_page:
          type: integer
        per_page:
          type: integer
        total:
          type: integer

  securitySchemes:
    bearerAuth:
      type: http
      scheme: bearer
      bearerFormat: JWT
```

---

# Next Document

**17 - Playground** — Interactive component testing and preview environment.
