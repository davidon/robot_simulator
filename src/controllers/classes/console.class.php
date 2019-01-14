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

use ControlCentre\{BaseController as BC, Report, Validation};
use	PriorOperation\Startup,
	InOperation\Face,
	InOperation\Move;

/**
 * Class Console
 * All console operations
 * @package Simulator
 */
class Console extends BC implements IConsole {
	/**
	 * @var Report
	 */
	private $report_controller;

	/**
	 * @var Startup
	 */
	private $startup_controller;

	/**
	 * @var Move
	 */
	private $move_controller;

	/**
	 * @var Face
	 */
	private $face_controller;

    /**
     * result of REPORT action
     * @var array
     */
	private $report_result;

    /**
     * For instance cache and lazy loading
     * @var Console
     */
	private static $console_instance;

    /**
     * Console constructor.
     * @param Startup $startup_controller
     * @param Face $face_controller
     * @param Move $move_controller
     * @param Report $report_controller
     */
	public function __construct(Startup $startup_controller, Face $face_controller, Move $move_controller, Report $report_controller) {
        $this->startup_controller = $startup_controller;
        $this->face_controller = $face_controller;
        $this->move_controller = $move_controller;
        $this->report_controller = $report_controller;
	}

    /**
     * Get Console instance
     * Singleton pattern for cache and lazy loading
     * @param bool $refresh
     * If true, generate new instance
     * @return Console
     */
	public static function get_instance(bool $refresh = false) {
	    if ($refresh !== true
            && isset(self::$console_instance)
            && (self::$console_instance instanceof Console)) {
	        return self::$console_instance;
        }
        $validator = new Validation();
        $startup = new Startup($validator);
        $face_controller = new Face($startup);
        $move = new Move($startup, $face_controller, $validator);
        $report = new Report($startup, $move, $face_controller);

        self::$console_instance = new Console($startup, $face_controller, $move, $report);
        return self::$console_instance;

    }

	/**
     * execute commands such as PLACE, MOVE, LEFT/RIGHT, Report
     * if PLACE command has no arguments followed, set to origin position and face north by default
     *
     * @param string $command
     * @return Console
     * return this class instance so as to chain robot's actions, e.g. $console->place()->move()->report()
	 * @throws \Exception
	 */
	public function execute(string $command) : Console {
        $action = strtolower($this->get_action($command));
        $options = $this->get_command_options($command);
        if (method_exists($this, $action)) {
            return $this->$action($options);
        }
        return $this;
	}

    /**
     * Parse command to get the action, that is, the first part in the command before space
     * (separating parsing action and options to keep Single Responsibility)
     *
     * @param string $command
     * @return string
     */
	private function get_action(string $command) : string {
        $action = strstr($command, ' ', true);
        if ($action === false) {
            $action = $command;
        }
        return $action;
    }

    /**
     * Parse command to get the options, that is, the part after the first space
     * for now, only PLACE command have options
     * (separating parsing action and options to keep Single Responsibility)
     *
     * @param string|null $command
     * @return array
     */
    private function get_command_options(string $command) : ?array {
        $options = strstr($command, ' ', false);
        if ($options === false) {
            return null;
        }
        $args = array_map('trim', explode(',', $options));
        return $args;

    }

    /**
     * Place robot
     * When PLACE command has no options, it means the default position (0,0) and face north
     *
     * @param array|null $options
     * @return Console
     * return this class instance so as to chain robot's actions, e.g. $console->place()->move()->report()
     */
    public function place(?array $options = null) : Console {
        if (empty($options)) {
            $posx = BC::MIN_UNIT_X;
            $posy = BC::MIN_UNIT_Y;
            $face = BC::FACE_N;
        } else {
            list($posx, $posy, $face) = $options;
        }
		$this->startup_controller->place($posx, $posy, $face);
        return $this;
	}

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
	public function move(?array $options = null) : Console {
		$this->move_controller->set_startup($this->startup_controller);
		$this->move_controller->set_face_controller($this->face_controller);
		$this->move_controller->forward();
		return $this;
	}

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
    public function left(?array $options = null) : Console {
		$this->face_controller->set_startup($this->startup_controller);
		$this->face_controller->turn_left();
		return $this;
	}

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
    public function right(?array $options = null) : Console {
		$this->face_controller->turn_right();
        return $this;
	}

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
    public function report(?array $options = null) : Console {
	    //not to pass result to argument as reference as it's not immutable way for functional programming
		$this->report_result = $this->report_controller->generate_report();
		return $this;
	}

    /**
     * get report result
     * @return array
     */
	public function get_report_result() {
        return $this->report_result;
    }

    /**
     * Is quiting command
     * @param string $command
     * @return bool
     */
    public function is_to_quit(string $command) {
        return in_array($command, BC::COMMANDS_QUIT);
    }
}
