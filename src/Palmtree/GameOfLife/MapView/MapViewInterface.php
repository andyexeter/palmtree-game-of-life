<?php

namespace Palmtree\GameOfLife\MapView;

use Palmtree\GameOfLife\Map;

/**
 * Interface MapViewInterface
 * @package    Palmtree\GameOfLife
 * @subpackage MapView
 */
interface MapViewInterface {
	/**
	 * MapViewInterface constructor.
	 *
	 * @param Map $map
	 */
	public function __construct( Map $map );

	/**
	 * @return mixed
	 */
	public function render();
}
