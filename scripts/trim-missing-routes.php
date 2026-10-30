<?php

/**
 * Comments out route definitions that point at Livewire component classes which
 * were never created, so the route table can boot. Re-enable a line once the
 * component exists.
 *
 * Route files usually import the component and reference the short name, so the
 * imports are resolved first.
 *
 * Usage: php scripts/trim-missing-routes.php
 */
$files = array_merge(glob(__DIR__.'/../routes/*.php'), glob(__DIR__.'/../routes/domains/*.php'));

$disabled = [];

foreach ($files as $file) {
    $contents = file_get_contents($file);
    $lines = preg_split("/\r\n|\n/", $contents);

    // Map short name => fully qualified class for every Livewire import.
    $imports = [];
    foreach ($lines as $line) {
        if (preg_match('/^use\s+(App\\\\Http\\\\Livewire\\\\[A-Za-z0-9_\\\\]+)(?:\s+as\s+([A-Za-z0-9_]+))?;/', trim($line), $matches)) {
            $fqcn = $matches[1];
            $alias = $matches[2] ?? substr($fqcn, strrpos($fqcn, '\\') + 1);
            $imports[$alias] = $fqcn;
        }
    }

    $changed = false;

    foreach ($lines as $i => $line) {
        if (str_starts_with(trim($line), '//')) {
            continue;
        }

        if (! preg_match('/([A-Za-z0-9_\\\\]+)::class/', $line, $matches)) {
            continue;
        }

        $reference = ltrim($matches[1], '\\');
        $class = str_contains($reference, '\\') ? $reference : ($imports[$reference] ?? null);

        if ($class === null || ! str_starts_with($class, 'App\\Http\\Livewire\\')) {
            continue;
        }

        $relative = str_replace('\\', '/', substr($class, strlen('App\\')));
        $path = __DIR__.'/../app/'.$relative.'.php';

        if (file_exists($path)) {
            continue;
        }

        $lines[$i] = '// '.trim($line).'  // TODO: '.$class.' does not exist yet';
        $changed = true;
        $disabled[] = basename($file).': '.$class;
    }

    if ($changed) {
        file_put_contents($file, implode("\n", $lines));
    }
}

echo 'Disabled '.count($disabled)." route(s)\n";

foreach ($disabled as $entry) {
    echo '  '.$entry."\n";
}
