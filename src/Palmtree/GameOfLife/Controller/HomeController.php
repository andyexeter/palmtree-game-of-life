<?php

namespace Palmtree\GameOfLife\Controller;

class HomeController extends AbstractController {
	public function index() {
		$this->template->addData( 'heading', 'Hello World!' );

		$this->response->setBody( $this->template->fetch( 'default' ) );
	}
}
