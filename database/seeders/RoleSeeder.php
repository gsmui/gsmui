<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['super_admin', 'admin', 'creator', 'user', 'viewer'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        $permissions = [
            // User management
            'view-users', 'create-users', 'edit-users', 'delete-users',

            // Role & permission management
            'manage-roles', 'manage-permissions',

            // Component management
            'create-components', 'edit-components', 'delete-components', 'publish-components',

            // Theme management
            'create-themes', 'edit-themes', 'delete-themes', 'publish-themes',

            // Template management
            'create-templates', 'edit-templates', 'delete-templates', 'publish-templates',

            // Blog management
            'create-posts', 'edit-posts', 'delete-posts', 'publish-posts',

            // Documentation
            'create-documents', 'edit-documents', 'delete-documents', 'publish-documents',

            // Marketplace
            'create-products', 'edit-products', 'delete-products', 'manage-orders', 'manage-payouts',

            // System
            'manage-settings', 'view-metrics', 'manage-coupons', 'manage-newsletters',

            // Showcase
            'create-showcase', 'edit-showcase', 'delete-showcase',

            // Playground
            'create-projects', 'edit-projects', 'delete-projects',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // super_admin gets everything
        Role::where('name', 'super_admin')->first()->givePermissionTo($permissions);

        // admin gets most permissions
        Role::where('name', 'admin')->first()->givePermissionTo([
            'view-users', 'edit-users',
            'create-components', 'edit-components', 'delete-components', 'publish-components',
            'create-themes', 'edit-themes', 'delete-themes', 'publish-themes',
            'create-templates', 'edit-templates', 'delete-templates', 'publish-templates',
            'create-posts', 'edit-posts', 'delete-posts', 'publish-posts',
            'create-documents', 'edit-documents', 'delete-documents', 'publish-documents',
            'create-products', 'edit-products', 'delete-products', 'manage-orders', 'manage-payouts',
            'manage-settings', 'view-metrics', 'manage-coupons', 'manage-newsletters',
            'create-showcase', 'edit-showcase', 'delete-showcase',
            'create-projects', 'edit-projects', 'delete-projects',
        ]);

        // creator can create and manage their own content
        Role::where('name', 'creator')->first()->givePermissionTo([
            'create-components', 'edit-components',
            'create-themes', 'edit-themes',
            'create-templates', 'edit-templates',
            'create-posts', 'edit-posts',
            'create-products', 'edit-products',
            'create-showcase', 'edit-showcase',
            'create-projects', 'edit-projects', 'delete-projects',
        ]);

        // regular user
        Role::where('name', 'user')->first()->givePermissionTo([
            'create-projects', 'edit-projects', 'delete-projects',
            'create-showcase',
        ]);

        // viewer can only read
        Role::where('name', 'viewer')->first()->givePermissionTo([
            'view-users',
        ]);
    }
}
