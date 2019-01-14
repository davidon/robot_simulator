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

/**
 * Interface IStartup
 * for work to startup robot; for now, it's just placing
 * @package PriorOperation
 */
interface IStartup {
    /**
     * Place robot
     * No matter position is invalid or face is invalid, both positions and face will be cleared (set to null)
     * @param int $posx
     * @param int $posy
     * @param string $face
     * @return bool
     */
	public function place(int $posx, int $posy, string $face) : bool;
}