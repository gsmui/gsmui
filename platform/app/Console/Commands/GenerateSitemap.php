<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Domains\Components\Models\Component;
use App\Domains\Themes\Models\Theme;
use App\Domains\Blog\Models\Post;
use App\Domains\Documentation\Models\Document;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate XML sitemap';

    public function handle(): int
    {
        $this->info('Generating sitemap...');

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Add static pages
        $sitemap .= $this->urlEntry(route('home'));
        $sitemap .= $this->urlEntry(route('components.index'));
        $sitemap .= $this->urlEntry(route('themes.index'));
        $sitemap .= $this->urlEntry(route('docs.index'));
        $sitemap .= $this->urlEntry(route('blog.index'));

        // Add components
        Component::where('status', 'published')->each(function ($component) use (&$sitemap) {
            $sitemap .= $this->urlEntry(route('components.show', $component->slug));
        });

        // Add themes
        Theme::where('status', 'published')->each(function ($theme) use (&$sitemap) {
            $sitemap .= $this->urlEntry(route('themes.show', $theme->slug));
        });

        // Add posts
        Post::where('status', 'published')->each(function ($post) use (&$sitemap) {
            $sitemap .= $this->urlEntry(route('blog.show', $post->slug));
        });

        // Add documents
        Document::where('status', 'published')->each(function ($document) use (&$sitemap) {
            $sitemap .= $this->urlEntry(route('docs.show', $document->slug));
        });

        $sitemap .= '</urlset>';

        Storage::disk('public')->put('sitemap.xml', $sitemap);

        $this->info('Sitemap generated successfully!');

        return Command::SUCCESS;
    }

    protected function urlEntry(string $url): string
    {
        return "<url><loc>{$url}</loc><lastmod>" . now()->toDateString() . "</lastmod></url>";
    }
}
