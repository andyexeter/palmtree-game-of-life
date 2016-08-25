<?php

namespace Palmtree\GameOfLife;

use Guzzle\Http\Message\RequestInterface;
use Palmtree\GameOfLife\MapView\HtmlTableMapView;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Chat implements MessageComponentInterface {
	protected $clients;
	protected $callback;

	public function __construct( $callback ) {
		$this->clients  = new \SplObjectStorage;
		$this->callback = $callback;
	}

	public function onOpen( ConnectionInterface $conn ) {
		// Store the new connection to send messages to later
		$this->clients->attach( $conn );

		echo "New connection! ({$conn->resourceId})\n";
	}

	public function onMessage( ConnectionInterface $from, $msg ) {
		$numRecv = count( $this->clients ) - 1;
		echo sprintf( 'Connection %d sending message "%s" to %d other connection%s' . "\n"
			, $from->resourceId, $msg, $numRecv, (int) $numRecv === 1 ? '' : 's' );

		/*foreach ( $this->clients as $client ) {
			if ( $from !== $client ) {
				// The sender is not the receiver, send to each client connected
				$client->send( $msg );
			}
		}*/

		/** @var World $world */
		$world = $from->World;

		$view     = $world->getView()->render();
		$continue = $world->tick();

		if ( $continue ) {
			$from->send( $view );
		} else {
			$from->send( '' );
		}
	}

	public function onClose( ConnectionInterface $conn ) {
		// The connection is closed, remove it, as we can no longer send it messages
		$this->clients->detach( $conn );

		echo "Connection {$conn->resourceId} has disconnected\n";
	}

	public function onError( ConnectionInterface $conn, \Exception $e ) {
		echo "An error has occurred: {$e->getMessage()}\n";

		$conn->close();
	}

	public function close() {
		call_user_func( $this->callback );
	}
}
