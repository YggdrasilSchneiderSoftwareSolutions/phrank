<?php
namespace Phrank;

class App {
    private array $registeredRoutes;

    public function __construct() {
        $this->registeredRoutes = [];
    }

    public function get($route, $handler) {
        // Wir normalieren den Pfad (abschließende Slashes entfernen)
        $trimmedPath = rtrim($route, '/') ?: '/';
        $this->registerRoute('GET',$route, $handler);
    }

    public function run() {
        $request = $_SERVER['REQUEST_URI'];
        // Entfernt eventuelle Query-Strings (?id=123) für sauberes Matching
        $uri = parse_url($request, PHP_URL_PATH);
        $path = rtrim($uri, '/') ?: '/';

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

    private function registerRoute($method, $route, $handler) {
        // TODO BasePath konfigurieren, damit dieser nicht in den Routen angegeben werden muss
        //$route = $this->basePath . $route;
        echo "Registering route: $method $route\n"; // Debug-Ausgabe
        $this->registeredRoutes[$method][$route] = $handler;
    }
}
?>