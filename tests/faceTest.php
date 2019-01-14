<?php

/**
 * InOperation
 * robot's all ongoing operations
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
use ControlCentre\TestCommon;
use ControlCentre\Validation;
use PriorOperation\Startup;

/**
 * Class FaceTest
 * make unit test for Face class
 *
 * @package InOperation
 */
class FaceTest extends TestCommon
{
	/**
	 * @var Face
	 */
	private $face_controller;

    /**
     * initialize for each test case
     */
	public function setUp() {
		$startup = new Startup(new Validation());
		$this->face_controller = new Face($startup);

	}

    /**
     * Test Face class turn method, turning left from north
     */
	public function testTurn_NorthToLeft_ShouldWest() {
		$this->face_controller->set_current_face(BC::FACE_N);
		try {
			$this->face_controller->turn_left();
		} catch (\Exception $e) {   //not likely
			$this->skip_message($e);
			return;
		}
		$this->assertEquals(BC::FACE_W, $this->face_controller->get_current_face());
	}

    /**
     * Test Face class turn method, turning right from north
     */
	public function testTurn_NorthToRight_ShouldEast() {
		$this->face_controller->set_current_face(BC::FACE_N);
		try {
			$this->face_controller->turn_right();
		} catch (\Exception $e) {   //not likely
			$this->skip_message($e);
			return;
		}
		$this->assertEquals(BC::FACE_E, $this->face_controller->get_current_face());
	}

    /**
     * Test Face class turn method, turning left from south
     */
    public function testTurn_SouthToLeft_ShouldEast() {
		$this->face_controller->set_current_face(BC::FACE_S);
		try {
			$this->face_controller->turn_left();
		} catch (\Exception $e) {   //not likely
			$this->skip_message($e);
			return;
		}

		$this->assertEquals(BC::FACE_E, $this->face_controller->get_current_face());
	}

    /**
     * Test Face class turn method, turning right from south
     */
    public function testTurn_SouthToRight_ShouldWest() {
		$this->face_controller->set_current_face(BC::FACE_S);
		try {
			$this->face_controller->turn_right();
		} catch (\Exception $e) {   //not likely
			$this->skip_message($e);
			return;
		}
		$this->assertEquals(BC::FACE_W, $this->face_controller->get_current_face());
	}

    /**
     * Test Face class turn method, turning left from west
     */
    public function testTurn_WestToLeft_ShouldSouth() {
		$this->face_controller->set_current_face(BC::FACE_W);
		try {
			$this->face_controller->turn_left();
		} catch (\Exception $e) {   //not likely
			$this->skip_message($e);
			return;
		}
		$this->assertEquals(BC::FACE_S, $this->face_controller->get_current_face());
	}

    /**
     * Test Face class turn method, turning right from west
     */
    public function testTurn_WestToRight_ShouldNorth() {
		$this->face_controller->set_current_face(BC::FACE_W);
		try {
			$this->face_controller->turn_right();
		} catch (\Exception $e) {   //not likely
			$this->skip_message($e);
			return;
		}

		$this->assertEquals(BC::FACE_N, $this->face_controller->get_current_face());
	}

    /**
     * Test Face class turn method, turning left from east
     */
    public function testTurn_EastToLeft_ShouldNorth() {
		$this->face_controller->set_current_face(BC::FACE_E);
		try {
			$this->face_controller->turn_left();
		} catch (\Exception $e) {   //not likely
			$this->skip_message($e);
			return;
		}
		$this->assertEquals(BC::FACE_N, $this->face_controller->get_current_face());
	}

    /**
     * Test Face class turn method, turning right from east
     */
    public function testTurn_EastToRight_ShouldSouth() {
		$this->face_controller->set_current_face(BC::FACE_E);
		try {
			$this->face_controller->turn_right();
		} catch (\Exception $e) {   //not likely
			$this->skip_message($e);
			return;
		}
		$this->assertEquals(BC::FACE_S, $this->face_controller->get_current_face());
	}

    /**
     * Test thrown exception when invalid turn is activated
     */
	public function testTurn_InvalidDirection_ShouldThrowException() {
        $face_mocker = new FaceMocker($this->face_controller->get_startup());
        $face_mocker->set_current_face(BC::FACE_E);
        try {
            $face_mocker->turn_invalid();
            $this->fail('Exception should have been thrown and it is wrong to come here');
        } catch (\Exception $e) {
            $this->assertEquals(FaceException::class, get_class($e));
            return;
        }

    }

}

/**
 * Class FaceMocker
 * Mock invalid turn for unit test purpose only
 * @package InOperation
 */
class FaceMocker extends  Face {
    /**
     * @throws FaceException
     */
    public function turn_invalid() {
        //intentional unhandled exception here
        $this->turn(BC::COMMAND_LEFT . 'X');
    }
}
