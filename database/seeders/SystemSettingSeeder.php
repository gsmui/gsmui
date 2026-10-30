<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'GsmUi', 'type' => 'string', 'group' => 'general', 'description' => 'The application name displayed in the UI.'],
            ['key' => 'site_description', 'value' => 'A comprehensive Livewire component library for Laravel.', 'type' => 'string', 'group' => 'general', 'description' => 'Meta description for the homepage.'],
            ['key' => 'site_url', 'value' => 'https://gsmui.dev', 'type' => 'string', 'group' => 'general', 'description' => 'Primary application URL.'],
            ['key' => 'support_email', 'value' => 'support@gsmui.dev', 'type' => 'string', 'group' => 'general', 'description' => 'Public support email address.'],
            ['key' => 'maintenance_mode', 'value' => 'false', 'type' => 'boolean', 'group' => 'general', 'description' => 'Enable or disable maintenance mode.'],

            ['key' => 'registration_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'auth', 'description' => 'Allow new user registrations.'],
            ['key' => 'email_verification_required', 'value' => 'true', 'type' => 'boolean', 'group' => 'auth', 'description' => 'Require email verification for new accounts.'],
            ['key' => 'two_factor_enabled', 'value' => 'false', 'type' => 'boolean', 'group' => 'auth', 'description' => 'Enable two-factor authentication globally.'],
            ['key' => 'password_min_length', 'value' => '8', 'type' => 'integer', 'group' => 'auth', 'description' => 'Minimum password length requirement.'],

            ['key' => 'currency', 'value' => 'USD', 'type' => 'string', 'group' => 'marketplace', 'description' => 'Default marketplace currency.'],
            ['key' => 'tax_rate', 'value' => '0.1', 'type' => 'float', 'group' => 'marketplace', 'description' => 'Default tax rate for digital products.'],
            ['key' => 'platform_commission_rate', 'value' => '15', 'type' => 'float', 'group' => 'marketplace', 'description' => 'Platform commission percentage on sales.'],
            ['key' => 'min_payout_amount', 'value' => '50', 'type' => 'float', 'group' => 'marketplace', 'description' => 'Minimum payout amount for creators.'],
            ['key' => 'auto_approve_products', 'value' => 'false', 'type' => 'boolean', 'group' => 'marketplace', 'description' => 'Automatically approve new product submissions.'],

            ['key' => 'newsletter_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'features', 'description' => 'Enable newsletter subscription.'],
            ['key' => 'showcase_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'features', 'description' => 'Enable community showcase.'],
            ['key' => 'playground_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'features', 'description' => 'Enable the interactive playground.'],
            ['key' => 'blog_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'features', 'description' => 'Enable the blog section.'],
            ['key' => 'docs_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'features', 'description' => 'Enable the documentation section.'],

            ['key' => 'smtp_host', 'value' => 'smtp.mailgun.org', 'type' => 'string', 'group' => 'mail', 'description' => 'SMTP server host.'],
            ['key' => 'smtp_port', 'value' => '587', 'type' => 'integer', 'group' => 'mail', 'description' => 'SMTP server port.'],
            ['key' => 'mail_from_address', 'value' => 'noreply@gsmui.dev', 'type' => 'string', 'group' => 'mail', 'description' => 'From address for outgoing emails.'],

            ['key' => 'items_per_page', 'value' => '15', 'type' => 'integer', 'group' => 'pagination', 'description' => 'Default items per page for listings.'],
            ['key' => 'max_upload_size_mb', 'value' => '10', 'type' => 'integer', 'group' => 'uploads', 'description' => 'Maximum file upload size in megabytes.'],
            ['key' => 'allowed_file_types', 'value' => 'jpg,jpeg,png,gif,svg,webp,pdf,zip', 'type' => 'string', 'group' => 'uploads', 'description' => 'Comma-separated list of allowed file extensions.'],
        ];

        foreach ($settings as $setting) {
            DB::table('system_settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
