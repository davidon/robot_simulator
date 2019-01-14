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

use PHPUnit\Framework\TestCase;
use ControlCentre\BaseController as BC;

/**
 * Class TestCommon
 * common methods for unit test
 * @package ControlCentre
 */
class TestCommon extends TestCase
{

    const INITIAL_PLACE = array(BC::MIN_UNIT_X, BC::MIN_UNIT_Y, BC::FACE_N);
    /**
     * mark unit test skipped when there's exception
     * @param \Exception $e
     */
	protected function skip_message(\Exception $e) {
		$this->markTestSkipped('Test is skipped because the tested method throws exception: ' . $e->getMessage());
	}

    /**
     * This is not testing, it's just for bypassing the warning message "No tests found in class..."
     */
	public function testNothing() {
	    $this->assertTrue(true);
    }

}
