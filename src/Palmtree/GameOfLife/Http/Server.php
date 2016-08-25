<?php

namespace Palmtree\GameOfLife\Http;

use Guzzle\Http\Message\RequestInterface;
use Palmtree\GameOfLife\MapView\HtmlTableMapView;
use Palmtree\GameOfLife\Service\Template;
use Palmtree\GameOfLife\World;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServerInterface;
use Ratchet\MessageComponentInterface;

class Server implements HttpServerInterface {
	private $component;

	/**
	 * @inheritDoc
	 */
	public function onOpen( ConnectionInterface $conn, RequestInterface $request = null ) {
		$template = new Template();



		$this->component->onOpen( $conn );

		$conn->close();
	}

	public function __construct( MessageComponentInterface $component ) {
		$this->component = $component;
	}

	/**
	 * @inheritDoc
	 */
	public function onClose( ConnectionInterface $conn ) {
		$this->component->onClose( $conn );
	}

	/**
	 * @inheritDoc
	 */
	public function onError( ConnectionInterface $conn, \Exception $e ) {
		$this->component->onError( $conn, $e );
	}

	/**
	 * @inheritDoc
	 */
	public function onMessage( ConnectionInterface $from, $msg ) {
		$this->component->onMessage( $from, $msg );
	}
}
