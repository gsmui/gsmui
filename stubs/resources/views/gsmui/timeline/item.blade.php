@props([
    'status' => null,
    'align' => null,
    'size' => null,
])

@php
$classes = Gsmui::classes();

$leadingLineClasses = Gsmui::classes()
    ->add('[[data-gsmui-timeline-status=complete]+[data-gsmui-timeline-item]_&]:*:bg-accent')
    ->add('*:bg-zinc-200 dark:*:bg-zinc-700')
    ->add('[[data-gsmui-timeline][data-gsmui-timeline-size=lg]_&]:*:bg-zinc-100')
    ;

$trailingLineClasses = Gsmui::classes()
    ->add('[[data-gsmui-timeline-status=complete]_&]:*:bg-accent')
    ->add('*:bg-zinc-200 dark:*:bg-zinc-700')
    ->add('[[data-gsmui-timeline][data-gsmui-timeline-size=lg]_&]:*:bg-zinc-100')
    ;

$attributes = $attributes->merge([
    'data-gsmui-timeline-status' => $status,
]);

if ($align) {
    $attributes = $attributes->merge([
        'data-gsmui-timeline-align' => $align,
    ]);
}

if ($size) {
    $attributes = $attributes->merge([
        'data-gsmui-timeline-size' => $size,
    ]);
}
@endphp

<li {{ $attributes->class($classes) }} data-gsmui-timeline-item>
    <div class="{{ $leadingLineClasses }}" data-gsmui-timeline-line-leading>
        <div></div>
    </div>

    <div data-gsmui-timeline-gap-leading></div>

    {{ $slot }}

    <div class="{{ $trailingLineClasses }}" data-gsmui-timeline-line-trailing>
        <div></div>
    </div>

    <div data-gsmui-timeline-gap-trailing></div>
</li>