# 21 - Blog

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

The Blog is GsmUi's content marketing platform, providing tutorials, release notes, case studies, and community stories to drive engagement and SEO.

---

# Vision

Build the authoritative content hub for Laravel UI development, attracting developers through high-quality tutorials, insights, and community stories.

---

# Core Features

## Content Management

* Markdown editor
* Rich text editor (fallback)
* Draft/Scheduled/Published states
* Version history
* Auto-save
* Media embedding

## Content Types

* Tutorials
* Release notes
* Case studies
* Community stories
* Opinion pieces
* News
* Guides

## Reader Features

* Clean reading experience
* Code syntax highlighting
* Copy code blocks
* Table of contents
* Reading time estimate
* Related posts
* Newsletter signup

## Author Features

* Author profiles
* Author dashboard
* Analytics
* SEO tools

---

# Blog Structure

```text
Blog

├── Categories
│   ├── Tutorials
│   ├── Release Notes
│   ├── Case Studies
│   ├── Community
│   ├── Guides
│   └── News
├── Tags
├── Authors
├── Series (multi-part posts)
└── Archives
```

---

# Post Metadata

```yaml
title: "Building a Dashboard with GsmUi"
slug: building-dashboard-gsmui
category: tutorials
tags:
  - dashboard
  - livewire
  - tutorial
author: john-doe
published_at: 2024-01-15
reading_time: 12 min
featured: true
seo:
  title: "Building a Dashboard with GsmUi - Tutorial"
  description: "Learn how to build a modern dashboard..."
  image: /images/dashboard-tutorial.png
```

---

# Post Structure

```text
Post Page
─────────
Header
├── Category badge
├── Title
├── Author avatar + name
├── Published date
├── Reading time
└── Share buttons

Content
├── Featured image
├── Table of contents
├── Markdown content
├── Code blocks with syntax highlighting
├── Images
├── Videos
└── Component previews

Footer
├── Tags
├── Author bio
├── Related posts
├── Newsletter signup
└── Comments
```

---

# Editor Features

## Markdown Editor

```markdown
---
title: My Post
category: tutorials
tags: [laravel, gsmui]
---

# Introduction

This is a tutorial about GsmUi.

## Code Example

```blade
<x-gsm-button variant="primary">
    Click me
</x-gsm-button>
```

## Live Component

<gsmui:preview component="button" variant="primary" />
```

## Editor Tools

* Split view (edit/preview)
* Syntax highlighting
* Auto-complete
* Image upload
* Link insertion
* Component embedding
* Table editor
* Footnotes

---

# SEO Features

## Technical SEO

* Server-side rendering
* Semantic HTML
* Structured data (Article schema)
* Open Graph tags
* Twitter Cards
* Canonical URLs
* XML sitemap

## Content SEO

* Meta title/description
* Focus keyword
* Readability score
* Internal linking suggestions
* Image alt text reminders

---

# Newsletter Integration

## Signup Forms

* Sidebar widget
* End-of-post form
* Pop-up (timed)
* Exit intent

## Email Features

* Weekly digest
* New post notifications
* Custom segments
* A/B testing

---

# Comment System

## Features

* Threaded comments
* Markdown support
* @mentions
* Like/reply
* Edit/delete own
* Moderation queue
* Spam filtering

## Moderation

* Automated spam detection
* Profanity filter
* Report system
* Moderator roles

---

# Analytics

Track post performance:

* Page views
* Unique visitors
* Reading time
* Scroll depth
* Code copies
* Share count
* Comment count
* Newsletter signups

---

# Technical Architecture

```text
Frontend (Livewire)
    ↓
Blog Service
    ├── Post Service
    ├── Category Service
    ├── Tag Service
    ├── Author Service
    ├── Comment Service
    └── Newsletter Service
    ↓
Database (MySQL)
Storage (S3 - media)
Cache (Redis)
Search (Meilisearch)
Email (Mailgun/SES)
```

---

# Database Schema

Key tables:

* `blog_posts` — Post content
* `blog_categories` — Categories
* `blog_tags` — Tags
* `blog_post_tags` — Post-tag relation
* `blog_authors` — Author profiles
* `blog_comments` — Comments
* `blog_subscribers` — Newsletter subscribers

---

# Admin Features

* Post editor
* Category management
* Tag management
* Author management
* Comment moderation
* Newsletter management
* SEO tools
* Analytics dashboard

---

# Success Metrics

* 100+ published posts
* 50,000+ monthly readers
* 5,000+ newsletter subscribers
* 10+ comments per post
* 4.5+ reading experience rating

---

# Detailed Content Management

## Post Management System

```php
class PostService
{
    public function createPost(array $data, User $author): Post
    {
        $validated = Validator::validate($data, [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts',
            'content' => 'required|string',
            'category' => 'required|exists:blog_categories,id',
            'tags' => 'sometimes|array',
            'featured_image' => 'sometimes|image|max:5120',
            'status' => 'required|in:draft,scheduled,published',
            'scheduled_at' => 'required_if:status,scheduled|date|after:now',
            'seo_title' => 'sometimes|string|max:60',
            'seo_description' => 'sometimes|string|max:160',
            'reading_time' => 'sometimes|integer',
        ]);
        
        $post = Post::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'excerpt' => $this->generateExcerpt($validated['content']),
            'category_id' => $validated['category'],
            'author_id' => $author->id,
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
            'scheduled_at' => $validated['scheduled_at'] ?? null,
            'seo_title' => $validated['seo_title'] ?? $validated['title'],
            'seo_description' => $validated['seo_description'] ?? $this->generateExcerpt($validated['content']),
            'reading_time' => $validated['reading_time'] ?? $this->calculateReadingTime($validated['content']),
            'featured_image' => $validated['featured_image'] ?? null,
        ]);
        
        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }
        
        $this->updateSearchIndex($post);
        
        return $post;
    }
    
    public function updatePost(Post $post, array $data): Post
    {
        $validated = Validator::validate($data, [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'category' => 'sometimes|exists:blog_categories,id',
            'tags' => 'sometimes|array',
            'status' => 'sometimes|in:draft,scheduled,published',
            'scheduled_at' => 'required_if:status,scheduled|date',
        ]);
        
        $post->update($validated);
        
        if (isset($validated['content'])) {
            $post->update([
                'excerpt' => $this->generateExcerpt($validated['content']),
                'reading_time' => $this->calculateReadingTime($validated['content']),
            ]);
        }
        
        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }
        
        $this->updateSearchIndex($post);
        $this->invalidateCache($post);
        
        return $post;
    }
    
    public function publishPost(Post $post): Post
    {
        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
        
        $this->updateSearchIndex($post);
        $this->notifySubscribers($post);
        $this->shareOnSocialMedia($post);
        
        return $post;
    }
    
    public function schedulePost(Post $post, Carbon $publishAt): Post
    {
        $post->update([
            'status' => 'scheduled',
            'scheduled_at' => $publishAt,
        ]);
        
        Schedule::job(new PublishScheduledPost($post))
            ->at($publishAt);
        
        return $post;
    }
    
    private function generateExcerpt(string $content, int $length = 160): string
    {
        $clean = strip_tags($content);
        $clean = preg_replace('/\s+/', ' ', $clean);
        
        return Str::limit(trim($clean), $length);
    }
    
    private function calculateReadingTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        
        return max(1, (int) ceil($wordCount / 200));
    }
}
```

## Category Management

```php
class CategoryService
{
    public function createCategory(array $data): Category
    {
        return Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
            'color' => $data['color'] ?? null,
            'icon' => $data['icon'] ?? null,
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
        // Move posts to uncategorized
        Post::where('category_id', $category->id)
            ->update(['category_id' => null]);
        
        $category->delete();
    }
    
    public function getCategoriesWithCounts(): Collection
    {
        return Category::withCount('posts')
            ->orderBy('sort_order')
            ->get();
    }
}
```

## Tag Management

```php
class TagService
{
    public function createTag(array $data): Tag
    {
        return Tag::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);
    }
    
    public function getOrCreateTags(array $tagNames): Collection
    {
        $tags = collect();
        
        foreach ($tagNames as $name) {
            $tag = Tag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
            $tags->push($tag);
        }
        
        return $tags;
    }
    
    public function getPopularTags(int $limit = 20): Collection
    {
        return Tag::withCount('posts')
            ->orderByDesc('posts_count')
            ->limit($limit)
            ->get();
    }
    
    public function mergeTags(Tag $source, Tag $target): void
    {
        $postIds = $source->posts()->pluck('posts.id');
        
        $target->posts()->syncWithoutDetaching($postIds);
        
        $source->delete();
    }
}
```

---

# Editor Features Details

## Markdown Editor Implementation

```javascript
class MarkdownEditor {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.editor = null;
        this.preview = null;
        
        this.init();
    }
    
    init() {
        this.container.innerHTML = `
            <div class="markdown-editor">
                <div class="editor-toolbar">
                    <button data-action="bold" title="Bold"><strong>B</strong></button>
                    <button data-action="italic" title="Italic"><em>I</em></button>
                    <button data-action="heading" title="Heading">H</button>
                    <button data-action="link" title="Link">🔗</button>
                    <button data-action="image" title="Image">🖼️</button>
                    <button data-action="code" title="Code">&lt;/&gt;</button>
                    <button data-action="list" title="List">☰</button>
                    <button data-action="quote" title="Quote">"</button>
                    <span class="separator"></span>
                    <button data-action="preview" title="Toggle Preview">👁️</button>
                </div>
                <div class="editor-content">
                    <div class="editor-pane" data-editor-pane>
                        <textarea class="editor-textarea" data-textarea></textarea>
                    </div>
                    <div class="preview-pane hidden" data-preview-pane>
                        <div class="preview-content" data-preview-content></div>
                    </div>
                </div>
            </div>
        `;
        
        this.textarea = this.container.querySelector('[data-textarea]');
        this.editorPane = this.container.querySelector('[data-editor-pane]');
        this.previewPane = this.container.querySelector('[data-preview-pane]');
        this.previewContent = this.container.querySelector('[data-preview-content]');
        
        this.setupEventListeners();
    }
    
    setupEventListeners() {
        // Toolbar actions
        this.container.querySelectorAll('[data-action]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.handleAction(e.target.closest('[data-action]').dataset.action);
            });
        });
        
        // Auto-save
        this.textarea.addEventListener('input', debounce(() => {
            this.autoSave();
        }, 1000));
        
        // Keyboard shortcuts
        this.textarea.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                switch (e.key) {
                    case 'b':
                        e.preventDefault();
                        this.handleAction('bold');
                        break;
                    case 'i':
                        e.preventDefault();
                        this.handleAction('italic');
                        break;
                    case 's':
                        e.preventDefault();
                        this.save();
                        break;
                }
            }
        });
    }
    
    handleAction(action) {
        const start = this.textarea.selectionStart;
        const end = this.textarea.selectionEnd;
        const selected = this.textarea.value.substring(start, end);
        
        const replacements = {
            bold: `**${selected || 'bold text'}**`,
            italic: `*${selected || 'italic text'}*`,
            heading: `## ${selected || 'Heading'}`,
            link: `[${selected || 'link text'}](url)`,
            image: `![${selected || 'alt text'}](url)`,
            code: selected.includes('\n') 
                ? `\`\`\`\n${selected}\n\`\`\`` 
                : `\`${selected || 'code'}\``,
            list: selected.split('\n').map(line => `- ${line}`).join('\n'),
            quote: `> ${selected || 'quote'}`,
        };
        
        if (replacements[action]) {
            this.textarea.value = 
                this.textarea.value.substring(0, start) + 
                replacements[action] + 
                this.textarea.value.substring(end);
            
            this.textarea.focus();
        }
        
        if (action === 'preview') {
            this.togglePreview();
        }
    }
    
    togglePreview() {
        const isPreviewVisible = !this.previewPane.classList.contains('hidden');
        
        if (isPreviewVisible) {
            this.previewPane.classList.add('hidden');
            this.editorPane.classList.remove('hidden');
        } else {
            this.previewContent.innerHTML = this.renderMarkdown(this.textarea.value);
            this.previewPane.classList.remove('hidden');
            this.editorPane.classList.add('hidden');
        }
    }
    
    renderMarkdown(text) {
        // Simple markdown rendering
        let html = text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/^## (.*$)/gm, '<h2>$1</h2>')
            .replace(/^# (.*$)/gm, '<h1>$1</h1>')
            .replace(/`(.*?)`/g, '<code>$1</code>')
            .replace(/\n/g, '<br>');
        
        return html;
    }
    
    autoSave() {
        localStorage.setItem('post_draft', this.textarea.value);
    }
    
    save() {
        // Emit save event
        const event = new CustomEvent('post:save', {
            detail: { content: this.textarea.value }
        });
        this.container.dispatchEvent(event);
    }
    
    getValue() {
        return this.textarea.value;
    }
    
    setValue(value) {
        this.textarea.value = value;
    }
}
```

## Rich Text Editor Fallback

```javascript
class RichTextEditor {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.editor = null;
        
        this.init();
    }
    
    init() {
        this.container.innerHTML = `
            <div class="rich-text-editor">
                <div class="editor-toolbar">
                    <select data-font-size>
                        <option value="1">Small</option>
                        <option value="3" selected>Normal</option>
                        <option value="5">Large</option>
                        <option value="7">Huge</option>
                    </select>
                    <button data-command="bold" title="Bold"><strong>B</strong></button>
                    <button data-command="italic" title="Italic"><em>I</em></button>
                    <button data-command="underline" title="Underline"><u>U</u></button>
                    <button data-command="strikeThrough" title="Strikethrough"><s>S</s></button>
                    <span class="separator"></span>
                    <button data-command="justifyLeft" title="Align Left">⬅</button>
                    <button data-command="justifyCenter" title="Align Center">⬛</button>
                    <button data-command="justifyRight" title="Align Right">➡</button>
                    <span class="separator"></span>
                    <button data-command="insertOrderedList" title="Ordered List">1.</button>
                    <button data-command="insertUnorderedList" title="Unordered List">•</button>
                    <span class="separator"></span>
                    <button data-command="createLink" title="Insert Link">🔗</button>
                    <button data-command="insertImage" title="Insert Image">🖼️</button>
                </div>
                <div class="editor-content" contenteditable="true" data-editor></div>
            </div>
        `;
        
        this.editor = this.container.querySelector('[data-editor]');
        
        this.setupEventListeners();
    }
    
    setupEventListeners() {
        this.container.querySelectorAll('[data-command]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const command = e.target.closest('[data-command]').dataset.command;
                this.executeCommand(command);
            });
        });
        
        this.container.querySelector('[data-font-size]').addEventListener('change', (e) => {
            document.execCommand('fontSize', false, e.target.value);
        });
    }
    
    executeCommand(command) {
        if (command === 'createLink') {
            const url = prompt('Enter URL:');
            if (url) {
                document.execCommand(command, false, url);
            }
        } else if (command === 'insertImage') {
            const url = prompt('Enter image URL:');
            if (url) {
                document.execCommand(command, false, url);
            }
        } else {
            document.execCommand(command, false, null);
        }
    }
    
    getHTML() {
        return this.editor.innerHTML;
    }
    
    setHTML(html) {
        this.editor.innerHTML = html;
    }
    
    getMarkdown() {
        return this.htmlToMarkdown(this.editor.innerHTML);
    }
    
    htmlToMarkdown(html) {
        let md = html;
        
        md = md.replace(/<strong>(.*?)<\/strong>/g, '**$1**');
        md = md.replace(/<b>(.*?)<\/b>/g, '**$1**');
        md = md.replace(/<em>(.*?)<\/em>/g, '*$1*');
        md = md.replace(/<i>(.*?)<\/i>/g, '*$1*');
        md = md.replace(/<h1>(.*?)<\/h1>/g, '# $1');
        md = md.replace(/<h2>(.*?)<\/h2>/g, '## $1');
        md = md.replace(/<h3>(.*?)<\/h3>/g, '### $1');
        md = md.replace(/<code>(.*?)<\/code>/g, '`$1`');
        md = md.replace(/<a href="(.*?)">(.*?)<\/a>/g, '[$2]($1)');
        md = md.replace(/<img src="(.*?)" alt="(.*?)">/g, '![$2]($1)');
        md = md.replace(/<li>(.*?)<\/li>/g, '- $1');
        md = md.replace(/<[^>]+>/g, '');
        
        return md.trim();
    }
}
```

---

# SEO Features Details

## Structured Data Implementation

```php
class BlogSeo
{
    public function getArticleSchema(Post $post): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->seo_title ?? $post->title,
            'description' => $post->seo_description ?? $post->excerpt,
            'image' => $post->featured_image,
            'datePublished' => $post->published_at->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->author->name,
                'url' => $post->author->profile_url,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('blog.post', $post->slug),
            ],
        ];
    }
    
    public function getBreadcrumbSchema(Post $post): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Blog',
                    'item' => route('blog.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $post->category->name,
                    'item' => route('blog.category', $post->category->slug),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 4,
                    'name' => $post->title,
                ],
            ],
        ];
    }
    
    public function getMetaTags(Post $post): array
    {
        return [
            'title' => $post->seo_title ?? "{$post->title} - " . config('app.name'),
            'description' => $post->seo_description ?? $post->excerpt,
            'og:title' => $post->seo_title ?? $post->title,
            'og:description' => $post->seo_description ?? $post->excerpt,
            'og:image' => $post->featured_image,
            'og:url' => route('blog.post', $post->slug),
            'og:type' => 'article',
            'og:site_name' => config('app.name'),
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $post->seo_title ?? $post->title,
            'twitter:description' => $post->seo_description ?? $post->excerpt,
            'twitter:image' => $post->featured_image,
            'canonical' => route('blog.post', $post->slug),
            'robots' => $post->is_noindex ? 'noindex' : 'index, follow',
        ];
    }
}
```

## Sitemap Generation

```php
class BlogSitemap
{
    public function generate(): string
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
        
        $urlset = $xml->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        
        // Add blog index
        $url = $this->createElement($xml, route('blog.index'), now(), '0.8');
        $urlset->appendChild($url);
        
        // Add categories
        $categories = Category::all();
        foreach ($categories as $category) {
            $url = $this->createElement($xml, route('blog.category', $category->slug), now(), '0.7');
            $urlset->appendChild($url);
        }
        
        // Add posts
        $posts = Post::where('status', 'published')
            ->where('is_noindex', false)
            ->get();
        
        foreach ($posts as $post) {
            $url = $this->createElement($xml, route('blog.post', $post->slug), $post->updated_at, '0.6');
            $urlset->appendChild($url);
        }
        
        $xml->appendChild($urlset);
        
        return $xml->saveXML();
    }
    
    private function createElement(DOMDocument $xml, string $loc, Carbon $lastmod, string $priority): DOMElement
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

# Newsletter Integration Details

## Subscriber Management

```php
class NewsletterService
{
    public function subscribe(string $email, array $preferences = []): Subscriber
    {
        $subscriber = Subscriber::firstOrCreate(
            ['email' => $email],
            [
                'token' => Str::random(32),
                'preferences' => $preferences,
                'subscribed_at' => now(),
            ]
        );
        
        if (!$subscriber->is_confirmed) {
            $this->sendConfirmationEmail($subscriber);
        }
        
        return $subscriber;
    }
    
    public function unsubscribe(string $token): bool
    {
        $subscriber = Subscriber::where('token', $token)->first();
        
        if (!$subscriber) {
            return false;
        }
        
        $subscriber->update([
            'unsubscribed_at' => now(),
            'is_active' => false,
        ]);
        
        return true;
    }
    
    public function confirm(string $token): bool
    {
        $subscriber = Subscriber::where('token', $token)
            ->whereNull('confirmed_at')
            ->first();
        
        if (!$subscriber) {
            return false;
        }
        
        $subscriber->update(['confirmed_at' => now()]);
        
        return true;
    }
    
    public function sendNewsletter(array $data): void
    {
        $subscribers = Subscriber::where('is_active', true)
            ->whereNotNull('confirmed_at')
            ->get();
        
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->queue(new NewsletterMail($data, $subscriber));
        }
    }
    
    public function sendPostNotification(Post $post): void
    {
        $subscribers = Subscriber::where('is_active', true)
            ->whereNotNull('confirmed_at')
            ->whereJsonContains('preferences->categories', $post->category->slug)
            ->get();
        
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->queue(new NewPostNotification($post, $subscriber));
        }
    }
    
    public function getStats(): array
    {
        return [
            'total' => Subscriber::count(),
            'active' => Subscriber::where('is_active', true)->count(),
            'confirmed' => Subscriber::whereNotNull('confirmed_at')->count(),
            'unsubscribed' => Subscriber::whereNotNull('unsubscribed_at')->count(),
        ];
    }
}
```

## Email Templates

```php
class NewsletterMail extends Mailable
{
    public function __construct(
        public array $data,
        public Subscriber $subscriber
    ) {}
    
    public function build(): self
    {
        return $this
            ->subject($this->data['subject'])
            ->view('emails.newsletter')
            ->with([
                'content' => $this->data['content'],
                'unsubscribeUrl' => route('newsletter.unsubscribe', $this->subscriber->token),
            ]);
    }
}
```

---

# Comment System Details

## Comment Management

```php
class CommentService
{
    public function addComment(Post $post, User $user, array $data): Comment
    {
        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'parent_id' => $data['parent_id'] ?? null,
            'content' => $data['content'],
            'status' => 'pending',
        ]);
        
        $post->increment('comments_count');
        
        // Notify post author
        if ($post->author_id !== $user->id) {
            Notification::send($post->author, new CommentAddedNotification($comment));
        }
        
        // Notify parent comment author
        if ($comment->parent_id) {
            $parentComment = Comment::find($comment->parent_id);
            if ($parentComment && $parentComment->user_id !== $user->id) {
                Notification::send($parentComment->user, new ReplyAddedNotification($comment));
            }
        }
        
        // Auto-approve for trusted users
        if ($this->isTrustedUser($user)) {
            $comment->update(['status' => 'approved']);
        }
        
        return $comment;
    }
    
    public function approveComment(Comment $comment): void
    {
        $comment->update(['status' => 'approved']);
    }
    
    public function rejectComment(Comment $comment): void
    {
        $comment->update(['status' => 'rejected']);
    }
    
    public function deleteComment(Comment $comment): void
    {
        $comment->update(['status' => 'deleted']);
        $comment->post->decrement('comments_count');
    }
    
    public function getComments(Post $post, int $limit = 50): Collection
    {
        return Comment::where('post_id', $post->id)
            ->whereNull('parent_id')
            ->where('status', 'approved')
            ->with(['user', 'replies.user'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
    
    private function isTrustedUser(User $user): bool
    {
        return $user->comments()
            ->where('status', 'approved')
            ->count() >= 10;
    }
}
```

---

# Analytics Details

## Post Analytics

```php
class PostAnalytics
{
    public function getPostMetrics(Post $post, int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        return [
            'views' => $this->getViews($post, $startDate),
            'unique_visitors' => $this->getUniqueVisitors($post, $startDate),
            'reading_time' => $this->getAvgReadingTime($post, $startDate),
            'scroll_depth' => $this->getAvgScrollDepth($post, $startDate),
            'code_copies' => $this->getCodeCopies($post, $startDate),
            'shares' => $this->getShares($post, $startDate),
            'comments' => $post->comments()->where('created_at', '>=', $startDate)->count(),
            'newsletter_signups' => $this->getNewsletterSignups($startDate),
        ];
    }
    
    public function getViewsChart(Post $post, int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        $views = DB::table('blog_post_views')
            ->where('post_id', $post->id)
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as views')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return [
            'labels' => $views->pluck('date'),
            'data' => $views->pluck('views'),
        ];
    }
    
    public function getPopularPosts(int $limit = 10): Collection
    {
        return Cache::remember('popular_posts', 3600, function () use ($limit) {
            return Post::where('status', 'published')
                ->with('author')
                ->orderByDesc('views_count')
                ->limit($limit)
                ->get();
        });
    }
    
    private function getViews(Post $post, Carbon $startDate): int
    {
        return DB::table('blog_post_views')
            ->where('post_id', $post->id)
            ->where('created_at', '>=', $startDate)
            ->count();
    }
    
    private function getUniqueVisitors(Post $post, Carbon $startDate): int
    {
        return DB::table('blog_post_views')
            ->where('post_id', $post->id)
            ->where('created_at', '>=', $startDate)
            ->distinct('ip_address')
            ->count();
    }
    
    private function getAvgReadingTime(Post $post, Carbon $startDate): float
    {
        $times = DB::table('blog_reading_times')
            ->where('post_id', $post->id)
            ->where('created_at', '>=', $startDate)
            ->pluck('time_seconds')
            ->toArray();
        
        return count($times) > 0 ? array_sum($times) / count($times) : 0;
    }
}
```

---

# Technical Architecture Details

## Database Schema

```sql
-- Blog Posts
CREATE TABLE blog_posts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content LONGTEXT,
    excerpt TEXT,
    featured_image VARCHAR(500),
    category_id BIGINT UNSIGNED,
    author_id BIGINT UNSIGNED NOT NULL,
    status ENUM('draft', 'scheduled', 'published', 'archived') NOT NULL DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    scheduled_at TIMESTAMP NULL,
    reading_time INT UNSIGNED NOT NULL DEFAULT 0,
    views_count INT UNSIGNED NOT NULL DEFAULT 0,
    comments_count INT UNSIGNED NOT NULL DEFAULT 0,
    seo_title VARCHAR(255),
    seo_description VARCHAR(160),
    is_noindex BOOLEAN NOT NULL DEFAULT FALSE,
    is_featured BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES users(id),
    INDEX idx_status (status),
    INDEX idx_category (category_id),
    INDEX idx_author (author_id),
    INDEX idx_published (published_at),
    FULLTEXT INDEX ft_search (title, content)
);

-- Blog Categories
CREATE TABLE blog_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    color VARCHAR(7),
    icon VARCHAR(100),
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE INDEX idx_slug (slug)
);

-- Blog Tags
CREATE TABLE blog_tags (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE INDEX idx_slug (slug)
);

-- Blog Post Tags Pivot
CREATE TABLE blog_post_tag (
    post_id BIGINT UNSIGNED NOT NULL,
    tag_id BIGINT UNSIGNED NOT NULL,
    
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES blog_tags(id) ON DELETE CASCADE
);

-- Blog Authors
CREATE TABLE blog_authors (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    bio TEXT,
    avatar VARCHAR(500),
    social_links JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Blog Comments
CREATE TABLE blog_comments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    parent_id BIGINT UNSIGNED,
    content TEXT NOT NULL,
    status ENUM('pending', 'approved', 'rejected', 'deleted') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES blog_comments(id) ON DELETE CASCADE,
    INDEX idx_post (post_id),
    INDEX idx_status (status)
);

-- Newsletter Subscribers
CREATE TABLE blog_subscribers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    token VARCHAR(64) NOT NULL,
    preferences JSON,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    is_confirmed BOOLEAN NOT NULL DEFAULT FALSE,
    confirmed_at TIMESTAMP NULL,
    unsubscribed_at TIMESTAMP NULL,
    subscribed_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE INDEX idx_email (email),
    INDEX idx_token (token)
);
```

---

# API Contracts Details

## Blog API Specification

```yaml
openapi: 3.0.0
info:
  title: GsmUi Blog API
  version: 1.0.0
  description: API for the GsmUi Blog

paths:
  /api/blog/posts:
    get:
      summary: List posts
      tags: [Posts]
      parameters:
        - name: category
          in: query
          schema:
            type: string
        - name: tag
          in: query
          schema:
            type: string
        - name: author
          in: query
          schema:
            type: string
        - name: search
          in: query
          schema:
            type: string
        - name: page
          in: query
          schema:
            type: integer
      responses:
        '200':
          description: Post list

    post:
      summary: Create post
      tags: [Posts]
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
                - content
                - category
              properties:
                title:
                  type: string
                content:
                  type: string
                category:
                  type: string
                tags:
                  type: array
                  items:
                    type: string
                featured_image:
                  type: string
                  format: binary
                status:
                  type: string
                  enum: [draft, scheduled, published]
                scheduled_at:
                  type: string
                  format: date-time
      responses:
        '201':
          description: Post created

  /api/blog/posts/{slug}:
    get:
      summary: Get post
      tags: [Posts]
      parameters:
        - name: slug
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Post details

    put:
      summary: Update post
      tags: [Posts]
      security:
        - bearerAuth: []
      parameters:
        - name: slug
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Post updated

    delete:
      summary: Delete post
      tags: [Posts]
      security:
        - bearerAuth: []
      parameters:
        - name: slug
          in: path
          required: true
          schema:
            type: string
      responses:
        '204':
          description: Post deleted

  /api/blog/posts/{id}/comments:
    get:
      summary: Get comments
      tags: [Comments]
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: integer
      responses:
        '200':
          description: Comment list

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

  /api/blog/subscribe:
    post:
      summary: Subscribe to newsletter
      tags: [Newsletter]
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - email
              properties:
                email:
                  type: string
                  format: email
      responses:
        '201':
          description: Subscribed

components:
  schemas:
    Post:
      type: object
      properties:
        id:
          type: integer
        title:
          type: string
        slug:
          type: string
        excerpt:
          type: string
        featured_image:
          type: string
        category:
          type: object
        author:
          type: object
        published_at:
          type: string
          format: date-time
        reading_time:
          type: integer
        views_count:
          type: integer
        comments_count:
          type: integer

    Comment:
      type: object
      properties:
        id:
          type: integer
        user:
          type: object
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

  securitySchemes:
    bearerAuth:
      type: http
      scheme: bearer
      bearerFormat: JWT
```

---

# User Flows Details

## Author Content Creation Flow

```text
Author logs in
    ↓
Navigates to blog dashboard
    ↓
Clicks "New Post"
    ↓
Opens post editor
    ├── Enters title
    ├── Writes content (Markdown/WYSIWYG)
    ├── Adds featured image
    ├── Selects category
    ├── Adds tags
    ├── Configures SEO
    └── Sets reading time
    ↓
Previews post
    ↓
Chooses action:
    ├── Save as Draft
    ├── Schedule for Later
    └── Publish Now
    ↓
Post processed:
    ├── Search index updated
    ├── Cache invalidated
    ├── Subscribers notified (if published)
    └── Social media shared (if published)
```

## Reader Engagement Flow

```text
Reader discovers post
    ├── Search engine
    ├── Social media
    ├── Newsletter
    └── Direct visit
    ↓
Views post page
    ├── Reads content
    ├── Views code examples
    ├── Copies code blocks
    └── Scrolls through article
    ↓
Engages with post:
    ├── Leaves comment
    ├── Shares on social media
    ├── Subscribes to newsletter
    └── Views related posts
    ↓
Returns for more content
```

---

# Success Metrics Details

## Key Performance Indicators

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Published Posts | 50 | 100+ | Database count |
| Monthly Readers | 25,000 | 50,000+ | Analytics |
| Newsletter Subscribers | 2,500 | 5,000+ | Database count |
| Comments per Post | 5 | 10+ | Average count |
| Reading Experience | 4.2/5 | 4.5/5 | Survey score |
| Code Copy Rate | 30% | 40%+ | Tracking |
| Return Reader Rate | 35% | 45%+ | Analytics |

## Content Performance Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Avg. Time on Page | 3 minutes | 5 minutes | Analytics |
| Scroll Depth | 60% | 75%+ | Analytics |
| Bounce Rate | 45% | <35% | Analytics |
| Pages per Session | 1.5 | 2.5+ | Analytics |
| Social Shares | 20/post | 50+/post | Tracking |

## Newsletter Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Open Rate | 25% | 35%+ | Email analytics |
| Click Rate | 3% | 5%+ | Email analytics |
| Unsubscribe Rate | 2% | <1% | Email analytics |
| Growth Rate | 10%/month | 15%+/month | Database |

---

# Admin Features Details

## Post Management Dashboard

```php
class PostDashboard
{
    public function getOverview(): array
    {
        return [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'scheduled_posts' => Post::where('status', 'scheduled')->count(),
            'total_views' => Post::sum('views_count'),
            'total_comments' => Post::sum('comments_count'),
            'total_subscribers' => Subscriber::where('is_active', true)->count(),
        ];
    }
    
    public function getRecentPosts(int $limit = 10): Collection
    {
        return Post::with(['author', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
    
    public function getPopularPosts(int $limit = 10): Collection
    {
        return Post::where('status', 'published')
            ->with('author')
            ->orderByDesc('views_count')
            ->limit($limit)
            ->get();
    }
    
    public function getScheduledPosts(): Collection
    {
        return Post::where('status', 'scheduled')
            ->where('scheduled_at', '>', now())
            ->with(['author', 'category'])
            ->orderBy('scheduled_at')
            ->get();
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
            'color' => $data['color'] ?? null,
            'icon' => $data['icon'] ?? null,
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
        Post::where('category_id', $category->id)
            ->update(['category_id' => null]);
        
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

## Comment Moderation

```php
class CommentModeration
{
    public function getPendingComments(int $limit = 50): Collection
    {
        return Comment::where('status', 'pending')
            ->with(['user', 'post'])
            ->orderBy('created_at')
            ->limit($limit)
            ->get();
    }
    
    public function approveComment(Comment $comment, User $moderator): void
    {
        $comment->update([
            'status' => 'approved',
            'approved_by' => $moderator->id,
            'approved_at' => now(),
        ]);
        
        Notification::send($comment->user, new CommentApprovedNotification($comment));
    }
    
    public function rejectComment(Comment $comment, User $moderator, string $reason = null): void
    {
        $comment->update([
            'status' => 'rejected',
            'rejected_by' => $moderator->id,
            'rejected_at' => now(),
            'rejection_reason' => $reason,
        ]);
        
        $comment->post->decrement('comments_count');
    }
    
    public function bulkApprove(array $commentIds, User $moderator): void
    {
        Comment::whereIn('id', $commentIds)
            ->update([
                'status' => 'approved',
                'approved_by' => $moderator->id,
                'approved_at' => now(),
            ]);
    }
    
    public function bulkReject(array $commentIds, User $moderator): void
    {
        Comment::whereIn('id', $commentIds)->update([
            'status' => 'rejected',
            'rejected_by' => $moderator->id,
            'rejected_at' => now(),
        ]);
    }
}
```

## Newsletter Management

```php
class NewsletterManagement
{
    public function getSubscriberStats(): array
    {
        return [
            'total' => Subscriber::count(),
            'active' => Subscriber::where('is_active', true)->count(),
            'confirmed' => Subscriber::whereNotNull('confirmed_at')->count(),
            'unsubscribed' => Subscriber::whereNotNull('unsubscribed_at')->count(),
            'growth_this_month' => Subscriber::where('created_at', '>=', now()->startOfMonth())->count(),
        ];
    }
    
    public function getSubscribersByPreference(): array
    {
        return Subscriber::where('is_active', true)
            ->select('preferences')
            ->get()
            ->flatMap(function ($subscriber) {
                $categories = json_decode($subscriber->preferences)['categories'] ?? [];
                return $categories;
            })
            ->countBy()
            ->toArray();
    }
    
    public function sendCampaign(string $subject, string $content, array $filters = []): void
    {
        $query = Subscriber::where('is_active', true)
            ->whereNotNull('confirmed_at');
        
        if (!empty($filters['categories'])) {
            $query->whereJsonContains('preferences->categories', $filters['categories']);
        }
        
        $subscribers = $query->get();
        
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->queue(new NewsletterCampaignMail($subject, $content, $subscriber));
        }
        
        // Track campaign
        Campaign::create([
            'subject' => $subject,
            'content' => $content,
            'recipients_count' => $subscribers->count(),
            'sent_at' => now(),
        ]);
    }
    
    public function getCampaignStats(Campaign $campaign): array
    {
        return [
            'recipients' => $campaign->recipients_count,
            'sent' => $campaign->sent_count,
            'opened' => $campaign->opened_count,
            'clicked' => $campaign->clicked_count,
            'unsubscribed' => $campaign->unsubscribed_count,
            'open_rate' => $campaign->recipients_count > 0 
                ? ($campaign->opened_count / $campaign->recipients_count) * 100 
                : 0,
            'click_rate' => $campaign->opened_count > 0 
                ? ($campaign->clicked_count / $campaign->opened_count) * 100 
                : 0,
        ];
    }
}
```

## SEO Tools

```php
class SeoTools
{
    public function analyzePost(Post $post): array
    {
        $issues = [];
        
        // Check title length
        $titleLength = strlen($post->seo_title ?? $post->title);
        if ($titleLength < 30) {
            $issues[] = ['type' => 'warning', 'message' => 'Title is too short (recommended: 30-60 characters)'];
        } elseif ($titleLength > 60) {
            $issues[] = ['type' => 'warning', 'message' => 'Title is too long (recommended: 30-60 characters)'];
        }
        
        // Check meta description
        $descLength = strlen($post->seo_description ?? '');
        if ($descLength < 120) {
            $issues[] = ['type' => 'warning', 'message' => 'Meta description is too short (recommended: 120-160 characters)'];
        } elseif ($descLength > 160) {
            $issues[] = ['type' => 'warning', 'message' => 'Meta description is too long (recommended: 120-160 characters)'];
        }
        
        // Check content length
        $wordCount = str_word_count(strip_tags($post->content));
        if ($wordCount < 300) {
            $issues[] = ['type' => 'warning', 'message' => 'Content is too short (recommended: 300+ words)'];
        }
        
        // Check headings
        $headings = preg_match_all('/<h[2-6]>/i', $post->content);
        if ($headings < 2) {
            $issues[] = ['type' => 'info', 'message' => 'Consider adding more headings for better structure'];
        }
        
        // Check images
        $images = preg_match_all('/<img/i', $post->content);
        if ($images === 0) {
            $issues[] = ['type' => 'info', 'message' => 'Consider adding images to improve engagement'];
        }
        
        // Check internal links
        $links = preg_match_all('/<a[^>]+href="[^"]*"/i', $post->content);
        if ($links < 2) {
            $issues[] = ['type' => 'info', 'message' => 'Consider adding more internal links'];
        }
        
        return [
            'score' => $this->calculateScore($issues),
            'issues' => $issues,
            'stats' => [
                'title_length' => $titleLength,
                'description_length' => $descLength,
                'word_count' => $wordCount,
                'headings' => $headings,
                'images' => $images,
                'links' => $links,
            ],
        ];
    }
    
    private function calculateScore(array $issues): int
    {
        $score = 100;
        
        foreach ($issues as $issue) {
            match ($issue['type']) {
                'error' => $score -= 20,
                'warning' => $score -= 10,
                'info' => $score -= 5,
            };
        }
        
        return max(0, $score);
    }
    
    public function suggestFocusKeyword(Post $post): array
    {
        $content = strtolower(strip_tags($post->content));
        $title = strtolower($post->title);
        
        // Extract potential keywords
        $words = str_word_count($content, 1);
        $wordCounts = array_count_values($words);
        
        // Filter out common words
        $stopWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by'];
        $wordCounts = array_diff_key($wordCounts, array_flip($stopWords));
        
        arsort($wordCounts);
        
        return array_slice(array_keys($wordCounts), 0, 10);
    }
}
```

---

# Success Metrics Details

## Key Performance Indicators

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Published Posts | 50 | 100+ | Database count |
| Monthly Readers | 25,000 | 50,000+ | Analytics |
| Newsletter Subscribers | 2,500 | 5,000+ | Database count |
| Comments per Post | 5 | 10+ | Average count |
| Reading Experience | 4.2/5 | 4.5/5 | Survey score |
| Code Copy Rate | 30% | 40%+ | Tracking |
| Return Reader Rate | 35% | 45%+ | Analytics |

## Content Performance Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Avg. Time on Page | 3 minutes | 5 minutes | Analytics |
| Scroll Depth | 60% | 75%+ | Analytics |
| Bounce Rate | 45% | <35% | Analytics |
| Pages per Session | 1.5 | 2.5+ | Analytics |
| Social Shares | 20/post | 50+/post | Tracking |

## Newsletter Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Open Rate | 25% | 35%+ | Email analytics |
| Click Rate | 3% | 5%+ | Email analytics |
| Unsubscribe Rate | 2% | <1% | Email analytics |
| Growth Rate | 10%/month | 15%+/month | Database |

## SEO Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Organic Traffic | 40% | 60%+ | Analytics |
| Avg. Position | 15 | <10 | Search Console |
| Click-through Rate | 2% | 4%+ | Search Console |
| Indexed Pages | 80% | 95%+ | Search Console |

---

# Next Document

**22 - CMS** — Content management system for static pages and navigation.
