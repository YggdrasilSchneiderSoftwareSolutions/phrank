<?php
require __DIR__ . '/core/Phrank.php';

get('/phrank', function() {
    echo "Hello World!";
});

run();

?>