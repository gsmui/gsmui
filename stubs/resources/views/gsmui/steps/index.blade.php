@props([
    'size' => 'md',
])

@php
$variants = [
    ['id' => 'basic', 'name' => 'Basic Steps', 'category' => 'Horizontal', 'desc' => 'Standard horizontal step indicator with connector lines.'],
    ['id' => 'vertical', 'name' => 'Vertical Steps', 'category' => 'Vertical', 'desc' => 'Vertical step layout for side panels or narrow spaces.'],
    ['id' => 'numbered', 'name' => 'Numbered Steps', 'category' => 'Horizontal', 'desc' => 'Steps with explicit number badges.'],
    ['id' => 'wizard', 'name' => 'Wizard Steps', 'category' => 'Interactive', 'desc' => 'Multi-step wizard with navigation controls.'],
    ['id' => 'timeline', 'name' => 'Timeline', 'category' => 'Vertical', 'desc' => 'Timeline-style vertical step progression.'],
    ['id' => 'checklist', 'name' => 'Checklist', 'category' => 'Vertical', 'desc' => 'Checklist-style steps with checkboxes.'],
    ['id' => 'icons', 'name' => 'Icon Steps', 'category' => 'Horizontal', 'desc' => 'Steps with custom icons instead of numbers.'],
    ['id' => 'minimal', 'name' => 'Minimal Steps', 'category' => 'Horizontal', 'desc' => 'Clean, minimal step indicator.'],
    ['id' => 'connected', 'name' => 'Connected Steps', 'category' => 'Horizontal', 'desc' => 'Steps connected by continuous lines.'],
    ['id' => 'card', 'name' => 'Card Steps', 'category' => 'Cards', 'desc' => 'Steps displayed as cards.'],
    ['id' => 'animated', 'name' => 'Animated Steps', 'category' => 'Interactive', 'desc' => 'Steps with smooth transition animations.'],
    ['id' => 'gradient', 'name' => 'Gradient Steps', 'category' => 'Styled', 'desc' => 'Steps with gradient backgrounds.'],
    ['id' => 'circular', 'name' => 'Circular Steps', 'category' => 'Radial', 'desc' => 'Steps arranged in a circular layout.'],
    ['id' => 'stepper', 'name' => 'Stepper', 'category' => 'Interactive', 'desc' => 'Step counter with increment/decrement buttons.'],
    ['id' => 'progress', 'name' => 'Progress Steps', 'category' => 'Horizontal', 'desc' => 'Steps with a progress bar indicator.'],
    ['id' => 'icon', 'name' => 'Icon Variant', 'category' => 'Horizontal', 'desc' => 'Alternative icon-based step display.'],
    ['id' => 'stacked', 'name' => 'Stacked Steps', 'category' => 'Cards', 'desc' => 'Stacked card layout for steps.'],
    ['id' => 'interactive', 'name' => 'Interactive Steps', 'category' => 'Interactive', 'desc' => 'Click-to-navigate step interface.'],
    ['id' => 'accordion', 'name' => 'Accordion Steps', 'category' => 'Interactive', 'desc' => 'Expandable accordion-style steps.'],
    ['id' => 'tabs', 'name' => 'Tab Steps', 'category' => 'Interactive', 'desc' => 'Steps displayed as tabs.'],
    ['id' => 'breadcrumb', 'name' => 'Breadcrumb Steps', 'category' => 'Navigation', 'desc' => 'Breadcrumb navigation for steps.'],
    ['id' => 'rail', 'name' => 'Rail Steps', 'category' => 'Horizontal', 'desc' => 'Rail-style steps with markers.'],
    ['id' => 'dots', 'name' => 'Dot Steps', 'category' => 'Minimal', 'desc' => 'Simple dot indicators for steps.'],
    ['id' => 'circles', 'name' => 'Concentric Circles', 'category' => 'Radial', 'desc' => 'Steps with concentric circle design.'],
    ['id' => 'segmented', 'name' => 'Segmented Steps', 'category' => 'Horizontal', 'desc' => 'Steps with segmented track.'],
    ['id' => 'pill', 'name' => 'Pill Steps', 'category' => 'Styled', 'desc' => 'Pill-shaped step indicators.'],
    ['id' => 'outline', 'name' => 'Outline Steps', 'category' => 'Styled', 'desc' => 'Steps with outline styling.'],
    ['id' => 'filled', 'name' => 'Filled Steps', 'category' => 'Styled', 'desc' => 'Steps with filled backgrounds.'],
    ['id' => 'ghost', 'name' => 'Ghost Steps', 'category' => 'Minimal', 'desc' => 'Subtle ghost-style steps.'],
    ['id' => 'neon', 'name' => 'Neon Steps', 'category' => 'Styled', 'desc' => 'Steps with neon glow effects.'],
    ['id' => 'retro', 'name' => 'Retro Steps', 'category' => 'Styled', 'desc' => 'Retro-styled step indicators.'],
    ['id' => 'glass', 'name' => 'Glass Steps', 'category' => 'Styled', 'desc' => 'Glassmorphism step design.'],
    ['id' => 'flat', 'name' => 'Flat Steps', 'category' => 'Styled', 'desc' => 'Flat design step indicators.'],
    ['id' => 'elevated', 'name' => 'Elevated Steps', 'category' => 'Cards', 'desc' => 'Elevated card-style steps.'],
    ['id' => 'bordered', 'name' => 'Bordered Steps', 'category' => 'Styled', 'desc' => 'Steps with prominent borders.'],
    ['id' => 'shadow', 'name' => 'Shadow Steps', 'category' => 'Cards', 'desc' => 'Steps with shadow effects.'],
    ['id' => 'striped', 'name' => 'Striped Steps', 'category' => 'Styled', 'desc' => 'Steps with striped patterns.'],
    ['id' => 'dotted', 'name' => 'Dotted Steps', 'category' => 'Minimal', 'desc' => 'Dotted line connectors.'],
    ['id' => 'dashed', 'name' => 'Dashed Steps', 'category' => 'Minimal', 'desc' => 'Dashed line connectors.'],
    ['id' => 'bold', 'name' => 'Bold Steps', 'category' => 'Styled', 'desc' => 'Bold, prominent step design.'],
    ['id' => 'subtle', 'name' => 'Subtle Steps', 'category' => 'Minimal', 'desc' => 'Subtle, understated steps.'],
    ['id' => 'colorful', 'name' => 'Colorful Steps', 'category' => 'Styled', 'desc' => 'Multi-color step indicators.'],
    ['id' => 'monochrome', 'name' => 'Monochrome Steps', 'category' => 'Styled', 'desc' => 'Single-color step design.'],
    ['id' => 'dark', 'name' => 'Dark Mode Steps', 'category' => 'Themed', 'desc' => 'Optimized for dark mode.'],
    ['id' => 'light', 'name' => 'Light Mode Steps', 'category' => 'Themed', 'desc' => 'Optimized for light mode.'],
    ['id' => 'auto', 'name' => 'Auto Theme Steps', 'category' => 'Themed', 'desc' => 'Adapts to system theme.'],
    ['id' => 'compact', 'name' => 'Compact Steps', 'category' => 'Horizontal', 'desc' => 'Space-efficient step layout.'],
    ['id' => 'spacious', 'name' => 'Spacious Steps', 'category' => 'Horizontal', 'desc' => 'Generous spacing between steps.'],
    ['id' => 'dense', 'name' => 'Dense Steps', 'category' => 'Horizontal', 'desc' => 'Tightly packed step indicators.'],
    ['id' => 'loose', 'name' => 'Loose Steps', 'category' => 'Horizontal', 'desc' => 'Loosely spaced steps.'],
    ['id' => 'xs', 'name' => 'Extra Small', 'category' => 'Sizes', 'desc' => 'Extra small step indicators.'],
    ['id' => 'sm', 'name' => 'Small', 'category' => 'Sizes', 'desc' => 'Small step indicators.'],
    ['id' => 'md', 'name' => 'Medium', 'category' => 'Sizes', 'desc' => 'Medium step indicators.'],
    ['id' => 'lg', 'name' => 'Large', 'category' => 'Sizes', 'desc' => 'Large step indicators.'],
    ['id' => 'xl', 'name' => 'Extra Large', 'category' => 'Sizes', 'desc' => 'Extra large step indicators.'],
    ['id' => '2xl', 'name' => '2XL Steps', 'category' => 'Sizes', 'desc' => 'Extra extra large steps.'],
    ['id' => 'responsive', 'name' => 'Responsive Steps', 'category' => 'Responsive', 'desc' => 'Adapts to screen size.'],
    ['id' => 'mobile', 'name' => 'Mobile Steps', 'category' => 'Responsive', 'desc' => 'Optimized for mobile.'],
    ['id' => 'desktop', 'name' => 'Desktop Steps', 'category' => 'Responsive', 'desc' => 'Optimized for desktop.'],
    ['id' => 'touch', 'name' => 'Touch Steps', 'category' => 'Interactive', 'desc' => 'Optimized for touch input.'],
    ['id' => 'keyboard', 'name' => 'Keyboard Steps', 'category' => 'Interactive', 'desc' => 'Keyboard navigation support.'],
    ['id' => 'animated-fill', 'name' => 'Animated Fill', 'category' => 'Animated', 'desc' => 'Steps with fill animation.'],
    ['id' => 'animated-slide', 'name' => 'Animated Slide', 'category' => 'Animated', 'desc' => 'Steps with slide transitions.'],
    ['id' => 'animated-fade', 'name' => 'Animated Fade', 'category' => 'Animated', 'desc' => 'Steps with fade transitions.'],
    ['id' => 'animated-scale', 'name' => 'Animated Scale', 'category' => 'Animated', 'desc' => 'Steps with scale transitions.'],
    ['id' => 'animated-bounce', 'name' => 'Animated Bounce', 'category' => 'Animated', 'desc' => 'Steps with bounce animation.'],
    ['id' => 'animated-pulse', 'name' => 'Animated Pulse', 'category' => 'Animated', 'desc' => 'Steps with pulse animation.'],
    ['id' => 'animated-spin', 'name' => 'Animated Spin', 'category' => 'Animated', 'desc' => 'Steps with spin animation.'],
    ['id' => 'with-descriptions', 'name' => 'With Descriptions', 'category' => 'Content', 'desc' => 'Steps with descriptive text.'],
    ['id' => 'with-icons', 'name' => 'With Icons', 'category' => 'Content', 'desc' => 'Steps with icon elements.'],
    ['id' => 'with-badges', 'name' => 'With Badges', 'category' => 'Content', 'desc' => 'Steps with status badges.'],
    ['id' => 'with-avatars', 'name' => 'With Avatars', 'category' => 'Content', 'desc' => 'Steps with user avatars.'],
    ['id' => 'with-images', 'name' => 'With Images', 'category' => 'Content', 'desc' => 'Steps with image elements.'],
    ['id' => 'with-tooltip', 'name' => 'With Tooltips', 'category' => 'Interactive', 'desc' => 'Steps with hover tooltips.'],
    ['id' => 'with-popover', 'name' => 'With Popovers', 'category' => 'Interactive', 'desc' => 'Steps with popover content.'],
    ['id' => 'with-dropdown', 'name' => 'With Dropdowns', 'category' => 'Interactive', 'desc' => 'Steps with dropdown menus.'],
    ['id' => 'with-modal', 'name' => 'With Modals', 'category' => 'Interactive', 'desc' => 'Steps that open modals.'],
    ['id' => 'with-drawer', 'name' => 'With Drawers', 'category' => 'Interactive', 'desc' => 'Steps that open drawers.'],
    ['id' => 'form-steps', 'name' => 'Form Steps', 'category' => 'Forms', 'desc' => 'Multi-step form wizard.'],
    ['id' => 'checkout-steps', 'name' => 'Checkout Steps', 'category' => 'E-commerce', 'desc' => 'Checkout flow steps.'],
    ['id' => 'onboarding-steps', 'name' => 'Onboarding Steps', 'category' => 'UX', 'desc' => 'User onboarding flow.'],
    ['id' => 'registration-steps', 'name' => 'Registration Steps', 'category' => 'Forms', 'desc' => 'User registration flow.'],
    ['id' => 'profile-steps', 'name' => 'Profile Steps', 'category' => 'Forms', 'desc' => 'Profile completion steps.'],
    ['id' => 'settings-steps', 'name' => 'Settings Steps', 'category' => 'Forms', 'desc' => 'Settings configuration steps.'],
    ['id' => 'tutorial-steps', 'name' => 'Tutorial Steps', 'category' => 'UX', 'desc' => 'Tutorial walkthrough steps.'],
    ['id' => 'quiz-steps', 'name' => 'Quiz Steps', 'category' => 'Interactive', 'desc' => 'Quiz question steps.'],
    ['id' => 'survey-steps', 'name' => 'Survey Steps', 'category' => 'Forms', 'desc' => 'Survey questionnaire steps.'],
    ['id' => 'payment-steps', 'name' => 'Payment Steps', 'category' => 'E-commerce', 'desc' => 'Payment flow steps.'],
    ['id' => 'shipping-steps', 'name' => 'Shipping Steps', 'category' => 'E-commerce', 'desc' => 'Shipping configuration steps.'],
    ['id' => 'order-steps', 'name' => 'Order Steps', 'category' => 'E-commerce', 'desc' => 'Order processing steps.'],
    ['id' => 'delivery-steps', 'name' => 'Delivery Steps', 'category' => 'E-commerce', 'desc' => 'Delivery tracking steps.'],
    ['id' => 'install-steps', 'name' => 'Install Steps', 'category' => 'Technical', 'desc' => 'Installation wizard steps.'],
    ['id' => 'setup-steps', 'name' => 'Setup Steps', 'category' => 'Technical', 'desc' => 'Setup configuration steps.'],
    ['id' => 'deploy-steps', 'name' => 'Deploy Steps', 'category' => 'Technical', 'desc' => 'Deployment pipeline steps.'],
    ['id' => 'ci-steps', 'name' => 'CI/CD Steps', 'category' => 'Technical', 'desc' => 'CI/CD pipeline steps.'],
    ['id' => 'migration-steps', 'name' => 'Migration Steps', 'category' => 'Technical', 'desc' => 'Data migration steps.'],
    ['id' => 'upgrade-steps', 'name' => 'Upgrade Steps', 'category' => 'Technical', 'desc' => 'System upgrade steps.'],
    ['id' => 'backup-steps', 'name' => 'Backup Steps', 'category' => 'Technical', 'desc' => 'Backup process steps.'],
    ['id' => 'restore-steps', 'name' => 'Restore Steps', 'category' => 'Technical', 'desc' => 'Restore process steps.'],
    ['id' => 'validation-steps', 'name' => 'Validation Steps', 'category' => 'Technical', 'desc' => 'Validation process steps.'],
    ['id' => 'testing-steps', 'name' => 'Testing Steps', 'category' => 'Technical', 'desc' => 'Testing process steps.'],
    ['id' => 'review-steps', 'name' => 'Review Steps', 'category' => 'Technical', 'desc' => 'Review process steps.'],
    ['id' => 'approval-steps', 'name' => 'Approval Steps', 'category' => 'Business', 'desc' => 'Approval workflow steps.'],
    ['id' => 'sign-off-steps', 'name' => 'Sign-off Steps', 'category' => 'Business', 'desc' => 'Sign-off process steps.'],
];

$categories = collect($variants)->groupBy('category');
@endphp

<div {{ $attributes }}>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Steps Components</h1>
        <p class="mt-2 text-zinc-500 dark:text-zinc-400">{{ count($variants) }} variants across {{ count($categories) }} categories</p>
    </div>
    
    @foreach($categories as $category => $items)
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white mb-4">{{ $category }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($items as $variant)
                    <a href="{{ route('gsmui.steps.' . $variant['id']) }}" 
                       class="block p-4 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
                        <h3 class="font-medium text-zinc-900 dark:text-white">{{ $variant['name'] }}</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ $variant['desc'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
