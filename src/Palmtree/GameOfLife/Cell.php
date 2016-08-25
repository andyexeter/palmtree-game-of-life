<?php

namespace Palmtree\GameOfLife;

use Palmtree\GameOfLife\Geometry\Point;

/**
 * Class Cell
 * @package Palmtree\GameOfLife
 */
class Cell {
	/** @var bool $alive */
	private $alive;
	/** @var Map $map */
	private $map;
	/** @var Point $point */
	private $point;

	/**
	 * Cell constructor.
	 *
	 * @param Map   $map
	 * @param Point $point
	 */
	public function __construct( Map $map, Point $point ) {
		$this->map   = $map;
		$this->point = $point;
	}

	/**
	 *
	 * @return Cell[]
	 */
	public function getNeighbours() {
		$point = $this->getPoint();

		$neighbours = $this->map->getCells( [
			new Point( $point->x, $point->y - 1 ), // north
			new Point( $point->x, $point->y + 1 ), // south
			new Point( $point->x + 1, $point->y ), // east
			new Point( $point->x - 1, $point->y ), // west
			new Point( $point->x + 1, $point->y - 1 ), // north east
			new Point( $point->x + 1, $point->y + 1 ), // south east
			new Point( $point->x - 1, $point->y + 1 ), // south west
			new Point( $point->x - 1, $point->y - 1 ), // north west
		] );

		return $neighbours;
	}

	/**
	 * @param boolean $alive
	 *
	 * @return Cell
	 */
	public function setAlive( $alive ) {
		$this->alive = $alive;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isAlive() {
		return $this->alive;
	}

	/**
	 * @return Point
	 */
	public function getPoint() {
		return $this->point;
	}
}
