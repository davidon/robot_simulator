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

/**
 * Interface IReport
 * process how robot report
 *
 * @package ControlCentre
 */
interface IReport {
	public function generate_report() : array;
}