<?php

namespace Palmtree\GameOfLife\MapView;

use Palmtree\GameOfLife\Cell;
use Palmtree\GameOfLife\Html\HtmlTable;
use Palmtree\GameOfLife\Map;

/**
 * Class HtmlTableMapView
 * @package    Palmtree\GameOfLife
 * @subpackage MapView
 */
class HtmlTableMapView implements MapViewInterface {
	/**
	 * @var Map
	 */
	private $map;

	/**
	 * HtmlTableMapView constructor.
	 *
	 * @param Map $map
	 */
	public function __construct( Map $map ) {
		$this->map = $map;
	}

	/**
	 * @return string
	 */
	public function render() {
		$table = new HtmlTable();
		/**
		 * @var Cell[] $cells
		 */
		foreach ( $this->map->getCells() as $y => $cells ) {
			$data = array();
			foreach ( $cells as $x => $cell ) {
				if ( $cell->isAlive() ) {
					$data[] = 'X';
				} else {
					$data[] = ' ';
				}
			}

			$table->addRow( $data );
		}

		return $table->render();
	}
}
