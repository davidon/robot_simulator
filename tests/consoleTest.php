<?php
/**
 * Simulator
 * robot's all simulations
 *
 * @category    Robot Simulator
 * @package     Simulator
 * @copyright   Copyright ©
 * @license     https://creativecommons.org/licenses/by-sa/4.0/legalcode
 * @version     1.0.0, 06/12/2018
 * @author
 */

Namespace Simulator;

use ControlCentre\BaseController as BC;
use ControlCentre\TestCommon;
/**
 * Class ConsoleTest
 * Unit test for class Console
 * @package Simulator
 */
class ConsoleTest extends TestCommon
{
	/**
	 * @var Console
	 */
	private $console;

    /**
     * initialize for each test case
     */
	public function setUp() {
	    //every test case needs to generate new Console instance
        $this->console = Console::get_instance(true);
	}

    /**
     * Generate a string form of command as console input
     * @param $posx
     * @param $posy
     * @param $face
     * @return string
     */
    private function getPlaceCommand($posx, $posy, $face) {
        return BC::COMMAND_PLACE . " {$posx},{$posy},{$face}";
    }

    /**
     * test execute method, issuing command "PLACE" without options
     */
    public function testExecute_PlaceWithouOptions_ShouldOriginNorth() {
        try {
            $this->console->execute(BC::COMMAND_PLACE)
                ->report();

            $this->assertEquals(array(BC::MIN_UNIT_X,
                BC::MIN_UNIT_Y,
                BC::FACE_N),
                $this->console->get_report_result());
        } catch (\Exception $e) {
            $this->fail($this->getError($e));
        }
    }

    /**
     * test execute() method with PLACE parameter is same as place() method
     */
    public function testExecuteOfPlace_Place_ShouldSame() {
        try {
            //PLACE command without options
            $this->console->execute(BC::COMMAND_PLACE)
                ->report();
            $result_exe = $this->console->get_report_result();

            $this->console->place()
                ->report();
            $result_place = $this->console->get_report_result();

            $this->assertEquals($result_exe, $result_place);
        } catch (\Exception $e) {
            $this->fail($this->getError($e));
        }
    }

    /**
     * test execute() method with PLACE parameter following options is same as place() method
     */
    public function testExecuteOfPlaceOptions_Place_ShouldSame() {
        try {
            //PLACE command with options
            $posx = BC::MIN_UNIT_X + BC::MOVE_STEP * 2;
            $posy = BC::MIN_UNIT_Y + BC::MOVE_STEP * 2;
            $face = BC::FACE_N;

            $this->console->execute($this->getPlaceCommand( $posx, $posy, $face))
                ->report();
            $result_exe = $this->console->get_report_result();

            $this->console->place([$posx, $posy, $face])
                ->report();
            $result_place = $this->console->get_report_result();

            $this->assertEquals($result_exe, $result_place);
        } catch (\Exception $e) {
            $this->fail($this->getError($e));
        }
    }

    /**
     * test execute method, robot is placed at origin without further movement
     */
	public function testExecute_OriginPlace_ShouldStay() {
		try {
			//use variable to make assertion clearer
			$posx = BC::MIN_UNIT_X;
			$posy = BC::MIN_UNIT_Y;
			$face = BC::FACE_N;

			$this->console->place(array($posx, $posy, $face))
			    ->report();

			$this->assertEquals(array($posx,
				$posy,
				$face),
                $this->console->get_report_result());
		} catch (\Exception $e) {
			$this->fail($this->getError($e));
		}
	}

    /**
     * test execute method, robot is placed at origin with further movement
     */
	public function testExecute_OriginPlaceMove_ShouldSameFaceDifferentPosition() {
		try {
			//use variable to make assertion clearer
			$posx = BC::MIN_UNIT_X;
			$posy = BC::MIN_UNIT_Y;
			$face = BC::FACE_N;

			$this->console->place(array($posx, $posy, $face))
                ->move()
                ->report();

			$this->assertEquals(array($posx,
				$posy + BC::MOVE_STEP,
				$face),
                $this->console->get_report_result());
		} catch (\Exception $e) {
			$this->fail($this->getError($e));
		}
	}

    /**
     * test execute method, robot is placed at origin with further turning
     */
	public function testExecute_OriginPlaceTurn_ShouldSamePositionDifferentFace() {
		try {
			//use variable to make assertion clearer
			$posx = BC::MIN_UNIT_X;
			$posy = BC::MIN_UNIT_Y;

			$this->console->place(array($posx, $posy, BC::FACE_N))
                ->left()
                ->report();

			$this->assertEquals(array($posx,
				$posy,
				BC::FACE_W),
                $this->console->get_report_result());
		} catch (\Exception $e) {
			$this->fail($this->getError($e));
		}
	}

    /**
     * test execute method, robot is placed inside moving area with further movement and turn
     */
	public function testExecute_InsidePlaceMoveTurn_ShouldDifferentPositionDifferentFace() {
		try {
			//use variable to make assertion clearer
			$posx = BC::MIN_UNIT_X + BC::MOVE_STEP;
			$posy = BC::MIN_UNIT_Y + 2 * BC::MOVE_STEP;

            $this->console->place(array($posx, $posy, BC::FACE_E))
                ->move()
                ->move()
                ->left()
                ->move()
                ->report();

			$this->assertEquals(array($posx + 2 * BC::MOVE_STEP,
				$posy + BC::MOVE_STEP,
				BC::FACE_N),
                $this->console->get_report_result());
		} catch (\Exception $e) {
			$this->fail($this->getError($e));
		}
	}

    /**
     * test execute method, robot is placed inside moving area with further movement and turn
     */
    public function testExecute_InvalidActionInvoled_ShouldIgnoreInvalidAction() {
        try {
            $this->console->place()
                ->move()
                ->move()    //0,2,north
                ->left()    //west
                ->move()    //stay
                ->move()    //stay
                ->left()   //south
                ->move()    //0,1
                ->left()   //east
                ->move()
                ->move()
                ->move()
                ->move()
                ->move()    //5,1
                ->move()    //stay
                ->right()   //south
                ->report();

            $this->assertEquals(array(BC::MAX_UNIT_X,
                BC::MIN_UNIT_Y + 1,
                BC::FACE_S),
                $this->console->get_report_result());
        } catch (\Exception $e) {
            $this->fail($this->getError($e));
        }
    }

    /**
     * test execute method, robot is placed outside boundary, so any movements doesn't take effect
     */
    public function testExecute_PlaceOutOfBoundary_ShouldReportNone() {
        try {
            //use variable to make assertion clearer
            $posx = BC::MAX_UNIT_X + BC::MOVE_STEP;
            $posy = BC::MIN_UNIT_Y;
            $face = BC::FACE_N;

            $this->console->place(array($posx, $posy, $face))
                ->move()
                ->move()
                ->report();

            $this->assertEquals(array(null, null, null), $this->console->get_report_result());
        } catch (\Exception $e) {
            $this->fail($this->getError($e));
        }
    }

    /**
     * test execute method, robot is placed with invalid face, so any movements doesn't take effect
     */
    public function testExecute_PlaceInvalidFace_ShouldReportNone() {
        try {
            //use variable to make assertion clearer
            $posx = BC::MAX_UNIT_X - BC::MOVE_STEP;
            $posy = BC::MIN_UNIT_Y;
            $face = BC::FACE_N . BC::FACE_W;

            $this->console->place(array($posx, $posy, $face))
                ->move()
                ->move()
                ->report();

            $this->assertEquals(array(null, null, null), $this->console->get_report_result());
        } catch (\Exception $e) {
            $this->fail($this->getError($e));
        }
    }

    /**
     * test execute method, robot has not been placed, so any movements doesn't take effect
     */
    public function testExecute_NotPlaced_ShouldReportNone() {
        try {
            $this->console->move()
                ->right()
                ->move()
                ->left()
                ->report();

            $this->assertEquals(array(null, null, null), $this->console->get_report_result());
        } catch (\Exception $e) {
            $this->fail($this->getError($e));
        }
    }

    /**
     * test execute method, invalid command is issued, and it won't take effect
     */
    public function testExecute_InvalidCommand_ShouldNotTakeEffect() {
        try {
            //invalid PLACEX command
            $this->console->execute(BC::COMMAND_PLACE . 'X')
                ->report();
            $this->assertEquals(array(null, null, null), $this->console->get_report_result());

            //invalid MOVEX command is issued, robot should stay
            $this->console->execute(BC::COMMAND_PLACE)
                ->execute(BC::COMMAND_MOVE . 'X')
                ->report();
            $this->assertEquals(self::INITIAL_PLACE, $this->console->get_report_result());

            //invalid turn command is issued, robot should stay
            $this->console->execute(BC::COMMAND_PLACE)
                ->move()
                ->execute(BC::COMMAND_LEFT . 'X')
                ->report();
            $this->assertEquals(array(BC::MIN_UNIT_X, BC::MIN_UNIT_Y + BC::MOVE_STEP, BC::FACE_N), $this->console->get_report_result());
        } catch (\Exception $e) {
            $this->fail($this->getError($e));
        }
    }

    /**
     * Get error message
     * @param \Exception $e
     * @return string
     */
    private function getError(\Exception $e) {
        return "Exception occurred: {$e->getMessage()}";
    }
}
