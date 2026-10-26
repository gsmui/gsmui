<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = User::first()->id;

        $themes = [
            [
                'name' => 'Default', 'slug' => 'default', 'description' => 'The official GsmUi theme with a clean, modern aesthetic built on Inter and a balanced indigo palette.', 'status' => 'published', 'is_free' => true, 'version' => '1.0.0', 'is_featured' => true, 'downloads_count' => 32100, 'rating' => 4.9, 'rating_count' => 342, 'tags' => ['official', 'default', 'clean'],
                'tokens' => ['color-primary' => '#6366f1', 'color-secondary' => '#8b5cf6', 'color-accent' => '#06b6d4', 'color-success' => '#22c55e', 'color-warning' => '#f59e0b', 'color-danger' => '#ef4444', 'font-sans' => 'Inter, system-ui, sans-serif', 'radius' => '0.5rem'],
            ],
            [
                'name' => 'Dark Pro', 'slug' => 'dark-pro', 'description' => 'A premium dark theme with vibrant neon accents, optimized for extended use.', 'status' => 'published', 'is_free' => false, 'price' => 9.00, 'version' => '2.1.0', 'is_featured' => true, 'downloads_count' => 18700, 'rating' => 4.8, 'rating_count' => 198, 'tags' => ['dark', 'premium', 'neon'],
                'tokens' => ['color-primary' => '#818cf8', 'color-secondary' => '#a78bfa', 'color-accent' => '#22d3ee', 'color-success' => '#4ade80', 'color-warning' => '#fbbf24', 'color-danger' => '#f87171', 'font-sans' => 'Plus Jakarta Sans, system-ui, sans-serif', 'radius' => '0.75rem'],
            ],
            [
                'name' => 'Minimal', 'slug' => 'minimal', 'description' => 'A minimal black and white theme with focus on typography and content hierarchy.', 'status' => 'published', 'is_free' => true, 'version' => '1.3.0', 'is_featured' => true, 'downloads_count' => 14200, 'rating' => 4.7, 'rating_count' => 134, 'tags' => ['minimal', 'typography', 'clean'],
                'tokens' => ['color-primary' => '#171717', 'color-secondary' => '#525252', 'color-accent' => '#0a0a0a', 'color-success' => '#16a34a', 'color-warning' => '#d97706', 'color-danger' => '#dc2626', 'font-sans' => 'Newsreader, Georgia, serif', 'radius' => '0.25rem'],
            ],
            [
                'name' => 'Sunset', 'slug' => 'sunset', 'description' => 'A warm theme inspired by golden hour with orange and purple gradients.', 'status' => 'published', 'is_free' => false, 'price' => 7.00, 'version' => '1.0.0', 'downloads_count' => 8900, 'rating' => 4.6, 'rating_count' => 87, 'tags' => ['warm', 'gradient', 'vibrant'],
                'tokens' => ['color-primary' => '#f97316', 'color-secondary' => '#a855f7', 'color-accent' => '#ec4899', 'color-success' => '#22c55e', 'color-warning' => '#eab308', 'color-danger' => '#ef4444', 'font-sans' => 'DM Sans, system-ui, sans-serif', 'radius' => '0.625rem'],
            ],
            [
                'name' => 'Ocean', 'slug' => 'ocean', 'description' => 'A calming blue-green theme with depth, inspired by deep ocean colors.', 'status' => 'published', 'is_free' => true, 'version' => '1.1.0', 'downloads_count' => 11200, 'rating' => 4.5, 'rating_count' => 112, 'tags' => ['blue', 'calm', 'nature'],
                'tokens' => ['color-primary' => '#0891b2', 'color-secondary' => '#0d9488', 'color-accent' => '#6366f1', 'color-success' => '#10b981', 'color-warning' => '#f59e0b', 'color-danger' => '#f43f5e', 'font-sans' => 'Inter, system-ui, sans-serif', 'radius' => '0.5rem'],
            ],
            [
                'name' => 'Forest', 'slug' => 'forest', 'description' => 'An earthy green theme with natural tones, perfect for eco and wellness brands.', 'status' => 'published', 'is_free' => true, 'version' => '1.0.0', 'downloads_count' => 6700, 'rating' => 4.4, 'rating_count' => 56, 'tags' => ['green', 'earth', 'nature'],
                'tokens' => ['color-primary' => '#16a34a', 'color-secondary' => '#15803d', 'color-accent' => '#65a30d', 'color-success' => '#22c55e', 'color-warning' => '#ca8a04', 'color-danger' => '#dc2626', 'font-sans' => 'Source Sans 3, system-ui, sans-serif', 'radius' => '0.375rem'],
            ],
            [
                'name' => 'Rose', 'slug' => 'rose', 'description' => 'An elegant pink and rose gold theme with a feminine, modern feel.', 'status' => 'published', 'is_free' => false, 'price' => 8.00, 'version' => '1.2.0', 'downloads_count' => 9400, 'rating' => 4.7, 'rating_count' => 98, 'tags' => ['pink', 'elegant', 'feminine'],
                'tokens' => ['color-primary' => '#f43f5e', 'color-secondary' => '#e11d48', 'color-accent' => '#be185d', 'color-success' => '#16a34a', 'color-warning' => '#f59e0b', 'color-danger' => '#dc2626', 'font-sans' => 'Outfit, system-ui, sans-serif', 'radius' => '0.75rem'],
            ],
            [
                'name' => 'Midnight', 'slug' => 'midnight', 'description' => 'A deep navy and indigo dark theme with subtle gradients and glass effects.', 'status' => 'published', 'is_free' => true, 'version' => '1.0.0', 'is_featured' => true, 'downloads_count' => 15600, 'rating' => 4.8, 'rating_count' => 167, 'tags' => ['dark', 'navy', 'glass'],
                'tokens' => ['color-primary' => '#4f46e5', 'color-secondary' => '#7c3aed', 'color-accent' => '#06b6d4', 'color-success' => '#34d399', 'color-warning' => '#fbbf24', 'color-danger' => '#fb7185', 'font-sans' => 'Inter, system-ui, sans-serif', 'radius' => '0.75rem'],
            ],
            [
                'name' => 'Corporate', 'slug' => 'corporate', 'description' => 'A professional, restrained theme designed for enterprise and B2B applications.', 'status' => 'published', 'is_free' => false, 'price' => 12.00, 'version' => '2.0.0', 'downloads_count' => 7800, 'rating' => 4.5, 'rating_count' => 67, 'tags' => ['professional', 'enterprise', 'b2b'],
                'tokens' => ['color-primary' => '#1e40af', 'color-secondary' => '#1e3a8a', 'color-accent' => '#0369a1', 'color-success' => '#15803d', 'color-warning' => '#b45309', 'color-danger' => '#b91c1c', 'font-sans' => 'IBM Plex Sans, system-ui, sans-serif', 'radius' => '0.375rem'],
            ],
            [
                'name' => 'Retro', 'slug' => 'retro', 'description' => 'A playful retro theme with bold colors, rounded shapes, and nostalgic vibes.', 'status' => 'published', 'is_free' => false, 'price' => 6.00, 'version' => '1.0.0', 'downloads_count' => 5400, 'rating' => 4.3, 'rating_count' => 45, 'tags' => ['retro', 'playful', 'bold'],
                'tokens' => ['color-primary' => '#e11d48', 'color-secondary' => '#7c3aed', 'color-accent' => '#f59e0b', 'color-success' => '#10b981', 'color-warning' => '#f97316', 'color-danger' => '#ef4444', 'font-sans' => 'Fredoka, system-ui, sans-serif', 'radius' => '1rem'],
            ],
        ];

        foreach ($themes as $themeData) {
            Theme::create([...$themeData, 'author_id' => $authorId]);
        }
    }
}
