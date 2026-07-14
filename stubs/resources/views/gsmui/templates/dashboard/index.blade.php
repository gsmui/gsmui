@php
/**
 * Dashboard Templates Index
 * 
 * A collection of 100 unique dashboard UI templates built with Tailwind CSS.
 * Use individual templates via: @include('gsmui::templates.dashboard.template-name')
 */

$categories = [
    'Business & Enterprise' => [
        ['file' => '01-admin', 'name' => 'Admin Panel', 'description' => 'General admin dashboard with stats, charts, and user management', 'icon' => 'shield-check', 'color' => 'blue'],
        ['file' => '04-crm', 'name' => 'CRM Dashboard', 'description' => 'Customer relationship management with pipeline and deals', 'icon' => 'users', 'color' => 'purple'],
        ['file' => '05-saas', 'name' => 'SaaS Dashboard', 'description' => 'SaaS metrics with MRR, churn, and customer analytics', 'icon' => 'chart-bar', 'color' => 'indigo'],
        ['file' => '07-finance', 'name' => 'Finance Dashboard', 'description' => 'Financial tracking with revenue, expenses, and profit charts', 'icon' => 'currency-dollar', 'color' => 'green'],
        ['file' => '10-hr', 'name' => 'HR Dashboard', 'description' => 'Human resources with employee stats and hiring pipeline', 'icon' => 'user-group', 'color' => 'pink'],
        ['file' => '20-recruitment', 'name' => 'Recruitment Dashboard', 'description' => 'Job posting and candidate tracking system', 'icon' => 'briefcase', 'color' => 'cyan'],
        ['file' => '34-saas-metrics', 'name' => 'SaaS Metrics', 'description' => 'Detailed SaaS analytics with cohort retention', 'icon' => 'chart-line', 'color' => 'violet'],
        ['file' => '40-recruiting', 'name' => 'Recruiting ATS', 'description' => 'Applicant tracking system with hiring pipeline', 'icon' => 'clipboard-list', 'color' => 'teal'],
        ['file' => '66-customer-success', 'name' => 'Customer Success', 'description' => 'Customer health scores and renewal tracking', 'icon' => 'heart', 'color' => 'rose'],
        ['file' => '96-admin-panel', 'name' => 'Admin System', 'description' => 'Admin dashboard with system health monitoring', 'icon' => 'cog', 'color' => 'slate'],
        ['file' => '97-crm-system', 'name' => 'CRM System', 'description' => 'CRM with pipeline stages and deal management', 'icon' => 'funnel', 'color' => 'amber'],
        ['file' => '98-finance-system', 'name' => 'Finance System', 'description' => 'Revenue vs expenses with transaction history', 'icon' => 'banknotes', 'color' => 'emerald'],
    ],
    'E-commerce & Sales' => [
        ['file' => '03-ecommerce', 'name' => 'E-commerce Dashboard', 'description' => 'Online store with sales, orders, and product stats', 'icon' => 'shopping-cart', 'color' => 'orange'],
        ['file' => '16-inventory', 'name' => 'Inventory Dashboard', 'description' => 'Stock management with low stock alerts', 'icon' => 'archive', 'color' => 'yellow'],
        ['file' => '39-property-management', 'name' => 'Property Management', 'description' => 'Real estate portfolio with occupancy tracking', 'icon' => 'building-office', 'color' => 'brown'],
        ['file' => '54-payment-processing', 'name' => 'Payment Processing', 'description' => 'Payment gateway with transaction history', 'icon' => 'credit-card', 'color' => 'indigo'],
        ['file' => '62-lead-scoring', 'name' => 'Lead Scoring', 'description' => 'Lead qualification and scoring system', 'icon' => 'target', 'color' => 'red'],
        ['file' => '84-real-estate', 'name' => 'Real Estate Dashboard', 'description' => 'Property listings and inquiry management', 'icon' => 'home', 'color' => 'blue'],
        ['file' => '85-inventory-management', 'name' => 'Inventory Management', 'description' => 'Stock tracking with alerts and analytics', 'icon' => 'cube', 'color' => 'purple'],
        ['file' => '91-payment-gateway', 'name' => 'Payment Gateway', 'description' => 'Transaction monitoring and payment methods', 'icon' => 'banknotes', 'color' => 'green'],
    ],
    'Analytics & Data' => [
        ['file' => '02-analytics', 'name' => 'Analytics Dashboard', 'description' => 'Web analytics with traffic sources and user behavior', 'icon' => 'chart-pie', 'color' => 'cyan'],
        ['file' => '30-video-analytics', 'name' => 'Video Analytics', 'description' => 'Video platform metrics with audience demographics', 'icon' => 'play-circle', 'color' => 'red'],
        ['file' => '47-user-analytics', 'name' => 'User Analytics', 'description' => 'User engagement and session tracking', 'icon' => 'user', 'color' => 'blue'],
        ['file' => '72-seo-analytics', 'name' => 'SEO Dashboard', 'description' => 'Search engine optimization with keyword rankings', 'icon' => 'magnifying-glass', 'color' => 'green'],
        ['file' => '74-predictive-analytics', 'name' => 'Predictive Analytics', 'description' => 'ML-powered forecasting with confidence scores', 'icon' => 'cpu', 'color' => 'violet'],
        ['file' => '94-analytics-system', 'name' => 'Analytics System', 'description' => 'General analytics with traffic sources and top pages', 'icon' => 'chart-bar', 'color' => 'indigo'],
    ],
    'Marketing & Content' => [
        ['file' => '08-social-media', 'name' => 'Social Media Dashboard', 'description' => 'Social media metrics across platforms', 'icon' => 'globe-alt', 'color' => 'pink'],
        ['file' => '24-email-marketing', 'name' => 'Email Marketing', 'description' => 'Email campaigns with open and click rates', 'icon' => 'envelope', 'color' => 'blue'],
        ['file' => '32-influencer', 'name' => 'Influencer Hub', 'description' => 'Influencer marketing with engagement metrics', 'icon' => 'star', 'color' => 'yellow'],
        ['file' => '38-podcast', 'name' => 'Podcast Dashboard', 'description' => 'Podcast analytics with download stats', 'icon' => 'musical-note', 'color' => 'purple'],
        ['file' => '45-social-scheduler', 'name' => 'Social Scheduler', 'description' => 'Content scheduling across social platforms', 'icon' => 'calendar', 'color' => 'teal'],
        ['file' => '49-affiliate', 'name' => 'Affiliate Program', 'description' => 'Affiliate tracking with referral stats', 'icon' => 'link', 'color' => 'orange'],
        ['file' => '69-community', 'name' => 'Community Forum', 'description' => 'Community engagement with trending topics', 'icon' => 'chat-bubble-left-right', 'color' => 'green'],
        ['file' => '81-content-calendar', 'name' => 'Content Calendar', 'description' => 'Editorial calendar with content planning', 'icon' => 'calendar-days', 'color' => 'indigo'],
        ['file' => '87-campaign-monitor', 'name' => 'Campaign Monitor', 'description' => 'Marketing campaign performance tracking', 'icon' => 'megaphone', 'color' => 'red'],
    ],
    'Project Management' => [
        ['file' => '06-project-management', 'name' => 'Project Management', 'description' => 'Project tracking with milestones and deadlines', 'icon' => 'clipboard-document-check', 'color' => 'blue'],
        ['file' => '42-real-time-collab', 'name' => 'Real-time Collaboration', 'description' => 'Team workspace with live editing', 'icon' => 'users', 'color' => 'green'],
        ['file' => '58-project-tracker', 'name' => 'Project Tracker', 'description' => 'Project progress with timeline tracking', 'icon' => 'flag', 'color' => 'orange'],
        ['file' => '65-task-management', 'name' => 'Task Manager', 'description' => 'Kanban-style task management board', 'icon' => 'view-columns', 'color' => 'purple'],
        ['file' => '92-time-tracker', 'name' => 'Time Tracker', 'description' => 'Time logging with billable hours tracking', 'icon' => 'clock', 'color' => 'cyan'],
        ['file' => '99-project-kanban', 'name' => 'Project Kanban', 'description' => 'Kanban board for task visualization', 'icon' => 'bars-3', 'color' => 'indigo'],
    ],
    'Development & DevOps' => [
        ['file' => '26-bug-tracker', 'name' => 'Bug Tracker', 'description' => 'Bug reporting and tracking system', 'icon' => 'bug-ant', 'color' => 'red'],
        ['file' => '28-cicd', 'name' => 'CI/CD Pipeline', 'description' => 'Continuous integration and deployment monitoring', 'icon' => 'arrow-path', 'color' => 'green'],
        ['file' => '48-server-monitoring', 'name' => 'Server Monitoring', 'description' => 'Server health and performance metrics', 'icon' => 'server', 'color' => 'slate'],
        ['file' => '50-devops', 'name' => 'DevOps Dashboard', 'description' => 'Infrastructure and deployment tracking', 'icon' => 'wrench-screwdriver', 'color' => 'blue'],
        ['file' => '51-webhook', 'name' => 'Webhook Manager', 'description' => 'Webhook delivery monitoring and debugging', 'icon' => 'signal', 'color' => 'purple'],
        ['file' => '53-kubernetes', 'name' => 'Kubernetes Cluster', 'description' => 'Container orchestration monitoring', 'icon' => 'square-3-stack-3d', 'color' => 'cyan'],
        ['file' => '56-api-management', 'name' => 'API Management', 'description' => 'API endpoint monitoring and analytics', 'icon' => 'code-bracket', 'color' => 'indigo'],
        ['file' => '67-data-pipeline', 'name' => 'Data Pipeline', 'description' => 'Data flow monitoring and job tracking', 'icon' => 'arrows-right-left', 'color' => 'teal'],
        ['file' => '73-github-stats', 'name' => 'GitHub Dashboard', 'description' => 'Repository stats with commits and PRs', 'icon' => 'folder', 'color' => 'gray'],
        ['file' => '76-graphql-explorer', 'name' => 'GraphQL Explorer', 'description' => 'API query builder with response viewer', 'icon' => 'command-line', 'color' => 'pink'],
        ['file' => '77-error-monitoring', 'name' => 'Error Monitoring', 'description' => 'Error tracking with occurrence counts', 'icon' => 'exclamation-triangle', 'color' => 'amber'],
        ['file' => '83-log-viewer', 'name' => 'Log Viewer', 'description' => 'Real-time log streaming and filtering', 'icon' => 'document-text', 'color' => 'zinc'],
    ],
    'Customer Support' => [
        ['file' => '14-support', 'name' => 'Support Dashboard', 'description' => 'Customer support metrics and ticket tracking', 'icon' => 'question-mark-circle', 'color' => 'blue'],
        ['file' => '27-support-ticket', 'name' => 'Support Tickets', 'description' => 'Ticket management with priority tracking', 'icon' => 'ticket', 'color' => 'green'],
        ['file' => '52-helpdesk', 'name' => 'Helpdesk', 'description' => 'Helpdesk system with agent performance', 'icon' => 'lifebuoy', 'color' => 'red'],
        ['file' => '57-email-inbox', 'name' => 'Email Inbox', 'description' => 'Unified inbox with message management', 'icon' => 'inbox', 'color' => 'purple'],
        ['file' => '82-feedback-portal', 'name' => 'Feedback Portal', 'description' => 'User feedback collection and voting', 'icon' => 'chat-bubble-bottom-center-text', 'color' => 'teal'],
        ['file' => '89-audit-log', 'name' => 'Audit Log', 'description' => 'System audit trail with activity tracking', 'icon' => 'document-magnifying-glass', 'color' => 'slate'],
    ],
    'Education & Learning' => [
        ['file' => '12-lms', 'name' => 'Learning Management', 'description' => 'Course management with student progress', 'icon' => 'academic-cap', 'color' => 'blue'],
        ['file' => '18-fitness', 'name' => 'Fitness Tracker', 'description' => 'Workout and health metrics tracking', 'icon' => 'heart', 'color' => 'red'],
        ['file' => '31-lms', 'name' => 'Learning Dashboard', 'description' => 'Learning progress with assignment tracking', 'icon' => 'book-open', 'color' => 'green'],
        ['file' => '78-student-portal', 'name' => 'Student Portal', 'description' => 'Student dashboard with grades and courses', 'icon' => 'user', 'color' => 'purple'],
    ],
    'Industry Specific' => [
        ['file' => '11-health', 'name' => 'Healthcare Dashboard', 'description' => 'Medical practice management', 'icon' => 'heart', 'color' => 'red'],
        ['file' => '13-realestate', 'name' => 'Real Estate', 'description' => 'Property listings and agent dashboard', 'icon' => 'home', 'color' => 'blue'],
        ['file' => '15-restaurant', 'name' => 'Restaurant Dashboard', 'description' => 'Restaurant operations and orders', 'icon' => 'building-storefront', 'color' => 'orange'],
        ['file' => '19-iot', 'name' => 'IoT Smart Home', 'description' => 'Smart home device control panel', 'icon' => 'signal', 'color' => 'cyan'],
        ['file' => '21-shipping', 'name' => 'Shipping Dashboard', 'description' => 'Logistics and shipment tracking', 'icon' => 'truck', 'color' => 'green'],
        ['file' => '23-fleet', 'name' => 'Fleet Management', 'description' => 'Vehicle fleet tracking and maintenance', 'icon' => 'map', 'color' => 'purple'],
        ['file' => '33-sports', 'name' => 'Sports Analytics', 'description' => 'Game stats and player performance', 'icon' => 'trophy', 'color' => 'yellow'],
        ['file' => '36-nft-marketplace', 'name' => 'NFT Marketplace', 'description' => 'Digital asset trading platform', 'icon' => 'cube', 'color' => 'pink'],
        ['file' => '37-crypto-trading', 'name' => 'Crypto Trading', 'description' => 'Cryptocurrency exchange dashboard', 'icon' => 'chart-line', 'color' => 'amber'],
        ['file' => '41-gamification', 'name' => 'Gamification Hub', 'description' => 'Points, badges, and leaderboards', 'icon' => 'gift', 'color' => 'indigo'],
        ['file' => '44-weather', 'name' => 'Weather Dashboard', 'description' => 'Weather monitoring with forecasts', 'icon' => 'cloud', 'color' => 'blue'],
        ['file' => '60-booking', 'name' => 'Booking System', 'description' => 'Reservation management with room availability', 'icon' => 'calendar-days', 'color' => 'teal'],
        ['file' => '61-video-conferencing', 'name' => 'Video Conferencing', 'description' => 'Video meeting management', 'icon' => 'video-camera', 'color' => 'green'],
        ['file' => '79-donation-tracker', 'name' => 'Donation Tracker', 'description' => 'Charity campaign and donation tracking', 'icon' => 'heart-handshake', 'color' => 'rose'],
    ],
    'Content & Documentation' => [
        ['file' => '09-portfolio', 'name' => 'Portfolio Dashboard', 'description' => 'Personal portfolio with project showcase', 'icon' => 'briefcase', 'color' => 'purple'],
        ['file' => '29-cms', 'name' => 'Content Management', 'description' => 'CMS with post management and analytics', 'icon' => 'document', 'color' => 'blue'],
        ['file' => '35-design-system', 'name' => 'Design System', 'description' => 'Design tokens and component library', 'icon' => 'swatch', 'color' => 'pink'],
        ['file' => '63-design-collab', 'name' => 'Design Hub', 'description' => 'Design collaboration and asset management', 'icon' => 'paint-brush', 'color' => 'indigo'],
        ['file' => '70-documentation', 'name' => 'Documentation', 'description' => 'Knowledge base with article management', 'icon' => 'book-open', 'color' => 'green'],
        ['file' => '90-knowledge-base', 'name' => 'Knowledge Base', 'description' => 'FAQ and documentation management', 'icon' => 'academic-cap', 'color' => 'teal'],
        ['file' => '93-document-manager', 'name' => 'Document Manager', 'description' => 'File storage and document management', 'icon' => 'folder-open', 'color' => 'orange'],
    ],
    'Operations & Logistics' => [
        ['file' => '22-events', 'name' => 'Event Management', 'description' => 'Event planning and tracking', 'icon' => 'calendar', 'color' => 'blue'],
        ['file' => '43-supply-chain', 'name' => 'Supply Chain', 'description' => 'Supply chain monitoring and tracking', 'icon' => 'arrow-right', 'color' => 'green'],
        ['file' => '64-inventory-analytics', 'name' => 'Inventory Analytics', 'description' => 'Stock analytics with category breakdown', 'icon' => 'chart-bar', 'color' => 'purple'],
        ['file' => '68-compliance', 'name' => 'Compliance Dashboard', 'description' => 'Regulatory compliance tracking', 'icon' => 'check-badge', 'color' => 'emerald'],
        ['file' => '88-warehouse', 'name' => 'Warehouse Management', 'description' => 'Warehouse operations and zone management', 'icon' => 'building-office-2', 'color' => 'slate'],
    ],
    'Human Resources' => [
        ['file' => '86-employee-directory', 'name' => 'Employee Directory', 'description' => 'Team member profiles and directory', 'icon' => 'user-group', 'color' => 'blue'],
    ],
    'Miscellaneous' => [
        ['file' => '55-notification-center', 'name' => 'Notification Center', 'description' => 'Unified notification management', 'icon' => 'bell', 'color' => 'yellow'],
        ['file' => '59-file-manager', 'name' => 'File Manager', 'description' => 'File system browser with folders', 'icon' => 'folder', 'color' => 'blue'],
        ['file' => '75-dark-mode-showcase', 'name' => 'Dark Mode Showcase', 'description' => 'Dark theme with gradient effects', 'icon' => 'moon', 'color' => 'purple'],
        ['file' => '80-ab-test-dashboard', 'name' => 'A/B Test Dashboard', 'description' => 'A/B testing with variant comparison', 'icon' => 'arrow-path', 'color' => 'green'],
        ['file' => '95-saas-dashboard', 'name' => 'SaaS Dashboard', 'description' => 'SaaS metrics with plan distribution', 'icon' => 'chart-pie', 'color' => 'indigo'],
        ['file' => '100-metrics-hub', 'name' => 'Metrics Hub', 'description' => 'General metrics with performance overview', 'icon' => 'chart-bar', 'color' => 'cyan'],
    ],
];

// Color map for icon backgrounds
$iconColors = [
    'blue' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400',
    'green' => 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400',
    'purple' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400',
    'pink' => 'bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400',
    'red' => 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400',
    'orange' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400',
    'yellow' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400',
    'indigo' => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400',
    'violet' => 'bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400',
    'cyan' => 'bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400',
    'teal' => 'bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400',
    'emerald' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400',
    'slate' => 'bg-slate-100 dark:bg-slate-900/30 text-slate-600 dark:text-slate-400',
    'gray' => 'bg-gray-100 dark:bg-gray-900/30 text-gray-600 dark:text-gray-400',
    'zinc' => 'bg-zinc-100 dark:bg-zinc-900/30 text-zinc-600 dark:text-zinc-400',
    'brown' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400',
    'rose' => 'bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400',
];

$totalTemplates = 0;
foreach ($categories as $templates) {
    $totalTemplates += count($templates);
}
@endphp

<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900" x-data="dashboardSearch()">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Dashboard Templates</h1>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 text-sm font-medium rounded-full">
                <span x-text="filteredCount">0</span> / {{ $totalTemplates }} Templates
            </span>
        </div>
    </header>

    <main class="p-6 max-w-7xl mx-auto">
        <!-- Search and Filter Section -->
        <div class="mb-8 space-y-4">
            <!-- Search Input -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    x-ref="searchInput"
                    x-model="searchQuery" 
                    @input="filterTemplates()"
                    placeholder="Search templates by name, description, or category... (Ctrl+K)" 
                    class="block w-full pl-10 pr-10 py-3 text-base border border-zinc-200 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                >
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button 
                        x-show="searchQuery.length > 0" 
                        @click="clearSearch()" 
                        class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Category Filters -->
            <div class="flex flex-wrap gap-2">
                <button 
                    @click="setCategory('all')" 
                    :class="selectedCategory === 'all' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 hover:border-blue-300 dark:hover:border-blue-700'"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                >
                    All Templates
                </button>
                @foreach($categories as $category => $templates)
                <button 
                    @click="setCategory('{{ $category }}')" 
                    :class="selectedCategory === '{{ $category }}' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 hover:border-blue-300 dark:hover:border-blue-700'"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                >
                    {{ $category }} <span class="ml-1 text-xs opacity-70">({{ count($templates) }})</span>
                </button>
                @endforeach
            </div>

            <!-- Active Filters & Clear -->
            <div x-show="searchQuery.length > 0 || selectedCategory !== 'all'" class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
                <span>Active filters:</span>
                <span x-show="searchQuery.length > 0" class="px-2 py-1 bg-zinc-100 dark:bg-zinc-700 rounded">
                    Search: "<span x-text="searchQuery"></span>"
                </span>
                <span x-show="selectedCategory !== 'all'" class="px-2 py-1 bg-zinc-100 dark:bg-zinc-700 rounded">
                    Category: <span x-text="selectedCategory"></span>
                </span>
                <button @click="clearAllFilters()" class="text-blue-600 dark:text-blue-400 hover:underline ml-2">Clear all</button>
            </div>
        </div>

        <!-- No Results Message -->
        <div x-show="filteredCount === 0" class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No templates found</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                Try adjusting your search or filter criteria.
            </p>
            <button @click="clearAllFilters()" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                Clear all filters
            </button>
        </div>

        <!-- Templates Grid -->
        <div class="space-y-8" x-show="filteredCount > 0">
            @foreach($categories as $category => $templates)
            <div x-show="selectedCategory === 'all' || selectedCategory === '{{ $category }}'">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-sm font-bold">
                        {{ count($templates) }}
                    </span>
                    {{ $category }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($templates as $template)
                    <a 
                        href="/dashboard/{{ $template['file'] }}" 
                        x-show="matchesFilter('{{ $template['name'] }}', '{{ $template['description'] }}', '{{ $category }}', '{{ $template['file'] }}')"
                        class="block bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 hover:border-blue-300 dark:hover:border-blue-700 hover:shadow-lg transition-all duration-200 group overflow-hidden"
                    >
                        <!-- Preview Thumbnail -->
                        <div class="relative h-32 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-700 dark:to-zinc-800 flex items-center justify-center overflow-hidden">
                            <!-- Mini Dashboard Preview -->
                            <div class="absolute inset-2 bg-white dark:bg-zinc-900 rounded-lg shadow-sm p-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                <div class="flex gap-1 mb-1">
                                    <div class="w-2 h-2 rounded-full bg-red-400"></div>
                                    <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                                    <div class="w-2 h-2 rounded-full bg-green-400"></div>
                                </div>
                                <div class="flex gap-1 h-full">
                                    <div class="w-1/4 bg-zinc-100 dark:bg-zinc-800 rounded"></div>
                                    <div class="flex-1 space-y-1">
                                        <div class="h-2 bg-zinc-100 dark:bg-zinc-800 rounded w-3/4"></div>
                                        <div class="h-2 bg-zinc-100 dark:bg-zinc-800 rounded w-1/2"></div>
                                        <div class="flex gap-1 mt-1">
                                            <div class="flex-1 h-8 bg-zinc-100 dark:bg-zinc-800 rounded"></div>
                                            <div class="flex-1 h-8 bg-zinc-100 dark:bg-zinc-800 rounded"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Category Icon Overlay -->
                            <div class="absolute top-3 right-3 {{ $iconColors[$template['color']] ?? $iconColors['blue'] }} w-10 h-10 rounded-lg flex items-center justify-center shadow-sm">
                                @if($template['icon'] === 'chart-bar')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                @elseif($template['icon'] === 'users')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                @elseif($template['icon'] === 'shopping-cart')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                @elseif($template['icon'] === 'chart-pie')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                                @elseif($template['icon'] === 'currency-dollar')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @elseif($template['icon'] === 'clipboard-list')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                @elseif($template['icon'] === 'bug-ant')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                @elseif($template['icon'] === 'arrow-path')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                @elseif($template['icon'] === 'server')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" /></svg>
                                @elseif($template['icon'] === 'globe-alt')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                @elseif($template['icon'] === 'envelope')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                @elseif($template['icon'] === 'heart')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                @elseif($template['icon'] === 'home')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                @elseif($template['icon'] === 'truck')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" /></svg>
                                @elseif($template['icon'] === 'calendar')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                @elseif($template['icon'] === 'bell')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                @elseif($template['icon'] === 'moon')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                                @else
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" /></svg>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-4">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-medium text-zinc-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                    {{ $template['name'] }}
                                </h3>
                                <span class="text-zinc-400 group-hover:text-blue-500 transition-colors">→</span>
                            </div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $template['description'] }}
                            </p>
                            <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-2 font-mono">
                                {{ $template['file'] }}.blade.php
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Usage Section -->
        <div class="mt-12 p-6 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Usage</h2>
            <div class="bg-zinc-100 dark:bg-zinc-900 rounded-lg p-4 font-mono text-sm">
                <p class="text-zinc-600 dark:text-zinc-400"># Include a specific template</p>
                <p class="text-zinc-900 dark:text-white">@include('gsmui::templates.dashboard.01-admin')</p>
                <br>
                <p class="text-zinc-600 dark:text-zinc-400"># Or use the index to browse all templates</p>
                <p class="text-zinc-900 dark:text-white">@include('gsmui::templates.dashboard.index')</p>
            </div>
        </div>
    </main>
</div>

<script>
function dashboardSearch() {
    return {
        searchQuery: '',
        selectedCategory: 'all',
        filteredCount: {{ $totalTemplates }},
        
        init() {
            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                // Ctrl+K or Cmd+K to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    this.$refs.searchInput.focus();
                }
                // Escape to clear search and blur input
                if (e.key === 'Escape') {
                    this.searchQuery = '';
                    this.filterTemplates();
                    this.$refs.searchInput.blur();
                }
            });
        },
        
        filterTemplates() {
            this.$nextTick(() => {
                let count = 0;
                document.querySelectorAll('[x-show^="matchesFilter"]').forEach(el => {
                    const style = window.getComputedStyle(el);
                    if (style.display !== 'none') {
                        count++;
                    }
                });
                this.filteredCount = count;
            });
        },
        
        matchesFilter(name, description, category, file) {
            const query = this.searchQuery.toLowerCase();
            
            if (this.selectedCategory !== 'all' && this.selectedCategory !== category) {
                return false;
            }
            
            if (query.length > 0) {
                const searchableText = `${name} ${description} ${category} ${file}`.toLowerCase();
                return searchableText.includes(query);
            }
            
            return true;
        },
        
        setCategory(category) {
            this.selectedCategory = category;
            this.$nextTick(() => {
                let count = 0;
                document.querySelectorAll('[x-show^="matchesFilter"]').forEach(el => {
                    const style = window.getComputedStyle(el);
                    if (style.display !== 'none') {
                        count++;
                    }
                });
                this.filteredCount = count;
            });
        },
        
        clearSearch() {
            this.searchQuery = '';
            this.filterTemplates();
        },
        
        clearAllFilters() {
            this.searchQuery = '';
            this.selectedCategory = 'all';
            this.$nextTick(() => {
                let count = 0;
                document.querySelectorAll('[x-show^="matchesFilter"]').forEach(el => {
                    const style = window.getComputedStyle(el);
                    if (style.display !== 'none') {
                        count++;
                    }
                });
                this.filteredCount = count;
            });
        }
    }
}
</script>
