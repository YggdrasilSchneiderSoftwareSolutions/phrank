<?php
use \Phrank\App;

require __DIR__ . '/core/App.php';

$app = new App();

$app->get('/phrank', function() {
    echo "Hello Word!";
});

$app->run();

?>