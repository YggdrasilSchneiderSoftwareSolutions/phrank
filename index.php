<?php
require_once __DIR__ . '/core/Phrank.php';

configure(function($config) {
    $config->setBasePath('/phrank')
           ->setEnvironment('development')
           ->setDebugMode(true)
           ->set('user', 'Frank');
});

before(function() {
    header('content-type: text/html; charset=utf-8');
    header('access-control-allow-origin: *');
    header('access-control-allow-methods: GET, POST, OPTIONS');
    echo "Before middleware executed.<br>";
});

after(function() {
    echo "After middleware executed.<br>";
});

get('/', function() {
    echo "<h4>Hello, World!</h4>";
});

get('/hello', function() {
    $name = $_GET['name'] ?? settings()['user'] ?? 'World';
    echo "<h4>Hello, $name!</h4>";
});

post('/hello', function() {
    $name = $_POST['name'] ?? 'World';
    echo "<h4>Hello, $name!</h4>";
    http_response_code(201); // Created
});

options('/hello', function() {
    echo "<h4>OPTIONS request received.</h4>";
    header('Allow: GET, POST, OPTIONS');
    http_response_code(204); // No Content
});

run();

?>