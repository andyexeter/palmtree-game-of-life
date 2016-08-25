<?php

require dirname( __DIR__ ) . '/vendor/autoload.php';

use Palmtree\GameOfLife\Chat;
use Palmtree\GameOfLife\HttpChat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

$wsServer = IoServer::factory(
	new HttpServer(
		new WsServer(
			new HttpChat(
				new Chat( '' )
			)
		)
	),
	8000
);

$wsServer->run();
