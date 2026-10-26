<?php

/**
 * Drives the render-smoke sweep in resumable batches.
 *
 * A few components are heavy enough to exhaust PHP memory, which kills the whole
 * PHPUnit run and would silently hide every result after them. Each component's
 * verdict is persisted as soon as it is known, so this script re-launches
 * PHPUnit until a round stops making progress.
 */

const MAX_ROUNDS = 40;

$root = dirname(__DIR__);
$resultsPath = $root . '/tests/render-smoke-results.json';

$manifest = json_decode((string) file_get_contents($root . '/component-manifest.json'), true);
$total = count(array_filter($manifest['components'], fn ($c) => $c['has_index']));

$logged = 0;

for ($round = 1; $round <= MAX_ROUNDS; $round++) {
    $before = is_file($resultsPath)
        ? count(json_decode((string) file_get_contents($resultsPath), true)['results'] ?? [])
        : 0;

    if ($before >= $total) {
        break;
    }

    $command = sprintf(
        'php -d memory_limit=-1 %s --filter RenderSmokeTest --no-coverage',
        escapeshellarg($root . '/vendor/phpunit/phpunit/phpunit')
    );

    putenv('SMOKE_RESUME=1');
    $output = [];
    exec($command . ' 2>&1', $output);

    // Surface the per-component errors PHPUnit printed for this round.
    foreach (array_slice($output, $logged) as $line) {
        if (preg_match('/^\[[a-z0-9-]+\]/', $line)) {
            echo $line, "\n";
        }
    }
    $logged = count($output);

    $after = is_file($resultsPath)
        ? count(json_decode((string) file_get_contents($resultsPath), true)['results'] ?? [])
        : 0;

    printf("round %d: %d -> %d of %d\n", $round, $before, $after, $total);

    if ($after === $before) {
        break;
    }
}

$results = is_file($resultsPath)
    ? json_decode((string) file_get_contents($resultsPath), true)['results'] ?? []
    : [];

$counts = array_count_values($results);
ksort($counts);

echo "\n";
foreach ($counts as $status => $count) {
    printf("  %-8s %d\n", $status, $count);
}

$covered = count($results);
printf("\n%d of %d components measured\n", $covered, $total);

// Exit non-zero only with --strict. `docs:build` chains through this script, so
// a non-zero exit would abort before the ledger is regenerated — leaving the
// ledger stale precisely when components are broken. `test:smoke` passes
// --strict so CI still fails on a real regression.
$failed = $counts['fail'] ?? 0;
$strict = in_array('--strict', $argv ?? [], true) || getenv('SMOKE_STRICT');

if ($failed > 0) {
    printf(
        "\n%d component(s) failed to render. See %s\n",
        $failed,
        str_replace('\\', '/', str_replace(getcwd() . DIRECTORY_SEPARATOR, '', $resultsPath))
    );
}

exit(($failed > 0 && $strict) ? 1 : 0);
