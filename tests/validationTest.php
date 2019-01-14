<?php
/**
 * ControlCentre
 * To ensure robot working properly, for example, validation, report
 *
 * Validate position and face
 *
 * @category    Robot Simulator
 * @package     ControlCentre
 * @copyright   Copyright ©
 * @license     https://creativecommons.org/licenses/by-sa/4.0/legalcode
 * @version     1.0.0, 06/12/2018
 * @author
 */
namespace ControlCentre;

use ControlCentre\BaseController as BC;

/**
 * Class ValidationTest
 * Make unit test for Validation class.
 * @package ControlCentre
 */
class ValidationTest extends \PHPUnit\Framework\TestCase
{

	/**
	 * @var Validation
	 */
	private $validator;
	public function setUp() {
		$this->validator = new Validation();
	}

    /**
     * Test Validation class Validate() method, when robot is placed at origin with different faces
     */
	public function testValidate_OriginFaces_ShouldValid() {
		foreach (BC::VALID_FACES as $face) {
			$this->assertTrue($this->validator->validate(BC::MIN_UNIT_X, BC::MIN_UNIT_Y, $face), "Failed to validate origin with face $face");
		}
	}

    /**
     * Test Validation class Validate() method, when robot is placed at top left corner with different faces
     */
	public function testValidate_TopLeftFaces_ShouldValid() {
		foreach (BC::VALID_FACES as $face) {
			$this->assertTrue($this->validator->validate(BC::MIN_UNIT_X, BC::MAX_UNIT_Y, $face), "Failed to validate top-left position with face $face");
		}
	}

    /**
     * Test Validation class Validate() method, when robot is placed at top right corner with different faces
     */
	public function testValidate_TopRightFaces_ShouldValid() {
		foreach (BC::VALID_FACES as $face) {
			$this->assertTrue($this->validator->validate(BC::MAX_UNIT_X, BC::MAX_UNIT_Y, $face), "Failed to validate top-right with face $face");
		}
	}

    /**
     * Test Validation class Validate() method, when robot is placed at bottom right corner with different faces
     */
	public function testValidate_BottomRightFaces_ShouldValid() {
		foreach (BC::VALID_FACES as $face) {
			$this->assertTrue($this->validator->validate(BC::MAX_UNIT_X, BC::MIN_UNIT_Y, $face), "Failed to validate bottom-right with face $face");
		}
	}

    /**
     * Test Validation class Validate() method, when robot is placed in the middle with different faces
     */
	public function testValidate_MiddleFaces_ShouldValid() {
		list($middle_x, $middle_y) = BC::get_middle_position();

		foreach (BC::VALID_FACES as $face) {
			$this->assertTrue($this->validator->validate($middle_x, $middle_y, $face), "Failed to validate top-right with face $face");
		}
	}

    /**
     * Test Validation class Validate() method, when robot is placed somewhere (may or may not be valid position) with invalid face
     */
    public function testValidate_FacesOutsideScope_ShouldInvalid() {
		foreach (BC::VALID_FACES as $key => $face) {
			$invalid_face = $face . '-' . BC::VALID_FACES[($key + 1) % 4];
			foreach (BC::CORNERS as $corner) {
				list($corner_x, $corner_y) = $corner;
				$this->assertFalse($this->validator->validate($corner_x, $corner_y, $invalid_face), "Failed to validate position ($corner_x, $corner_y) with face $face");
				$pos_x = $corner_x + 2;  //might be out of range
				$pos_y = $corner_y + 2;  //might be out of range
				$this->assertFalse($this->validator->validate($pos_x, $pos_y, $invalid_face), "Failed to validate position ($pos_x, $pos_y) with face $face");
			}
		}
	}
}
