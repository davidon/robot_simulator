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
 * Class Report
 * process how robot report
 *
 * @package ControlCentre
 */
class Report extends BC implements IReport {

	/**
	 * @var Move
	 */
	protected $move;

	/**
	 * @var Face
	 */
	protected $face_controller;

	/**
	 * @var Startup
	 */
	protected $startup;

    /**
     * Report constructor.
     * @param Startup $startup
     * @param Move $move
     * @param Face $face_controller
     */
	public function __construct(Startup $startup, Move $move, Face $face_controller) {
		$this->startup = $startup;
		$this->move = $move;
		$this->face_controller = $face_controller;
	}

	/**
     * generate report
	 * @return array
	 * [position-X, position-Y, face]
     * When robot is not in valid position or has no valid face, the result is array(null, null, null)
	 */
	public function generate_report() : array {
		list($posx, $posy) = $this->get_position();
		return array($posx, $posy, $this->get_face());
	}

    /**
     * get position
     * @return array
     * [position-X, position-Y, face]
     * When robot is not in valid position, the result is array(null, null)
     */
	protected function get_position() : array {
		$posx = $this->move->get_current_position_x();
		$posy = $this->move->get_current_position_y();
		return array($posx, $posy);
	}

    /**
     * Get face
     * @return string|null
     */
	protected function get_face() : ?string {
		return $this->move->get_current_face() ?? $this->startup->get_face();
	}

    /**
     * @param Startup $startup
     */
	public function set_startup(Startup $startup) {
		$this->startup = $startup;
	}

    /**
     * @param Move $move
     */
	public function set_move(Move $move) {
		$this->move = $move;
	}

    /**
     * Set Face instance
     * @param Face $face_controller
     */
	public function set_face_controller($face_controller) {
		$this->face_controller = $face_controller;
	}
}