{{--
Gsmui Hover — Demo / Reference Page

Showcases: 2D effects, 3D effects, gallery effects
Maps to: gsmui:hover, gsmui:hover.3d, gsmui:hover.gallery
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hover Effects — Demo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 font-sans antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 space-y-16">

        {{-- Hero --}}
        <header class="text-center space-y-3">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-zinc-200 dark:bg-zinc-800 text-xs font-medium text-zinc-500">✨ gsmui:hover</span>
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight">Hover Effects</h1>
            <p class="text-zinc-500 dark:text-zinc-400 max-w-2xl mx-auto">2D transforms · shadows · filters · borders · colors · 3D perspective · gallery overlays — 100+ variants</p>
        </header>

        {{-- ======================== 2D EFFECTS ======================== --}}
        <section class="space-y-8">
            <div class="flex items-center gap-3">
                <span class="size-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-sm font-bold text-blue-600">2D</span>
                <h2 class="text-xl font-semibold">2D Transform Effects</h2>
            </div>

            @php
            $effects2D = [
                'lift' => 'Lift', 'lift-lg' => 'Lift LG', 'press' => 'Press', 'press-lg' => 'Press LG',
                'scale' => 'Scale', 'scale-lg' => 'Scale LG', 'scale-down' => 'Scale Down', 'grow' => 'Grow', 'shrink' => 'Shrink',
                'slide-up' => 'Slide Up', 'slide-down' => 'Slide Down', 'slide-left' => 'Slide Left', 'slide-right' => 'Slide Right',
                'skew' => 'Skew', 'skew-lg' => 'Skew LG', 'skew-x' => 'Skew X', 'skew-y' => 'Skew Y',
                'rotate' => 'Rotate', 'rotate-lg' => 'Rotate LG', 'wobble' => 'Wobble', 'bounce' => 'Bounce',
            ];
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-7 gap-3">
                @foreach ($effects2D as $key => $label)
                <gsmui:hover effect="{{ $key }}" class="group">
                    <div class="w-full h-20 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-xs font-medium text-zinc-500 shadow-sm">{{ $label }}</div>
                </gsmui:hover>
                @endforeach
            </div>
        </section>

        {{-- ======================== SHADOWS ======================== --}}
        <section class="space-y-8">
            <div class="flex items-center gap-3">
                <span class="size-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-sm font-bold text-amber-600">✦</span>
                <h2 class="text-xl font-semibold">Shadow &amp; Glow Effects</h2>
            </div>

            @php
            $shadowEffects = ['shadow', 'shadow-lg', 'shadow-xl', 'shadow-2xl', 'shadow-colored', 'shadow-deep', 'glow', 'glow-blue', 'glow-green', 'glow-red', 'glow-amber', 'glow-violet', 'glow-cyan', 'glow-rose'];
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-7 gap-3">
                @foreach ($shadowEffects as $key)
                <gsmui:hover effect="{{ $key }}" class="group">
                    <div class="w-full h-20 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-xs font-medium text-zinc-500 shadow-sm">{{ $key }}</div>
                </gsmui:hover>
                @endforeach
            </div>
        </section>

        {{-- ======================== BORDER & RING ======================== --}}
        <section class="space-y-8">
            <div class="flex items-center gap-3">
                <span class="size-8 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-sm font-bold text-green-600">○</span>
                <h2 class="text-xl font-semibold">Border &amp; Outline Effects</h2>
            </div>

            @php
            $borderEffects = ['border', 'border-primary', 'border-accent', 'border-success', 'border-danger', 'border-warning', 'border-info', 'outline', 'outline-primary'];
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                @foreach ($borderEffects as $key)
                <gsmui:hover effect="{{ $key }}" class="group">
                    <div class="w-full h-20 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-xs font-medium text-zinc-500 shadow-sm">{{ $key }}</div>
                </gsmui:hover>
                @endforeach
            </div>
        </section>

        {{-- ======================== BACKGROUND & COLOR ======================== --}}
        <section class="space-y-8">
            <div class="flex items-center gap-3">
                <span class="size-8 rounded-lg bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center text-sm font-bold text-violet-600">🎨</span>
                <h2 class="text-xl font-semibold">Background &amp; Color Effects</h2>
            </div>

            @php
            $bgEffects = ['bg-darken', 'bg-lighten', 'bg-highlight', 'bg-primary', 'bg-success', 'bg-danger', 'bg-amber', 'bg-violet', 'bg-cyan', 'bg-rose', 'color-primary', 'color-success', 'color-danger', 'color-amber', 'color-violet', 'color-invert'];
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-8 gap-3">
                @foreach ($bgEffects as $key)
                <gsmui:hover effect="{{ $key }}" class="group">
                    <div class="w-full h-20 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-xs font-medium text-zinc-500 shadow-sm">{{ $key }}</div>
                </gsmui:hover>
                @endforeach
            </div>
        </section>

        {{-- ======================== FILTER ======================== --}}
        <section class="space-y-8">
            <div class="flex items-center gap-3">
                <span class="size-8 rounded-lg bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center text-sm font-bold text-cyan-600">◑</span>
                <h2 class="text-xl font-semibold">Filter Effects</h2>
            </div>

            @php
            $filterEffects = ['grayscale', 'saturate', 'saturate-lg', 'contrast', 'contrast-lg', 'brightness', 'brightness-lg', 'blur', 'blur-sm', 'sepia', 'hue-rotate'];
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                @foreach ($filterEffects as $key)
                <gsmui:hover effect="{{ $key }}" class="group">
                    <div class="w-full h-20 rounded-xl bg-gradient-to-br from-sky-200 to-indigo-200 dark:from-sky-800 dark:to-indigo-800 flex items-center justify-center text-xs font-medium text-zinc-600 dark:text-zinc-300 shadow-sm">{{ $key }}</div>
                </gsmui:hover>
                @endforeach
            </div>
        </section>

        {{-- ======================== 3D EFFECTS ======================== --}}
        <section class="space-y-8">
            <div class="flex items-center gap-3">
                <span class="size-8 rounded-lg bg-fuchsia-100 dark:bg-fuchsia-900/30 flex items-center justify-center text-sm font-bold text-fuchsia-600">3D</span>
                <h2 class="text-xl font-semibold">3D Perspective Effects</h2>
                <span class="text-xs text-zinc-400">using gsmui:hover.3d</span>
            </div>

            @php
            $effects3D = ['tilt', 'tilt-lg', 'float', 'float-lg', 'card', 'card-lg', 'flip', 'flip-lg', 'pop', 'pop-lg', 'push', 'push-lg', 'rise', 'rise-lg', 'glide', 'glide-lg', 'swing', 'swing-lg', 'fold', 'fold-lg', 'reveal-up', 'reveal-down'];
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach ($effects3D as $key)
                <gsmui:hover.3d effect="{{ $key }}" class="group">
                    <div class="w-full h-24 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-xs font-medium text-zinc-500 shadow-sm">{{ $key }}</div>
                </gsmui:hover.3d>
                @endforeach
            </div>
        </section>

        {{-- ======================== GALLERY EFFECTS ======================== --}}
        <section class="space-y-8">
            <div class="flex items-center gap-3">
                <span class="size-8 rounded-lg bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center text-sm font-bold text-rose-600">🖼</span>
                <h2 class="text-xl font-semibold">Gallery &amp; Image Effects</h2>
                <span class="text-xs text-zinc-400">using gsmui:hover.gallery</span>
            </div>

            @php
            $galleryEffects = ['zoom', 'zoom-lg', 'zoom-out', 'pan-up', 'pan-down', 'pan-left', 'pan-right', 'pan-diagonal', 'rotate-zoom', 'blur', 'grayscale', 'saturate', 'vintage', 'overlay', 'overlay-dark', 'overlay-gradient', 'tint-blue', 'tint-green', 'tint-red', 'tint-amber', 'tint-violet'];
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-7 gap-4">
                @foreach ($galleryEffects as $key)
                <gsmui:hover.gallery effect="{{ $key }}" class="aspect-square rounded-lg overflow-hidden bg-zinc-200 dark:bg-zinc-800">
                    <div class="w-full h-full bg-gradient-to-br from-blue-400 via-violet-400 to-rose-400 flex items-center justify-center text-white text-xs font-medium text-center p-2 leading-tight">{{ $key }}</div>
                </gsmui:hover.gallery>
                @endforeach
            </div>
        </section>

        {{-- ======================== GALLERY WITH OVERLAY + CAPTION ======================== --}}
        <section class="space-y-8">
            <div class="flex items-center gap-3">
                <span class="size-8 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-sm font-bold text-orange-600">📝</span>
                <h2 class="text-xl font-semibold">Overlay + Caption Gallery</h2>
                <span class="text-xs text-zinc-400">fade / slide / zoom captions</span>
            </div>

            @php
            $captionGallery = [
                ['effect' => 'caption-fade', 'label' => 'Fade Caption', 'caption' => 'Beautiful Landscape'],
                ['effect' => 'caption-slide-up', 'label' => 'Slide Up', 'caption' => 'Mountain Sunrise'],
                ['effect' => 'caption-slide-down', 'label' => 'Slide Down', 'caption' => 'Ocean View'],
                ['effect' => 'caption-slide-left', 'label' => 'Slide Left', 'caption' => 'City Lights'],
                ['effect' => 'caption-slide-right', 'label' => 'Slide Right', 'caption' => 'Forest Path'],
                ['effect' => 'caption-zoom', 'label' => 'Zoom Caption', 'caption' => 'Starry Night'],
            ];
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
                @foreach ($captionGallery as $item)
                <gsmui:hover.gallery effect="{{ $item['effect'] }}" caption="{{ $item['caption'] }}" class="aspect-[4/3] rounded-lg overflow-hidden bg-zinc-300 dark:bg-zinc-700">
                    <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-teal-600"></div>
                </gsmui:hover.gallery>
                @endforeach
            </div>
        </section>

        {{-- ======================== STATS ======================== --}}
        <footer class="pt-8 border-t border-zinc-200 dark:border-zinc-800 text-center text-xs text-zinc-400 space-y-1">
            @php
            $total2D = count($effects2D) + count($shadowEffects) + count($borderEffects) + count($bgEffects) + count($filterEffects);
            $total3D = count($effects3D);
            $totalGallery = count($galleryEffects) + count($captionGallery);
            $totalVariants = $total2D + $total3D + $totalGallery;
            @endphp
            <p class="text-sm font-medium text-zinc-500">{{ $totalVariants }}+ hover variants</p>
            <p><span class="font-medium">{{ $total2D }}</span> 2D · <span class="font-medium">{{ $total3D }}</span> 3D · <span class="font-medium">{{ $totalGallery }}</span> gallery</p>
            <p class="mt-2">gsmui:hover · gsmui:hover.3d · gsmui:hover.gallery</p>
        </footer>

    </div>
</body>
</html>
