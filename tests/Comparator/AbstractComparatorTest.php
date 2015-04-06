<?php
namespace SGH\Comparable\Arrays\Test\Comparator;

/**
 * Base test case for comparators
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable\Array
 * @since 1.0.2
 */
abstract class AbstractComparatorTest extends \PHPUnit_Framework_TestCase
{
    protected function assertCompareResult($expectedOrder, $actualOrder)
    {
        $this->assertInternalType('int', $actualOrder);
        if ($expectedOrder > 0) {
            $this->assertGreaterThan(0, $actualOrder);
        } elseif ($expectedOrder < 0) {
            $this->assertLessThan(0, $actualOrder);
        } else {
            $this->assertEquals(0, $actualOrder);
        }
    }
}