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
interface IValidation {
    /**
     * Validate position and face
     * @param int|null $posx horizonal position
     * @param int|null $posy vertical position
     * @param string|null $face face of north, south, east and west
     * @return bool
     */
	public function validate(?int $posx = null, ?int $posy = null, ?string $face = null) : bool;
}
