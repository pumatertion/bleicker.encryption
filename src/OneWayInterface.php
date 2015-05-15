<?php

namespace Bleicker\Encryption;

/**
 * Interface OneWayInterface
 *
 * @package Bleicker\Bcrypt
 */
interface OneWayInterface {

	/**
	 * @param mixed $source
	 * @return string
	 */
	public static function encrypt($source);

	/**
	 * @param string $source
	 * @param string $encrypted
	 * @return mixed
	 */
	public static function validate($source, $encrypted);
}
