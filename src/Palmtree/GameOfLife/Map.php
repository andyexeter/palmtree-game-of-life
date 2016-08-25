<?php

namespace Palmtree\GameOfLife;

use Palmtree\GameOfLife\Geometry\Point;

/**
 * Class Map
 * @package Palmtree\GameOfLife
 */
class Map {
	/** @var Cell[][] $cells */
	private $cells = [ ];

	/**
	 * @param Point $point
	 *
	 * @return Cell|null
	 */
	public function getCell( Point $point ) {
		if ( ! isset( $this->cells[ $point->x ][ $point->y ] ) ) {
			return null;
		}

		return $this->cells[ $point->x ][ $point->y ];
	}

	/**
	 * @param Cell $cell
	 *
	 * @return bool
	 */
	public function addCell( Cell $cell ) {
		$this->cells[ $cell->getPoint()->x ][ $cell->getPoint()->y ] = $cell;

		return true;
	}

	/**
	 * @param Point[] $points
	 *
	 * @return Cell[][]|Cell[]
	 */
	public function getCells( array $points = [ ] ) {
		if ( empty( $points ) ) {
			return $this->cells;
		}

		$cells = [ ];

		foreach ( $points as $point ) {
			$cell = $this->getCell( $point );

			if ( $cell instanceof Cell ) {
				$cells[] = $cell;
			}
		}

		return $cells;
	}
}
