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
use PriorOperation\Startup;

/**
 * Class Face
 * process how robot turns face
 * @package InOperation
 */
class Face extends BC implements IFace {

	/**
	 * ATTENTION: This should not be used directly, need to use $this->get_current_face() instead
	 * @var string
	 */
	private $current_face;

	/**
	 * @var Startup
	 */
	protected $startup;

    /**
     * Face constructor.
     * @param Startup $startup
     */
	public function __construct(Startup $startup) {
		$this->startup = $startup;
	}

	/**
     * Process robot's turning left or right
	 * @param string $direction
	 * @return bool
	 * @throws FaceException
	 */
	protected function turn(string $direction) : bool {
	    if (!$this->is_current_face_valid()) {
            \Logger::log("Robot has not been placed and so it is unable to turn");
            return false;
        }

		if (!$this->is_turn_valid($direction)) {
			\Logger::log("Parameter is invalid: {$direction} in " . __FUNCTION__);
			throw new FaceException('Invalid direction is provided');
		}

		$face_index = array_search($this->get_current_face(), BC::VALID_FACES);
		$next_face_index = ($direction == BC::DIRECTION_LEFT) ? ($face_index - 1) : ($face_index + 1);

		//if turning Left from North
		if ($next_face_index < 0) {
			$next_face_index = 3;  //West
		}

		//turning right from west
		if ($next_face_index > 3) {
			$next_face_index = 0;   //north
		}

		$this->current_face = strtolower(BC::VALID_FACES[$next_face_index]);
		return true;
	}

	/**
     * Process robot's turning right
	 * @return bool
	 * @throws FaceException
	 */
	public function turn_right() : bool {
		return $this->turn(BC::DIRECTION_RIGHT);
	}

	/**
     * Process robot's turning left
     * @return bool
	 * @throws FaceException
	 */
	public function turn_left() : bool {
		return $this->turn(BC::DIRECTION_LEFT);
	}

    /**
     * get current face
     * @return string|null
     */
	public function get_current_face() : ?string {
        $face = $this->current_face ?? $this->startup->get_face();
        if (is_null($face)) {
            return null;
        }
        return strtolower($face);
	}

    /**
     * set current face
     * Don't use (and you can't now) set_current_face(null)
     * @param string $face
     */
	public function set_current_face(string $face) {
		$this->current_face = strtolower($face);
	}

	/**
     * Clear current face
	 * Don't use (and you can't now) set_current_face(null)
	 * (however in other methods, parameter null value could mean keeping existing value)
	 */
	public function unset_current_face() {
		$this->current_face = null;
	}

    /**
     * Set startup instance
     * @param Startup $startup
     */
	public function set_startup(Startup $startup) {
		$this->startup = $startup;
	}

    /**
     * Get startup instance
     * @return Startup
     */
	public function get_startup() : Startup {
	    return $this->startup;
    }

    /**
     * Is it valid turn direction
     * @param string $direction
     * @return bool
     */
	private function is_turn_valid(string $direction) {
        return in_array($direction, [BC::DIRECTION_LEFT, BC::DIRECTION_RIGHT]);
    }

    /**
     * is current face valid
     * @return bool
     */
    private function is_current_face_valid() : bool {
        return $this->startup->has_placed() || in_array($this->current_face, BC::VALID_FACES);
    }
}