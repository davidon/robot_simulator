<?php
/**
 * InOperation
 * for robot's all ongoing operations
 *
 * @category    Robot Simulator
 * @package     InOperation
 * @copyright   Copyright ©
 * @license     https://creativecommons.org/licenses/by-sa/4.0/legalcode
 * @version     1.0.0, 06/12/2018
 * @author
 */

namespace InOperation;

use ControlCentre\BaseController as BC;
use ControlCentre\Validation;
use PriorOperation\Startup;

/**
 * Class MoveTest
 * Make unit test for Move class.
 * @package InOperation
 */
class MoveTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @var Move
	 */
	protected $move;

    /**
     * initialize for each test case
     */
    public function setUp() {
		$validator = new Validation();
		$startup = new Startup($validator);
		$this->move = new Move(new Startup($validator), new Face($startup), $validator);

	}

    /**
     * destroy testing resources
     */
	public function tearDown() {
	}

    /**
     * set positions and face as PLACE does
     * @param $posx
     * @param $posy
     * @param $face
     */
	protected function setPlace($posx, $posy, $face) {
		$this->move->set_current_position_x($posx);
		$this->move->set_current_position_y($posy);
		$this->setFace($face);
	}

    /**
     * Set face like north etc.
     * @param string $face
     */
	protected function setFace(string $face) {
		$this->move->set_current_face($face);
	}

	/**
	 * The parameters are expected result for assertion
	 * If a parameter is null, it's not needed to assert
	 * @param int|null $posx
	 * @param int|null $posy
	 * @param null|string $face
	 */
	protected function forwardAssert(?int $posx = null, ?int $posy = null, ?string $face = null) {
		$this->move->forward();

		if (!is_null($posx)) {
			$current_position_x = $this->move->get_current_position_x();
			$this->assertEquals($posx, $current_position_x, "Current position-X {$current_position_x} does not match expected {$posx}");
		}

		if (!is_null($posy)) {
			$current_position_y = $this->move->get_current_position_y();
			$this->assertEquals($posy, $current_position_y, "Current position-Y {$current_position_y} does not match expected {$posy}");
		}

		if (!is_null($face)) {
			$this->assertEquals($face, $this->move->get_current_face(), 'Face does not match');
		}

	}

    /**
     * Test Move class forward method, when robot has not been placed
     */
	public function testForward_NotPlaced_ShouldNotMove() {
		$this->move->forward();
		$this->assertNull($this->move->get_current_position_x());
		$this->assertNull($this->move->get_current_position_y());
		$this->assertNull($this->move->get_current_face());
	}

    /**
     * Test Move class forward method, at origin position and facing north
     */
	public function testForward_OriginNorth_ShouldIncreaseY() {
		$this->setPlace(BC::MIN_UNIT_X, BC::MIN_UNIT_Y, BC::FACE_N);
		$this->forwardAssert(BC::MIN_UNIT_X, BC::MIN_UNIT_Y + BC::MOVE_STEP);
	}

    /**
     * Test Move class forward method, at origin position and facing south
     */
	public function testForward_OriginSouth_ShouldStay() {
		$this->setPlace(BC::MIN_UNIT_X, BC::MIN_UNIT_Y, BC::FACE_S);
		$this->forwardAssert(BC::MIN_UNIT_X, BC::MIN_UNIT_Y);
	}

    /**
     * Test Move class forward method, at origin position and facing east
     */
	public function testForward_OriginEast_ShouldIncreaseX() {
		$this->setPlace(BC::MIN_UNIT_X, BC::MIN_UNIT_Y, BC::FACE_E);
		$this->forwardAssert(BC::MIN_UNIT_X + BC::MOVE_STEP);
	}

    /**
     * Test Move class forward method, at origin position and facing west
     */
	public function testForward_OriginWest_ShouldStay() {
		$this->setPlace(BC::MIN_UNIT_X, BC::MIN_UNIT_Y, BC::FACE_W);
		$this->forwardAssert(BC::MIN_UNIT_X, BC::MIN_UNIT_Y);
	}

    /**
     * Test Move class forward method, at top left corner and facing north
     */
	public function testForward_TopLeftNorth_ShouldStay() {
		$this->setPlace(BC::MIN_UNIT_X, BC::MAX_UNIT_Y, BC::FACE_N);
		$this->forwardAssert(BC::MIN_UNIT_X, BC::MAX_UNIT_Y);
	}

    /**
     * Test Move class forward method, at top left corner and facing south
     */
	public function testForward_TopLeftSouth_ShouldDecreaseY() {
		$this->setPlace(BC::MIN_UNIT_X, BC::MAX_UNIT_Y, BC::FACE_S);
		$this->forwardAssert(BC::MIN_UNIT_X, BC::MAX_UNIT_Y - BC::MOVE_STEP);
	}

    /**
     * Test Move class forward method, at top left corner and facing east
     */
	public function testForward_TopLeftEast_ShouldIncreaseX() {
		$this->setPlace(BC::MIN_UNIT_X, BC::MAX_UNIT_Y, BC::FACE_E);
		$this->forwardAssert(BC::MIN_UNIT_X + BC::MOVE_STEP);
	}

    /**
     * Test Move class forward method, at top left corner and facing west
     */
	public function testForward_TopLeftWest_ShouldStay() {
		$this->setPlace(BC::MIN_UNIT_X, BC::MAX_UNIT_Y, BC::FACE_W);
		$this->forwardAssert(BC::MIN_UNIT_X, BC::MAX_UNIT_Y);
	}

    /**
     * Test Move class forward method, at top right corner and facing north
     */
	public function testForward_TopRighttNorth_ShouldStay() {
		$this->setPlace(BC::MAX_UNIT_X, BC::MAX_UNIT_Y, BC::FACE_N);
		$this->forwardAssert(BC::MAX_UNIT_X, BC::MAX_UNIT_Y);
	}

    /**
     * Test Move class forward method, at top right corner and facing south
     */
	public function testForward_TopRightSouth_ShouldDecreaseY() {
		$this->setPlace(BC::MAX_UNIT_X, BC::MAX_UNIT_Y, BC::FACE_S);
		$this->forwardAssert(BC::MAX_UNIT_X, BC::MAX_UNIT_Y - BC::MOVE_STEP);
	}

    /**
     * Test Move class forward method, at top right corner and facing east
     */
	public function testForward_TopRightEast_ShouldStay() {
		$this->setPlace(BC::MAX_UNIT_X, BC::MAX_UNIT_Y, BC::FACE_E);
		$this->forwardAssert(BC::MAX_UNIT_X, BC::MAX_UNIT_Y);
	}

    /**
     * Test Move class forward method, at top right corner and facing west
     */
	public function testForward_TopRightWest_ShouldDecreaseX() {
		$this->setPlace(BC::MAX_UNIT_X, BC::MAX_UNIT_Y, BC::FACE_W);
		$this->forwardAssert(BC::MAX_UNIT_X - BC::MOVE_STEP);
	}

    /**
     * Test Move class forward method, at bottom right corner and facing north
     */
	public function testForward_BottomRightNorth_ShouldIncreaseY() {
		$this->setPlace(BC::MAX_UNIT_X, BC::MIN_UNIT_Y, BC::FACE_N);
		$this->forwardAssert(BC::MAX_UNIT_X, BC::MIN_UNIT_Y + BC::MOVE_STEP);
	}

    /**
     * Test Move class forward method, at bottom right corner and facing south
     */
	public function testForward_BottomRightSouth_ShouldStay() {
		$this->setPlace(BC::MAX_UNIT_X, BC::MIN_UNIT_Y, BC::FACE_S);
		$this->forwardAssert(BC::MAX_UNIT_X, BC::MIN_UNIT_Y);
	}

    /**
     * Test Move class forward method, at bottom right corner and facing east
     */
	public function testForward_BottomRightEast_ShouldStay() {
		$this->setPlace(BC::MAX_UNIT_X, BC::MIN_UNIT_Y, BC::FACE_E);
		$this->forwardAssert(BC::MAX_UNIT_X, BC::MIN_UNIT_Y);
	}

    /**
     * Test Move class forward method, at bottom right corner and facing west
     */
	public function testForward_BottomRightWest_ShouldDecreaseX() {
		$this->setPlace(BC::MAX_UNIT_X, BC::MIN_UNIT_Y, BC::FACE_W);
		$this->forwardAssert(BC::MAX_UNIT_X - BC::MOVE_STEP);
	}

    /**
     * Test Move class forward method, at middle position and facing north
     */
	public function testForward_MiddleNorth_ShouldIncreaseY() {
		list($middle_x, $middle_y) = BC::get_middle_position();

		$this->setPlace($middle_x, $middle_y, BC::FACE_N);
		$this->forwardAssert($middle_x, $middle_y + BC::MOVE_STEP);
	}

    /**
     * Test Move class forward method, at middle position and facing south
     */
	public function testForward_MiddleSouth_ShouldDecreaseY() {
		list($middle_x, $middle_y) = BC::get_middle_position();

		$this->setPlace($middle_x, $middle_y, BC::FACE_S);
		$this->forwardAssert($middle_x, $middle_y - BC::MOVE_STEP);
	}

    /**
     * Test Move class forward method, at middle position and facing east
     */
	public function testForward_MiddleEast_ShouldIncreaseX() {
		list($middle_x, $middle_y) = BC::get_middle_position();

		$this->setPlace($middle_x, $middle_y, BC::FACE_E);
		$this->forwardAssert($middle_x + BC::MOVE_STEP);
	}

    /**
     * Test Move class forward method, at middle position and facing west
     */
	public function testForward_MiddleWest_ShouldDecreaseX() {
		list($middle_x, $middle_y) = BC::get_middle_position();

		$this->setPlace($middle_x, $middle_y, BC::FACE_W);
		$this->forwardAssert($middle_x - BC::MOVE_STEP);
	}
}
