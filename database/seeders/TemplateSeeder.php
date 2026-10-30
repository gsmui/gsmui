<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Templates\Models\Template;
use App\Domains\Users\Models\User;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = User::first()->id;

        $templates = [
            ['name' => 'Dashboard Starter', 'slug' => 'dashboard-starter', 'description' => 'A complete admin dashboard with authentication, sidebar navigation, charts, and user management.', 'status' => 'published', 'is_free' => true, 'framework' => 'laravel', 'industry' => 'saas', 'version' => '1.2.0', 'downloads_count' => 8900, 'rating' => 4.8, 'rating_count' => 134, 'is_featured' => true, 'tags' => ['dashboard', 'admin', 'auth']],
            ['name' => 'E-commerce Starter', 'slug' => 'ecommerce-starter', 'description' => 'Full-featured e-commerce template with product catalog, cart, checkout, and order management.', 'status' => 'published', 'is_free' => false, 'price' => 49.00, 'framework' => 'laravel', 'industry' => 'ecommerce', 'version' => '2.0.0', 'downloads_count' => 6700, 'rating' => 4.7, 'rating_count' => 98, 'is_featured' => true, 'tags' => ['ecommerce', 'shop', 'cart']],
            ['name' => 'Portfolio Pro', 'slug' => 'portfolio-pro', 'description' => 'A stunning portfolio template with project galleries, testimonials, and contact form.', 'status' => 'published', 'is_free' => false, 'price' => 29.00, 'framework' => 'livewire', 'industry' => 'portfolio', 'version' => '1.0.0', 'downloads_count' => 4500, 'rating' => 4.6, 'rating_count' => 67, 'tags' => ['portfolio', 'creative', 'showcase']],
            ['name' => 'SaaS Boilerplate', 'slug' => 'saas-boilerplate', 'description' => 'Complete SaaS boilerplate with billing, subscription management, and multi-tenancy.', 'status' => 'published', 'is_free' => false, 'price' => 99.00, 'framework' => 'laravel', 'industry' => 'saas', 'version' => '3.1.0', 'downloads_count' => 5600, 'rating' => 4.9, 'rating_count' => 156, 'is_featured' => true, 'tags' => ['saas', 'billing', 'subscription']],
            ['name' => 'Blog Starter', 'slug' => 'blog-starter', 'description' => 'A clean blog template with categories, tags, search, and reading time estimates.', 'status' => 'published', 'is_free' => true, 'framework' => 'livewire', 'industry' => 'blog', 'version' => '1.1.0', 'downloads_count' => 7800, 'rating' => 4.5, 'rating_count' => 89, 'tags' => ['blog', 'content', 'writing']],
            ['name' => 'Agency Landing', 'slug' => 'agency-landing', 'description' => 'A modern landing page template for digital agencies with service showcases and team sections.', 'status' => 'published', 'is_free' => false, 'price' => 39.00, 'framework' => 'laravel', 'industry' => 'agency', 'version' => '1.0.0', 'downloads_count' => 3400, 'rating' => 4.4, 'rating_count' => 56, 'tags' => ['agency', 'landing', 'marketing']],
            ['name' => 'Restaurant Template', 'slug' => 'restaurant-template', 'description' => 'A beautiful restaurant template with menu, reservations, and online ordering.', 'status' => 'published', 'is_free' => false, 'price' => 34.00, 'framework' => 'livewire', 'industry' => 'ecommerce', 'version' => '1.0.0', 'downloads_count' => 2100, 'rating' => 4.3, 'rating_count' => 34, 'tags' => ['restaurant', 'food', 'menu']],
            ['name' => 'Learning Platform', 'slug' => 'learning-platform', 'description' => 'An online learning platform with courses, quizzes, progress tracking, and certificates.', 'status' => 'published', 'is_free' => false, 'price' => 79.00, 'framework' => 'laravel', 'industry' => 'saas', 'version' => '1.3.0', 'downloads_count' => 3200, 'rating' => 4.7, 'rating_count' => 45, 'tags' => ['education', 'courses', 'lms']],
            ['name' => 'Real Estate', 'slug' => 'real-estate', 'description' => 'A real estate listing template with property search, filters, and agent profiles.', 'status' => 'published', 'is_free' => false, 'price' => 44.00, 'framework' => 'laravel', 'industry' => 'ecommerce', 'version' => '1.0.0', 'downloads_count' => 1800, 'rating' => 4.2, 'rating_count' => 23, 'tags' => ['real-estate', 'property', 'listings']],
            ['name' => 'Invoicing App', 'slug' => 'invoicing-app', 'description' => 'A complete invoicing application with client management, estimates, and payment tracking.', 'status' => 'published', 'is_free' => true, 'framework' => 'livewire', 'industry' => 'saas', 'version' => '1.0.0', 'downloads_count' => 4200, 'rating' => 4.5, 'rating_count' => 67, 'tags' => ['invoicing', 'billing', 'accounting']],
            ['name' => 'Event Platform', 'slug' => 'event-platform', 'description' => 'An event management platform with ticketing, schedules, and attendee networking.', 'status' => 'published', 'is_free' => false, 'price' => 59.00, 'framework' => 'laravel', 'industry' => 'saas', 'version' => '1.0.0', 'downloads_count' => 1500, 'rating' => 4.4, 'rating_count' => 28, 'tags' => ['events', 'tickets', 'conference']],
        ];

        foreach ($templates as $templateData) {
            Template::create([...$templateData, 'author_id' => $authorId]);
        }
    }
}
