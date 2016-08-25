<?php

namespace Palmtree\GameOfLife;

use Guzzle\Http\Message\RequestInterface;
use Palmtree\GameOfLife\MapView\HtmlTableMapView;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServerInterface;
use Ratchet\MessageComponentInterface;

class HttpChat implements HttpServerInterface {
	private $component;

	/**
	 * @inheritDoc
	 */
	public function onOpen( ConnectionInterface $conn, RequestInterface $request = null ) {
		$path   = realpath( __DIR__ . '/../../..' );
		$config = require_once $path . '/config/config.php';

		$world = new World( [
			//'size'     => $config['size'],
			'size'     => 100,
			'seed'     => $config['seed'],
			'ticks'    => $config['ticks'],
			'tickSecs' => $config['tickSecs'],
		] );

		$mapView = new HtmlTableMapView( $world->getMap() );

		$world->setView( $mapView );
		$conn->World = $world;

		$conn->send( $world->getView()->render() );
		$this->component->onOpen( $conn );
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
