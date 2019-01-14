<?php
/**
 * Simulator
 * robot's all simulations
 *
 * Main program as command line (CLI)
 * ctrl+c or "Q" or "QUIT" or "EXIT" (case insensitive) to exit
 * if PLACE command has no following arguments, set to origin position and face north by default
 *
 * @category    Robot Simulator
 * @package     Simulator
 * @copyright   Copyright ©
 * @license     https://creativecommons.org/licenses/by-sa/4.0/legalcode
 * @version     1.0.0, 06/12/2018
 * @author
 */

Namespace Simulator;

use ControlCentre\{BaseController as BC, Report};
use PriorOperation\Startup;
use InOperation\{Move, Face};

require_once("./vendor/autoload.php");

$console = Console::get_instance();
$view = new ConsoleView();

while(true) {
	$command = strtoupper(trim(fgets(STDIN)));
	if ($console->is_to_quit($command)) {
		exit;
	}

	try {
		$console->execute($command);
		if ($command == BC::COMMAND_REPORT) {
		    echo $view->display($console->get_report_result());
		}

	} catch (\Exception $e) {
		exit("Exception occurred: {$e->getMessage()}");
	}
}