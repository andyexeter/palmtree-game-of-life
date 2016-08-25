<?php

namespace Palmtree\GameOfLife;

use Palmtree\GameOfLife\Geometry\Point;
use Palmtree\GameOfLife\MapView\MapViewInterface;

/**
 * Class World
 * @package Palmtree\GameOfLife
 */
class World {
	/**
	 * @var Map
	 */
	private $map;
	/**
	 * @var array
	 */
	private $settings = [ ];
	/** @var  MapViewInterface $view */
	private $view;

	/**
	 * @var float
	 */
	private $secondsElapsed;
	/**
	 * @var int|mixed
	 */
	private $microSecondsPerTick = 0;

	/**
	 * @var string
	 */
	private $result;

	/**
	 * @var array
	 */
	public static $defaults = [
		'size'     => 4,
		'seed'     => [ ],
		'tickSecs' => 0,
	];

	/**
	 * World constructor.
	 *
	 * @param array $args
	 */
	public function __construct( array $args ) {
		$this->settings = $this->parseArgs( $args );

		$oneMillion                = 1000000;
		$this->microSecondsPerTick = $this->settings['tickSecs'] * $oneMillion;

		$this->map = new Map();

		$this->build();
	}

	/**
	 *
	 */
	private function build() {
		for ( $y = 0; $y < $this->settings['size']; $y++ ) {
			for ( $x = 0; $x < $this->settings['size']; $x++ ) {
				$cell = new Cell( $this->getMap(), new Point( $x, $y ) );

				$isAlive = $this->findSeed( $cell->getPoint() );
				$cell->setAlive( $isAlive );

				$this->getMap()->addCell( $cell );
			}
		}
	}

	/**
	 *
	 */
	public function start() {
		$timeStarted = microtime( true );

		$continue = true;
		for ( $ticks = 0; $ticks < $this->settings['ticks'] && $continue; $ticks++ ) {
			echo $this->getView()->render();

			$continue = $this->tick();
		}

		$timeEnded = microtime( true );

		$this->secondsElapsed = $timeEnded - $timeStarted;

		$time = $this->formatSeconds( $this->secondsElapsed );

		if ( $continue === false ) {
			$this->result = "World extinct after $ticks ticks ($time)";
		} else {
			$this->result = "Generation ended after $ticks ticks ($time)";
		}
	}

	/**
	 * @return bool
	 */
	public function tick() {
		$tickStarted = microtime( true );
		/** @var Cell[] $cellsToLive */
		$cellsToLive = [ ];
		/** @var Cell[] $cellsToDie */
		$cellsToDie = [ ];

		$totalCells     = 0;
		$totalDeadCells = 0;

		/** @var Cell[] $cells */
		foreach ( $this->getMap()->getCells() as $y => $cells ) {
			foreach ( $cells as $x => $cell ) {
				$neighboursAlive = 0;
				$totalCells++;

				if ( ! $cell->isAlive() ) {
					$totalDeadCells++;
				}

				foreach ( $cell->getNeighbours() as $neighbour ) {
					if ( $neighbour->isAlive() ) {
						$neighboursAlive++;
					}
				}

				if ( $cell->isAlive() && $neighboursAlive < 2 ) {
					// Loneliness
					$cellsToDie[] = $cell;
				} elseif ( $cell->isAlive() && $neighboursAlive > 3 ) {
					// Over-population
					$cellsToDie[] = $cell;
				} else if ( ! $cell->isAlive() && $neighboursAlive === 3 ) {
					// Reproduction
					$cellsToLive[] = $cell;
				}
			}
		}

		foreach ( $cellsToLive as $cell ) {
			$cell->setAlive( true );
		}

		foreach ( $cellsToDie as $cell ) {
			$cell->setAlive( false );
		}

		$tickEnded = microtime( true );

		if ( $this->microSecondsPerTick > 0 ) {
			usleep( $this->microSecondsPerTick - ( $tickEnded - $tickStarted ) );
		}

		if ( $totalDeadCells >= $totalCells ) {
			return false;
		}

		return true;
	}

	/**
	 * @param Point $point
	 *
	 * @return bool
	 */
	public function findSeed( Point $point ) {
		if ( empty( $this->settings['seed'] ) || ! is_array( $this->settings['seed'] ) ) {
			return false;
		}

		$seedKey = array_search( $point->getCoordinates(), $this->settings['seed'] );

		if ( $seedKey === false ) {
			return false;
		}

		return true;
	}

	/**
	 * @return Map
	 */
	public function getMap() {
		return $this->map;
	}

	/**
	 * @param MapViewInterface $view
	 *
	 * @return World
	 */
	public function setView( MapViewInterface $view ) {
		$this->view = $view;

		return $this;
	}

	/**
	 * @return MapViewInterface
	 */
	public function getView() {
		return $this->view;
	}

	/**
	 * @param int $seconds
	 *
	 * @return string
	 */
	private function formatSeconds( $seconds ) {
		$hours   = floor( $seconds / 3600 );
		$minutes = floor( ( $seconds / 60 ) % 60 );
		$seconds = $seconds % 60;

		return sprintf( '%02d:%02d:%02d', $hours, $minutes, $seconds );
	}

	/**
	 * @param array $args
	 *
	 * @return array
	 */
	private function parseArgs( array $args = array() ) {
		return array_replace_recursive( self::$defaults, $args );
	}

	/**
	 * @return string
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * @return float
	 */
	public function getSecondsElapsed() {
		return $this->secondsElapsed;
	}

	/**
	 * @return string
	 */
	public function getTimeElapsed() {
		return $this->formatSeconds( $this->secondsElapsed );
	}
}
