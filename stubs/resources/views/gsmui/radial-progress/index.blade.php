@props([
    'size' => 'md',
])

@php
$variants = [
    // Basic styles
    ['id' => 'basic', 'name' => 'Basic', 'category' => 'Basic', 'desc' => 'Standard radial progress indicator.'],
    ['id' => 'minimal', 'name' => 'Minimal', 'category' => 'Basic', 'desc' => 'Clean, minimal design.'],
    ['id' => 'flat', 'name' => 'Flat', 'category' => 'Basic', 'desc' => 'Flat design style.'],
    ['id' => 'thick', 'name' => 'Thick', 'category' => 'Basic', 'desc' => 'Thick stroke indicator.'],
    ['id' => 'thin', 'name' => 'Thin', 'category' => 'Basic', 'desc' => 'Thin stroke indicator.'],
    ['id' => 'raised', 'name' => 'Raised', 'category' => 'Basic', 'desc' => 'Elevated with shadow.'],
    ['id' => 'inset', 'name' => 'Inset', 'category' => 'Basic', 'desc' => 'Recessed design.'],
    
    // Gradient styles
    ['id' => 'gradient', 'name' => 'Gradient', 'category' => 'Gradient', 'desc' => 'Gradient stroke effect.'],
    ['id' => 'gradient-rainbow', 'name' => 'Rainbow Gradient', 'category' => 'Gradient', 'desc' => 'Rainbow gradient effect.'],
    ['id' => 'gradient-ring', 'name' => 'Gradient Ring', 'category' => 'Gradient', 'desc' => 'Double gradient rings.'],
    ['id' => 'sunset-gradient', 'name' => 'Sunset Gradient', 'category' => 'Gradient', 'desc' => 'Warm sunset colors.'],
    ['id' => 'multi-color', 'name' => 'Multi Color', 'category' => 'Gradient', 'desc' => 'Multiple color segments.'],
    ['id' => 'multi-stop', 'name' => 'Multi Stop', 'category' => 'Gradient', 'desc' => 'Multi-stop gradient.'],
    ['id' => 'prism', 'name' => 'Prism', 'category' => 'Gradient', 'desc' => 'Prismatic light effect.'],
    ['id' => 'spectrum', 'name' => 'Spectrum', 'category' => 'Gradient', 'desc' => 'Color spectrum display.'],
    
    // Animation styles
    ['id' => 'animated', 'name' => 'Animated', 'category' => 'Animation', 'desc' => 'Animated transitions.'],
    ['id' => 'pulse', 'name' => 'Pulse', 'category' => 'Animation', 'desc' => 'Pulsing animation.'],
    ['id' => 'pulsar', 'name' => 'Pulsar', 'category' => 'Animation', 'desc' => 'Pulsing ring effect.'],
    ['id' => 'bounce', 'name' => 'Bounce', 'category' => 'Animation', 'desc' => 'Bounce animation.'],
    ['id' => 'breathing', 'name' => 'Breathing', 'category' => 'Animation', 'desc' => 'Breathing effect.'],
    ['id' => 'spin', 'name' => 'Spin', 'category' => 'Animation', 'desc' => 'Spinning animation.'],
    ['id' => 'elastic', 'name' => 'Elastic', 'category' => 'Animation', 'desc' => 'Elastic spring effect.'],
    ['id' => 'draw', 'name' => 'Draw', 'category' => 'Animation', 'desc' => 'Drawing animation.'],
    ['id' => 'slide', 'name' => 'Slide', 'category' => 'Animation', 'desc' => 'Sliding transition.'],
    ['id' => 'confetti', 'name' => 'Confetti', 'category' => 'Animation', 'desc' => 'Confetti burst effect.'],
    ['id' => 'particles', 'name' => 'Particles', 'category' => 'Animation', 'desc' => 'Particle effect.'],
    ['id' => 'ripple', 'name' => 'Ripple', 'category' => 'Animation', 'desc' => 'Ripple wave effect.'],
    ['id' => 'wave', 'name' => 'Wave', 'category' => 'Animation', 'desc' => 'Wave animation.'],
    ['id' => 'waveform', 'name' => 'Waveform', 'category' => 'Animation', 'desc' => 'Audio waveform style.'],
    
    // Segmented styles
    ['id' => 'segmented', 'name' => 'Segmented', 'category' => 'Segmented', 'desc' => 'Segmented track.'],
    ['id' => 'segmented-ring', 'name' => 'Segmented Ring', 'category' => 'Segmented', 'desc' => 'Segmented ring design.'],
    ['id' => 'segmented-fill', 'name' => 'Segmented Fill', 'category' => 'Segmented', 'desc' => 'Pie-slice segments.'],
    ['id' => 'dashed', 'name' => 'Dashed', 'category' => 'Segmented', 'desc' => 'Dashed track.'],
    ['id' => 'striped', 'name' => 'Striped', 'category' => 'Segmented', 'desc' => 'Striped pattern.'],
    ['id' => 'mosaic', 'name' => 'Mosaic', 'category' => 'Segmented', 'desc' => 'Mosaic block pattern.'],
    ['id' => 'spiral', 'name' => 'Spiral', 'category' => 'Segmented', 'desc' => 'Spiral segments.'],
    
    // Double/Multi ring
    ['id' => 'double', 'name' => 'Double', 'category' => 'Multi-Ring', 'desc' => 'Double ring design.'],
    ['id' => 'multi-ring', 'name' => 'Multi Ring', 'category' => 'Multi-Ring', 'desc' => 'Multiple concentric rings.'],
    ['id' => 'concentric', 'name' => 'Concentric', 'category' => 'Multi-Ring', 'desc' => 'Concentric circles.'],
    ['id' => 'circles-stack', 'name' => 'Circles Stack', 'category' => 'Multi-Ring', 'desc' => 'Stacked circle rings.'],
    
    // Display styles
    ['id' => 'counter', 'name' => 'Counter', 'category' => 'Display', 'desc' => 'With counter display.'],
    ['id' => 'stat', 'name' => 'Stat', 'category' => 'Display', 'desc' => 'Statistics display.'],
    ['id' => 'icon', 'name' => 'Icon', 'category' => 'Display', 'desc' => 'With icon center.'],
    ['id' => 'percentage-ring', 'name' => 'Percentage Ring', 'category' => 'Display', 'desc' => 'Large percentage text.'],
    ['id' => 'loading', 'name' => 'Loading', 'category' => 'Display', 'desc' => 'Loading indicator.'],
    ['id' => 'skeleton', 'name' => 'Skeleton', 'category' => 'Display', 'desc' => 'Skeleton loading state.'],
    ['id' => 'half', 'name' => 'Half', 'category' => 'Display', 'desc' => 'Half-circle gauge.'],
    ['id' => 'gauge', 'name' => 'Gauge', 'category' => 'Display', 'desc' => 'Gauge meter display.'],
    ['id' => 'speedometer', 'name' => 'Speedometer', 'category' => 'Display', 'desc' => 'Speedometer style.'],
    
    // Interactive
    ['id' => 'interactive', 'name' => 'Interactive', 'category' => 'Interactive', 'desc' => 'Interactive controls.'],
    ['id' => 'hoverable', 'name' => 'Hoverable', 'category' => 'Interactive', 'desc' => 'Hover effects.'],
    ['id' => 'responsive', 'name' => 'Responsive', 'category' => 'Interactive', 'desc' => 'Responsive sizing.'],
    ['id' => 'countdown', 'name' => 'Countdown', 'category' => 'Interactive', 'desc' => 'Countdown timer.'],
    ['id' => 'steps', 'name' => 'Steps', 'category' => 'Interactive', 'desc' => 'Step-based progress.'],
    
    // Glass/Effects
    ['id' => 'glass', 'name' => 'Glass', 'category' => 'Effects', 'desc' => 'Glassmorphism style.'],
    ['id' => 'glow', 'name' => 'Glow', 'category' => 'Effects', 'desc' => 'Glowing effect.'],
    ['id' => 'neon', 'name' => 'Neon', 'category' => 'Effects', 'desc' => 'Neon glow effect.'],
    ['id' => 'ring', 'name' => 'Ring', 'category' => 'Effects', 'desc' => 'Ring design.'],
    ['id' => 'donut', 'name' => 'Donut', 'category' => 'Effects', 'desc' => 'Donut chart style.'],
    ['id' => 'progressive', 'name' => 'Progressive', 'category' => 'Effects', 'desc' => 'Progressive reveal.'],
    
    // Cosmic/Space
    ['id' => 'galaxy', 'name' => 'Galaxy', 'category' => 'Cosmic', 'desc' => 'Galaxy-inspired design.'],
    ['id' => 'nebula', 'name' => 'Nebula', 'category' => 'Cosmic', 'desc' => 'Nebula cloud effect.'],
    ['id' => 'cosmos', 'name' => 'Cosmos', 'category' => 'Cosmic', 'desc' => 'Space cosmos design.'],
    ['id' => 'constellation', 'name' => 'Constellation', 'category' => 'Cosmic', 'desc' => 'Star constellation.'],
    ['id' => 'atomic', 'name' => 'Atomic', 'category' => 'Cosmic', 'desc' => 'Atomic orbital design.'],
    ['id' => 'orbit', 'name' => 'Orbit', 'category' => 'Cosmic', 'desc' => 'Orbital satellite.'],
    ['id' => 'vortex', 'name' => 'Vortex', 'category' => 'Cosmic', 'desc' => 'Swirling vortex.'],
    ['id' => 'helix', 'name' => 'Helix', 'category' => 'Cosmic', 'desc' => 'DNA helix design.'],
    
    // Celestial
    ['id' => 'sunrise', 'name' => 'Sunrise', 'category' => 'Celestial', 'desc' => 'Sunrise colors.'],
    ['id' => 'sunset', 'name' => 'Sunset', 'category' => 'Celestial', 'desc' => 'Sunset colors.'],
    ['id' => 'eclipse', 'name' => 'Eclipse', 'category' => 'Celestial', 'desc' => 'Eclipse effect.'],
    ['id' => 'comet', 'name' => 'Comet', 'category' => 'Celestial', 'desc' => 'Comet trail effect.'],
    ['id' => 'meteor', 'name' => 'Meteor', 'category' => 'Celestial', 'desc' => 'Meteor shower.'],
    ['id' => 'aurora', 'name' => 'Aurora', 'category' => 'Celestial', 'desc' => 'Aurora borealis.'],
    ['id' => 'plasma', 'name' => 'Plasma', 'category' => 'Celestial', 'desc' => 'Plasma energy effect.'],
    
    // Nature/Elements
    ['id' => 'fire', 'name' => 'Fire', 'category' => 'Nature', 'desc' => 'Fire element.'],
    ['id' => 'lava', 'name' => 'Lava', 'category' => 'Nature', 'desc' => 'Molten lava effect.'],
    ['id' => 'ice', 'name' => 'Ice', 'category' => 'Nature', 'desc' => 'Ice crystal design.'],
    ['id' => 'tundra', 'name' => 'Tundra', 'category' => 'Nature', 'desc' => 'Tundra ice theme.'],
    ['id' => 'ocean', 'name' => 'Ocean', 'category' => 'Nature', 'desc' => 'Ocean blue theme.'],
    ['id' => 'forest', 'name' => 'Forest', 'category' => 'Nature', 'desc' => 'Forest green theme.'],
    ['id' => 'spring', 'name' => 'Spring', 'category' => 'Seasons', 'desc' => 'Spring fresh green.'],
    ['id' => 'summer', 'name' => 'Summer', 'category' => 'Seasons', 'desc' => 'Summer warm orange.'],
    ['id' => 'autumn', 'name' => 'Autumn', 'category' => 'Seasons', 'desc' => 'Autumn amber tones.'],
    ['id' => 'winter', 'name' => 'Winter', 'category' => 'Seasons', 'desc' => 'Winter cool blue.'],
    ['id' => 'storm', 'name' => 'Storm', 'category' => 'Nature', 'desc' => 'Storm theme.'],
    
    // Shapes
    ['id' => 'heart', 'name' => 'Heart', 'category' => 'Shapes', 'desc' => 'Heart icon center.'],
    ['id' => 'star', 'name' => 'Star', 'category' => 'Shapes', 'desc' => 'Star indicators.'],
    ['id' => 'diamond', 'name' => 'Diamond', 'category' => 'Shapes', 'desc' => 'Diamond accents.'],
    ['id' => 'flower', 'name' => 'Flower', 'category' => 'Shapes', 'desc' => 'Flower petal design.'],
    ['id' => 'crystal', 'name' => 'Crystal', 'category' => 'Shapes', 'desc' => 'Faceted crystal.'],
    ['id' => 'marble', 'name' => 'Marble', 'category' => 'Shapes', 'desc' => 'Marble texture.'],
    
    // Functional
    ['id' => 'battery', 'name' => 'Battery', 'category' => 'Functional', 'desc' => 'Battery indicator.'],
    ['id' => 'clock', 'name' => 'Clock', 'category' => 'Functional', 'desc' => 'Clock face design.'],
    ['id' => 'gear', 'name' => 'Gear', 'category' => 'Functional', 'desc' => 'Gear mechanism.'],
    ['id' => 'target', 'name' => 'Target', 'category' => 'Functional', 'desc' => 'Bullseye target.'],
    
    // Radial patterns
    ['id' => 'radial-bars', 'name' => 'Radial Bars', 'category' => 'Radial', 'desc' => 'Bar segments radiating.'],
    ['id' => 'radial-dots', 'name' => 'Radial Dots', 'category' => 'Radial', 'desc' => 'Dots arranged in circle.'],
    ['id' => 'radial-arrows', 'name' => 'Radial Arrows', 'category' => 'Radial', 'desc' => 'Arrow segments.'],
    
    // Tech/Futuristic
    ['id' => 'cyberpunk', 'name' => 'Cyberpunk', 'category' => 'Tech', 'desc' => 'Cyberpunk neon style.'],
    ['id' => 'rainbow', 'name' => 'Rainbow', 'category' => 'Colors', 'desc' => 'Rainbow color effect.'],
    ['id' => 'gradient', 'name' => 'Gradient', 'category' => 'Colors', 'desc' => 'Color gradient.'],
];

$categories = collect($variants)->groupBy('category');
@endphp

<div {{ $attributes }}>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Radial Progress Components</h1>
        <p class="mt-2 text-zinc-500 dark:text-zinc-400">{{ count($variants) }} variants across {{ count($categories) }} categories</p>
    </div>
    
    @foreach($categories as $category => $items)
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white mb-4">{{ $category }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($items as $variant)
                    <a href="{{ route('gsmui.radial-progress.' . $variant['id']) }}" 
                       class="block p-4 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
                        <h3 class="font-medium text-zinc-900 dark:text-white">{{ $variant['name'] }}</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ $variant['desc'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
