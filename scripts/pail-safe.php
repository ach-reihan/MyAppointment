<?php

if (! function_exists('pcntl_fork')) {
    fwrite(STDOUT, "Pail is unavailable on this platform; keeping the dev process alive without logs.\n");

    while (true) {
        sleep(3600);
    }
}

$artisanPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'artisan';
$command = [PHP_BINARY, $artisanPath, 'pail', '--timeout=0'];

$process = proc_open($command, [
    0 => STDIN,
    1 => STDOUT,
    2 => STDERR,
], $pipes, dirname(__DIR__));

if (! is_resource($process)) {
    fwrite(STDERR, "Unable to start Pail.\n");
    exit(1);
}

$exitCode = proc_close($process);

exit($exitCode);