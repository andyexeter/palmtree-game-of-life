<?php

namespace Palmtree\GameOfLife\Controller;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Palmtree\GameOfLife\Service\Template;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServerInterface;

abstract class AbstractController implements HttpServerInterface {
	protected $response;
	protected $template;

	public function __construct() {
		$this->response = new Response( 200, [
			'Content-Type' => 'text/html; charset=utf-8',
		] );

		$this->template = new Template( [
			'path' => realpath( __DIR__ . '/../../../view' ),
		] );
	}

	abstract public function index();

	/**
	 * @inheritDoc
	 */
	public function onOpen( ConnectionInterface $conn, RequestInterface $request = null ) {
		$this->index();

		$this->close( $conn );
	}

	/**
	 * @inheritDoc
	 */
	public function onClose( ConnectionInterface $conn ) {
	}

	/**
	 * @inheritDoc
	 */
	public function onError( ConnectionInterface $conn, \Exception $e ) {
	}

	/**
	 * @inheritDoc
	 */
	public function onMessage( ConnectionInterface $from, $msg ) {
	}

	protected function close( ConnectionInterface $conn ) {
		$conn->send( $this->response );

		$conn->close();
	}
}
