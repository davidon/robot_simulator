<?php
/**
 * ControlCentre
 * To ensure robot working properly, for example, validation, report
 *
 * @category    Robot Simulator
 * @package     ControlCentre
 * @copyright   Copyright ©
 * @license     https://creativecommons.org/licenses/by-sa/4.0/legalcode
 * @version     1.0.0, 06/12/2018
 * @author
 */

namespace ControlCentre;


use InOperation\Face;
use InOperation\Move;
use PriorOperation\Startup;
use ControlCentre\BaseController as BC;

/**
 * Class ReportTest
 * Make unit test for Report class
 * @package ControlCentre
 */
class ReportTest extends TestCommon
{
	/**
	 * @var Report
	 */
	private $report;

	/**
	 * @var Startup
	 */
	private $startup;

	/**
	 * @var Move
	 */
	private $move;

	/**
	 * @var Face
	 */
	private $face_controller;

    /**
     * initialize for each test case
     */
	public function setUp() {
		$validator = new Validation();
		$this->startup = $startup = new Startup($validator);
		$this->face_controller = $face = new Face($startup);
		$this->move = $move = new Move($startup, $face, $validator);
		$this->report = new Report($startup, $move, $face);

	}

    /**
     * Test Report class generate_report() method, when robot is just placed without any movement or turn
     */
	public function testGenerateReport_JustPlaced_ShouldSamePositionFace() {
		$posx = BC::MIN_UNIT_X;
		$posy = BC::MIN_UNIT_Y;
		$face = BC::FACE_N;

		$this->startup->place($posx, $posy, $face);

		list($report_x, $report_y, $report_face) = array_pad($this->report->generate_report(), 3, null);
		$this->assertEquals($posx, $report_x);
		$this->assertEquals($posy, $report_y);
		$this->assertEquals($face, $report_face);
	}

    /**
     * Test Report class generate_report() method, when robot is placed at origin position with only one movement
     */
	public function testGenerateReport_OriginMoveOnly_ShouldKeepFace() {
		$posx = BC::MIN_UNIT_X ;
		$posy = BC::MIN_UNIT_Y;
		$face = BC::FACE_N;

		try {
			$this->startup->place($posx, $posy, $face);
			$this->move->set_startup($this->startup);
			$this->move->forward();
		} catch (\Exception $e) {
			$this->skip_message($e);
			return;
		}

		$this->report->set_startup($this->startup);
		$this->report->set_move($this->move);
		list($report_x, $report_y, $report_face) = array_pad($this->report->generate_report(), 3, null);

		$this->assertEquals($posx, $report_x);
		$this->assertEquals($posy + BC::MOVE_STEP, $report_y);
		$this->assertEquals($face, $report_face);

	}

    /**
     * Test Report class generate_report() method, when robot is placed at origin position with only one turn
     */
	public function testGenerateReport_OriginTurnOnly_ShouldKeepPosition() {
		$posx = BC::MIN_UNIT_X;
		$posy = BC::MIN_UNIT_Y;
		$face = BC::FACE_N;

		try {
			$this->startup->place($posx, $posy, $face);

			$this->face_controller->turn_left();
		} catch (\Exception $e) {
			$this->skip_message($e);
			return;
		}

		list($report_x, $report_y, $report_face) = array_pad($this->report->generate_report(), 3, null);

		$this->assertEquals($posx, $report_x);
		$this->assertEquals($posy, $report_y);
		$this->assertEquals(BC::FACE_W, $report_face);

	}

    /**
     * Test Report class generate_report() method, when robot is placed inside the moving area with  movement and turn
     */
    public function testGenerateReport_MoveLeftTurn_ShouldChangePositionFace() {
		//PLACE 1,2,EAST
		$posx = BC::MIN_UNIT_X + 1;
		$posy = BC::MIN_UNIT_Y + 2;
		$face = BC::FACE_E;

		try {
			$this->startup->place($posx, $posy, $face);

			$this->move->set_startup($this->startup);
			$this->move->forward(); //X+1
			$this->move->forward(); //X+1

			$this->face_controller->turn_left();   //North

			$this->move->set_face_controller($this->face_controller);
			$this->move->forward(); //Y+1
		} catch (\Exception $e) {
			$this->skip_message($e);
			return;
		}

		list($report_x, $report_y, $report_face) = array_pad($this->report->generate_report(), 3, null);

		$this->assertEquals($posx + 2 * BC::MOVE_STEP, $report_x);
		$this->assertEquals($posy + BC::MOVE_STEP, $report_y);
		$this->assertEquals(BC::FACE_N, $report_face);

	}

    /**
     * Test Report class generate_report() method, when robot is placed inside the moving area with  movement and turn
     */
	public function testGenerateReport_MoveRightTurn_ShouldChangePositionFace() {
		//PLACE 1,2,EAST
		$posx = BC::MAX_UNIT_X - 1;
		$posy = BC::MAX_UNIT_Y - 2;
		$face = BC::FACE_W;

		try {
			$this->startup->place($posx, $posy, $face);

			$this->move->set_startup($this->startup);
			$this->move->forward(); //X-1

			$this->face_controller->turn_right();   //North

			$this->move->set_face_controller($this->face_controller);
			$this->move->forward(); //Y+1

			$this->face_controller->turn_right();   //east

			$this->move->set_face_controller($this->face_controller);
			$this->move->forward(); //X+1
		} catch (\Exception $e) {
			$this->skip_message($e);
			return;
		}

		list($report_x, $report_y, $report_face) = array_pad($this->report->generate_report(), 3, null);

		$this->assertEquals($posx, $report_x);
		$this->assertEquals($posy + BC::MOVE_STEP, $report_y);
		$this->assertEquals(BC::FACE_E, $report_face);

	}

    /**
     * Test Report class generate_report() method, when robot is placed at top left corner and unable to move but can still turn
     */
	public function testGenerateReport_TopLeftUnableMove_ShouldKeepPositionChangeFace() {
		//PLACE 1,2,EAST
		$posx = BC::MIN_UNIT_X;
		$posy = BC::MAX_UNIT_Y;
		$face = BC::FACE_W;

		try {
			$this->startup->place($posx, $posy, $face);

			$this->move->set_startup($this->startup);
			$this->move->forward(); //X
			$this->move->forward(); //X

			$this->face_controller->turn_left();   //south
		} catch (\Exception $e) {
			$this->skip_message($e);
			return;
		}

		list($report_x, $report_y, $report_face) = array_pad($this->report->generate_report(), 3, null);

		$this->assertEquals($posx, $report_x);
		$this->assertEquals($posy, $report_y);
		$this->assertEquals(BC::FACE_S, $report_face);

	}

    /**
     * Test Report class generate_report() method, when robot is placed at top right corner and unable to move but turn first then move
     */
	public function testGenerateReport_TopRightUnableMoveThenTurnMove_ShouldMoveLess() {
		//PLACE 1,2,EAST
		$posx = BC::MAX_UNIT_X;
		$posy = BC::MAX_UNIT_Y;
		$face = BC::FACE_E;

		try {
			$this->startup->place($posx, $posy, $face);

			$this->move->set_startup($this->startup);
			$this->move->forward(); //X
			$this->move->forward(); //X

			$this->face_controller->turn_right();   //south

			$this->move->set_face_controller($this->face_controller);
			$this->move->forward(); //Y-1
			$this->move->forward(); //Y-1
		} catch (\Exception $e) {
			$this->skip_message($e);
			return;
		}

		list($report_x, $report_y, $report_face) = array_pad($this->report->generate_report(), 3, null);

		$this->assertEquals($posx, $report_x);
		$this->assertEquals($posy - 2 * BC::MOVE_STEP, $report_y);
		$this->assertEquals(BC::FACE_S, $report_face);

	}

}
