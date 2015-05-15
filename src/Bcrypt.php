<?php

namespace Bleicker\Encryption;

use Bleicker\Encryption\Exception\EncryptionFailedException;
use Bleicker\Encryption\Exception\IterationException;

/**
 * Class Bcrypt
 *
 * @package Bleicker\Bcrypt
 */
class Bcrypt implements OneWayInterface {

	/**
	 * @param mixed $source
	 * @param mixed $iterations
	 * @return string
	 * @throws EncryptionFailedException
	 */
	public static function encrypt($source, $iterations = 4) {
		$salt = static::salt($iterations);
		$encrypted = crypt($source, $salt);
		if ($encrypted === '*0') {
			throw new EncryptionFailedException('Encryption failed.', 1431692855);
		}
		return $encrypted;
	}

	/**
	 * @param string $source
	 * @param string $encrypted
	 * @return boolean
	 */
	public static function validate($source, $encrypted) {
		return crypt($source, substr($encrypted, 0, 30)) === $encrypted;
	}

	/**
	 * @param mixed $iterations
	 * @return string
	 * @throws IterationException
	 */
	protected static function salt($iterations) {
		if ($iterations < 4 || $iterations > 31) {
			throw new IterationException('Iterations > 4 and < 31 required. Got "' . $iterations . '".', 1431692854);
		}
		$iterations = sprintf('%02d', $iterations);
		$stack = './0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$salt = substr(str_shuffle($stack), 0, 22);
		return '$2a$' . $iterations . '$' . $salt;
	}
}
