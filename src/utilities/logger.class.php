<?php

/**
 * Logger
 *
 * @category    Robot Simulator
 * @package     Logger
 * @copyright   Copyright ©
 * @license     https://creativecommons.org/licenses/by-sa/4.0/legalcode
 * @version     1.0.0, 06/12/2018
 * @author
 */

/**
 * Class Logger
 * log information
 */
class Logger {
    /**
     * @param $messages variable-length arguments list
     * @return bool
     */
    public static function log($messages) {
        $args_num = func_num_args();

        if ($args_num == 0) {
            trigger_error('No message is provided');
        }

        $args = func_get_args();

        $log_msg = '';
        foreach ($args as $msg) {

            if (is_resource($msg)) {
                trigger_error('Unable to log resource');
                continue;
            }

            if (is_array($msg) || is_object($msg)) {
                $log_msg .= print_r($msg, true) . PHP_EOL;
            } else {
                $log_msg .= $msg . PHP_EOL;
            }
        }

        $logger_filename = __DIR__ . '/../../logs/robot_simulator.log';
        if (!$fs = fopen($logger_filename, 'a+')) {
            trigger_error('Exception: unable to open log file ' . $logger_filename, E_USER_ERROR);
            fclose($fs);
            return false;
        }

        if ($log_msg !== '') {
            fwrite($fs, PHP_EOL . $log_msg);
        }

        fclose($fs);
        return true;
    }

}