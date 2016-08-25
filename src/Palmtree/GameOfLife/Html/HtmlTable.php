<?php

namespace Palmtree\GameOfLife\Html;

use Palmtree\GameOfLife\Service\Template;

class HtmlTable {
	private $headers = array();
	private $rows = array();

	public function __construct() {

	}

	public function addHeader( $header ) {
		$this->headers[] = $header;
	}

	public function addRow( $row ) {
		$this->rows[] = $row;
	}

	public function render() {
		$template = new Template();

		$template->addData( 'headers', $this->getHeaders() )->addData( 'rows', $this->getRows() );

		return $template->fetch( GOL_VIEW_DIR . '/MapView/html-table-map.php' );
	}

	/**
	 * @return array
	 */
	public function getRows() {
		return $this->rows;
	}

	/**
	 * @return array
	 */
	public function getHeaders() {
		return $this->headers;
	}
}
