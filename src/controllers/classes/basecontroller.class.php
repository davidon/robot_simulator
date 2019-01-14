<?php
/**
 * ControlCentre
 * to ensure robot working properly, for example, validation, report
 *
 * @category    Robot Simulator
 * @package     ControlCentre
 * @copyright   Copyright ©
 * @license     https://creativecommons.org/licenses/by-sa/4.0/legalcode
 * @version     1.0.0, 06/12/2018
 * @author
 */
namespace ControlCentre;
class BaseController {
    /**
     * constant of north face
     */
    public const FACE_N = "north";
	public const FACE_S = "south";
	public const FACE_E = "east";
	public const FACE_W = "west";

    /**
     * constant turn direction of right
     */
	public const DIRECTION_RIGHT = 'R';
	public const DIRECTION_LEFT = 'L';

    /**
     * Max horizonal size of robot's moving range
     */
	public const MAX_UNIT_X = 5;
	public const MAX_UNIT_Y = 5;

    /**
     * Min horizonal size of robot's moving range
     */
	public const MIN_UNIT_X = 0;
	public const MIN_UNIT_Y = 0;

    /**
     * The number of units for robot's each move
     */
	public const MOVE_STEP = 1;

    /**
     * The following commands are to control robot; case insensitive
     */
	public const COMMAND_PLACE = 'PLACE';
	public const COMMAND_MOVE = 'MOVE';
	public const COMMAND_LEFT = 'LEFT';
	public const COMMAND_RIGHT = 'RIGHT';
	public const COMMAND_REPORT = 'REPORT';

    /**
     * The commands to quit robot simulator execution; case insensitive
     */
	public const COMMANDS_QUIT = ['Q', 'QUIT', 'EXIT'];

	/**
	 * ATTENTION: this array must be in clockwise order from N->E->S->W
	 */
	public const VALID_FACES = [self::FACE_N, self::FACE_E, self::FACE_S, self::FACE_W];

    /**
     * Four corners of robot's movement range
     */
	public const CORNERS = [[self::MIN_UNIT_X, self::MIN_UNIT_Y], [self::MIN_UNIT_X, self::MAX_UNIT_Y], [self::MAX_UNIT_X, self::MAX_UNIT_Y], [self::MAX_UNIT_X, self::MIN_UNIT_Y]];

	/**
     * message for invalid face
     */
	public const ERROR_MESSAGE_FACE = 'The face is invalid';

    /**
     * Get middle position of robot's movement range
     * @return array
     */
	public static function get_middle_position() : array {
		$middle_x = floor((self::MAX_UNIT_X + 1) / 2);
		$middle_y = floor((self::MAX_UNIT_Y + 1) / 2);
		return array($middle_x, $middle_y);
	}

}