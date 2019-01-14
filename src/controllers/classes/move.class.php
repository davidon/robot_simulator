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

use ControlCentre\{BaseController as BC, Validation};
use PriorOperation\Startup;

/**
 * Class Move
 * Processes how robot moves; currently forwards only, future feature includes backwards, jump etc.
 * @package InOperation
 */
class Move extends BC implements IMove {

    /**
     * @var int Current position of horizonal axis
     */
    private $current_posx;

    /**
     * @var int Current position of vertical axis
     */
	private $current_posy;

	//ATTENTION: DO NOT SET CURRENT FACE AS MEMBER OF THIS CLASS IN ORDER TO SEPARATION OF CONCERN
	//private $current_face;

    /**
     * @var int Following position of horizonal axis after movement
     */
	private $next_posx;

    /**
     * @var int Following position of vertical axis after movement
     */
	private $next_posy;

	/**
	 * @var Startup
	 */
	private $startup;

	/**
	 * @var Face
	 */
	private $face_controller;

	/**
	 * @var Validation
	 */
	private $validator;

	/**
	 * Move constructor.
	 * @param Startup $startup
	 * @param Face $face_controller
	 * @param Validation $validator
	 * (It could be instantiated inside constructor because mostly or unlikely it needs injection)
	 */
	public function __construct(Startup $startup, Face $face_controller, Validation $validator) {
		$this->startup = $startup;
		$this->face_controller = $face_controller;
		$this->validator = $validator;
	}

	/**
     * Move forward
	 * If robot is going to move out of boundary, current position is not changed
	 * @return bool
	 */
	public function forward() : bool {
		if (!$this->has_placed()) {
			//clear current position and face as redundancy measure to ensure data correct
			$this->current_posx = null;
			$this->current_posy = null;
			$this->face_controller->unset_current_face();
			\Logger::log('The robot has not yet been placed.');

			return false;
		}

		list($next_posx, $next_posy) = $this->get_next_position();

		if ($this->validator->validate_position($next_posx, $next_posy)) {
			$this->current_posx = $next_posx;
			$this->current_posy = $next_posy;
			return true;
		}
		//otherwise current position is not changed
        \Logger::log("The robot is to be out of boundary.\nPosition X: {$next_posx}, Position Y: $next_posy}");
		return false;
	}

	/**
     * Get next position after movement
	 * @return array
	 */
	private function get_next_position() : array {
		switch (strtolower($this->get_current_face())) {
			case strtolower(BC::FACE_N):
				$next_place = [$this->get_current_position_x(), $this->get_current_position_y() + BC::MOVE_STEP];
				break;

			case strtolower(BC::FACE_S):
				$next_place = [$this->get_current_position_x(), $this->get_current_position_y() - BC::MOVE_STEP];
				break;

			case strtolower(BC::FACE_E):
				$next_place = [$this->get_current_position_x() + BC::MOVE_STEP, $this->get_current_position_y()];
				break;

			case strtolower(BC::FACE_W):
				$next_place = [$this->get_current_position_x() - BC::MOVE_STEP, $this->get_current_position_y()];
				break;
			default:    //unlikely
				//clear position and face (not throw exception)
				 $next_place = [null, null];
				$this->unset_current_face();
                \Logger::log(BC::ERROR_MESSAGE_FACE . ':' . $this->get_current_face());
		}
		return $next_place;
	}

    /**
     * Future feature of  moving backward
     * not needed for now
     * @return bool
     */
	public function backward() : bool {
		return false;
	}

	/**
     * Future feature of jumping
	 * Just demonstrate possible future functionality only
	 * @return bool
	 */
	public function jump() : bool {
		return true;
	}

    /**
     * Has robot been placed
     * @return bool
     */
	public function has_placed() : bool {
		if ($this->validator->validate_position($this->get_current_position_x(), $this->get_current_position_y())
			&& $this->validator->validate_face($this->get_current_face())) {
			return true;
		}
		return false;
	}

    /**
     * Get robot's current horizonal position, which could be from placement
     * @return int|null
     * When robot is not in valid position , the result is null
     */
	public function get_current_position_x() {
		return $this->current_posx ?? $this->startup->get_position_x();
	}

    /**
     * set current horizonal position
     * @param $posx
     */
	public function set_current_position_x($posx) {
		$this->current_posx = $posx;
	}

    /**
     * Get robot's current vertical position, which could be from placement
     * @return int|null
     * When robot is not in valid position , the result is null
     */
	public function get_current_position_y() {
		return $this->current_posy ?? $this->startup->get_position_y();
	}

    /**
     * set current vertical position
     * @param $posy
     */
	public function set_current_position_y($posy) {
		$this->current_posy = $posy;
	}

    /**
     * Get robot's current face, which could be from placement
     * @return string|null
     * When robot has no valid face , the result is null
     */
	public function get_current_face() : ?string {
	    $face = $this->face_controller->get_current_face() ?? $this->startup->get_face();
	    if (is_null($face)) {
	        return null;
        }
		return strtolower($face);
	}

	/**
     * Set robot's current face
	 * DO NOT SET CURRENT FACE AS MEMBER OF THIS CLASS IN ORDER TO SEPARATION OF CONCERN
	 * @param string $face
	 */
	public function set_current_face(string $face) {
		$this->face_controller->set_current_face($face);
	}

    /**
     * unset robot's current face
     */
	public function unset_current_face() {
		$this->face_controller->unset_current_face();
	}

    /**
     * Set startup instance
     * @param Startup $startup
     */
	public function set_startup(Startup $startup) {
		$this->startup = $startup;
	}

    /**
     * Set Face instance
     * @param Face $face_controller
     */
	public function set_face_controller(Face $face_controller) {
		$this->face_controller = $face_controller;
	}
}