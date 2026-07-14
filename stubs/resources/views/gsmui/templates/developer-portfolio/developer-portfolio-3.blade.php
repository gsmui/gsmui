@props([
    'title' => 'root@dev',
    'subtitle' => 'Backend Engineer & Systems Architect',
    'commands' => [
        ['command' => 'whoami', 'output' => 'Senior Backend Engineer specializing in distributed systems.'],
        ['command' => 'cat experience.txt', 'output' => '8+ years building high-throughput APIs, microservices, and data pipelines.'],
        ['command' => 'uptime', 'output' => 'Projects running in production: 23 | Uptime: 99.97%'],
    ],
    'skills' => [
        ['name' => 'Python', 'level' => 95],
        ['name' => 'Rust', 'level' => 80],
        ['name' => 'Go', 'level' => 88],
        ['name' => 'PostgreSQL', 'level' => 92],
        ['name' => 'Docker/K8s', 'level' => 85],
        ['name' => 'Redis', 'level' => 78],
    ],
])

<div {{ $attributes->class('min-h-screen bg-zinc-950 font-mono text-sm text-green-400') }}>
    <header class="sticky top-0 z-50 border-b border-green-500/20 bg-zinc-950/90 backdrop-blur-lg">
        <div class="mx-auto flex max-w-4xl items-center justify-between px-6 py-3">
            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-red-500"></span>
                <span class="h-3 w-3 rounded-full bg-yellow-500"></span>
                <span class="h-3 w-3 rounded-full bg-green-500"></span>
                <span class="ml-3 text-zinc-500">{{ $title }} — bash — 80x24</span>
            </div>
            <nav class="hidden items-center gap-4 text-xs text-zinc-500 sm:flex">
                <a href="#skills" class="hover:text-green-400 transition-colors">{{ __('skills') }}</a>
                <a href="#projects" class="hover:text-green-400 transition-colors">{{ __('projects') }}</a>
                <a href="#contact" class="hover:text-green-400 transition-colors">{{ __('contact') }}</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-4xl px-6 py-10">
        <section class="mb-8 rounded-lg border border-green-500/20 bg-zinc-900/50 p-5">
            <p class="text-green-600">{{ __('Last login:') }} {{ now()->format('D M d H:i:s') }}</p>
            @foreach ($commands as $cmd)
                <div class="mt-4">
                    <p><span class="text-green-600">{{ $title }}:~$</span> <span class="text-white">{{ $cmd['command'] }}</span></p>
                    <p class="mt-1 text-green-300">{{ $cmd['output'] }}</p>
                </div>
            @endforeach
        </section>

        <section id="skills" class="mb-8 rounded-lg border border-green-500/20 bg-zinc-900/50 p-5">
            <p class="mb-4"><span class="text-green-600">{{ $title }}:~$</span> <span class="text-white">neofetch --skills</span></p>
            <div class="grid gap-3 sm:grid-cols-2">
                @foreach ($skills as $skill)
                    <div class="flex items-center gap-3">
                        <span class="w-24 shrink-0 text-right text-cyan-400">{{ $skill['name'] }}</span>
                        <div class="flex-1">
                            <gsmui:progress :value="$skill['level']" color="emerald" />
                        </div>
                        <span class="w-10 text-right text-zinc-500">[{{ $skill['level'] }}%]</span>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="projects" class="mb-8 rounded-lg border border-green-500/20 bg-zinc-900/50 p-5">
            <p class="mb-4"><span class="text-green-600">{{ $title }}:~$</span> <span class="text-white">ls -la ~/projects</span></p>
            <div class="space-y-1 text-xs">
                <p class="text-green-600">total {{ count($commands) * 3 }}</p>
                <p><span class="text-zinc-500">drwxr-xr-x</span> <span class="text-zinc-500">4.0K</span> <span class="text-zinc-500">2024-01-15</span> <span class="text-cyan-400">distributed-cache/</span></p>
                <p><span class="text-zinc-500">drwxr-xr-x</span> <span class="text-zinc-500">8.4K</span> <span class="text-zinc-500">2024-02-20</span> <span class="text-cyan-400">api-gateway/</span></p>
                <p><span class="text-zinc-500">drwxr-xr-x</span> <span class="text-zinc-500">2.1K</span> <span class="text-zinc-500">2024-03-10</span> <span class="text-cyan-400">ml-pipeline/</span></p>
                <p><span class="text-zinc-500">-rw-r--r--</span> <span class="text-zinc-500">1.2K</span> <span class="text-zinc-500">2024-04-05</span> <span class="text-yellow-300">README.md</span></p>
            </div>
        </section>

        <section id="contact" class="mb-8 rounded-lg border border-green-500/20 bg-zinc-900/50 p-5">
            <p class="mb-4"><span class="text-green-600">{{ $title }}:~$</span> <span class="text-white">mail -s "Hello" contact</span></p>
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <span class="text-green-600 shrink-0">To:</span>
                    <gsmui:input type="email" placeholder="your@email.com" icon="envelope" class="font-mono text-xs bg-transparent! border-green-500/30! text-green-300 placeholder:text-green-800" />
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-green-600 shrink-0">Sub:</span>
                    <gsmui:input type="text" placeholder="{{ __('Project collaboration') }}" class="font-mono text-xs bg-transparent! border-green-500/30! text-green-300 placeholder:text-green-800" />
                </div>
                <gsmui:button variant="filled" size="sm" class="bg-green-600! hover:bg-green-500! text-black! font-mono" icon="envelope">[ {{ __('Send') }} ]</gsmui:button>
            </div>
        </section>
    </main>

    <footer class="border-t border-green-500/20 py-6 text-center">
        <p class="text-xs text-green-800">{{ __('~/.bash_history loaded successfully') }} | {{ $title }} {{ __('session active') }}</p>
    </footer>
</div>
