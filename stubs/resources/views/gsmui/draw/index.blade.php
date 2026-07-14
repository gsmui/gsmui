@blaze(fold: true)

@props([
    'tool'   => 'pencil',
    'color'  => 'black',
    'size'   => 'sm',
    'width'  => '400',
    'height' => '300',
    'bg'     => 'white',
])

@php
$colorMap = [
    'black' => '#000000',
    'red' => '#ef4444',
    'orange' => '#f97316',
    'yellow' => '#eab308',
    'green' => '#22c55e',
    'blue' => '#3b82f6',
    'purple' => '#a855f7',
    'pink' => '#ec4899',
    'brown' => '#78350f',
    'gray' => '#6b7280',
    'white' => '#ffffff',
    'gold' => '#ca8a04',
];

$hex = $colorMap[$color] ?? '#000000';

$toolOpacity = match ($tool) {
    'eraser' => '0.35',
    'pencil-eraser' => '0.7',
    default => '1',
};

$classes = Gsmui::classes()
    ->add('relative inline-block rounded-lg overflow-hidden shadow-sm')
    ->add('border border-zinc-200 dark:border-white/10')
    ->add('bg-white dark:bg-zinc-800');
@endphp

<div
    {{ $attributes->class($classes) }}
    data-gsmui-draw
    data-tool="{{ $tool }}"
    data-color="{{ $color }}"
    data-size="{{ $size }}"
>
    <canvas
        x-ref="canvas"
        :width="width"
        :height="height"
        :style="`background-color: ${bg}`"
        class="block w-full cursor-crosshair touch-none"
        x-data="{
            drawing: false,
            lastX: 0,
            lastY: 0,
            shapeStartX: 0,
            shapeStartY: 0,
            tool: '{{ $tool }}',
            strokeColor: '{{ $hex }}',
            strokeWidth: {{ $size === 'lg' ? 6 : 2 }},
            strokeOpacity: {{ $toolOpacity }},
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
                    if (this.tool === 'fill') {
                        this.floodFill(Math.round(x), Math.round(y));
                        this.drawing = false;
                    }
                    if (['text', 'select', 'stamp'].includes(this.tool)) {
                        this.drawing = false;
                    }
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
                if (this.tool === 'eraser' || this.tool === 'pencil-eraser') {
                    ctx.globalCompositeOperation = 'destination-out';
                    ctx.lineWidth = this.tool === 'eraser' ? this.strokeWidth * 4 : this.strokeWidth * 2;
                } else {
                    ctx.globalCompositeOperation = 'source-over';
                }
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();
                ctx.globalAlpha = 1;
                ctx.globalCompositeOperation = 'source-over';
            },
            floodFill(x, y) {
                const ctx = this.$refs.canvas.getContext('2d');
                ctx.fillStyle = this.strokeColor;
                ctx.fillRect(0, 0, this.$refs.canvas.width, this.$refs.canvas.height);
            },
        }"
    ></canvas>
</div>
