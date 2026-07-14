{{--
Gsmui Phone Mockup — Demo / Visual Reference Page

Showcases every variant combination:
  • 20 bezel colors
  • 3 variants (bezel / minimal / flat)
  • 5 sizes (xs / sm / default / lg / xl)
  • 4 camera types (dot / bar / notch / dynamic-island)

Route (in a Laravel app):
  Route::get('/gsmui/phone/demo', fn () => view('gsmui.phone.demo'));
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phone Mockup — Demo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @gsmuiScripts
</head>
<body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 font-sans antialiased">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 space-y-16">

        {{-- ======================================================================== --}}
        {{-- HERO --}}
        {{-- ======================================================================== --}}
        <header class="text-center space-y-3">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-zinc-200 dark:bg-zinc-800 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                📱
                gsmui:phone
            </span>
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight">Phone Mockup</h1>
            <p class="text-zinc-500 dark:text-zinc-400 max-w-xl mx-auto">
                A complete visual reference of every variant — colors, sizes, bezel styles, and camera types.
            </p>
        </header>

        {{-- ======================================================================== --}}
        {{-- SECTION 1 — 20 COLORS --}}
        {{-- ======================================================================== --}}
        <section>
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center justify-center size-8 rounded-lg bg-zinc-200 dark:bg-zinc-800 text-xs font-bold text-zinc-500">01</span>
                <div>
                    <h2 class="text-xl font-semibold">20 Bezel Colors</h2>
                    <p class="text-sm text-zinc-400">Every color in the palette, from slate to rose.</p>
                </div>
            </div>

            @php
            $allColors = ['slate', 'zinc', 'red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose'];
            $colorLabels = [
                'slate' => 'Slate', 'zinc' => 'Zinc', 'red' => 'Red', 'orange' => 'Orange',
                'amber' => 'Amber', 'yellow' => 'Yellow', 'lime' => 'Lime', 'green' => 'Green',
                'emerald' => 'Emerald', 'teal' => 'Teal', 'cyan' => 'Cyan', 'sky' => 'Sky',
                'blue' => 'Blue', 'indigo' => 'Indigo', 'violet' => 'Violet', 'purple' => 'Purple',
                'fuchsia' => 'Fuchsia', 'pink' => 'Pink', 'rose' => 'Rose',
            ];
            @endphp

            {{-- Default (black) shown first, then the 19 named colors --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                {{-- Default (black) --}}
                <div class="flex flex-col items-center gap-2">
                    <gsmui:phone.screen color="default" size="xs" camera="dynamic-island" displayAspect="video" displayColor="zinc" class="mx-auto">
                        <div class="flex items-center justify-center h-full text-[10px] text-zinc-500 dark:text-zinc-600">Default</div>
                    </gsmui:phone.screen>
                    <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Default</span>
                </div>

                @foreach ($allColors as $c)
                <div class="flex flex-col items-center gap-2">
                    <gsmui:phone.screen color="{{ $c }}" size="xs" camera="dynamic-island" displayAspect="video" displayColor="zinc" class="mx-auto">
                        <div class="flex items-center justify-center h-full text-[10px] text-zinc-500 dark:text-zinc-600">{{ $colorLabels[$c] ?? ucfirst($c) }}</div>
                    </gsmui:phone.screen>
                    <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">{{ $colorLabels[$c] ?? ucfirst($c) }}</span>
                </div>
                @endforeach
            </div>
        </section>

        {{-- ======================================================================== --}}
        {{-- SECTION 2 — 3 STYLES --}}
        {{-- ======================================================================== --}}
        <section>
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center justify-center size-8 rounded-lg bg-zinc-200 dark:bg-zinc-800 text-xs font-bold text-zinc-500">02</span>
                <div>
                    <h2 class="text-xl font-semibold">3 Bezel Styles</h2>
                    <p class="text-sm text-zinc-400">bezel — minimal — flat. Each with distinct rounded-corner scaling and padding.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                {{-- Bezel --}}
                <div class="flex flex-col items-center gap-3">
                    <gsmui:phone.screen variant="bezel" size="sm" camera="dynamic-island" displayAspect="video" displayColor="zinc" class="mx-auto">
                        <div class="flex items-center justify-center h-full text-[11px] text-zinc-500 dark:text-zinc-600">bezel</div>
                    </gsmui:phone.screen>
                    <span class="text-sm font-medium px-2 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">bezel</span>
                    <p class="text-xs text-zinc-400 text-center">rounded-[3rem] · p-2.5 · shadow-2xl</p>
                </div>

                {{-- Minimal --}}
                <div class="flex flex-col items-center gap-3">
                    <gsmui:phone.screen variant="minimal" color="blue" size="sm" camera="bar" displayAspect="video" displayColor="zinc" class="mx-auto">
                        <div class="flex items-center justify-center h-full text-[11px] text-zinc-500 dark:text-zinc-600">minimal</div>
                    </gsmui:phone.screen>
                    <span class="text-sm font-medium px-2 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">minimal</span>
                    <p class="text-xs text-zinc-400 text-center">rounded-[2rem] · p-1.5 · shadow-2xl</p>
                </div>

                {{-- Flat --}}
                <div class="flex flex-col items-center gap-3">
                    <gsmui:phone.screen variant="flat" color="violet" size="sm" camera="notch" displayAspect="video" displayColor="zinc" class="mx-auto">
                        <div class="flex items-center justify-center h-full text-[11px] text-zinc-500 dark:text-zinc-600">flat</div>
                    </gsmui:phone.screen>
                    <span class="text-sm font-medium px-2 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">flat</span>
                    <p class="text-xs text-zinc-400 text-center">rounded-2xl · p-0 · shadow-lg</p>
                </div>
            </div>
        </section>

        {{-- ======================================================================== --}}
        {{-- SECTION 3 — 5 SIZES --}}
        {{-- ======================================================================== --}}
        <section>
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center justify-center size-8 rounded-lg bg-zinc-200 dark:bg-zinc-800 text-xs font-bold text-zinc-500">03</span>
                <div>
                    <h2 class="text-xl font-semibold">5 Sizes</h2>
                    <p class="text-sm text-zinc-400">xs · sm · default (md) · lg · xl — width progression from 12rem to 24rem.</p>
                </div>
            </div>

            <div class="flex flex-wrap items-end justify-center gap-6">
                @php
                $sizeLabels = ['xs' => 'xs (12rem)', 'sm' => 'sm (14rem)', 'default' => 'md (16rem)', 'lg' => 'lg (20rem)', 'xl' => 'xl (24rem)'];
        @endphp

                @foreach (['xs', 'sm', 'default', 'lg', 'xl'] as $s)
                <div class="flex flex-col items-center gap-2">
                    <gsmui:phone.screen
                        color="indigo"
                        variant="bezel"
                        size="{{ $s }}"
                        camera="dynamic-island"
                        displayAspect="video"
                        displayColor="zinc"
                        class="mx-auto"
                    >
                        <div class="flex items-center justify-center h-full text-[10px] text-zinc-500 dark:text-zinc-600 leading-tight text-center px-1">
                            {{ $s }}
                        </div>
                    </gsmui:phone.screen>
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 text-center">{{ $sizeLabels[$s] }}</span>
                </div>
                @endforeach
            </div>
        </section>

        {{-- ======================================================================== --}}
        {{-- SECTION 4 — 4 CAMERA TYPES --}}
        {{-- ======================================================================== --}}
        <section>
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center justify-center size-8 rounded-lg bg-zinc-200 dark:bg-zinc-800 text-xs font-bold text-zinc-500">04</span>
                <div>
                    <h2 class="text-xl font-semibold">4 Camera Notch Styles</h2>
                    <p class="text-sm text-zinc-400">dot · bar · notch · dynamic-island — each with a distinct shape and position.</p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                @php
                $cameras = [
                    'dot' => ['label' => 'Dot', 'desc' => 'Simple circle'],
                    'bar' => ['label' => 'Bar', 'desc' => 'Horizontal pill'],
                    'notch' => ['label' => 'Notch', 'desc' => 'Rounded rectangle'],
                    'dynamic-island' => ['label' => 'Dynamic Island', 'desc' => 'Pill with sensors'],
                ];
                @endphp

                @foreach ($cameras as $cam => $info)
                <div class="flex flex-col items-center gap-3">
                    <gsmui:phone.screen
                        color="zinc"
                        size="sm"
                        camera="{{ $cam }}"
                        displayAspect="video"
                        displayColor="slate"
                        class="mx-auto"
                    >
                        <div class="flex items-center justify-center h-full text-[11px] text-zinc-500 dark:text-zinc-600">
                            {{ $info['label'] }}
                        </div>
                    </gsmui:phone.screen>
                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $info['label'] }}</span>
                    <span class="text-xs text-zinc-400">{{ $info['desc'] }}</span>
                </div>
                @endforeach
            </div>
        </section>

        {{-- ======================================================================== --}}
        {{-- SECTION 5 — COLOR + CAMERA COMBOS --}}
        {{-- ======================================================================== --}}
        <section>
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center justify-center size-8 rounded-lg bg-zinc-200 dark:bg-zinc-800 text-xs font-bold text-zinc-500">05</span>
                <div>
                    <h2 class="text-xl font-semibold">Curated Combinations</h2>
                    <p class="text-sm text-zinc-400">Matching color, camera style, and variant for themed looks.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Midnight --}}
                <div class="flex flex-col items-center gap-2 p-4 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                    <gsmui:phone.screen color="default" size="sm" camera="dynamic-island" displayAspect="video" displayColor="zinc" class="mx-auto">
                        <div class="flex items-center justify-center h-full text-[10px] text-zinc-500">Midnight</div>
                    </gsmui:phone.screen>
                    <span class="text-sm font-semibold">Midnight</span>
                    <span class="text-xs text-zinc-400">black · dynamic-island</span>
                </div>

                {{-- Product Red --}}
                <div class="flex flex-col items-center gap-2 p-4 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                    <gsmui:phone.screen variant="minimal" color="red" size="sm" camera="notch" displayAspect="video" displayColor="zinc" class="mx-auto">
                        <div class="flex items-center justify-center h-full text-[10px] text-zinc-500">(Product) RED</div>
                    </gsmui:phone.screen>
                    <span class="text-sm font-semibold">(Product) RED</span>
                    <span class="text-xs text-zinc-400">red · minimal · notch</span>
                </div>

                {{-- Pacific Blue --}}
                <div class="flex flex-col items-center gap-2 p-4 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                    <gsmui:phone.screen color="blue" size="sm" camera="bar" displayAspect="video" displayColor="sky" class="mx-auto">
                        <div class="flex items-center justify-center h-full text-[10px] text-zinc-500">Pacific Blue</div>
                    </gsmui:phone.screen>
                    <span class="text-sm font-semibold">Pacific Blue</span>
                    <span class="text-xs text-zinc-400">blue · bezel · bar</span>
                </div>

                {{-- Rose Gold --}}
                <div class="flex flex-col items-center gap-2 p-4 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                    <gsmui:phone.screen variant="flat" color="pink" size="sm" camera="dot" displayAspect="video" displayColor="zinc" class="mx-auto">
                        <div class="flex items-center justify-center h-full text-[10px] text-zinc-500">Rose Gold</div>
                    </gsmui:phone.screen>
                    <span class="text-sm font-semibold">Rose Gold</span>
                    <span class="text-xs text-zinc-400">pink · flat · dot</span>
                </div>
            </div>
        </section>

        {{-- ======================================================================== --}}
        {{-- SECTION 6 — FULL-SCREEN MOCKUP (large showcase) --}}
        {{-- ======================================================================== --}}
        <section>
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center justify-center size-8 rounded-lg bg-zinc-200 dark:bg-zinc-800 text-xs font-bold text-zinc-500">06</span>
                <div>
                    <h2 class="text-xl font-semibold">App Screen Previews</h2>
                    <p class="text-sm text-zinc-400">Phone mockups with simulated app content at default size.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                {{-- Weather app with status bar --}}
                <div class="flex flex-col items-center gap-3">
                    <gsmui:phone.screen color="sky" size="default" camera="dynamic-island" displayAspect="video" :status-bar="true" status-bar-time="9:41" status-bar-battery="82" class="mx-auto">
                        <div class="flex-1 flex flex-col items-center justify-center text-center space-y-1 px-2 pb-2">
                            <span class="text-3xl font-light text-zinc-800 dark:text-zinc-200">72°</span>
                            <span class="text-zinc-500 dark:text-zinc-400 text-[11px]">Sunny</span>
                            <span class="text-zinc-400 dark:text-zinc-500 text-[10px]">H: 78° L: 65°</span>
                        </div>
                    </gsmui:phone.screen>
                    <span class="text-sm font-medium">Weather</span>
                    <span class="text-xs text-zinc-400">:status-bar="true"</span>
                </div>

                {{-- Music app with inverted status bar (dark content) --}}
                <div class="flex flex-col items-center gap-3">
                    <gsmui:phone.screen color="fuchsia" variant="minimal" size="default" camera="dynamic-island" displayAspect="video" :status-bar="true" status-bar-time="9:41" status-bar-battery="45" status-bar-inverse="true" class="mx-auto">
                        <div class="flex-1 flex flex-col items-center justify-center text-center space-y-1.5 px-2 pb-2">
                            <div class="size-12 rounded-lg bg-gradient-to-br from-fuchsia-400 to-purple-600 flex items-center justify-center">
                                <span class="text-2xl text-white">🎵</span>
                            </div>
                            <span class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Midnight Dreams</span>
                            <span class="text-zinc-500 dark:text-zinc-400 text-[11px]">Artist Name</span>
                            <div class="w-full h-1 rounded-full bg-zinc-200 dark:bg-zinc-700 mt-1">
                                <div class="w-2/3 h-full rounded-full bg-fuchsia-500"></div>
                            </div>
                        </div>
                    </gsmui:phone.screen>
                    <span class="text-sm font-medium">Music</span>
                    <span class="text-xs text-zinc-400">:status-bar-inverse="true"</span>
                </div>

                {{-- Messages app with low battery status bar --}}
                <div class="flex flex-col items-center gap-3">
                    <gsmui:phone.screen color="green" variant="flat" size="default" camera="notch" displayAspect="video" :status-bar="true" status-bar-time="9:41" status-bar-battery="12" class="mx-auto">
                        <div class="flex-1 flex flex-col justify-end space-y-2 px-2 pb-2">
                            <div class="bg-green-500/20 dark:bg-green-500/10 rounded-xl rounded-br-sm p-2 self-end max-w-[80%]">
                                <p class="text-zinc-700 dark:text-zinc-300 text-[11px]">Hey! Want to grab coffee?</p>
                            </div>
                            <div class="bg-zinc-100 dark:bg-zinc-800 rounded-xl rounded-bl-sm p-2 self-start max-w-[80%]">
                                <p class="text-zinc-700 dark:text-zinc-300 text-[11px]">Sure! Meet at 3pm?</p>
                            </div>
                            <div class="bg-green-500/20 dark:bg-green-500/10 rounded-xl rounded-br-sm p-2 self-end max-w-[80%]">
                                <p class="text-zinc-700 dark:text-zinc-300 text-[11px]">Perfect, see you there!</p>
                            </div>
                        </div>
                    </gsmui:phone.screen>
                    <span class="text-sm font-medium">Messages</span>
                    <span class="text-xs text-zinc-400">battery @ 12% (red)</span>
                </div>
            </div>
        </section>

        {{-- ======================================================================== --}}
        {{-- FOOTER --}}
        {{-- ======================================================================== --}}
        <footer class="pt-8 border-t border-zinc-200 dark:border-zinc-800 text-center text-xs text-zinc-400 space-y-1">
            <p>Gsmui Phone Mockup — <span class="font-medium">20 colors · 3 styles · 5 sizes · 4 cameras</span></p>
            <p>Built with <span class="text-red-400">♥</span> using Gsmui Pro</p>
        </footer>

    </div>
</body>
</html>
