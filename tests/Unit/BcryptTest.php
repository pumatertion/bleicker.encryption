<?php

namespace Tests\Bleicker\Encryption\Unit;

use Bleicker\Encryption\Bcrypt;
use Tests\Bleicker\Encryption\UnitTestCase;

/**
 * Class BcryptTest
 *
 * @package Unit
 */
class BcryptTest extends UnitTestCase {

	/**
	 * @test
	 */
	public function bcryptTest() {
		$source = uniqid();
		$encrypted = Bcrypt::encrypt($source);
		$this->assertNotEquals($source, $encrypted);
		$this->assertEquals(60, strlen($encrypted));
	}

	/**
	 * @test
	 */
	public function notUniqueTest() {
		$source = uniqid();
		$encrypted1 = Bcrypt::encrypt($source);
		$encrypted2 = Bcrypt::encrypt($source);
		$this->assertNotEquals($encrypted1, $encrypted2);
	}

	/**
	 * @test
	 */
	public function validateTest() {
		$source = uniqid();
		$encrypted = Bcrypt::encrypt($source);
		$this->assertTrue(Bcrypt::validate($source, $encrypted));
		$this->assertFalse(Bcrypt::validate(uniqid(), $encrypted));
	}

	/**
	 * @test
	 * @expectedException \Bleicker\Encryption\Exception\IterationException
	 */
	public function iterationMaxTest() {
		$source = uniqid();
		Bcrypt::encrypt($source, 32);
	}

	/**
	 * @test
	 * @expectedException \Bleicker\Encryption\Exception\IterationException
	 */
	public function iterationMinTest() {
		$source = uniqid();
		Bcrypt::encrypt($source, 3);
	}
}
