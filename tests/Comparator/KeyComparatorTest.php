<?php
namespace SGH\Comparable\Arrays\Test\Comparator;

use SGH\Comparable\Arrays\Comparator\KeyComparator;
use SGH\Comparable\Test\Comparator\AbstractComparatorTest;
use SGH\Comparable\Comparator\NumericComparator;
use SGH\Comparable\Comparator\ObjectComparator;
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
class KeyComparatorTest extends AbstractComparatorTest
{
    /**
     * @var KeyComparator
     */
    private $arrayComparator;

    /**
     * Tests ArrayComparator->compare()
     * 
     * @test
     * @dataProvider dataNumericArrays
     */
    public function testCompareNumeric($key, $array1, $array2, $expectedOrder)
    {
        $this->arrayComparator = new KeyComparator($key);
        $actualOrder = $this->arrayComparator->compare($array1, $array2);
        $this->assertCompareResult($expectedOrder, $actualOrder);
    }
    /**
     * @test
     * @dataProvider dataMissingItems
     * @expectedException \SGH\Comparable\ComparatorException
     */
    public function testMissingItemStrictMode($key, $comparator, $array1, $array2, $expectedOrder)
    {
        $this->arrayComparator = new KeyComparator($key, $comparator);
        $actualOrder = $this->arrayComparator->compare($array1, $array2);
        $this->assertCompareResult($expectedOrder, $actualOrder);
    }
    /**
     * @test
     * @dataProvider dataMissingItems
     */
    public function testMissingItemNonStrictMode($key, $comparator, $array1, $array2, $expectedOrder)
    {
        $this->arrayComparator = new KeyComparator($key, $comparator);
        $this->arrayComparator->setStrict(false);
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
            'int_lt' => ['foo', ['foo' => 1, 'bar' => 2], ['foo' => 1, 'bar' => 1], 0 ],
            'int_eq' => ['foo', ['foo' => 2, 'bar' => 2], ['foo' => 1, 'bar' => 2], 1 ],
            'int_gt' => ['foo', ['foo' => 1, 'bar' => 0], ['foo' => 2, 'bar' => 1], -1 ],
            'string_to_int' => ['foo', ['foo' => '010'], ['foo' => '8'], 1 ],
            'string_to_float' => ['foo', ['foo' => '0.5'], ['foo' => '.55'], -1 ],
            'float' => ['foo', ['foo' => 0.0], ['foo' => 0.1], -1]
        );
    }
    /**
     * Data provider for testMissingItemStrictMode() and testMissingItemNonStrictMode()
     * 
     * @return mixed[][]
     */
    public static function dataMissingItems()
    {
        return array(
            'any_gt_null' => ['foo', new NumericComparator, ['foo' => 1, 'bar' => 1], ['bar' => 1], 1 ],
            'null_lt_any' => ['foo', new NumericComparator, ['bar' => 1], ['bar' => 1, 'foo' => 1], -1 ],
            'null_eq_null' => ['foo', new NumericComparator, ['bar' => 1], ['bar' => 2], 0 ],
            'objects' => ['foo', new ObjectComparator, ['foo' => new \stdClass], [], 1 ],
        );
    }
}