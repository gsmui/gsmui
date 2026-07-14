@blaze(unsafe: [
    // flux:with-field props
    'name', 'label', 'badge',
    'description', 'description:trailing',
    'label:badge', 'label:aside', 'label:trailing',
    'error:name', 'error:bag', 'error:message', 'error:icon', 'error:nested', 'error:deep',
])

@props([
    'toolbar' => null,
    'invalid' => null,
    'variant' => null,
    'name' => null,
])

@php
// We only want to show the name attribute on the checkbox if it has been set
// manually, but not if it has been set from the wire:model attribute...
$showName = isset($name);

if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$invalid ??= ($name && $errors->has($name));

$classes = Gsmui::classes()
    ->add('block w-full')
    ->add(match($variant) {
        'borderless' => [
            '**:data-[slot=content]:p-2!',
        ],
        default => [
            'shadow-xs [&[disabled]]:shadow-none border rounded-lg',
            'bg-white dark:bg-white/10 dark:[&[disabled]]:bg-white/[7%]',
            $invalid ? 'border-red-500' : 'border-zinc-200 border-b-zinc-300/80 dark:border-white/10',
        ],
    })
    ->add('**:data-[slot=content]:text-base! sm:**:data-[slot=content]:text-sm!')
    ->add('**:data-[slot=content]:text-zinc-700 dark:**:data-[slot=content]:text-zinc-300')
    ->add('[&[disabled]_[data-slot=content]]:text-zinc-500 dark:[&[disabled]_[data-slot=content]]:text-zinc-400')
    ;
@endphp

<gsmui:with-field :$attributes>
    <ui-editor {{ $attributes->class($classes) }} @if($showName) name="{{ $name }}" @endif aria-label="{{ __('Rich text editor') }}" data-gsmui-control data-gsmui-editor>
        <?php if ($slot->isEmpty()): ?>
            <gsmui:editor.toolbar :items="$toolbar" />

            <gsmui:editor.content />
        <?php else: ?>
            {{ $slot }}
        <?php endif; ?>
    </ui-editor>
</gsmui:with-field>

@assets
<gsmui:editor.scripts />
<gsmui:editor.styles />
@endassets
