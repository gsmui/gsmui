<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MarketplaceProduct;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = User::first()->id;

        $products = [
            ['name' => 'GsmUi Pro Components', 'slug' => 'gsmui-pro-components', 'description' => 'Full access to all 100+ GsmUi Pro components with priority support.', 'price' => 99.00, 'compare_price' => 149.00, 'type' => 'subscription', 'status' => 'published', 'downloads_count' => 4567, 'reviews_count' => 342, 'rating_avg' => 4.9, 'featured' => true],
            ['name' => 'Dashboard Pro Template', 'slug' => 'dashboard-pro-template', 'description' => 'A complete admin dashboard template with 50+ pre-built pages.', 'price' => 49.00, 'compare_price' => 79.00, 'type' => 'digital', 'status' => 'published', 'downloads_count' => 2345, 'reviews_count' => 189, 'rating_avg' => 4.8, 'featured' => true],
            ['name' => 'E-commerce Starter Kit', 'slug' => 'ecommerce-starter-kit', 'description' => 'Full-featured e-commerce solution with product catalog, cart, and checkout.', 'price' => 79.00, 'type' => 'digital', 'status' => 'published', 'downloads_count' => 1876, 'reviews_count' => 156, 'rating_avg' => 4.7],
            ['name' => 'Dark Theme Bundle', 'slug' => 'dark-theme-bundle', 'description' => 'Collection of 5 premium dark themes for GsmUi.', 'price' => 29.00, 'compare_price' => 45.00, 'type' => 'bundle', 'status' => 'published', 'downloads_count' => 3456, 'reviews_count' => 234, 'rating_avg' => 4.8, 'featured' => true],
            ['name' => 'SaaS Boilerplate', 'slug' => 'saas-boilerplate', 'description' => 'Complete SaaS boilerplate with billing, auth, and team management.', 'price' => 149.00, 'type' => 'digital', 'status' => 'published', 'downloads_count' => 987, 'reviews_count' => 89, 'rating_avg' => 4.9],
            ['name' => 'Component Icons Pack', 'slug' => 'component-icons-pack', 'description' => '200+ hand-crafted SVG icons optimized for GsmUi components.', 'price' => 19.00, 'type' => 'digital', 'status' => 'published', 'downloads_count' => 5678, 'reviews_count' => 345, 'rating_avg' => 4.6],
            ['name' => 'Livewire Forms Course', 'slug' => 'livewire-forms-course', 'description' => 'Video course on building advanced forms with Livewire and GsmUi.', 'price' => 59.00, 'type' => 'digital', 'status' => 'published', 'downloads_count' => 1234, 'reviews_count' => 98, 'rating_avg' => 4.7],
            ['name' => 'Portfolio Templates Pack', 'slug' => 'portfolio-templates-pack', 'description' => '3 stunning portfolio templates for developers and designers.', 'price' => 34.00, 'compare_price' => 49.00, 'type' => 'bundle', 'status' => 'published', 'downloads_count' => 2100, 'reviews_count' => 167, 'rating_avg' => 4.5],
            ['name' => 'Tailwind GsmUi Preset', 'slug' => 'tailwind-gsmui-preset', 'description' => 'Custom Tailwind CSS preset optimized for GsmUi components.', 'price' => 0, 'type' => 'digital', 'status' => 'published', 'downloads_count' => 8765, 'reviews_count' => 456, 'rating_avg' => 4.4],
            ['name' => 'Enterprise Support Plan', 'slug' => 'enterprise-support-plan', 'description' => '12 months of priority support, custom development, and consulting.', 'price' => 499.00, 'type' => 'subscription', 'status' => 'published', 'downloads_count' => 56, 'reviews_count' => 23, 'rating_avg' => 4.9],
            ['name' => 'Chart Components Pro', 'slug' => 'chart-components-pro', 'description' => 'Advanced charting components with 15 chart types and real-time updates.', 'price' => 39.00, 'type' => 'digital', 'status' => 'published', 'downloads_count' => 1567, 'reviews_count' => 112, 'rating_avg' => 4.6],
            ['name' => 'Authentication Kit', 'slug' => 'authentication-kit', 'description' => 'Complete authentication system with 2FA, social login, and magic links.', 'price' => 44.00, 'type' => 'digital', 'status' => 'published', 'downloads_count' => 2345, 'reviews_count' => 178, 'rating_avg' => 4.7],
            ['name' => 'Blog Template Pro', 'slug' => 'blog-template-pro', 'description' => 'Professional blog template with MDX support and newsletter integration.', 'price' => 24.00, 'compare_price' => 39.00, 'type' => 'digital', 'status' => 'published', 'downloads_count' => 3210, 'reviews_count' => 234, 'rating_avg' => 4.5],
            ['name' => 'Notification System', 'slug' => 'notification-system', 'description' => 'Multi-channel notification system with email, SMS, and push support.', 'price' => 34.00, 'type' => 'digital', 'status' => 'draft', 'downloads_count' => 0, 'reviews_count' => 0, 'rating_avg' => 0],
            ['name' => 'Figma to GsmUi Kit', 'slug' => 'figma-to-gsmui-kit', 'description' => 'Figma component library matching all GsmUi components for designers.', 'price' => 29.00, 'type' => 'digital', 'status' => 'published', 'downloads_count' => 4567, 'reviews_count' => 312, 'rating_avg' => 4.8],
        ];

        foreach ($products as $productData) {
            MarketplaceProduct::create([...$productData, 'user_id' => $authorId]);
        }
    }
}
