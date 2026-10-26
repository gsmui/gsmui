<?php

/**
 * Drives the render-smoke sweep in resumable batches.
 *
 * A handful of components (e.g. `form-builder`) are heavy enough to exhaust PHP
 * memory, which kills the whole PHPUnit run. That would silently hide the other
 * 150 results. So each component's verdict is persisted as soon as it is known,
 * and this script re-launches PHPUnit until nothing new is learned.
 */

const MAX_ROUNDS = 40;

$root = dirname(__DIR__);
$resultsPath = $root . '/tests/render-smoke-results.json';
$logPath = $root . '/smoke-out.txt';

$manifest = json_decode((string) file_get_contents($root . '/component-manifest.json'), true);
$total = count(array_filter($manifest['components'], fn ($c) => $c['has_index']));

$seen = 0;

for ($round = 1; $round <= MAX_ROUNDS; $round++) {
    $before = is_file($resultsPath)
        ? count(json_decode((string) file_get_contents($resultsPath), true)['results'] ?? [])
        : 0;

    $command = sprintf(
        'php -d memory_limit=-1 %s --filter RenderSmokeTest --no-coverage > %s 2>&1',
        escapeshellarg($root . '/vendor/phpunit/phpunit/phpunit'),
        escapeshellarg($logPath)
    );

    // Resume mode: skip components already recorded.
    putenv('SMOKE_RESUME=1');
    exec($command);

    $after = is_file($resultsPath)
        ? count(json_decode((string) file_get_contents($resultsPath), true)['results'] ?? [])
        : 0;

    printf("round %d: %d -> %d of %d components\n", $round, $before, $after, $total);

    if ($after >= $total || $after === $before) {
        $seen = $after;
        break;
    }
    $seen = $after;
}

if ($seen >= $total) {
    echo "sweep complete\n";
} else {
    printf("sweep stalled at %d of %d (remaining components crash PHP)\n", $seen, $total);
}
