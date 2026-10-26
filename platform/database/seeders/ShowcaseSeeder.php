<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ShowcaseItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShowcaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->pluck('id')->toArray();
        $authorId = User::first()->id;

        if (empty($users)) {
            $users = [$authorId];
        }

        $showcases = [
            ['title' => 'TaskFlow - Project Management Dashboard', 'slug' => 'taskflow-project-management', 'description' => 'A sleek project management dashboard built with GsmUi components and Livewire.', 'category' => 'SaaS', 'tags' => ['dashboard', 'project-management', 'livewire'], 'likes_count' => 342, 'comments_count' => 45, 'status' => 'published', 'featured' => true],
            ['title' => 'InvoiceCraft - Freelancer Invoicing', 'slug' => 'invoicecraft-freelancer-invoicing', 'description' => 'Beautiful invoicing app for freelancers with PDF generation and payment tracking.', 'category' => 'SaaS', 'tags' => ['invoicing', 'freelancer', 'billing'], 'likes_count' => 278, 'comments_count' => 34, 'status' => 'published', 'featured' => true],
            ['title' => 'Artisan Portfolio', 'slug' => 'artisan-portfolio', 'description' => 'A photographer portfolio with gallery lightbox and contact form.', 'category' => 'Portfolio', 'tags' => ['photography', 'gallery', 'portfolio'], 'likes_count' => 456, 'comments_count' => 67, 'status' => 'published', 'featured' => true],
            ['title' => 'GreenLeaf - Eco Commerce', 'slug' => 'greenleaf-eco-commerce', 'description' => 'An eco-friendly e-commerce store with product filtering and cart.', 'category' => 'E-commerce', 'tags' => ['ecommerce', 'sustainable', 'shop'], 'likes_count' => 189, 'comments_count' => 23, 'status' => 'published'],
            ['title' => 'DevConnect - Social Platform', 'slug' => 'devconnect-social-platform', 'description' => 'A developer social network with profiles, posts, and real-time chat.', 'category' => 'SaaS', 'tags' => ['social', 'community', 'chat'], 'likes_count' => 567, 'comments_count' => 89, 'status' => 'published', 'featured' => true],
            ['title' => 'MenuMaster - Restaurant Ordering', 'slug' => 'menumaster-restaurant-ordering', 'description' => 'Online ordering system for restaurants with menu management.', 'category' => 'E-commerce', 'tags' => ['restaurant', 'food', 'ordering'], 'likes_count' => 145, 'comments_count' => 18, 'status' => 'published'],
            ['title' => 'LearnPath - Course Platform', 'slug' => 'learnpath-course-platform', 'description' => 'Online learning platform with video lessons, quizzes, and certificates.', 'category' => 'SaaS', 'tags' => ['education', 'courses', 'learning'], 'likes_count' => 312, 'comments_count' => 41, 'status' => 'published', 'featured' => true],
            ['title' => 'CryptoWatch - Dashboard', 'slug' => 'cryptowatch-dashboard', 'description' => 'Real-time cryptocurrency tracking dashboard with charts and alerts.', 'category' => 'Dashboard', 'tags' => ['crypto', 'finance', 'charts'], 'likes_count' => 234, 'comments_count' => 29, 'status' => 'published'],
            ['title' => 'Wedding Planner App', 'slug' => 'wedding-planner-app', 'description' => 'A complete wedding planning tool with timeline, budget, and guest management.', 'category' => 'SaaS', 'tags' => ['wedding', 'planning', 'events'], 'likes_count' => 178, 'comments_count' => 22, 'status' => 'published'],
            ['title' => 'Agency Website Template', 'slug' => 'agency-website-template', 'description' => 'A modern agency website with services, team, and case studies sections.', 'category' => 'Agency', 'tags' => ['agency', 'corporate', 'landing'], 'likes_count' => 267, 'comments_count' => 35, 'status' => 'published'],
            ['title' => 'Fitness Tracker', 'slug' => 'fitness-tracker', 'description' => 'Personal fitness tracking app with workout logs and progress charts.', 'category' => 'Dashboard', 'tags' => ['fitness', 'health', 'tracking'], 'likes_count' => 156, 'comments_count' => 19, 'status' => 'published'],
            ['title' => 'Real Estate Listings', 'slug' => 'real-estate-listings', 'description' => 'Property listing platform with search, filters, and virtual tours.', 'category' => 'E-commerce', 'tags' => ['real-estate', 'property', 'listings'], 'likes_count' => 198, 'comments_count' => 26, 'status' => 'published'],
        ];

        foreach ($showcases as $index => $showcase) {
            $userId = $users[$index % count($users)];
            $fullBody = $showcase['description'] . "\n\n## About\n\nThis project demonstrates the power of GsmUi components in building real-world applications. Built with Laravel, Livewire, and Tailwind CSS.\n\n## Features\n\n- Responsive design\n- Dark mode support\n- Accessible interfaces\n- Clean, maintainable code";

            ShowcaseItem::create([
                ...$showcase,
                'user_id' => $userId,
                'body' => $fullBody,
                'thumbnail' => "https://picsum.photos/seed/{$showcase['slug']}/800/600",
                'gallery' => [
                    "https://picsum.photos/seed/{$showcase['slug']}-1/800/600",
                    "https://picsum.photos/seed/{$showcase['slug']}-2/800/600",
                    "https://picsum.photos/seed/{$showcase['slug']}-3/800/600",
                ],
            ]);
        }
    }
}
