<?php
/**
 * InOperation namespace is for robot's all ongoing operations
 *
 * @category    Robot Simulator
 * @package     InOperation
 * @copyright   Copyright ©
 * @license     https://creativecommons.org/licenses/by-sa/4.0/legalcode
 * @version     1.0.0, 06/12/2018
 * @author
 */

namespace InOperation;

/**
 * Interface IMove
 * Processes how robot moves; currently forwards only, future feature includes backwards, jump etc.
 *
 * @package InOperation
 */
interface IMove {
    /**
     * Move forward
     * If robot is going to move out of boundary, current position is not changed
     * @return bool
     */
	public function forward() : bool;

    /**
     * Future feature of  moving backward
     * not needed for now
     * @return bool
     */
	public function backward() : bool;
}