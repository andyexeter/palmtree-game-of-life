<?php

use Palmtree\GameOfLife\Controller\AboutController;
use Palmtree\GameOfLife\Controller\HomeController;
use Ratchet\App;

require dirname( __DIR__ ) . '/vendor/autoload.php';

$app = new App( 'localhost', 8080, '127.0.0.1' );

$app->route( '/', new HomeController(), [ '*' ] );
$app->route( '/about/*', new AboutController(), [ '*' ] );

$app->run();
