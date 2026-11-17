<?php
namespace Phrank;

require_once __DIR__ . '/Configuration.php';

class App {
    private array $registeredRoutes;
    private Configuration $config;
    private $beforeMiddleware;
    private $afterMiddleware;


    public function __construct() {
        $this->registeredRoutes = [];
        $this->config = new Configuration();
        $this->beforeMiddleware = null;
        $this->afterMiddleware = null;

        // Default Konfiguration setzen
        $this->config->setEnvironment('development');
    }

    public function configure(callable $callback): void {
        $callback($this->config);
        if ($this->config->isDebugMode()) {
            echo "Configuration set:<br>";
            echo "BasePath: " . $this->config->getBasePath() . "<br>";
            echo "Environment: " . $this->config->getEnvironment() . "<br><br>";
        }
    }

    public function before(callable $callback): void {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException("The provided before middleware is not callable.");
        }
        if ($this->config->isDebugMode()) {
            echo "Before middleware registered.<br>";
        }
        $this->beforeMiddleware = $callback;
    }

    public function after(callable $callback): void {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException("The provided after middleware is not callable.");
        }
        if ($this->config->isDebugMode()) {
            echo "After middleware registered.<br>";
        }
        $this->afterMiddleware = $callback;
    }

    public function get(string $route, callable $handler): void {
        // Wir normalieren den Pfad (abschließende Slashes entfernen)
        $trimmedPath = rtrim($route, '/') ?: '/';
        $this->registerRoute('GET',$trimmedPath, $handler);
    }

    public function post(string $route, callable $handler): void {
        // Wir normalisieren den Pfad (abschließende Slashes entfernen)
        $trimmedPath = rtrim($route, '/') ?: '/';
        $this->registerRoute('POST', $trimmedPath, $handler);
    }

    public function options(string $route, callable $handler): void {
        // Wir normalisieren den Pfad (abschließende Slashes entfernen)
        $trimmedPath = rtrim($route, '/') ?: '/';
        $this->registerRoute('OPTIONS', $trimmedPath, $handler);
    }

    public function run(): void {
        // Vor der Anfrage Middleware ausführen, falls vorhanden
        if (isset($this->beforeMiddleware)) {
            ($this->beforeMiddleware)();
        }

        $request = $_SERVER['REQUEST_URI'];
        // Entfernt eventuelle Query-Strings (?id=123) für sauberes Matching
        $uri = parse_url($request, PHP_URL_PATH);
        // Bei Home '/' oder BasePath '/' wird der Pfad auf '/' gesetzt, ansonsten wird der Pfad normalisiert
        $path = $uri;
        if ($uri !== $this->config->getBasePath() . '/') {
            $path = rtrim($uri, '/') ?: '/';
        }
        
        $method = $_SERVER['REQUEST_METHOD'];
        $handler = $this->registeredRoutes[$method][$path] ?? null;
        if (is_callable($handler)) {
            $handler();
        } else {
            http_response_code(404);
            echo 'Unsupported route: ' . $_SERVER['SCRIPT_URI'];
        }

        // Nach der Anfrage Middleware ausführen, falls vorhanden
        if (isset($this->afterMiddleware)) {
            ($this->afterMiddleware)();
        }
    }

    private function registerRoute(string $method, string $route, callable $handler): void {
        // BasePath konfigurieren, damit dieser nicht in den Routen angegeben werden muss
        $route = $this->config->getBasePath() . $route;
        $this->registeredRoutes[$method][$route] = $handler;

        if ($this->config->isDebugMode()) {
            echo "Registered route: $method $route<br>";
        }
    }
}
