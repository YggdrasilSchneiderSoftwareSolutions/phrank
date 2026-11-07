<?php
use \Phrank\App;

require __DIR__ . '/App.php';

$app = new App();

function get($path, $handler) {
    global $app;
    $app->get($path, $handler);
}

function run() {
    global $app;
    $app->run();
}
?>