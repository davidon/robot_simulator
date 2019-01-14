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

/**
 * Interface IFace
 * Process turn actions
 * @package InOperation
 */
interface IFace {
    /**
     * Process robot's turning right
     * @return bool
     */
	public  function turn_right() : bool;

    /**
     * Process robot's turning left
     * @return bool
     */
	public  function turn_left() : bool;
}