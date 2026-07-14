{{--
CSP Test Page — exercises every major Gsmui Pro component.
Open in browser with CSP enabled and check DevTools Console for violations.

Usage:
  1. Publish CSP config:   php artisan vendor:publish --tag=gsmui-pro-csp-config
  2. Register middleware:   add CspMiddleware to app/Http/Kernel.php
  3. Visit:                 /gsmui-csp-test
  4. Open DevTools Console → no CSP violations should appear

Route (in a Laravel app):
  Route::get('/gsmui-csp-test', fn () => view('gsmui-csp-test'));
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gsmui Pro — CSP Test</title>
    <gsmui:styles />
    @gsmuiScripts
</head>
<body class="bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100">
    <div class="p-8 space-y-12 max-w-4xl mx-auto">

        <h1 class="text-2xl font-bold">Gsmui Pro — CSP Violation Test</h1>
        <p class="text-sm text-zinc-500 mb-8">
            Each component below should render without CSP warnings in DevTools Console.
            Open DevTools → Console. If you see "Refused to..." messages, a CSP directive needs adjustment.
        </p>

        {{-- Input --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Input</h2>
            <div class="flex gap-4 flex-wrap">
                <gsmui:input placeholder="Default" name="a" />
                <gsmui:input placeholder="Disabled" name="b" disabled />
                <gsmui:input placeholder="Invalid" name="c" invalid />
            </div>
        </section>

        {{-- Select --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Select</h2>
            <gsmui:select name="d" placeholder="Pick one" class="w-64">
                <gsmui:select.option value="1">Option One</gsmui:select.option>
                <gsmui:select.option value="2">Option Two</gsmui:select.option>
                <gsmui:select.option value="3">Option Three</gsmui:select.option>
            </gsmui:select>
        </section>

        {{-- Date Picker --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Date Picker</h2>
            <div class="flex gap-4 flex-wrap">
                <gsmui:date-picker name="e" class="w-64" />
                <gsmui:date-picker name="f" type="input" class="w-64" />
            </div>
        </section>

        {{-- Time Picker --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Time Picker</h2>
            <gsmui:time-picker name="g" class="w-48" />
        </section>

        {{-- Color Picker --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Color Picker</h2>
            <gsmui:color-picker name="h" class="w-48" />
        </section>

        {{-- Slider --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Slider</h2>
            <gsmui:slider name="i" class="w-64" />
        </section>

        {{-- Tabs --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Tabs</h2>
            <gsmui:tabs>
                <gsmui:tab name="tab1" label="Tab One" selected>Content one</gsmui:tab>
                <gsmui:tab name="tab2" label="Tab Two">Content two</gsmui:tab>
            </gsmui:tabs>
        </section>

        {{-- Modal --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Modal</h2>
            <gsmui:modal>
                <gsmui:button>Open Modal</gsmui:button>
                <dialog>
                    <div class="p-4">Modal content. Should not trigger CSP violations.</div>
                    <form method="dialog">
                        <gsmui:button>Close</gsmui:button>
                    </form>
                </dialog>
            </gsmui:modal>
        </section>

        {{-- Accordion --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Accordion</h2>
            <gsmui:accordion>
                <gsmui:accordion.item heading="Item One">
                    Accordion content one.
                </gsmui:accordion.item>
                <gsmui:accordion.item heading="Item Two">
                    Accordion content two.
                </gsmui:accordion.item>
            </gsmui:accordion>
        </section>

        {{-- Pillbox --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Pillbox</h2>
            <gsmui:pillbox name="j" class="w-64" />
        </section>

        {{-- Calendar --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Calendar</h2>
            <gsmui:calendar />
        </section>

        {{-- Autocomplete --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Autocomplete</h2>
            <gsmui:autocomplete name="k" class="w-64">
                <gsmui:autocomplete.item label="Apple" value="apple" />
                <gsmui:autocomplete.item label="Banana" value="banana" />
                <gsmui:autocomplete.item label="Cherry" value="cherry" />
            </gsmui:autocomplete>
        </section>

        {{-- Buttons --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Buttons</h2>
            <div class="flex gap-2 flex-wrap">
                <gsmui:button variant="primary">Primary</gsmui:button>
                <gsmui:button variant="secondary">Secondary</gsmui:button>
                <gsmui:button variant="ghost">Ghost</gsmui:button>
                <gsmui:button variant="danger">Danger</gsmui:button>
                <gsmui:button disabled>Disabled</gsmui:button>
            </div>
        </section>

        {{-- Editor --}}
        <section>
            <h2 class="text-lg font-semibold mb-2 border-b pb-1">Editor (Rich Text)</h2>
            <gsmui:editor name="l" class="w-full" />
        </section>
    </div>
</body>
</html>
