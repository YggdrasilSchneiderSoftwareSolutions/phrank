<?php
use \Phrank\App;

require __DIR__ . '/App.php';

$app = new App();

function configure(callable $callback) {
    // Hier können Konfigurationsoptionen gesetzt werden, z.B. BasePath
    global $app;
    $app->configure($callback);
}

function before(callable $callback) {
    // Hier können Middleware-Funktionen registriert werden, die vor jeder Anfrage ausgeführt werden
    global $app;
    $app->before($callback);
}

function after(callable $callback) {
    // Hier können Middleware-Funktionen registriert werden, die nach jeder Anfrage ausgeführt werden
    global $app;
    $app->after($callback);
}

function get(string $path, callable $handler) {
    global $app;
    $app->get($path, $handler);
}

function run() {
    global $app;
    $app->run();
}
