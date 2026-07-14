@blaze(fold: true, unsafe: [
    'name', 'label', 'badge',
    'description', 'description:trailing',
    'label:badge', 'label:aside', 'label:trailing',
    'error:name', 'error:bag', 'error:message', 'error:icon', 'error:nested', 'error:deep',
])

@props([
    'value' => 0,
    'max' => 100,
    'color' => null,
    'label' => null,
    'description' => null,
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;

$trackClasses = Gsmui::classes()
    ->add('w-full bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden')
    ->add('h-2')
    ;

$barClasses = Gsmui::classes()
    ->add('h-full rounded-full transition-all duration-500 ease-out')
    ->add(match ($color) {
        'red' => 'bg-red-500',
        'orange' => 'bg-orange-500',
        'amber' => 'bg-amber-500',
        'yellow' => 'bg-yellow-500',
        'lime' => 'bg-lime-500',
        'green' => 'bg-green-500',
        'emerald' => 'bg-emerald-500',
        'teal' => 'bg-teal-500',
        'cyan' => 'bg-cyan-500',
        'sky' => 'bg-sky-500',
        'blue' => 'bg-blue-500',
        'indigo' => 'bg-indigo-500',
        'violet' => 'bg-violet-500',
        'purple' => 'bg-purple-500',
        'fuchsia' => 'bg-fuchsia-500',
        'pink' => 'bg-pink-500',
        'rose' => 'bg-rose-500',
        default => 'bg-blue-600 dark:bg-blue-500',
    })
    ;
@endphp

<gsmui:with-field :$attributes>
    <div {{ $attributes->only(['class', 'wire:model'])->class($trackClasses) }} data-gsmui-progress role="progressbar" aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="{{ $max }}">
        <div class="{{ $barClasses }}" style="width: {{ $percentage }}%"></div>
    </div>
</gsmui:with-field>
