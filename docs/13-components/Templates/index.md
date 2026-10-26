---
title: Page Templates
description: Pre-built page templates for dashboard, landing, auth, settings, admin, docs, and marketplace layouts.
order: 13.5
group: Templates
---

# Page Templates

GsmUi ships production-ready page templates built on the component library. Each template is a complete, responsive layout that can be copied, extended, or customized.

## Template Catalog

| Template | Path | Components Used | Purpose |
|---|---|---|---|
| Dashboard | `templates/dashboard.blade.php` | Sidebar, Card, Table, Chart | Admin dashboards |
| Landing | `templates/landing.blade.php` | Hero, Grid, CTA, Footer | Marketing pages |
| Auth | `templates/auth.blade.php` | Card, Input, Button | Login/Register |
| Settings | `templates/settings.blade.php` | Sidebar, Tabs, Form | User settings |
| Admin | `templates/admin.blade.php` | Sidebar, Table, Modal | Back-office |
| Docs | `templates/docs.blade.php` | Sidebar, TOC, Code | Documentation |
| Marketplace | `templates/marketplace.blade.php` | Grid, Card, Filter | Product listing |

## Dashboard Template

```blade
<x-gsmui:layout-dashboard title="Dashboard">
    <x-slot:sidebar>
        <x-gsmui:sidebar-nav :items="$navItems" />
    </x-slot:sidebar>

    <x-slot:header>
        <x-gsmui:page-header title="Dashboard" :breadcrumb="$breadcrumb">
            <x-slot:actions>
                <gsmui:button variant="primary">New Report</gsmui:button>
            </x-slot:actions>
        </x-gsmui:page-header>
    </x-slot:header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-gsmui:stat-card label="Revenue" value="$12,345" change="+12%" />
        <x-gsmui:stat-card label="Users" value="1,234" change="+8%" />
        <x-gsmui:stat-card label="Orders" value="567" change="-3%" />
        <x-gsmui:stat-card label="Conversion" value="3.2%" change="+0.5%" />
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <x-gsmui:card class="lg:col-span-2">
            <x-gsmui:chart type="line" :data="$revenueData" />
        </x-gsmui:card>
        <x-gsmui:card>
            <h3 class="text-lg font-semibold mb-4">Recent Orders</h3>
            <x-gsmui:table :columns="$orderColumns" :rows="$recentOrders" compact />
        </x-gsmui:card>
    </div>
</x-gsmui:layout-dashboard>
```

### Dashboard Layout Structure

| Area | Position | Width | Behavior |
|---|---|---|---|
| Sidebar | Left | `w-64` | Collapsible on mobile |
| Header | Top | Full | Sticky |
| Content | Center | Fluid | Scrollable |
| Footer | Bottom | Full | Optional |

## Landing Template

```blade
<x-gsmui:layout-landing title="GsmUi Pro">
    <x-gsmui:navbar :items="$navItems">
        <x-slot:brand>
            <img src="/logo.svg" alt="GsmUi" class="h-8" />
        </x-slot:brand>
        <x-slot:actions>
            <gsmui:button variant="ghost">Sign in</gsmui:button>
            <gsmui:button variant="primary">Get Started</gsmui:button>
        </x-slot:actions>
    </x-gsmui:navbar>

    <x-gsmui:hero
        title="Build Beautiful Interfaces"
        subtitle="A complete Livewire UI component library for Laravel."
        :primary-cta="['label' => 'Get Started', 'href' => '/pricing']"
        :secondary-cta="['label' => 'View Demo', 'href' => '/demo']"
    />

    <x-gsmui:section class="py-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($features as $feature)
                <x-gsmui:feature-card :title="$feature['title']" :description="$feature['description']" />
            @endforeach
        </div>
    </x-gsmui:section>

    <x-gsmui:cta
        title="Ready to get started?"
        description="Join thousands of developers building with GsmUi."
        button-label="Start Free Trial"
    />

    <x-gsmui:footer :links="$footerLinks" />
</x-gsmui:layout-landing>
```

## Auth Template

```blade
<x-gsmui:layout-auth title="Sign In">
    <x-gsmui:card class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="/logo.svg" alt="GsmUi" class="h-10 mx-auto mb-4" />
            <h1 class="text-2xl font-bold">Sign in to your account</h1>
        </div>

        <form wire:submit="login">
            <x-gsmui:input
                wire:model="email"
                type="email"
                label="Email address"
                placeholder="you@example.com"
                required
            />

            <x-gsmui:input
                wire:model="password"
                type="password"
                label="Password"
                placeholder="••••••••"
                required
                class="mt-4"
            />

            <div class="flex items-center justify-between mt-4">
                <x-gsmui:checkbox wire:model="remember" label="Remember me" />
                <a href="/forgot-password" class="text-sm text-blue-600 hover:underline">
                    Forgot password?
                </a>
            </div>

            <gsmui:button type="submit" class="w-full mt-6" :loading="$isLoggingIn">
                Sign in
            </gsmui:button>
        </form>
    </x-gsmui:card>
</x-gsmui:layout-auth>
```

## Settings Template

```blade
<x-gsmui:layout-settings title="Settings">
    <x-gsmui:page-header title="Settings" :breadcrumb="['Settings']" />

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-4 gap-6">
        <x-gsmui:sidebar-nav :items="$settingsNav" variant="pills" />

        <div class="lg:col-span-3">
            <x-gsmui:tabs wire:model="activeTab">
                <x-gsmui:tab name="profile" label="Profile">
                    <x-gsmui:card>
                        <form wire:submit="saveProfile">
                            <x-gsmui:input wire:model="name" label="Name" />
                            <x-gsmui:input wire:model="email" label="Email" type="email" class="mt-4" />
                            <x-gsmui:textarea wire:model="bio" label="Bio" rows="3" class="mt-4" />
                            <gsmui:button type="submit" class="mt-6">Save Changes</gsmui:button>
                        </form>
                    </x-gsmui:card>
                </x-gsmui:tab>

                <x-gsmui:tab name="security" label="Security">
                    <x-gsmui:card>
                        <p>Security settings content</p>
                    </x-gsmui:card>
                </x-gsmui:tab>
            </x-gsmui:tabs>
        </div>
    </div>
</x-gsmui:layout-settings>
```

## Admin Template

```blade
<x-gsmui:layout-admin title="Admin Panel">
    <x-slot:sidebar>
        <x-gsmui:sidebar-nav :items="$adminNav" collapsible />
    </x-slot:sidebar>

    <x-gsmui:page-header title="Users">
        <x-slot:actions>
            <gsmui:button wire:click="exportUsers" variant="ghost">Export</gsmui:button>
            <gsmui:button wire:click="$dispatch('showModal')" variant="primary">Add User</gsmui:button>
        </x-slot:actions>
    </x-gsmui:page-header>

    <x-gsmui:card class="mt-6">
        <x-gsmui:table
            :columns="$columns"
            :rows="$users"
            :sortable="true"
            :selectable="true"
            wire:model="selectedUsers"
        />
    </x-gsmui:card>
</x-gsmui:layout-admin>
```

## Responsive Behavior

| Template | Mobile | Tablet | Desktop |
|---|---|---|---|
| Dashboard | Sidebar → drawer | Sidebar fixed | Sidebar fixed |
| Landing | Stacked sections | 2-col grid | 3-col grid |
| Auth | Full-width card | Centered card | Centered card |
| Settings | Tabs → dropdown | 2-col sidebar | 3-col sidebar |
| Admin | Sidebar → drawer | Collapsible sidebar | Fixed sidebar |
| Docs | Hamburger menu | Sidebar + content | Sidebar + TOC + content |
