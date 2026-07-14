@blaze(fold: true)

@props([
    'code' => 404,
    'design' => 'centered',   // centered | split | fullscreen | card | terminal
    'title' => null,
    'description' => null,
    'actionLabel' => null,
    'actionHref' => null,
])

@php
$code = is_numeric($code) ? (int) $code : 404;

$codeMap = [
    // 1xx Informational
    100 => ['title' => __('Continue'), 'description' => __('The server has received the request headers and is waiting for the body.')],
    101 => ['title' => __('Switching Protocols'), 'description' => __('The requester has asked the server to switch protocols.')],
    102 => ['title' => __('Processing'), 'description' => __('The server is processing the request but has no response yet.')],
    103 => ['title' => __('Early Hints'), 'description' => __('Returns some response headers before the final response.')],

    // 2xx Success
    200 => ['title' => __('OK'), 'description' => __('The request succeeded.')],
    201 => ['title' => __('Created'), 'description' => __('The request succeeded and a new resource was created.')],
    202 => ['title' => __('Accepted'), 'description' => __('The request has been accepted for processing, but not completed.')],
    203 => ['title' => __('Non-Authoritative Information'), 'description' => __('The request succeeded but the response is from a third party.')],
    204 => ['title' => __('No Content'), 'description' => __('The request succeeded but there is no content to send.')],
    205 => ['title' => __('Reset Content'), 'description' => __('The request succeeded and the client should reset the document view.')],
    206 => ['title' => __('Partial Content'), 'description' => __('The server is delivering only part of the resource.')],
    207 => ['title' => __('Multi-Status'), 'description' => __('The response carries multiple status codes for multiple resources.')],
    208 => ['title' => __('Already Reported'), 'description' => __('The members of a binding have already been enumerated.')],
    226 => ['title' => __('IM Used'), 'description' => __('The server fulfilled the request using instance-manipulation.')],

    // 3xx Redirection
    300 => ['title' => __('Multiple Choices'), 'description' => __('Multiple options for the resource follow.')],
    301 => ['title' => __('Moved Permanently'), 'description' => __('The resource has been permanently moved to a new URL.')],
    302 => ['title' => __('Found'), 'description' => __('The resource is temporarily located at a different URL.')],
    303 => ['title' => __('See Other'), 'description' => __('The response can be found under a different URI using GET.')],
    304 => ['title' => __('Not Modified'), 'description' => __('The resource has not been modified since the last request.')],
    307 => ['title' => __('Temporary Redirect'), 'description' => __('The resource is temporarily elsewhere; the method stays the same.')],
    308 => ['title' => __('Permanent Redirect'), 'description' => __('The resource has moved permanently; the method stays the same.')],

    // 4xx Client Error
    400 => ['title' => __('Bad Request'), 'description' => __('The server could not understand the request.')],
    401 => ['title' => __('Unauthorized'), 'description' => __('Authentication is required and has failed or not been provided.')],
    402 => ['title' => __('Payment Required'), 'description' => __('Reserved for future use; originally intended for digital payments.')],
    403 => ['title' => __('Forbidden'), 'description' => __("You don't have permission to access this resource.")],
    404 => ['title' => __('Not Found'), 'description' => __("The page you're looking for doesn't exist.")],
    405 => ['title' => __('Method Not Allowed'), 'description' => __('The request method is not supported for this resource.')],
    406 => ['title' => __('Not Acceptable'), 'description' => __("The server can't produce a response matching the requested formats.")],
    407 => ['title' => __('Proxy Authentication Required'), 'description' => __('Authentication with the proxy is required.')],
    408 => ['title' => __('Request Timeout'), 'description' => __('The server timed out waiting for the request.')],
    409 => ['title' => __('Conflict'), 'description' => __('The request conflicts with the current state of the resource.')],
    410 => ['title' => __('Gone'), 'description' => __('The requested resource is no longer available.')],
    411 => ['title' => __('Length Required'), 'description' => __('The request requires a Content-Length header.')],
    412 => ['title' => __('Precondition Failed'), 'description' => __('A precondition in the request evaluated to false.')],
    413 => ['title' => __('Payload Too Large'), 'description' => __('The request entity is larger than the server allows.')],
    414 => ['title' => __('URI Too Long'), 'description' => __('The requested URI is longer than the server allows.')],
    415 => ['title' => __('Unsupported Media Type'), 'description' => __('The media format of the request is not supported.')],
    416 => ['title' => __('Range Not Satisfiable'), 'description' => __('The requested range cannot be satisfied.')],
    417 => ['title' => __('Expectation Failed'), 'description' => __("The server can't meet the Expect request header.")],
    418 => ['title' => __("I'm a Teapot"), 'description' => __('The server refuses to brew coffee with a teapot.')],
    421 => ['title' => __('Misdirected Request'), 'description' => __('The request was directed at a server that cannot respond.')],
    422 => ['title' => __('Unprocessable Entity'), 'description' => __('The request was well-formed but contained semantic errors.')],
    423 => ['title' => __('Locked'), 'description' => __('The resource is locked.')],
    424 => ['title' => __('Failed Dependency'), 'description' => __('The request failed because it depended on another request.')],
    425 => ['title' => __('Too Early'), 'description' => __('The server is unwilling to risk processing a replayed request.')],
    426 => ['title' => __('Upgrade Required'), 'description' => __('The client should switch to a different protocol.')],
    428 => ['title' => __('Precondition Required'), 'description' => __('The server requires the request to be conditional.')],
    429 => ['title' => __('Too Many Requests'), 'description' => __('You have sent too many requests in a given amount of time.')],
    431 => ['title' => __('Request Header Fields Too Large'), 'description' => __('The request headers are too large.')],
    451 => ['title' => __('Unavailable For Legal Reasons'), 'description' => __('The resource is unavailable for legal reasons.')],

    // 5xx Server Error
    500 => ['title' => __('Internal Server Error'), 'description' => __('The server encountered an unexpected condition.')],
    501 => ['title' => __('Not Implemented'), 'description' => __("The server doesn't support the functionality required.")],
    502 => ['title' => __('Bad Gateway'), 'description' => __('The server received an invalid response from an upstream server.')],
    503 => ['title' => __('Service Unavailable'), 'description' => __('The server is temporarily unable to handle the request.')],
    504 => ['title' => __('Gateway Timeout'), 'description' => __('The upstream server failed to send a timely response.')],
    505 => ['title' => __('HTTP Version Not Supported'), 'description' => __("The server doesn't support the HTTP version used.")],
    506 => ['title' => __('Variant Also Negotiates'), 'description' => __('Transparent content negotiation is misconfigured.')],
    507 => ['title' => __('Insufficient Storage'), 'description' => __("The server can't store the representation needed.")],
    508 => ['title' => __('Loop Detected'), 'description' => __('The server detected an infinite loop while processing.')],
    510 => ['title' => __('Not Extended'), 'description' => __('Further extensions are required to fulfill the request.')],
    511 => ['title' => __('Network Authentication Required'), 'description' => __('Network authentication is required to gain access.')],
];

$resolved = $codeMap[$code] ?? [
    'title' => __('Unknown Status'),
    'description' => __('No description available for HTTP :code.', ['code' => $code]),
];

$title = $title ?? $resolved['title'];
$description = $description ?? $resolved['description'];

$httpClass = (int) floor($code / 100);

$accent = match ($httpClass) {
    1 => [
        'text' => 'text-sky-500 dark:text-sky-400',
        'soft' => 'bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-400',
        'solid' => 'bg-sky-500',
    ],
    2 => [
        'text' => 'text-emerald-500 dark:text-emerald-400',
        'soft' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400',
        'solid' => 'bg-emerald-500',
    ],
    3 => [
        'text' => 'text-blue-500 dark:text-blue-400',
        'soft' => 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400',
        'solid' => 'bg-blue-500',
    ],
    4 => [
        'text' => 'text-amber-500 dark:text-amber-400',
        'soft' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400',
        'solid' => 'bg-amber-500',
    ],
    5 => [
        'text' => 'text-red-500 dark:text-red-400',
        'soft' => 'bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400',
        'solid' => 'bg-red-500',
    ],
    default => [
        'text' => 'text-zinc-500 dark:text-zinc-400',
        'soft' => 'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300',
        'solid' => 'bg-zinc-500',
    ],
};

$toneIcon = match ($httpClass) {
    1 => 'loading',
    2 => 'check',
    3 => 'arrow-right',
    4 => 'magnifying-glass',
    5 => 'exclamation-triangle',
    default => 'x-mark',
};

$classes = Gsmui::classes()
    ->add('w-full')
    ->add(match ($design) {
        'fullscreen' => 'min-h-screen',
        'card' => 'min-h-[60vh]',
        'terminal' => 'min-h-[60vh]',
        default => 'min-h-[60vh]',
    });
@endphp

<section
    role="alert"
    {{ $attributes->class($classes) }}
    data-gsmui-errors
    data-gsmui-errors-code="{{ $code }}"
    data-gsmui-errors-design="{{ $design }}"
>

@switch($design)
    @case('split')
        <div class="grid min-h-[60vh] md:grid-cols-2">
            <div class="{{ $accent['solid'] }} flex flex-col items-center justify-center gap-4 p-10 text-white">
                <gsmui:icon :name="$toneIcon" variant="lg" class="size-12 opacity-90" />
                <p class="text-8xl font-bold tabular-nums">{{ $code }}</p>
                <span class="text-xs font-medium uppercase tracking-widest opacity-80">{{ $httpClass }}xx</span>
            </div>
            <div class="flex items-center bg-white p-8 text-left dark:bg-zinc-900 md:pl-10">
                <div class="max-w-md">
                    <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $title }}</h1>
                    <p class="mt-3 text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</p>
                    @if ($actionLabel && $actionHref)
                        <div class="mt-6">
                            <gsmui:button href="{{ $actionHref }}">{{ $actionLabel }}</gsmui:button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @break

    @case('fullscreen')
        <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-zinc-900 via-zinc-800 to-zinc-900 p-8 text-white">
            <div class="max-w-lg rounded-2xl border border-white/10 bg-white/5 p-10 text-center backdrop-blur">
                <gsmui:icon :name="$toneIcon" variant="lg" class="mx-auto size-12 text-zinc-400" />
                <p class="mt-4 text-8xl font-bold tabular-nums">{{ $code }}</p>
                <h1 class="mt-4 text-2xl font-semibold">{{ $title }}</h1>
                <p class="mt-2 text-sm text-zinc-300">{{ $description }}</p>
                @if ($actionLabel && $actionHref)
                    <div class="mt-6 flex justify-center">
                        <gsmui:button variant="ghost" href="{{ $actionHref }}">{{ $actionLabel }}</gsmui:button>
                    </div>
                @endif
            </div>
        </div>
        @break

    @case('card')
        <div class="flex min-h-[60vh] items-center justify-center bg-zinc-50 p-8 dark:bg-zinc-900">
            <div class="mx-auto max-w-lg rounded-xl border border-zinc-200 bg-white p-8 text-center shadow-sm dark:border-white/10 dark:bg-zinc-800">
                <div class="mx-auto flex size-14 items-center justify-center rounded-full {{ $accent['soft'] }}">
                    <gsmui:icon :name="$toneIcon" variant="lg" />
                </div>
                <p class="mt-5 text-6xl font-bold tabular-nums {{ $accent['text'] }}">{{ $code }}</p>
                <h1 class="mt-3 text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $title }}</h1>
                <p class="mx-auto mt-2 max-w-sm text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</p>
                @if ($actionLabel && $actionHref)
                    <div class="mt-6 flex justify-center">
                        <gsmui:button href="{{ $actionHref }}">{{ $actionLabel }}</gsmui:button>
                    </div>
                @endif
            </div>
        </div>
        @break

    @case('terminal')
        <div class="flex min-h-[60vh] items-center bg-zinc-950 p-8 font-mono text-zinc-100">
            <div class="mx-auto w-full max-w-2xl">
                <p class="text-emerald-400"><span class="text-zinc-500">$</span> error {{ $code }} <span class="text-zinc-600">::</span> {{ $title }}</p>
                <p class="mt-2 text-zinc-300"><span class="text-zinc-500">$</span> {{ $description }}</p>
                @if ($actionHref)
                    <a href="{{ $actionHref }}" class="mt-4 inline-flex items-center gap-2 text-emerald-400 hover:text-emerald-300">
                        <span class="text-zinc-500">$</span> {{ $actionLabel ?? __('return') }}
                        <gsmui:icon name="arrow-right" variant="mini" />
                    </a>
                @elseif ($actionLabel)
                    <p class="mt-4 text-zinc-500"><span class="text-zinc-600">$</span> {{ $actionLabel }}</p>
                @endif
                <p class="mt-4 text-zinc-500"><span class="text-zinc-600">$</span> <span class="inline-block h-4 w-2 translate-y-0.5 animate-pulse bg-zinc-100 align-middle"></span></p>
            </div>
        </div>
        @break

    @default
        <div class="flex min-h-[60vh] items-center justify-center p-8">
            <div class="max-w-md text-center">
                <gsmui:icon :name="$toneIcon" variant="lg" class="mx-auto size-12 {{ $accent['text'] }}" />
                <p class="mt-4 text-7xl font-bold tabular-nums {{ $accent['text'] }}">{{ $code }}</p>
                <h1 class="mt-4 text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $title }}</h1>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</p>
                @if ($actionLabel && $actionHref)
                    <div class="mt-6 flex justify-center">
                        <gsmui:button href="{{ $actionHref }}">{{ $actionLabel }}</gsmui:button>
                    </div>
                @endif
            </div>
        </div>
@endswitch

</section>
