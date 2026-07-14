@props([
    'size' => 'md',
    'placeholder' => 'Pick an emoji...',
    'showPreview' => true,
    'recentEmojis' => [],
    'emojis' => null,
])

@php
    $sizes = ['sm' => 'text-lg', 'md' => 'text-xl', 'lg' => 'text-2xl'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    
    $allEmojis = [
        '😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩',
        '😘', '😗', '😚', '😙', '🥲', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐',
        '😐', '😑', '😶', '😏', '😒', '🙄', '😬', '🤥', '😌', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕',
        '🤢', '🤮', '🥵', '🥶', '🥴', '😵', '🤯', '🤠', '🥳', '🥸', '😎', '🤓', '🧐', '😕', '😟', '🙁',
        '😮', '😯', '😲', '😳', '🥺', '🥹', '😦', '😧', '😨', '😰', '😥', '😢', '😭', '😱', '😖', '😣',
        '😞', '😓', '😩', '😫', '🥱', '😤', '😡', '😠', '🤬', '😈', '👿', '💀', '☠️', '💩', '🤡', '👹',
        '👍', '👎', '👊', '✊', '🤛', '🤜', '👏', '🙌', '👐', '🤲', '🤝', '🙏', '💪', '❤️', '🧡', '💛',
        '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '💟',
        '🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐸', '🐵', '🙈',
        '🍕', '🍔', '🍟', '🌭', '🥪', '🌮', '🌯', '🍣', '🍱', '🍜', '🍝', '🍦', '🍩', '🍪', '🎂', '🍰',
        '⚽', '🏀', '🏈', '⚾', '🎾', '🏐', '🎮', '🎯', '🎲', '🧩', '🎸', '🎹', '🎺', '🎻', '🎬', '🎤',
        '🚗', '🚕', '🚌', '✈️', '🚀', '🚢', '🏠', '🏢', '🏨', '🏥', '🏫', '🏭', '🗼', '🗽', '⛪', '🕌',
        '💡', '🔦', '💰', '💳', '🔧', '🔩', '⚙️', '🔫', '💣', '🔪', '🗡️', '🛡️', '🔬', '🔭', '💊', '💉',
        '❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘',
        '🏁', '🚩', '🎌', '🏴', '🏳️', '🇺🇸', '🇬🇧', '🇫🇷', '🇩🇪', '🇮🇹', '🇪🇸', '🇷🇺', '🇨🇳', '🇯🇵', '🇰🇷', '🇮🇳',
    ];
    
    // Emoji name mappings for search
    $emojiNames = [
        '😀' => 'grinning face smile happy',
        '😃' => 'smiley face smile happy',
        '😄' => 'smile happy joy',
        '😁' => 'grin beam smile',
        '😆' => 'laughing satisfied',
        '😅' => 'sweat smile relief',
        '🤣' => 'rofl rolling floor laughing',
        '😂' => 'joy tears laugh',
        '🙂' => 'slightly smiling',
        '🙃' => 'upside down',
        '😉' => 'wink',
        '😊' => 'blush smile happy',
        '😇' => 'innocent angel',
        '🥰' => 'love adore hearts',
        '😍' => 'heart eyes love',
        '🤩' => 'star struck excited',
        '😘' => 'kiss blowing',
        '😗' => 'kiss',
        '😚' => 'kiss closed eyes',
        '😙' => 'kiss smile',
        '🥲' => 'touched smile',
        '😋' => 'yummy delicious tongue',
        '😛' => 'tongue playful',
        '😜' => 'wink tongue crazy',
        '🤪' => 'crazy zany wild',
        '😝' => 'tongue squinting',
        '🤑' => 'money mouth rich',
        '🤗' => 'hug embrace',
        '🤭' => 'oops giggle',
        '🤫' => 'shush quiet secret',
        '🤔' => 'thinking hmmm',
        '🤐' => 'zip mouth sealed',
        '🤨' => 'raised eyebrow skeptical',
        '😐' => 'neutral expressionless',
        '😑' => 'expressionless blank',
        '😶' => 'no mouth silent',
        '😏' => 'smirk suggestive',
        '😒' => 'unamused bored',
        '🙄' => 'eye roll',
        '😬' => 'grimace awkward',
        '🤥' => 'lying pinocchio',
        '😌' => 'relieved peaceful',
        '😔' => 'pensive sad',
        '😪' => 'sleepy tired',
        '🤤' => 'drool hungry',
        '😴' => 'sleeping zzz',
        '😷' => 'mask sick covid',
        '🤒' => 'thermometer sick fever',
        '🤕' => 'head bandage hurt',
        '🤢' => 'nauseated sick',
        '🤮' => 'vomit sick throw',
        '🥵' => 'hot sweating heat',
        '🥶' => 'cold freezing ice',
        '🥴' => 'woozy dizzy drunk',
        '😵' => 'dizzy dead',
        '🤯' => 'mind blown exploding',
        '🤠' => 'cowboy hat western',
        '🥳' => 'party celebration cake',
        '🥸' => 'disguise glasses nose',
        '😎' => 'cool sunglasses',
        '🤓' => 'nerd smart geek',
        '🧐' => 'monocle thinking',
        '😕' => 'confused puzzled',
        '😟' => 'worried concerned',
        '🙁' => 'slightly frowning sad',
        '😮' => 'open mouth surprised',
        '😯' => 'hushed surprised',
        '😲' => 'astonished shocked',
        '😳' => 'flushed embarrassed',
        '🥺' => 'pleading puppy eyes',
        '😦' => 'frowning surprised',
        '😧' => 'anguished upset',
        '😨' => 'fearful scared',
        '😰' => 'anxious sweating nervous',
        '😥' => 'sad relieved',
        '😢' => 'cry sad tear',
        '😭' => 'sobbing crying loud',
        '😱' => 'scream horror',
        '😖' => 'confounded frustrated',
        '😣' => 'persevere struggling',
        '😞' => 'disappointed sad',
        '😓' => 'downcast sweating',
        '😩' => 'weary tired',
        '😫' => 'tired exhausted',
        '🥱' => 'yawn sleepy',
        '😤' => 'angry triumph frustrated',
        '😡' => 'angry rage mad',
        '😠' => 'angry mad',
        '🤬' => 'cursing swearing',
        '😈' => 'devil evil smirk',
        '👿' => 'angry devil evil',
        '💀' => 'skull dead',
        '☠️' => 'skull crossbones danger',
        '💩' => 'poop poo',
        '🤡' => 'clown joker',
        '👹' => 'ogre monster',
        '👺' => 'goblin angry',
        '👻' => 'ghost halloween spooky',
        '👽' => 'alien ufo space',
        '👾' => 'alien monster game',
        '🤖' => 'robot bot',
        '👍' => 'thumbs up like good yes',
        '👎' => 'thumbs down dislike no',
        '👊' => 'fist punch bump',
        '✊' => 'raised fist solidarity',
        '🤛' => 'fist bump left',
        '🤜' => 'fist bump right',
        '👏' => 'clap applause bravo',
        '🙌' => 'raised hands hooray celebration',
        '👐' => 'open hands',
        '🤲' => 'palms up together',
        '🤝' => 'handshake agreement deal',
        '🙏' => 'prayer please thank you',
        '💪' => 'muscle strong flex',
        '❤️' => 'red heart love',
        '🧡' => 'orange heart',
        '💛' => 'yellow heart',
        '💚' => 'green heart',
        '💙' => 'blue heart',
        '💜' => 'purple heart',
        '🖤' => 'black heart',
        '🤍' => 'white heart',
        '🤎' => 'brown heart',
        '💔' => 'broken heart sad',
        '❣️' => 'heart exclamation',
        '💕' => 'two hearts love',
        '💞' => 'revolving hearts',
        '💓' => 'beating heart pulse',
        '💗' => 'growing heart',
        '💖' => 'sparkling heart',
        '💘' => 'heart arrow cupid',
        '💝' => 'heart ribbon gift',
        '🐶' => 'dog puppy pet',
        '🐱' => 'cat kitten pet',
        '🐭' => 'mouse',
        '🐹' => 'hamster',
        '🐰' => 'rabbit bunny',
        '🦊' => 'fox',
        '🐻' => 'bear',
        '🐼' => 'panda',
        '🐨' => 'koala',
        '🐯' => 'tiger',
        '🦁' => 'lion',
        '🐮' => 'cow',
        '🐷' => 'pig',
        '🐸' => 'frog',
        '🐵' => 'monkey',
        '🍕' => 'pizza food',
        '🍔' => 'burger hamburger food',
        '🍟' => 'fries french fries food',
        '🌮' => 'taco mexican food',
        '🍣' => 'sushi japanese food',
        '🍜' => 'noodles ramen food',
        '🍦' => 'ice cream dessert',
        '🍩' => 'donut dessert sweet',
        '🎂' => 'cake birthday celebration',
        '⚽' => 'soccer ball football sport',
        '🏀' => 'basketball sport',
        '🏈' => 'american football sport',
        '🎮' => 'video game controller play',
        '🎯' => 'dart bullseye target',
        '🎲' => 'dice game',
        '🎸' => 'guitar music',
        '🎹' => 'piano keyboard music',
        '🎬' => 'movie film clapper',
        '🎤' => 'microphone karaoke',
        '🚗' => 'car automobile',
        '🚌' => 'bus',
        '✈️' => 'airplane flight fly',
        '🚀' => 'rocket space launch',
        '🏠' => 'house home',
        '🏨' => 'hotel',
        '🏥' => 'hospital',
        '💡' => 'light bulb idea',
        '🔦' => 'flashlight torch',
        '💰' => 'money bag',
        '💳' => 'credit card',
        '🔧' => 'wrench tool',
        '🔑' => 'key',
        '🔒' => 'lock secure',
        '✅' => 'check mark done complete yes',
        '❌' => 'cross mark no wrong',
        '⭕' => 'circle red',
        '🛑' => 'stop sign',
        '⚠️' => 'warning caution alert',
        '🏁' => 'checkered flag finish race',
        '🚩' => 'red flag',
        '🏳️' => 'white flag surrender',
        '🇺🇸' => 'united states america flag',
        '🇬🇧' => 'united kingdom britain flag',
        '🇫🇷' => 'france french flag',
        '🇩🇪' => 'germany german flag',
        '🇯🇵' => 'japan japanese flag',
        '🇨🇳' => 'china chinese flag',
    ];
@endphp

<div 
    {{ $attributes->class(["relative"]) }}
    x-data="{ 
        selected: '', 
        search: '',
        showPicker: false,
        preview: null,
        emojis: {{ json_encode($allEmojis) }},
        emojiNames: {{ json_encode($emojiNames) }},
        filteredEmojis() {
            if (!this.search) return this.emojis;
            const query = this.search.toLowerCase();
            return this.emojis.filter(e => {
                const name = this.emojiNames[e] || '';
                return e.includes(this.search) || name.toLowerCase().includes(query);
            });
        }
    }"
>
    {{-- Trigger Button --}}
    <button 
        @click="showPicker = !showPicker"
        class="flex items-center gap-2 px-3 py-2 bg-zinc-100 dark:bg-zinc-700 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors"
    >
        @if($selected)
            <span class="{{ $sizeClass }}">{{ $selected }}</span>
        @else
            <span class="{{ $sizeClass }} text-zinc-400">😀</span>
        @endif
        <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $placeholder }}</span>
    </button>

    {{-- Picker Dropdown --}}
    <div 
        x-show="showPicker"
        @click.away="showPicker = false"
        x-transition
        class="absolute z-50 mt-2 w-80 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-xl overflow-hidden"
    >
        {{-- Search --}}
        <div class="p-2 border-b border-zinc-200 dark:border-zinc-700">
            <input 
                type="text"
                x-model="search"
                placeholder="Search..."
                class="w-full px-3 py-2 text-sm bg-zinc-100 dark:bg-zinc-700 rounded-lg border-0 focus:ring-2 focus:ring-blue-500"
            />
        </div>

        {{-- Emoji Grid --}}
        <div class="p-2 max-h-64 overflow-y-auto">
            <div class="grid grid-cols-8 gap-1">
                <template x-for="emoji in filteredEmojis()" :key="emoji">
                    <button 
                        @click="selected = emoji; showPicker = false; $dispatch('emoji-select', emoji)"
                        @mouseenter="preview = emoji"
                        @mouseleave="preview = null"
                        class="flex items-center justify-center w-9 h-9 text-xl rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                        x-text="emoji"
                    ></button>
                </template>
            </div>
        </div>

        {{-- Preview --}}
        @if($showPreview)
            <div class="p-2 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-center h-16">
                <template x-if="preview">
                    <span class="text-4xl" x-text="preview"></span>
                </template>
                <template x-if="!preview">
                    <span class="text-sm text-zinc-400">Hover to preview</span>
                </template>
            </div>
        @endif
    </div>
</div>
