@props([
    'buttons' => [
        ['label' => 'Get Protected', 'href' => '#', 'style' => 'primary'],
    ],
    'stats' => [
        ['value' => '99.9%', 'label' => 'Threat Block Rate'],
        ['value' => '10M+', 'label' => 'Threats Detected'],
        ['value' => '24/7', 'label' => 'Monitoring'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-emerald-900 to-teal-900 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-emerald-200"><span aria-hidden="true">🛡️</span> Enterprise Security</div>
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Secure Your<br><span class="bg-gradient-to-r from-emerald-300 to-teal-300 bg-clip-text text-transparent">Digital Future</span></h1>
                <p class="mt-6 text-lg leading-8 text-zinc-300">Comprehensive security solutions to protect your business from evolving cyber threats.</p>
                <div class="mt-8 flex gap-8">
                    @foreach ($stats as $stat)
                        <div><p class="text-2xl font-bold text-emerald-400">{{ $stat['value'] }}</p><p class="text-xs text-zinc-400">{{ $stat['label'] }}</p></div>
                    @endforeach
                </div>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-emerald-600 px-8 py-3 text-sm font-semibold text-white hover:bg-emerald-500 transition-all">{{ $button['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
                <div class="flex items-center justify-between border-b border-white/10 pb-4"><span class="text-sm font-medium">Security Overview</span><span class="flex items-center gap-1.5 text-xs text-emerald-400"><span class="size-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span> Protected</span></div>
                <div class="mt-6 space-y-4">
                    <div class="flex justify-between"><span class="text-sm text-zinc-400">Firewall</span><span class="text-sm font-medium text-emerald-400">Active</span></div>
                    <div class="flex justify-between"><span class="text-sm text-zinc-400">Encryption</span><span class="text-sm font-medium text-emerald-400">AES-256</span></div>
                    <div class="flex justify-between"><span class="text-sm text-zinc-400">2FA</span><span class="text-sm font-medium text-emerald-400">Enabled</span></div>
                    <div class="flex justify-between"><span class="text-sm text-zinc-400">Last Audit</span><span class="text-sm font-medium">2 hours ago</span></div>
                    <div class="flex justify-between"><span class="text-sm text-zinc-400">Active Sessions</span><span class="text-sm font-medium">3</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
