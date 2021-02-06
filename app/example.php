<?php declare(strict_types=1);

require_once __DIR__ . '/functions.php';

$input = file_get_contents(__DIR__ . '/sample.txt');

try {
    $result = getMostPopularWords($input);

    var_dump($result);
} catch (\Exception $e) {
    echo("Sorry, something went wrong: {$e->getMessage()}\n");
}
