<?php
require_once __DIR__ . '/core/Phrank.php';

configure(function($config) {
    $config->setBasePath('/phrank');
});

get('/', function() {
    echo "Hello World!";
});

run();

?>