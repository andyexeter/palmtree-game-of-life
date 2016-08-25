<?php

require dirname( __DIR__ ) . '/vendor/autoload.php';

use Palmtree\GameOfLife\Chat;
use Palmtree\GameOfLife\HttpChat;
use Ratchet\App;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

/*$app = new App( 'localhost', 8080, '127.0.0.1' );
$app->route( '/test', new Chat(), [ '*' ] );

$app->run();*/

$httpServer = IoServer::factory(
	new HttpServer(
		new HttpChat(
			new Chat( 'stopCallback' )
		)
	),
	8080
);

/*$wsServer = IoServer::factory(
	new WsServer(
		new Chat()
	),
	8000
);*/

$httpServer->run();

function stopCallback() {
	global $httpServer;
	$httpServer->loop->stop();
}
