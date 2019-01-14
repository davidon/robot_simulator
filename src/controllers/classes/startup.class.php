<?php
/**
 * PriorOperation
 * for all needed preparation before robot start operation
 *
 * process placing the robot
 *
 * @category    Robot Simulator
 * @package     ControlCentre
 * @copyright   Copyright ©
 * @license     https://creativecommons.org/licenses/by-sa/4.0/legalcode
 * @version     1.0.0, 06/12/2018
 * @author
 */

namespace PriorOperation;
use ControlCentre\{BaseController as BC, Validation};

/**
 * Class Startup
 * Startup class is for work to startup robot; for now, it's just placing
 *
 * @package PriorOperation
 */
class Startup extends BC implements IStartup {
	/**
	 * @var int|null
	 */
	protected $position_x;
	/**
	 * @var int|null
	 */
	protected $position_y;
	/**
	 * @var string|null
	 */
	protected $face;

	/**
	 * @var Validation
	 */
	protected $validator;

	/**
	 * has the robot been placed
	 * @var bool
	 */
	protected $has_placed;

	/**
	 * Startup constructor.
	 * @param Validation|null $validator
	 * Nullable because it's not needed sometimes e.g. unit test
	 */
	public function __construct(Validation $validator) {
		$this->validator = $validator;
	}

	/**
     * Place robot
	 * No matter position is invalid or face is invalid, both positions and face will be cleared (set to null)
	 * @param int $posx
	 * @param int $posy
	 * @param string $face
	 * @return bool
	 */
	public function place(int $posx, int $posy, string $face) : bool {
		if (!$this->validator->validate_position($posx, $posy)
			|| !$this->validator->validate_face($face)) {
			$this->position_x = null;
			$this->position_y = null;
			$this->face = null;

			$this->has_placed = false;
			return false;
		} else {
			$this->position_x = $posx;
			$this->position_y = $posy;
			$this->face = strtolower($face);

			$this->has_placed = true;
			return true;
		}
	}

    /**
     * get position
     * @return array [position_x, position_y]
     */
	public function get_position() : array {
		return array($this->position_x, $this->position_y);
	}

    /**
     * get horizonal position
     * @return int|null
     */
	public function get_position_x() : ?int {
		return $this->position_x;
	}

    /**
     * get vertical position
     * @return int|null
     */
	public function get_position_y() : ?int {
		return $this->position_y;
	}

    /**
     * Get face
     * @return string|null
     */
	public function get_face() : ?string {
        if (is_null($this->face)) {
            return null;
        }
        return strtolower($this->face);
	}

    /**
     * Has robot been placed
     * @return bool
     */
	public function has_placed() : bool {
		return $this->has_placed ?? false;
	}
}