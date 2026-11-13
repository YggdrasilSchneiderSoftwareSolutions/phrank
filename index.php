<?php
require_once __DIR__ . '/core/Phrank.php';

configure(function($config) {
    $config->setBasePath('/phrank');
});

before(function() {
    echo "Before middleware executed.<br>";
});

after(function() {
    echo "After middleware executed.<br>";
});

get('/', function() {
    echo "<h4>Hello World!</h4>";
});

run();

?>