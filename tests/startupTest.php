<?php
/**
 * PriorOperation
 * for all needed preparation before robot start operation
 *
 * @category    Robot Simulator
 * @package     ControlCentre
 * @copyright   Copyright ©
 * @license     https://creativecommons.org/licenses/by-sa/4.0/legalcode
 * @version     1.0.0, 06/12/2018
 * @author
 */

namespace PriorOperation;

use ControlCentre\BaseController as BC;
use PHPUnit\Framework\TestCase;
use ControlCentre\Validation;

/**
 * Class StartupTest
 * Process unit test for Startup class (placement for now)
 * @package PriorOperation
 */
class StartupTest extends TestCase
{

	/**
	 * @var Startup
	 */
	protected $startup;

    /**
     * initialize for each test case
     */
	public function setUp() {
		$this->startup = new Startup(new Validation());

	}

    /**
     * Test Place() method, robot is placed at origin position
     */
	public function testPlace_Origin_ShouldSucceed()
	{
		$this->startup->place(BC::MIN_UNIT_X, BC::MIN_UNIT_Y, BC::FACE_N);
		$this->assertEquals(BC::MIN_UNIT_Y, $this->startup->get_position_x());
		$this->assertEquals(BC::MIN_UNIT_Y, $this->startup->get_position_y());
		$this->assertEquals(BC::FACE_N, $this->startup->get_face());
	}

    /**
     * Test Place() method, robot is placed at top left corner
     */
	public function testPlace_TopLeft_ShouldSucceed()
	{
		$this->startup->place(BC::MIN_UNIT_X, BC::MAX_UNIT_Y, BC::FACE_S);
		$this->assertEquals(BC::MIN_UNIT_Y, $this->startup->get_position_x());
		$this->assertEquals(BC::MAX_UNIT_Y, $this->startup->get_position_y());
		$this->assertEquals(BC::FACE_S, $this->startup->get_face());
	}

    /**
     * Test Place() method, robot is placed at top right corner
     */
	public function testPlace_TopRight_ShouldSucceed()
	{
		$this->startup->place(BC::MAX_UNIT_X, BC::MAX_UNIT_Y, BC::FACE_E);
		$this->assertEquals(BC::MAX_UNIT_Y, $this->startup->get_position_x());
		$this->assertEquals(BC::MAX_UNIT_Y, $this->startup->get_position_y());
		$this->assertEquals(BC::FACE_E, $this->startup->get_face());
	}

    /**
     * Test Place() method, robot is placed at bottom right corner
     */
	public function testPlace_BottomRight_ShouldSucceed()
	{
		$this->startup->place(BC::MAX_UNIT_X, BC::MIN_UNIT_Y, BC::FACE_W);
		$this->assertEquals(BC::MAX_UNIT_Y, $this->startup->get_position_x());
		$this->assertEquals(BC::MIN_UNIT_Y, $this->startup->get_position_y());
		$this->assertEquals(BC::FACE_W, $this->startup->get_face());
	}

    /**
     * Test Place() method, robot is placed at middle position of the moving area
     */
    public function testPlace_Middle_ShouldSucceed()
	{
		list($middle_x, $middle_y) = BC::get_middle_position();
		$this->startup->place($middle_x, $middle_y, BC::FACE_W);
		$this->assertEquals($middle_x, $this->startup->get_position_x());
		$this->assertEquals($middle_y, $this->startup->get_position_y());
		$this->assertEquals(BC::FACE_W, $this->startup->get_face());
	}

    /**
     * Test Place() method, robot is placed outside of the moving area
     */
    public function testPlace_PositionOutOfBoundary_ShouldClearPositonFace()
	{
		//firstly place robot in a valid position
		list($middle_x, $middle_y) = BC::get_middle_position();
		$this->startup->place($middle_x, $middle_y, BC::FACE_W);

		//then place robot outside the boundary
		$this->startup->place(BC::MAX_UNIT_X + 1, BC::MAX_UNIT_Y + 2, "South");

		//robot's position and face should become null
		$this->assertNull($this->startup->get_position_x());
		$this->assertNull($this->startup->get_position_y());
		$this->assertNull($this->startup->get_face());
	}

    /**
     * Test Place() method, robot is placed without valid face
     */
	public function testPlace_FaceOutOfBoundary_ShouldClearPositonFace()
	{
		//firstly place robot in a valid position
		list($middle_x, $middle_y) = BC::get_middle_position();
		$this->startup->place($middle_x, $middle_y, BC::FACE_W);

		//then place robot in a valid position but with invalid face
		$this->startup->place($middle_x, $middle_y, "SouthEast");

		//robot's position and face should become null
		$this->assertNull($this->startup->get_position_x());
		$this->assertNull($this->startup->get_position_y());
		$this->assertNull($this->startup->get_face());
	}
}
