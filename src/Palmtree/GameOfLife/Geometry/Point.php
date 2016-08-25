<?php

namespace Palmtree\GameOfLife\Geometry;

/**
 * Class Point
 * @package    Palmtree\GameOfLife
 * @subpackage Geometry
 */
class Point {
	/** @var int $x */
	public $x;
	/** @var int $y */
	public $y;

	/**
	 * Point constructor.
	 *
	 * If the first argument is an array it is assumed to be
	 * an array containing both x and y positions and the second
	 * argument is discarded.
	 *
	 * @param int|array $x
	 * @param int|null  $y
	 */
	public function __construct( $x = 0, $y = 0 ) {
		if ( func_num_args() === 1 && is_array( $x ) ) {
			$x = $x[0];
			$y = $x[1];
		}

		$this->x = $x;
		$this->y = $y;
	}

	/**
	 * Returns the x and y positions as an array.
	 *
	 * @return int[]
	 */
	public function getCoordinates() {
		return [ $this->x, $this->y ];
	}
}
