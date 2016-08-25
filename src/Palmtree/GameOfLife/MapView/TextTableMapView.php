<?php

namespace Palmtree\GameOfLife\MapView;

use Palmtree\GameOfLife\Cell;
use Palmtree\GameOfLife\Map;

/**
 * Class TextTableMapView
 * @package    Palmtree\GameOfLife
 * @subpackage MapView
 */
class TextTableMapView implements MapViewInterface {
	/**
	 * @var Map
	 */
	private $map;

	/**
	 * TextTableMapView constructor.
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
		$table = new \Console_Table();
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

		$view = $table->getTable();

		$output = $this->prepareScreen( $view );
		$output .= $view;

		return $output;
	}

	/**
	 * @param string $view
	 *
	 * @return string
	 */
	private function prepareScreen( $view ) {
		$output = "\n";
		$parts  = explode( "\n", $view );

		for ( $i = count( $parts ) - 1, $j = 0; $i >= $j; $i-- ) {
			$output .= str_repeat( "\x08", mb_strlen( $parts[ $i ] ) );
			$output .= "\033[1A";
		}

		// @todo: Work out why this is needed - Top line remains without it.
		$output .= "\033[1A";
		$output .= str_repeat( "\x08", mb_strlen( $parts[0] ) );

		$output .= "\n";

		return $output;
	}
}
