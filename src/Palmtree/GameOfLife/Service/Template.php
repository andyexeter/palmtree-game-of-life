<?php

namespace Palmtree\GameOfLife\Service;

/**
 * Class Template
 * @package    Palmtree\GameOfLife
 * @subpackage Service
 */
class Template {
	/**
	 * @var string
	 */
	private $path = '';
	/**
	 * @var array
	 */
	private $data = [ ];

	/**
	 * Template constructor.
	 *
	 * @param array $args
	 */
	public function __construct( array $args = [ ] ) {
		if ( isset( $args['path'] ) ) {
			$this->setPath( $args['path'] );
		}

		if ( isset( $args['data'] ) ) {
			$this->setData( $args['data'] );
		}
	}

	/**
	 * @param $file
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function fetch( $file ) {
		$path = $this->getPath();

		if ( ! empty( $path ) ) {
			$file = $path . $file;
		}

		$file = dirname( $file ) . '/' . basename( $file, '.php' ) . '.php';

		if ( ! file_exists( $file ) ) {
			throw new \Exception( "The file '$file' does not exist." );
		}

		extract( $this->getData() );

		ob_start();

		include $file;

		return ob_get_clean();
	}

	/**
	 * @param string $key
	 * @param mixed  $value
	 */
	public function addData( $key, $value ) {
		$this->data[ $key ] = $value;

		return $this;
	}

	/**
	 * @param array $data
	 *
	 * @return Template
	 */
	public function setData( array $data ) {
		$this->data = $data;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @param string $path
	 *
	 * @return Template
	 */
	public function setPath( $path ) {
		$this->path = rtrim( $path, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPath() {
		return $this->path;
	}
}
