<?php
/**
 * Lints the @php blocks of a Blade file by extracting and syntax-checking them.
 *
 * Usage: php scripts/lint-blade.php <path-to-blade-file>
 */

$path = $argv[1] ?? null;

if (! $path || ! is_file($path)) {
    fwrite(STDERR, "Usage: php scripts/lint-blade.php <blade-file>\n");
    exit(1);
}

$source = file_get_contents($path);

// Collect both @php ... @endphp blocks and raw inline PHP blocks.
preg_match_all('/@php(.*?)@endphp/s', $source, $blocks);
preg_match_all('/<[?]php(.*?)(?:[?]>|$)/s', $source, $inline);

$chunks = array_merge($blocks[1] ?? [], $inline[1] ?? []);
$failed = false;

foreach ($chunks as $i => $code) {
    $tmp = tempnam(sys_get_temp_dir(), 'blade') . '.php';
    // Preserve line numbers: prepend the raw block (minus the leading @php line)
    // so reported line numbers map back to the source file.
    $offset = substr_count(substr($source, 0, strpos($source, $code)), "\n");
    file_put_contents($tmp, "<?php\n" . $code);

    exec(escapeshellarg(PHP_BINARY) . ' -l ' . escapeshellarg($tmp) . ' 2>&1', $out, $code_i);
    if ($code_i !== 0) {
        $failed = true;
        echo "chunk #{$i} (source line ~" . ($offset + 1) . ") FAILED:\n";
        echo preg_replace('/^.*?tmp\.php on line (\d+):?.*$/m', '  relative line $1', implode("\n", $out)) . "\n";
        // Echo the offending line for context.
        if (preg_match('/on line (\d+)/', implode("\n", $out), $lm)) {
            $lines = explode("\n", $code);
            $n = (int) $lm[1];
            for ($k = max(0, $n - 3); $k < min(count($lines), $n + 1); $k++) {
                echo '  ' . ($k + 1) . ' | ' . substr($lines[$k], 0, 200) . "\n";
            }
            echo '  >> source line ' . ($offset + $n) . "\n";
        }
    }
    $out = [];
    unlink($tmp);
}

echo $failed ? "syntax errors found\n" : "all @php blocks OK\n";
exit($failed ? 1 : 0);
