@props([
    'items' => [],
    'layout' => 'horizontal', // horizontal, vertical, grid
    'labelWidth' => '160px',
    'divide' => true,
    'colon' => false,
    'class' => '',
])

<?php
$layoutClasses = match($layout) {
    'horizontal' => 'grid grid-cols-[max-content_1fr] gap-x-4 gap-y-2',
    'vertical' => 'space-y-3',
    'grid' => 'grid grid-cols-2 gap-x-4 gap-y-3 sm:grid-cols-4 lg:grid-cols-6',
    default => 'grid grid-cols-[max-content_1fr] gap-x-4 gap-y-2',
};

$labelColon = $colon ? ':' : '';
?>

<div 
    class="gsmui-description-list {{ $class }}"
    data-layout="{{ $layout }}"
>
    @if($layout === 'horizontal')
        <dl class="{{ $layoutClasses }}" style="--label-width: {{ $labelWidth }};">
            @foreach($items as $item)
                <div class="flex items-start gap-3">
                    <dt class="text-sm font-medium text-zinc-600 dark:text-zinc-400 shrink-0" style="width: {{ $labelWidth }};">
                        {{ $item['label'] }}{{ $labelColon }}
                    </dt>
                    <dd class="text-sm text-zinc-900 dark:text-white flex-1 min-w-0 {{ $item['class'] ?? '' }}">
                        @if($item['copyable'])
                            <div class="flex items-center gap-2">
                                <span class="truncate block">{{ $item['value'] }}</span>
                                <button 
                                    type="button"
                                    class="p-1.5 rounded text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors"
                                    onclick="navigator.clipboard.writeText('{{ addslashes($item['value']) }}')"
                                    aria-label="Copy to clipboard"
                                    title="Copy"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                </button>
                            </div>
                        @elseif($item['href'])
                            <a href="{{ $item['href'] }}" class="text-primary hover:underline">{{ $item['value'] }}</a>
                        @else
                            {{ $item['value'] }}
                        @endif
                        
                        @if($item['variant'])
                            <x-gsmui:badge variant="{{ $item['variant'] }}" size="sm" class="ml-2">{{ $item['variant'] }}</x-gsmui:badge>
                        @endif
                    </dd>
                </div>
                @if($divide && !$loop->last)
                    <hr class="border-zinc-200 dark:border-zinc-700" />
                @endif
            @endforeach
        </dl>
    @elseif($layout === 'vertical')
        <dl class="{{ $layoutClasses }}">
            @foreach($items as $item)
                <div>
                    <dt class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-1">
                        {{ $item['label'] }}{{ $labelColon }}
                    </dt>
                    <dd class="text-sm text-zinc-900 dark:text-white ml-0 {{ $item['class'] ?? '' }}">
                        @if($item['copyable'])
                            <div class="flex items-center gap-2">
                                <span class="truncate block">{{ $item['value'] }}</span>
                                <button 
                                    type="button"
                                    class="p-1.5 rounded text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors"
                                    onclick="navigator.clipboard.writeText('{{ addslashes($item['value']) }}')"
                                    aria-label="Copy to clipboard"
                                    title="Copy"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                </button>
                            </div>
                        @elseif($item['href'])
                            <a href="{{ $item['href'] }}" class="text-primary hover:underline">{{ $item['value'] }}</a>
                        @else
                            {{ $item['value'] }}
                        @endif
                        
                        @if($item['variant'])
                            <x-gsmui:badge variant="{{ $item['variant'] }}" size="sm" class="mt-1 inline-block">{{ $item['variant'] }}</x-gsmui:badge>
                        @endif
                    </dd>
                    @if($divide && !$loop->last)
                        <hr class="border-zinc-200 dark:border-zinc-700 mt-3" />
                    @endif
                </div>
            @endforeach
        </dl>
    @else
        <dl class="{{ $layoutClasses }}">
            @foreach($items as $item)
                <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                    <dt class="text-sm font-medium text-zinc-600 dark:text-zinc-400">
                        {{ $item['label'] }}{{ $labelColon }}
                    </dt>
                    <dd class="text-sm text-zinc-900 dark:text-white mt-0.5 {{ $item['class'] ?? '' }}">
                        @if($item['copyable'])
                            <div class="flex items-center gap-2">
                                <span class="truncate block">{{ $item['value'] }}</span>
                                <button 
                                    type="button"
                                    class="p-1.5 rounded text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors"
                                    onclick="navigator.clipboard.writeText('{{ addslashes($item['value']) }}')"
                                    aria-label="Copy to clipboard"
                                    title="Copy"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                </button>
                            </div>
                        @elseif($item['href'])
                            <a href="{{ $item['href'] }}" class="text-primary hover:underline">{{ $item['value'] }}</a>
                        @else
                            {{ $item['value'] }}
                        @endif
                        
                        @if($item['variant'])
                            <x-gsmui:badge variant="{{ $item['variant'] }}" size="sm" class="mt-1 inline-block">{{ $item['variant'] }}</x-gsmui:badge>
                        @endif
                    </dd>
                </div>
            @endforeach
        </dl>
    @endif
</div>