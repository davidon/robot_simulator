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

/**
 * Class ConsoleView
 * Provide display of console
 * @package Simulator
 */
class ConsoleView extends BaseView implements IView {
    /**
     * How the fields of report is separated
     */
    public const REPORT_DELIMITER = ' ';


    /**
     * Get screen output
     * @param array $report_result Result of console report
     * @return string
     */
    public function display(array $report_result) : string {
        return strtoupper(implode(self::REPORT_DELIMITER, $report_result)) . PHP_EOL;
    }
}