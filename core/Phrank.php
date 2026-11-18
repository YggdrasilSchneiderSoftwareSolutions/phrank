<?php
use \Phrank\App;

require __DIR__ . '/App.php';

$app = new App();

/**
 * Configure the application
 * @param callable $callback The configuration callback
 */
function configure(callable $callback) {
    // Hier können Konfigurationsoptionen gesetzt werden, z.B. BasePath
    global $app;
    $app->configure($callback);
}

/**
 * Register a before middleware
 * @param callable $callback The middleware function
 */
function before(callable $callback) {
    // Hier können Middleware-Funktionen registriert werden, die vor jeder Anfrage ausgeführt werden
    global $app;
    $app->before($callback);
}

/**
 * Register an after middleware
 * @param callable $callback The middleware function
 */
function after(callable $callback) {
    // Hier können Middleware-Funktionen registriert werden, die nach jeder Anfrage ausgeführt werden
    global $app;
    $app->after($callback);
}

/**
 * Register a GET route
 * @param string $path The route path
 * @param callable $handler The handler function for the route
 */
function get(string $path, callable $handler) {
    global $app;
    $app->get($path, $handler);
}

/**
 * Register a POST route
 * @param string $path The route path
 * @param callable $handler The handler function for the route
 */
function post(string $path, callable $handler) {
    global $app;
    $app->post($path, $handler);
}

/**
 * Register a PUT route
 * @param string $path The route path
 * @param callable $handler The handler function for the route
 */
function put(string $path, callable $handler) {
    global $app;
    $app->put($path, $handler);
}

/**
 * Register a PATCH route
 * @param string $path The route path
 * @param callable $handler The handler function for the route
 */
function patch(string $path, callable $handler) {
    global $app;
    $app->patch($path, $handler);
}

/**
 * Register a DELETE route
 * @param string $path The route path
 * @param callable $handler The handler function for the route
 */
function delete(string $path, callable $handler) {
    global $app;
    $app->delete($path, $handler);
}

/**
 * Register an OPTIONS route
 * @param string $path The route path
 * @param callable $handler The handler function for the route
 */
function options(string $path, callable $handler) {
    global $app;
    $app->options($path, $handler);
}

/**
 * Get all configuration settings
 * @return array The configuration settings
 */
function settings() {
    global $app;
    return $app->getConfig()->getAll();
}

/**
 * Run the application
 */
function run() {
    global $app;
    $app->run();
}
