<?php
namespace Phrank;

require_once __DIR__ . '/Configuration.php';

class App {
    private array $registeredRoutes;
    private Configuration $config;

    public function __construct() {
        $this->registeredRoutes = [];
        $this->config = new Configuration();

        // Default Konfiguration setzen
        $this->config->setEnvironment('development');
    }

    public function configure(callable $callback): void {
        $callback($this->config);
        if ($this->config->getEnvironment() === 'development') {
            echo "Configuration set:<br>";
            echo "BasePath: " . $this->config->getBasePath() . "<br>";
            echo "Environment: " . $this->config->getEnvironment() . "<br>";
        }
    }

    public function get(string $route, callable $handler): void {
        // Wir normalieren den Pfad (abschließende Slashes entfernen)
        $trimmedPath = rtrim($route, '/') ?: '/';
        $this->registerRoute('GET',$route, $handler);
    }

    public function run(): void {
        $request = $_SERVER['REQUEST_URI'];
        // Entfernt eventuelle Query-Strings (?id=123) für sauberes Matching
        $uri = parse_url($request, PHP_URL_PATH);
        // Bei Home '/' oder BasePath '/' wird der Pfad auf '/' gesetzt, ansonsten wird der Pfad normalisiert
        $path = $uri;
        if ($uri !== $this->config->getBasePath() . '/') {
            $path = rtrim($uri, '/') ?: '/';
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $handler = $this->registeredRoutes['GET'][$path];
            if (isset($handler)) {
                if (is_callable($handler)) {
                    $handler();
                }
            } else {
                http_response_code(404);
                echo 'Unsupported route: ' . $_SERVER['SCRIPT_URI'];
            }
        }
    }

    private function registerRoute(string $method, string $route, callable $handler): void {
        // BasePath konfigurieren, damit dieser nicht in den Routen angegeben werden muss
        $route = $this->config->getBasePath() . $route;
        $this->registeredRoutes[$method][$route] = $handler;

        if ($this->config->getEnvironment() === 'development') {
            echo "Registered route: $method $route<br><br>";
        }
    }
}
