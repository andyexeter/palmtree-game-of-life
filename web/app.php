<?php
use Palmtree\GameOfLife\MapView\HtmlTableMapView;
use Palmtree\GameOfLife\World;

require_once __DIR__ . '/vendor/autoload.php';

//$config = require __DIR__ . '/config/config.php' ;

$world = new World( [
	'size'     => $config['size'],
	'seed'     => $config['seed'],
	'ticks'    => $config['ticks'],
	'tickSecs' => $config['tickSecs'],
] );

$mapView = new HtmlTableMapView( $world->getMap() );

$world->setView( $mapView );
$world->start();

echo $world->getResult() . "\n";
