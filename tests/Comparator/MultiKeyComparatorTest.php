<?php
namespace SGH\Comparable\Arrays\Test\Comparator;

use SGH\Comparable\Arrays\Comparator\KeyComparator;
use SGH\Comparable\Test\Comparator\AbstractComparatorTest;
use SGH\Comparable\Comparator\NumericComparator;
use SGH\Comparable\Arrays\Comparator\MultiKeyComparator;
/**
 * ArrayComparator test case.
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable\Array
 * @since 1.0.0
 */
class MultiKeyComparatorTest extends AbstractComparatorTest
{
    /**
     * @var MultiKeyComparator
     */
    private $arrayComparator;

    /**
     * Tests ArrayComparator->compare()
     * 
     * @test
     * @dataProvider dataNumericArrays
     */
    public function testCompareNumeric($comparatorsByKey, $array1, $array2, $expectedOrder)
    {
        $this->arrayComparator = new MultiKeyComparator($comparatorsByKey);
        $actualOrder = $this->arrayComparator->compare($array1, $array2);
        $this->assertCompareResult($expectedOrder, $actualOrder);
    }
    /**
     * Data provider for testCompare()
     * 
     * @return mixed[][]
     */
    public static function dataNumericArrays()
    {
        return array(
            'foo_gt' => [
                ['foo' => new NumericComparator, 'bar' => new NumericComparator],
                ['foo' => 2, 'bar' => 1], ['foo' => 1, 'bar' => 1], 1 ],
            'foo_eq_bar_gt' => [
                ['foo' => new NumericComparator, 'bar' => new NumericComparator],
                ['foo' => 1, 'bar' => 2], ['foo' => 1, 'bar' => 1], 1 ],
            'foo_eq_bar_eq' => [
                ['foo' => new NumericComparator, 'bar' => new NumericComparator],
                ['foo' => 1, 'bar' => 2], ['foo' => 1, 'bar' => 2], 0 ],
            'numeric_indexes' => [
                [1 => new NumericComparator, 0 => new NumericComparator],
                [1, 1, 1], [1, 0, 1], 1 ],
        );
    }
}

