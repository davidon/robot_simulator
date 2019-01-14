<?php
/**
 * Simulator
 * robot's all simulations
 *
 * @category    Robot Simulator
 * @package     Simulator
 * @copyright   Copyright ©
 * @license     https://creativecommons.org/licenses/by-sa/4.0/legalcode
 * @version     1.0.0, 06/12/2018
 * @author
 */

namespace Simulator;

interface IView {

    /**
     * Get display output
     * @param array $report_result Result of report
     * @return string
     */
    public function display(array $report_result) : string;
}