@props([
    'size' => 'md',
    'label' => null,
    'showSearch' => true,
    'columns' => 8,
    'emojis' => null,
])

<style>[x-cloak]{display:none!important}</style>

@php
    $sizes = ['xs' => 'text-lg', 'sm' => 'text-xl', 'md' => 'text-2xl', 'lg' => 'text-3xl', 'xl' => 'text-4xl'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    
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
    
    $categories = [
        'smileys' => [
            'name' => 'Smileys & People',
            'icon' => '😀',
            'emojis' => [
                '😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩',
                '😘', '😗', '😚', '😙', '🥲', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🫢', '🫣', '🤫',
                '🤔', '🫡', '🤐', '🤨', '😐', '😑', '😶', '🫥', '😏', '😒', '🙄', '😬', '🤥', '🫨', '😌', '😔',
                '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🥵', '🥶', '🥴', '😵', '🤯', '🤠', '🥳', '🥸',
                '😎', '🤓', '🧐', '😕', '🫤', '😟', '🙁', '😮', '😯', '😲', '😳', '🥺', '🥹', '😦', '😧', '😨',
                '😰', '😥', '😢', '😭', '😱', '😖', '😣', '😞', '😓', '😩', '😫', '🥱', '😤', '😡', '😠', '🤬',
                '😈', '👿', '💀', '☠️', '💩', '🤡', '👹', '👺', '👻', '👽', '👾', '🤖', '😺', '😸', '😹', '😻',
                '😼', '😽', '🙀', '😿', '😾', '🫶', '👋', '🤚', '🖐️', '✋', '🖖', '🫱', '🫲', '🫳', '🫴', '👌',
                '🤌', '🤏', '✌️', '🤞', '🫰', '🤟', '🤘', '🤙', '👈', '👉', '👆', '🖕', '👇', '☝️', '🫵', '👍',
                '👎', '✊', '👊', '🤛', '🤜', '👏', '🙌', '🫶', '👐', '🤲', '🤝', '🙏', '💪', '🦾', '🦿', '🦵',
                '🦶', '👂', '🦻', '👃', '🧠', '🫀', '🫁', '🦷', '🦴', '👀', '👁️', '👅', '👄', '🫦', '💋', '🩸',
            ],
        ],
        'nature' => [
            'name' => 'Animals & Nature',
            'icon' => '🐶',
            'emojis' => [
                '🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐻‍❄️', '🐨', '🐯', '🦁', '🐮', '🐷', '🐸', '🐵',
                '🙈', '🙉', '🙊', '🐒', '🐔', '🐧', '🐦', '🐤', '🐣', '🐥', '🦆', '🦅', '🦉', '🦇', '🐺', '🐗',
                '🐴', '🦄', '🐝', '🪱', '🐛', '🦋', '🐌', '🐞', '🐜', '🪲', '🪳', '🦟', '🦗', '🕷️', '🦂', '🐢',
                '🐍', '🦎', '🦖', '🦕', '🐙', '🦑', '🦐', '🦞', '🦀', '🐡', '🐠', '🐟', '🐬', '🐳', '🐋', '🦈',
                '🐊', '🐅', '🐆', '🦓', '🫏', '🦍', '🦧', '🐘', '🦣', '🦛', '🦏', '🐪', '🐫', '🦒', '🦘', '🦬',
                '🐃', '🐂', '🐄', '🐎', '🐖', '🐏', '🐑', '🦙', '🐐', '🦌', '🐕', '🐩', '🦮', '🐕‍🦺', '🐈', '🐈‍⬛',
                '🪶', '🐓', '🦃', '🦤', '🦚', '🦜', '🦢', '🪿', '🐸', '🐊', '🦎', '🐍', '🐲', '🐉', '🦕', '🦖',
                '🌵', '🎄', '🌲', '🌳', '🌴', '🪵', '🌱', '🌿', '☘️', '🍀', '🎍', '🪴', '🎋', '🍃', '🍂', '🍁',
                '🍄', '🪨', '🌾', '💐', '🌷', '🌹', '🥀', '🌺', '🌸', '🌼', '🌻', '🌞', '🌝', '🌛', '🌜', '🌚',
                '🌑', '🌒', '🌓', '🌔', '🌕', '🌖', '🌗', '🌘', '🌙', '🌍', '🌎', '🌏', '🪐', '💫', '⭐', '🌟',
                '✨', '⚡', '☄️', '💥', '🔥', '🌪️', '🌈', '☀️', '🌤️', '⛅', '🌥️', '☁️', '🌦️', '🌧️', '⛈️', '🌩️',
            ],
        ],
        'food' => [
            'name' => 'Food & Drink',
            'icon' => '🍕',
            'emojis' => [
                '🍇', '🍈', '🍉', '🍊', '🍋', '🍌', '🍍', '🥭', '🍎', '🍏', '🍐', '🍑', '🍒', '🍓', '🫐', '🥝',
                '🍅', '🫒', '🥥', '🥑', '🍆', '🥔', '🥕', '🌽', '🌶️', '🫑', '🥒', '🥬', '🥦', '🧄', '🧅', '🥜',
                '🫘', '🌰', '🫚', '🫛', '🍞', '🥐', '🥖', '🫓', '🥨', '🥯', '🥞', '🧇', '🧀', '🍖', '🍗', '🥩',
                '🥓', '🍔', '🍟', '🍕', '🌭', '🥪', '🌮', '🌯', '🫔', '🥙', '🧆', '🥚', '🍳', '🥘', '🍲', '🫕',
                '🥣', '🥗', '🍿', '🧈', '🧂', '🥫', '🍱', '🍘', '🍙', '🍚', '🍛', '🍜', '🍝', '🍠', '🍢', '🍣',
                '🍤', '🍥', '🥮', '🍡', '🥟', '🥠', '🥡', '🦀', '🦞', '🦐', '🦑', '🦪', '🍦', '🍧', '🍨', '🍩',
                '🍪', '🎂', '🍰', '🧁', '🥧', '🍫', '🍬', '🍭', '🍮', '🍯', '🍼', '🥛', '☕', '🫖', '🍵', '🍶',
                '🍾', '🍷', '🍸', '🍹', '🍺', '🍻', '🥂', '🥃', '🫗', '🥤', '🧋', '🧃', '🧉', '🧊', '🥢', '🍽️',
                '🍴', '🥄', '🔪', '🫙', '🏺', '🌍', '🌎', '🌏', '🪐', '💫', '⭐', '🌟', '✨', '⚡', '☄️', '💥',
            ],
        ],
        'activities' => [
            'name' => 'Activities',
            'icon' => '⚽',
            'emojis' => [
                '⚽', '🏀', '🏈', '⚾', '🥎', '🎾', '🏐', '🏉', '🥏', '🎱', '🪀', '🏓', '🏸', '🏒', '🏑', '🥍',
                '🏏', '🪃', '🥅', '⛳', '🪁', '🏹', '🎣', '🤿', '🥊', '🥋', '🎽', '🛹', '🛼', '🛷', '⛸️', '🥌',
                '🎿', '🎯', '🪀', '🪁', '🎮', '🕹️', '🎰', '🎲', '🧩', '🧸', '🪅', '🪆', '♠️', '♥️', '♦️', '♣️',
                '♟️', '🃏', '🀄', '🎴', '🎭', '🖼️', '🎨', '🧵', '🪡', '🧶', '🪢', '👓', '🕶️', '🥽', '🥼', '🦺',
                '👔', '👕', '👖', '🧣', '🧤', '🧥', '🧦', '👗', '👘', '🥻', '🩱', '🩲', '🩳', '👙', '👚', '🪭',
                '👛', '👜', '👝', '🛍️', '🎒', '🩴', '👞', '👟', '🥾', '🥿', '👠', '👡', '🩰', '👢', '🪮', '👑',
                '👒', '🎩', '🎓', '🧢', '🪖', '⛑️', '📿', '💄', '💍', '💎', '🪬', '🪇', '🪈', '🎵', '🎶', '🎤',
                '🎧', '🎼', '🎹', '🥁', '🪘', '🎷', '🎺', '🪗', '🎸', '🪕', '🎻', '🪈', '🎬', '📺', '📷', '📸',
            ],
        ],
        'travel' => [
            'name' => 'Travel & Places',
            'icon' => '🚗',
            'emojis' => [
                '🚗', '🚕', '🚙', '🚌', '🚎', '🏎️', '🚓', '🚑', '🚒', '🚐', '🛻', '🚚', '🚛', '🚜', '🛵', '🏍️',
                '🛺', '🚲', '🛴', '🛹', '🛼', '🚏', '🛣️', '🛤️', '🛞', '⛽', '🛞', '🚨', '🚥', '🚦', '🛑', '🚧',
                '⚓', '🛟', '⛵', '🛶', '🚤', '🛳️', '⛴️', '🛥️', '🚢', '✈️', '🛩️', '🛫', '🛬', '🪂', '💺', '🚁',
                '🚟', '🚠', '🚡', '🛰️', '🚀', '🛸', '🌍', '🌎', '🌏', '🗺️', '🗾', '🧭', '🏔️', '⛰️', '🌋', '🗻',
                '🏕️', '🏖️', '🏜️', '🏝️', '🏞️', '🏟️', '🏛️', '🏗️', '🧱', '🪨', '🪵', '🛖', '🏘️', '🏚️', '🏠', '🏡',
                '🏢', '🏣', '🏤', '🏥', '🏦', '🏨', '🏩', '🏪', '🏫', '🏬', '🏭', '🏯', '🏰', '💒', '🗼', '🗽',
                '⛪', '🕌', '🛕', '🕍', '⛩️', '🕋', '⛲', '⛺', '🌁', '🌃', '🏙️', '🌄', '🌅', '🌆', '🌇', '🌉',
                '🎠', '🛝', '🎡', '🎢', '💈', '🎪', '🚂', '🚃', '🚄', '🚅', '🚆', '🚇', '🚈', '🚉', '🚊', '🚝',
            ],
        ],
        'objects' => [
            'name' => 'Objects',
            'icon' => '💡',
            'emojis' => [
                '⌚', '📱', '📲', '💻', '⌨️', '🖥️', '🖨️', '🖱️', '🖲️', '🕹️', '🗜️', '💽', '💾', '💿', '📀', '📼',
                '📷', '📸', '📹', '🎥', '📽️', '🎞️', '📞', '☎️', '📟', '📠', '📺', '📻', '🎙️', '🎚️', '🎛️', '🧭',
                '⏱️', '⏲️', '⏰', '🕰️', '⌛', '⏳', '📡', '🔋', '🪫', '🔌', '💡', '🔦', '🕯️', '🪔', '🧯', '🛢️',
                '💸', '💵', '💴', '💶', '💷', '🪙', '💰', '💳', '🪪', '💎', '⚖️', '🪜', '🧰', '🪛', '🔧', '🔩',
                '⚙️', '🗜️', '⛏️', '🛠️', '⚒️', '🔨', '🪚', '🔗', '⛓️', '🪝', '🧲', '🔫', '💣', '🧨', '🪓', '🔪',
                '🗡️', '⚔️', '🛡️', '🚬', '⚰️', '🪦', '⚱️', '🏺', '🔮', '📿', '🧿', '🪬', '💈', '⚗️', '🔬', '🔭',
                '🕳️', '🩹', '🩺', '💊', '💉', '🩸', '🧬', '🦠', '🧫', '🧪', '🌡️', '🧹', '🪠', '🧺', '🧻', '🚽',
                '🚰', '🚿', '🛁', '🛀', '🧼', '🪥', '🪒', '🧽', '🪣', '🧴', '🛎️', '🔑', '🗝️', '🚪', '🪑', '🛋️',
            ],
        ],
        'symbols' => [
            'name' => 'Symbols',
            'icon' => '❤️',
            'emojis' => [
                '❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❤️‍🔥', '❤️‍🩹', '❣️', '💕', '💞', '💓',
                '💗', '💖', '💘', '💝', '💟', '☮️', '✝️', '☪️', '🕉️', '☸️', '✡️', '🔯', '🕎', '☯️', '☦️', '🛐',
                '⛎', '♈', '♉', '♊', '♋', '♌', '♍', '♎', '♏', '♐', '♑', '♒', '♓', '🆔', '⚛️', '🉑',
                '☢️', '☣️', '📴', '📳', '🈶', '🈚', '🈸', '🈺', '🈷️', '✴️', '🆚', '💮', '🉐', '㊙️', '㊗️', '🈴',
                '🈵', '🈹', '🈲', '🅰️', '🅱️', '🆎', '🆑', '🅾️', '🆘', '❌', '⭕', '🛑', '⛔', '📛', '🚫', '💯',
                '💢', '♨️', '🚷', '🚯', '🚳', '🚱', '🔞', '📵', '🚭', '❗', '❕', '❓', '❔', '‼️', '⁉️', '🔅',
                '🔆', '〽️', '⚠️', '🚸', '🔱', '⚜️', '🔰', '♻️', '✅', '🈯', '💹', '❇️', '✳️', '❎', '🌐', '💠',
                'Ⓜ️', '🌀', '💤', '🏧', '🚾', '♿', '🅿️', '🛗', '🈳', '🈂️', '🛂', '🛃', '🛄', '🛅', '🚹', '🚺',
            ],
        ],
        'flags' => [
            'name' => 'Flags',
            'icon' => '🏁',
            'emojis' => [
                '🏁', '🚩', '🎌', '🏴', '🏳️', '🏳️‍🌈', '🏳️‍⚧️', '🏴‍☠️', '🇺🇸', '🇬🇧', '🇫🇷', '🇩🇪', '🇮🇹', '🇪🇸', '🇷🇺', '🇨🇳',
                '🇯🇵', '🇰🇷', '🇮🇳', '🇧🇷', '🇨🇦', '🇦🇺', '🇲🇽', '🇦🇷', '🇹🇷', '🇸🇦', '🇦🇪', '🇿🇦', '🇳🇬', '🇪🇬', '🇰🇪', '🇹🇭',
                '🇻🇳', '🇮🇩', '🇵🇭', '🇲🇾', '🇸🇬', '🇳🇿', '🇮🇪', '🇵🇹', '🇳🇱', '🇧🇪', '🇨🇭', '🇦🇹', '🇸🇪', '🇳🇴', '🇩🇰', '🇫🇮',
                '🇵🇱', '🇨🇿', '🇭🇺', '🇷🇴', '🇧🇬', '🇭🇷', '🇷🇸', '🇺🇦', '🇬🇷', '🇹🇼', '🇭🇰', '🇲🇴', '🇨🇱', '🇨🇴', '🇵🇪', '🇪🇨',
                '🇻🇪', '🇵🇾', '🇺🇾', '🇧🇴', '🇨🇷', '🇵🇦', '🇳🇮', '🇭🇳', '🇸🇻', '🇬🇹', '🇧🇿', '🇯🇲', '🇹🇹', '🇭🇹', '🇩🇴', '🇨🇺',
                '🇵🇷', '🇹🇼', '🇮🇱', '🇯🇴', '🇱🇧', '🇮🇶', '🇮🇷', '🇦🇫', '🇵🇰', '🇧🇩', '🇱🇰', '🇳🇵', '🇲🇲', '🇰🇭', '🇱🇦', '🇲🇳',
                '🇰🇿', '🇺🇿', '🇦🇿', '🇬🇪', '🇦🇲', '🇧🇾', '🇲🇩', '🇦🇱', '🇲🇰', '🇽🇰', '🇲🇪', '🇧🇦', '🇸🇮', '🇸🇰', '🇱🇹', '🇱🇻',
                '🇪🇪', '🇮🇸', '🇱🇺', '🇲🇹', '🇨🇾', '🇦🇩', '🇲🇨', '🇸🇲', '🇻🇦', '🇱🇮', '🇧🇲', '🇰🇾', '🇻🇬', '🇮🇴', '🇫🇰', '🇬🇮',
                '🇦🇶', '🇧🇻', '🇸🇯', '🇵🇲', '🇸🇭', '🇦🇨', '🇹🇦', '🇮🇨', '🇪🇦', '🇲🇵', '🇬🇺', '🇦🇸', '🇻🇮', '🇵🇼', '🇨🇰', '🇳🇺',
                '🇹🇰', '🇫🇯', '🇵🇬', '🇸🇧', '🇻🇺', '🇳🇨', '🇼🇸', '🇹🇴', '🇰🇮', '🇹🇻', '🇲🇭', '🇫🇲', '🇵🇳', '🇧🇶', '🇸🇽', '🇨🇼',
            ],
        ],
    ];
@endphp

<div {{ $attributes->class(["bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-lg overflow-hidden select-none"]) }}
    x-data="{ 
        search: '', 
        activeCategory: 'smileys',
        categories: {{ json_encode(collect($categories)->mapWithKeys(fn($cat, $key) => [$key => ['name' => $cat['name'], 'icon' => $cat['icon']]))->toArray()) }},
        emojiNames: {{ json_encode($emojiNames) }},
        searchEmoji(emoji) {
            if (!this.search) return false;
            const query = this.search.toLowerCase();
            const name = this.emojiNames[emoji] || '';
            return name.toLowerCase().includes(query);
        },
        filteredEmojis(emojis) {
            if (!this.search) return emojis;
            const query = this.search.toLowerCase();
            return emojis.filter(e => {
                const name = this.emojiNames[e] || '';
                return e.includes(this.search) || name.toLowerCase().includes(query);
            });
        }
    }"
>
    {{-- Header --}}
    <div class="p-3 border-b border-zinc-200 dark:border-zinc-700">
        @if($label)
            <div class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">{{ $label }}</div>
        @endif
        @if($showSearch)
            <div class="relative">
                <input 
                    type="text" 
                    x-model="search"
                    placeholder="Search emoji..."
                    class="w-full px-3 py-2 text-sm bg-zinc-100 dark:bg-zinc-700 border-0 rounded-lg focus:ring-2 focus:ring-blue-500 text-zinc-900 dark:text-white placeholder-zinc-500"
                />
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        @endif
    </div>

    {{-- Category Tabs --}}
    <div class="flex border-b border-zinc-200 dark:border-zinc-700 overflow-x-auto">
        @foreach($categories as $key => $category)
            <button 
                @click="activeCategory = '{{ $key }}'"
                class="flex items-center justify-center w-10 h-10 text-xl hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors shrink-0"
                :class="{ 'bg-zinc-100 dark:bg-zinc-700 border-b-2 border-blue-500': activeCategory === '{{ $key }}' }"
                title="{{ $category['name'] }}"
            >
                {{ $category['icon'] }}
            </button>
        @endforeach
    </div>

    {{-- Emoji Grid --}}
    <div class="p-3 max-h-80 overflow-y-auto">
        @foreach($categories as $key => $category)
            <div x-show="activeCategory === '{{ $key }}' && !search">
                <div class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-2 uppercase tracking-wide">{{ $category['name'] }}</div>
                <div class="grid grid-cols-{{ $columns }} gap-1">
                    @foreach($category['emojis'] as $emoji)
                        <button 
                            class="flex items-center justify-center w-10 h-10 {{ $sizeClass }} rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                            @click="$dispatch('emoji-select', '{{ $emoji }}')"
                            title="{{ $emoji }}"
                        >
                            {{ $emoji }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Search Results --}}
        <div x-show="search" x-cloak>
            <div class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-2">
                Search Results
                <span class="text-zinc-400">-</span>
                <span x-text="filteredEmojis(@js(collect($categories)->flatMap(fn($cat) => $cat['emojis'])->toArray())).length + ' found'"></span>
            </div>
            <div class="grid grid-cols-{{ $columns }} gap-1">
                @foreach(collect($categories)->flatMap(fn($cat) => $cat['emojis']) as $emoji)
                    <button 
                        class="flex items-center justify-center w-10 h-10 {{ $sizeClass }} rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                        @click="$dispatch('emoji-select', '{{ $emoji }}')"
                        x-show="filteredEmojis(@js([$emoji])).length > 0"
                        :title="emojiNames['{{ $emoji }}'] || '{{ $emoji }}'"
                    >
                        {{ $emoji }}
                    </button>
                @endforeach
            </div>
            <div x-show="filteredEmojis(@js(collect($categories)->flatMap(fn($cat) => $cat['emojis'])->toArray())).length === 0" class="text-center py-4 text-sm text-zinc-500">
                No emojis found for "<span x-text="search"></span>"
            </div>
        </div>
    </div>
</div>
