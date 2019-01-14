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

Namespace Simulator;

/**
 * Interface IConsole
 * The actions available for robot operations, and so this interface can be used as robot's API
 * @package Simulator
 */
interface IConsole {
    /**
     * execute commands such as PLACE, MOVE, LEFT/RIGHT, Report
     * if PLACE command has no arguments followed, set to origin position and face north by default
     *
     * @param string $command
     * @return Console
     * return this class instance so as to chain robot's actions, e.g. $console->place()->move()->report()
     * @throws \Exception
     */
	public function execute(string $command) : Console;

    /**
     * Place robot
     * When PLACE command has no options, it means the default position (0,0) and face north
     *
     * @param array|null $options
     * @return Console
     * return this class instance so as to chain robot's actions, e.g. $console->place()->move()->report()
     */
    public function place(?array $options = null) : Console;

    /**
     * Move robot
     *
     * @param array|null $options
     * It's not used for now, but for future feature enhancement, for example, robot could move several units, i.e. MOVE 2
     * Keeping it also for consistency with other commands e.g. PLACE
     *
     * @return Console
     * return this class instance so as to chain robot's actions, e.g. $console->place()->move()->report()
     */
    public function move(?array $options = null) : Console;

    /**
     * Robot left turn
     *
     * @param array|null $options
     * It's not used for now, but for future feature enhancement, for example, robot could turn left 45 degrees, i.e. LEFT 45
     * Keeping it also for consistency with other commands e.g. PLACE
     *
     * @return Console
     * return this class instance so as to chain robot's actions, e.g. $console->place()->move()->report()
     * @throws \Exception
     */
    public function left(?array $options = null) : Console;

    /**
     * Robot right turn
     *
     * @param array|null $options
     * It's not used for now, but for future feature enhancement, for example, robot could turn left 45 degrees, i.e. RIGHT 45
     * Keeping it also for consistency with other commands e.g. PLACE
     *
     * @return Console
     * return this class instance so as to chain robot's actions, e.g. $console->place()->move()->report()
     * @throws \Exception
     */
    public function right(?array $options = null) : Console;

    /**
     * Report robot's information
     *
     * @param array|null $options
     * It's not used for now, but for future feature enhancement that report could be in different format, for example, CSV, JSON, XML, i.e. RIGHT JSON
     * Keeping it also for consistency with other commands e.g. PLACE
     *
     * @return Console
     * return this class instance so as to chain robot's actions, e.g. $console->place()->move()->report()
     */
    public function report(?array $options = null) : Console;
}
