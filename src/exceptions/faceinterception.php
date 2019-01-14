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

use ControlCentre\Error;

/**
 * Class FaceException
 * process exception of Face Controller
 * @package InOperation
 */
class FaceException extends \Exception {

    const PREFIX_MESSAGE = "Exception occurred during Face Controller process";

    /**
     * FaceException constructor.
     * Prefix specific information to error message
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message, int $code = 0) {
        parent::__construct(self::PREFIX_MESSAGE . PHP_EOL . $message, ($code ?: ERROR::FACE_ERROR_CODE));
    }

    /**
     * Get error message appended with error code
     * @return string
     */
    public function getError() : string {
        return "{$this->getMessage()} [Error Code: {$this->getCode()}]";
    }
}
