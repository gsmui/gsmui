<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Phase 1: Roles & permissions
        $this->call([
            RoleSeeder::class,
        ]);

        // Phase 2: Users
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
        ]);

        // Phase 3: Core content
        $this->call([
            ComponentSeeder::class,
            ThemeSeeder::class,
            TemplateSeeder::class,
        ]);

        // Phase 4: Blog & documentation
        $this->call([
            BlogSeeder::class,
            DocumentationSeeder::class,
        ]);

        // Phase 5: Marketplace
        $this->call([
            ProductSeeder::class,
            CouponSeeder::class,
            OrderSeeder::class,
        ]);

        // Phase 6: Community & engagement
        $this->call([
            ShowcaseSeeder::class,
            NewsletterSeeder::class,
        ]);

        // Phase 7: System & analytics
        $this->call([
            SystemSettingSeeder::class,
            MetricSeeder::class,
        ]);
    }
}
