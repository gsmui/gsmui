@props([
    'authPages' => [
        // Login — Modern
        ['id' => 'login-1', 'name' => 'Login: Centered Card', 'desc' => 'Clean white card on gradient background.', 'page' => 'login', 'style' => 'modern'],
        ['id' => 'login-2', 'name' => 'Login: Split Screen', 'desc' => 'Left gradient panel, right form.', 'page' => 'login', 'style' => 'modern'],
        ['id' => 'login-3', 'name' => 'Login: Glassmorphism', 'desc' => 'Frosted glass card on dark gradient.', 'page' => 'login', 'style' => 'modern'],
        ['id' => 'login-4', 'name' => 'Login: Minimal', 'desc' => 'No card, centered, whitespace.', 'page' => 'login', 'style' => 'modern'],
        ['id' => 'login-5', 'name' => 'Login: Dark', 'desc' => 'Dark card on dark pattern background.', 'page' => 'login', 'style' => 'modern'],
        // Register — Modern
        ['id' => 'register-1', 'name' => 'Register: Centered Card', 'desc' => 'Multi-field form with two-column names.', 'page' => 'register', 'style' => 'modern'],
        ['id' => 'register-2', 'name' => 'Register: Split Illustration', 'desc' => 'Left green gradient, right form.', 'page' => 'register', 'style' => 'modern'],
        ['id' => 'register-3', 'name' => 'Register: Floating Glass', 'desc' => 'Glassmorphism card with elevation.', 'page' => 'register', 'style' => 'modern'],
        ['id' => 'register-4', 'name' => 'Register: Compact', 'desc' => 'Two-column fields, tight spacing.', 'page' => 'register', 'style' => 'modern'],
        ['id' => 'register-5', 'name' => 'Register: Stepped', 'desc' => 'Multi-step flow with Alpine progress.', 'page' => 'register', 'style' => 'modern'],
        // Signin — Classic
        ['id' => 'signin-1', 'name' => 'Signin: Boxed Card', 'desc' => 'Traditional bordered card with shadow.', 'page' => 'signin', 'style' => 'classic'],
        ['id' => 'signin-2', 'name' => 'Signin: Two Panel', 'desc' => 'Left brand panel, right form panel.', 'page' => 'signin', 'style' => 'classic'],
        ['id' => 'signin-3', 'name' => 'Signin: Narrow Column', 'desc' => 'Centered column with field labels.', 'page' => 'signin', 'style' => 'classic'],
        ['id' => 'signin-4', 'name' => 'Signin: Structured Grid', 'desc' => 'Grid-based, business application feel.', 'page' => 'signin', 'style' => 'classic'],
        ['id' => 'signin-5', 'name' => 'Signin: Warm Amber', 'desc' => 'Amber tones, rounded, friendly.', 'page' => 'signin', 'style' => 'classic'],
        // Signup — Classic
        ['id' => 'signup-1', 'name' => 'Signup: Bordered Panel', 'desc' => 'Classic bordered panel with header.', 'page' => 'signup', 'style' => 'classic'],
        ['id' => 'signup-2', 'name' => 'Signup: Sidebar Benefits', 'desc' => 'Left sidebar with features, right form.', 'page' => 'signup', 'style' => 'classic'],
        ['id' => 'signup-3', 'name' => 'Signup: Magazine', 'desc' => 'Editorial typography, sectioned form.', 'page' => 'signup', 'style' => 'classic'],
        ['id' => 'signup-4', 'name' => 'Signup: Formal Business', 'desc' => 'Muted colors, strict alignment.', 'page' => 'signup', 'style' => 'classic'],
        ['id' => 'signup-5', 'name' => 'Signup: Friendly Pastel', 'desc' => 'Pink tones, casual, rounded.', 'page' => 'signup', 'style' => 'classic'],
        // Forgot Password
        ['id' => 'forgot-password-1', 'name' => 'Forgot Password: Centered Card', 'desc' => 'White card, email input.', 'page' => 'forgot-password', 'style' => 'modern'],
        ['id' => 'forgot-password-2', 'name' => 'Forgot Password: Split Screen', 'desc' => 'Left blue gradient, right form.', 'page' => 'forgot-password', 'style' => 'modern'],
        ['id' => 'forgot-password-3', 'name' => 'Forgot Password: Minimal', 'desc' => 'No card, clean centered.', 'page' => 'forgot-password', 'style' => 'modern'],
        ['id' => 'forgot-password-4', 'name' => 'Forgot Password: Dark', 'desc' => 'Dark bg with pattern.', 'page' => 'forgot-password', 'style' => 'modern'],
        ['id' => 'forgot-password-5', 'name' => 'Forgot Password: Glassmorphism', 'desc' => 'Frosted glass, violet accent.', 'page' => 'forgot-password', 'style' => 'modern'],
        // Reset Password
        ['id' => 'reset-password-1', 'name' => 'Reset Password: Centered Card', 'desc' => 'New password + confirm fields.', 'page' => 'reset-password', 'style' => 'modern'],
        ['id' => 'reset-password-2', 'name' => 'Reset Password: Split Screen', 'desc' => 'Left gradient, right form.', 'page' => 'reset-password', 'style' => 'modern'],
        ['id' => 'reset-password-3', 'name' => 'Reset Password: Minimal', 'desc' => 'Clean centered layout.', 'page' => 'reset-password', 'style' => 'modern'],
        ['id' => 'reset-password-4', 'name' => 'Reset Password: Dark', 'desc' => 'Dark card, blue accent.', 'page' => 'reset-password', 'style' => 'modern'],
        ['id' => 'reset-password-5', 'name' => 'Reset Password: Glassmorphism', 'desc' => 'Frosted glass card.', 'page' => 'reset-password', 'style' => 'modern'],
        // Verify Email
        ['id' => 'verify-email-1', 'name' => 'Verify Email: Centered Card', 'desc' => 'Envelope icon, resend button.', 'page' => 'verify-email', 'style' => 'modern'],
        ['id' => 'verify-email-2', 'name' => 'Verify Email: Split Screen', 'desc' => 'Left gradient, right message.', 'page' => 'verify-email', 'style' => 'modern'],
        ['id' => 'verify-email-3', 'name' => 'Verify Email: Minimal', 'desc' => 'Clean centered message.', 'page' => 'verify-email', 'style' => 'modern'],
        ['id' => 'verify-email-4', 'name' => 'Verify Email: Dark', 'desc' => 'Dark bg, dark card.', 'page' => 'verify-email', 'style' => 'modern'],
        ['id' => 'verify-email-5', 'name' => 'Verify Email: Countdown', 'desc' => 'Resend timer with Alpine countdown.', 'page' => 'verify-email', 'style' => 'modern'],
        // Two Factor
        ['id' => 'two-factor-1', 'name' => '2FA: Centered Card', 'desc' => '6-digit code inputs with auto-advance.', 'page' => 'two-factor', 'style' => 'modern'],
        ['id' => 'two-factor-2', 'name' => '2FA: Split Screen', 'desc' => 'Left teal gradient, right form.', 'page' => 'two-factor', 'style' => 'modern'],
        ['id' => 'two-factor-3', 'name' => '2FA: Minimal', 'desc' => 'Clean centered code entry.', 'page' => 'two-factor', 'style' => 'modern'],
        ['id' => 'two-factor-4', 'name' => '2FA: Dark', 'desc' => 'Dark styled inputs.', 'page' => 'two-factor', 'style' => 'modern'],
        ['id' => 'two-factor-5', 'name' => '2FA: QR Code', 'desc' => 'QR code placeholder + manual entry.', 'page' => 'two-factor', 'style' => 'modern'],
        // Confirm Password
        ['id' => 'confirm-password-1', 'name' => 'Confirm: Centered Card', 'desc' => 'Lock icon, password field.', 'page' => 'confirm-password', 'style' => 'modern'],
        ['id' => 'confirm-password-2', 'name' => 'Confirm: Split Screen', 'desc' => 'Left blue gradient.', 'page' => 'confirm-password', 'style' => 'modern'],
        ['id' => 'confirm-password-3', 'name' => 'Confirm: Minimal', 'desc' => 'Clean centered.', 'page' => 'confirm-password', 'style' => 'modern'],
        ['id' => 'confirm-password-4', 'name' => 'Confirm: Dark', 'desc' => 'Dark bg, lock icon.', 'page' => 'confirm-password', 'style' => 'modern'],
        ['id' => 'confirm-password-5', 'name' => 'Confirm: Modal', 'desc' => 'Small card, dark overlay.', 'page' => 'confirm-password', 'style' => 'modern'],
        // Lock Screen
        ['id' => 'lock-screen-1', 'name' => 'Lock: Avatar Card', 'desc' => 'Centered avatar with name.', 'page' => 'lock-screen', 'style' => 'modern'],
        ['id' => 'lock-screen-2', 'name' => 'Lock: Full Dark', 'desc' => 'Full-screen dark with avatar.', 'page' => 'lock-screen', 'style' => 'modern'],
        ['id' => 'lock-screen-3', 'name' => 'Lock: Minimal', 'desc' => 'Small inline avatar.', 'page' => 'lock-screen', 'style' => 'modern'],
        ['id' => 'lock-screen-4', 'name' => 'Lock: Glassmorphism', 'desc' => 'Frosted glass with avatar.', 'page' => 'lock-screen', 'style' => 'modern'],
        ['id' => 'lock-screen-5', 'name' => 'Lock: Split Screen', 'desc' => 'Left gradient with avatar.', 'page' => 'lock-screen', 'style' => 'modern'],
    ],
])

@php
$grouped = collect($authPages)->groupBy('page');
$total = count($authPages);
@endphp

<div {{ $attributes->class('min-h-screen bg-zinc-50 dark:bg-zinc-900') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div>
                <h1 class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Pro Auth Templates</h1>
                <p class="text-sm text-zinc-500">{{ $total }} production-ready authentication pages</p>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <span class="rounded-full bg-blue-100 dark:bg-blue-900/30 px-3 py-1 text-xs font-medium text-blue-700 dark:text-blue-300">{{ $total }} Templates</span>
                <span class="rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-3 py-1 text-xs font-medium text-emerald-700 dark:text-emerald-300">Dark Mode</span>
                <span class="rounded-full bg-violet-100 dark:bg-violet-900/30 px-3 py-1 text-xs font-medium text-violet-700 dark:text-violet-300">Livewire Ready</span>
            </div>
        </div>
        <div class="border-t border-zinc-200 dark:border-white/10 overflow-x-auto">
            <div class="mx-auto flex max-w-7xl gap-1 px-6 py-2 text-xs font-medium text-zinc-500">
                @foreach ($grouped as $page => $variants)
                    <a href="#section-{{ $page }}" class="shrink-0 rounded-md px-2 py-1 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white transition-all capitalize">{{ str_replace('-', ' ', $page) }} ({{ count($variants) }})</a>
                @endforeach
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-12 space-y-24">
        @foreach ($grouped as $page => $variants)
            <section id="section-{{ $page }}" class="scroll-mt-32">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white capitalize">{{ str_replace('-', ' ', $page) }}</h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ count($variants) }} variants</p>
                </div>

                <div class="space-y-16">
                    @foreach ($variants as $template)
                        <div id="template-{{ $template['id'] }}">
                            <div class="mb-4 flex items-center justify-between">
                                <div>
                                    <span class="inline-flex items-center gap-2 rounded-full {{ $template['style'] === 'modern' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' }} px-3 py-1 text-xs font-medium">
                                        {{ ucfirst($template['style']) }}
                                    </span>
                                    <h3 class="mt-2 text-lg font-semibold text-zinc-900 dark:text-white">{{ $template['name'] }}</h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $template['desc'] }}</p>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-zinc-400">
                                    <span class="rounded-md border border-zinc-200 dark:border-white/10 px-2 py-1 font-mono">&lt;x-gsmui::auth.{{ $template['id'] }} /&gt;</span>
                                    <button onclick="navigator.clipboard.writeText('<x-gsmui::auth.{{ $template['id'] }} />')" class="rounded-md border border-zinc-200 dark:border-white/10 px-2 py-1 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all" title="Copy usage code">Copy</button>
                                </div>
                            </div>

                            <div class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-white/10 shadow-sm">
                                <x-dynamic-component :component="'gsmui::auth.' . $template['id']" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        <footer class="border-t border-zinc-200 dark:border-white/10 pt-12 pb-8 text-center">
            <p class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Pro — {{ $total }} Auth Templates</p>
            <p class="mt-2 text-sm text-zinc-500">Fully responsive · Dark mode ready · Livewire ready · Tailwind CSS</p>
            <p class="mt-1 text-xs text-zinc-400">Copy any template with <code class="rounded bg-zinc-200 dark:bg-zinc-700 px-1.5 py-0.5 text-xs font-mono">&lt;x-gsmui::auth.{name}-{n} /&gt;</code></p>
        </footer>
    </main>
</div>
