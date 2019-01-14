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
 * Class Validation
 * Validate position and face
 *
 * @package ControlCentre
 */
class Validation extends BC implements IValidation {
    /**
     * Validate position and face
     * @param int|null $posx horizonal position
     * @param int|null $posy vertical position
     * @param string|null $face face of north, south, east and west
     * @return bool
     */
	public function validate(?int $posx = null, ?int $posy = null, ?string $face = null) : bool {
		if (!$this->validate_position($posx, $posy)) {
			return false;
		}

		if (!$this->validate_face($face)) {
			return false;
		}

		return true;
	}

    /**
     * Validate position
     * @param int|null $posx
     * @param int|null $posy
     * @return bool
     */
	public function validate_position(?int $posx = null, ?int $posy = null) : bool {
		if (!$this->validate_position_x($posx)
			|| !$this->validate_position_y($posy)) {
			return false;
		}

		return true;
	}

    /**
     * Validate horizonal position
     * @param int|null $posx
     * @return bool
     */
	protected function validate_position_x(?int $posx) : bool {
		if ($posx >= BC::MIN_UNIT_X && $posx <= BC::MAX_UNIT_X) {
			return true;
		}
		return false;
	}

    /**
     * Validate vertical position
     * @param int|null $posy
     * @return bool
     */
	protected function validate_position_y(?int $posy) : bool {
		if ($posy >= BC::MIN_UNIT_Y && $posy <= BC::MAX_UNIT_Y) {
			return true;
		}

		return false;
	}

    /**
     * Validate face
     * @param string|null $face
     * @return bool
     */
	public function validate_face(?string $face) : bool {
		if (in_array(strtolower($face), array_map('strtolower', BC::VALID_FACES))) {
			return true;
		}
		return false;
	}
}