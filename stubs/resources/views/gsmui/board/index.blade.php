@blaze(fold: true)

@props([
    'type'  => 'whiteboard',
    'width'  => '400',
    'height' => '300',
    'bg'     => 'white',
])

@php
$bgMap = [
    'whiteboard' => '#ffffff',
    'blackboard' => '#1e3a2f',
    'chalkboard' => '#2b2b2b',
    'artboard'   => '#ffffff',
    'drawboard'  => '#ffffff',
    'sketchboard' => '#fdf6e3',
    'paintboard'  => '#ffffff',
    'canvasboard' => '#f5f0e1',
    'noteboard'   => '#fffbeb',
    'corkboard'   => '#c8a06a',
    'pinboard'    => '#c8a06a',
    'moodboard'   => '#f3f4f6',
    'storyboard'  => '#ffffff',
    'mindboard'   => '#ffffff',
    'gridboard'   => '#ffffff',
    'dotboard'    => '#ffffff',
    'graphboard'  => '#ffffff',
    'musicboard'  => '#ffffff',
    'scoreboard'  => '#111827',
    'dashboard'   => '#f9fafb',
    'chartboard'  => '#ffffff',
];

$patternMap = [
    'storyboard' => 'linear-gradient(to right, #e5e7eb 10px, transparent 10px), linear-gradient(to bottom, #e5e7eb 10px, transparent 10px)',
    'gridboard'  => 'linear-gradient(to right, #e5e7eb 1px, transparent 1px), linear-gradient(to bottom, #e5e7eb 1px, transparent 1px)',
    'dotboard'   => 'radial-gradient(circle, #9ca3af 1px, transparent 1px)',
    'graphboard' => 'linear-gradient(to right, #e5e7eb 1px, transparent 1px), linear-gradient(to bottom, #e5e7eb 1px, transparent 1px)',
    'musicboard' => 'repeating-linear-gradient(transparent, transparent 3px, #9ca3af 3px, #9ca3af 4px)',
];

$patternSizeMap = [
    'storyboard' => '110px 110px',
    'gridboard'  => '20px 20px',
    'dotboard'   => '20px 20px',
    'graphboard' => '20px 20px',
    'musicboard' => '100% 4px',
];

$bg = $bgMap[$type] ?? '#ffffff';
$pattern = $patternMap[$type] ?? null;
$patternSize = $patternSizeMap[$type] ?? null;

$style = 'background-color: ' . $bg;
if ($pattern) {
    $style .= '; background-image: ' . $pattern;
    if ($patternSize) {
        $style .= '; background-size: ' . $patternSize;
    }
}

$classes = Gsmui::classes()
    ->add('relative inline-block rounded-lg overflow-hidden shadow-sm')
    ->add('border border-zinc-200 dark:border-white/10');

if ($type === 'artboard') {
    $classes->add('border-2 border-zinc-300 dark:border-white/20');
}

$defaultStroke = '#000000';
if ($type === 'scoreboard') {
    $defaultStroke = '#ffffff';
}
@endphp

<div
    {{ $attributes->class($classes) }}
    data-gsmui-board
    data-gsmui-board-type="{{ $type }}"
>
    <canvas
        x-ref="canvas"
        :width="width"
        :height="height"
        :style="`{{ $style }}`"
        class="block w-full cursor-crosshair touch-none"
        x-data="{
            drawing: false,
            lastX: 0,
            lastY: 0,
            shapeStartX: 0,
            shapeStartY: 0,
            strokeColor: '{{ $defaultStroke }}',
            strokeWidth: 2,
            strokeOpacity: 1,
            bgColor: '{{ $bg }}',
            init() {
                const c = this.$refs.canvas;
                c.addEventListener('pointerdown', e => {
                    const r = c.getBoundingClientRect();
                    const scaleX = c.width / r.width;
                    const scaleY = c.height / r.height;
                    const x = (e.clientX - r.left) * scaleX;
                    const y = (e.clientY - r.top)  * scaleY;
                    this.drawing = true;
                    this.shapeStartX = x;
                    this.shapeStartY = y;
                    this.lastX = x;
                    this.lastY = y;
                });
                c.addEventListener('pointermove', e => {
                    if (!this.drawing) return;
                    const r = c.getBoundingClientRect();
                    const scaleX = c.width / r.width;
                    const scaleY = c.height / r.height;
                    const x = (e.clientX - r.left) * scaleX;
                    const y = (e.clientY - r.top)  * scaleY;
                    this.draw(this.lastX, this.lastY, x, y);
                    this.lastX = x;
                    this.lastY = y;
                });
                c.addEventListener('pointerup',    () => { this.drawing = false; });
                c.addEventListener('pointerleave', () => { this.drawing = false; });
            },
            draw(x1, y1, x2, y2) {
                const ctx = this.$refs.canvas.getContext('2d');
                ctx.strokeStyle = this.strokeColor;
                ctx.lineWidth   = this.strokeWidth;
                ctx.lineCap     = 'round';
                ctx.lineJoin    = 'round';
                ctx.globalAlpha = this.strokeOpacity;
                ctx.beginPath();
                ctx.globalCompositeOperation = 'source-over';
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();
                ctx.globalAlpha = 1;
                ctx.globalCompositeOperation = 'source-over';
            },
        }"
    ></canvas>
</div>
