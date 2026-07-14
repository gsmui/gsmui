@blaze(fold: true, unsafe: [
    // flux:with-field props
    'name', 'label', 'badge',
    'description', 'description:trailing',
    'label:badge', 'label:aside', 'label:trailing',
    'error:name', 'error:bag', 'error:message', 'error:icon', 'error:nested', 'error:deep',
])

@props(['range' => false])

@php
$classes = Gsmui::classes()
    ->add('flex flex-col justify-center w-full [:where(&)]:min-h-4 isolate select-none [&[disabled]]:opacity-50 touch-none')
    ;

$trackClasses = Gsmui::classes()
    ->add('shrink-0 relative [:where(&)]:h-1.5 bg-zinc-200 rounded-full dark:bg-white/10 select-none')
    ->add($attributes->pluck('track:class'))
    ;

$indicatorWrapperClasses = Gsmui::classes()
    ->add('relative w-full h-full rounded-full overflow-hidden select-none')
    ;

$indicatorClasses = Gsmui::classes()
    ->add('absolute inset-y-0 bg-accent')
    ;

$thumbClasses = Gsmui::classes()
    ->add('absolute top-1/2 [:where(&)]:size-4 rounded-full bg-white ring ring-black/15 shadow-[0px_1px_2px_0px_rgba(0,0,0,.05),0px_2px_4px_0px_rgba(0,0,0,.1)] select-none -translate-y-1/2 -translate-x-1/2 dark:ring-black/30 rtl:translate-x-1/2 has-focus-visible:outline-2 has-focus-visible:outline-[-webkit-focus-ring-color]')
    ->add($attributes->pluck('thumb:class'))
    ;
@endphp

<gsmui:with-field :$attributes>
    <ui-slider 
        {{ $attributes->class($classes) }}
        @if ($range) range @endif
        data-gsmui-control
        data-gsmui-slider
        tabindex="-1"
        data-gsmui-aria-range-start="{{ __('start range') }}"
        data-gsmui-aria-range-end="{{ __('end range') }}"
    >
        <div class="h-full flex flex-col justify-center" data-gsmui-slider-track>
            <div data-gsmui-slider-track class="{{ $trackClasses }}">
                <div class="{{ $indicatorWrapperClasses }}">
                    <div data-gsmui-slider-indicator class="{{ $indicatorClasses }}" wire:ignore></div>
                </div>
                
                <div data-gsmui-slider-thumb class="{{ $thumbClasses }}" wire:ignore>
                    <input type="range" class="sr-only" {{ $attributes->only(['min', 'max', 'step']) }} />
                </div>

                @if ($range)
                    <div data-gsmui-slider-thumb class="{{ $thumbClasses }}" wire:ignore>
                        <input type="range" class="sr-only" {{ $attributes->only(['min', 'max', 'step']) }} />
                    </div>
                @endif
            </div>
            
            {{-- Step marks --}}
            <?php if ($slot->isNotEmpty()): ?>
                <div class="relative grid *:col-start-1 *:row-start-1 select-none cursor-default">
                    {{ $slot }}
                </div>
            <?php endif; ?>
        </div>
    </ui-slider>
</gsmui:with-field>
