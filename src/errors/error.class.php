<?php
/**
 * ControlCentre
 * to ensure robot working properly, for example, validation, report
 *
 * @category    Robot Simulator
 * @package
 * @copyright   Copyright ©
 * @license     https://creativecommons.org/licenses/by-sa/4.0/legalcode
 * @version     1.0.0, 06/12/2018
 * @author
 */

namespace ControlCentre;

/**
 * Class Error
 * process error code and error message
 */
class Error {
    const FACE_ERROR_CODE = 100;
    const MOVE_ERROR_CODE = 101;
    const REPORT_ERROR_CODE = 102;
    const PLACE_ERROR_CODE = 103;

    public const ERROR_MESSAGES = [self::FACE_ERROR_CODE => 'Error occurred in Face Controller',
            self::MOVE_ERROR_CODE => 'Error occurred in Move Controller',
            self::REPORT_ERROR_CODE => 'Error occurred in Report Controller',
            self::PLACE_ERROR_CODE => 'Error occurred during PLACE action'
        ];

    /**
     * @param int $code Error code
     * @return string Error message
     */
    public function getErrorByCode(int $code) : string {
        return self::ERROR_MESSAGES[$code] ?? 'System Error';

    }
}