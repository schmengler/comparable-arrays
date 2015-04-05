<?php
namespace SGH\Comparable\Arrays\Test\Comparator;

use SGH\Comparable\Arrays\Comparator\KeyComparator;
use SGH\Comparable\Test\Comparator\AbstractComparatorTest;
use SGH\Comparable\Comparator\NumericComparator;
use SGH\Comparable\Arrays\Comparator\MultiKeyComparator;
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
     * @test
     * @dataProvider dataMissingItems
     * @expectedException \SGH\Comparable\ComparatorException
     */
    public function testMissingItemStrictMode($comparatorsByKey, $array1, $array2, $expectedOrder)
    {
        $this->arrayComparator = new MultiKeyComparator($comparatorsByKey);
        $actualOrder = $this->arrayComparator->compare($array1, $array2);
        $this->assertCompareResult($expectedOrder, $actualOrder);
    }
    /**
     * @test
     * @dataProvider dataMissingItems
     */
    public function testMissingItemNonStrictMode($comparatorsByKey, $array1, $array2, $expectedOrder)
    {
        $this->arrayComparator = new MultiKeyComparator($comparatorsByKey);
        $this->arrayComparator->setStrict(false);
        $actualOrder = $this->arrayComparator->compare($array1, $array2);
        $this->assertCompareResult($expectedOrder, $actualOrder);
    }
    /**
     * Tests MultiKeyComparator::calback()
     * 
     * @test
     */
    public function testCallback()
    {
        $callback = MultiKeyComparator::callback();
        $this->assertInstanceOf('\SGH\Comparable\Comparator\InvokableComparator', $callback);
    }
    /**
     * @test
     * @dataProvider dataInvalidArguments
     * @expectedException \SGH\Comparable\ComparatorException
     */
    public function testInvalidArguments($object1, $object2)
    {
        $this->arrayComparator = new MultiKeyComparator(array());
        $this->arrayComparator->compare($object1, $object2);
    }
    /**
     * @test
     * @expectedException \SGH\Comparable\ComparatorException
     */
    public function testNotAcceptArrayAccess()
    {
        $this->arrayComparator = new MultiKeyComparator(array());
        $this->arrayComparator->setAcceptArrayAccessObject(false);
        $this->arrayComparator->compare(new \ArrayObject([]), new \ArrayObject([]));
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
            'foo_gt_bar_missing' => [
                ['foo' => new NumericComparator, 'bar' => new NumericComparator],
                ['foo' => 2], ['foo' => 1], 1 ],
            'foo_eq_bar_gt' => [
                ['foo' => new NumericComparator, 'bar' => new NumericComparator],
                ['foo' => 1, 'bar' => 2], ['foo' => 1, 'bar' => 1], 1 ],
            'foo_eq_bar_eq' => [
                ['foo' => new NumericComparator, 'bar' => new NumericComparator],
                ['foo' => 1, 'bar' => 2], ['foo' => 1, 'bar' => 2], 0 ],
            'numeric_indexes' => [
                [1 => new NumericComparator, 0 => new NumericComparator],
                [1, 1, 1], [1, 0, 1], 1 ],
            'all_empty' => [ [], [], [], 0],
            'comparators_empty' => [ [], ['foo' => 1], ['foo' => 2], 0],
            'array_object' => [
                ['foo' => new NumericComparator, 'bar' => new NumericComparator],
                new \ArrayObject(['foo' => 2, 'bar' => 1]), new \ArrayObject(['foo' => 1, 'bar' => 1]), 1 ],
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
            'any_gt_null' => [['foo' => new NumericComparator], ['foo' => 1, 'bar' => 1], ['bar' => 1], 1 ],
            'null_lt_any' => [['foo' => new NumericComparator], ['bar' => 1], ['bar' => 1, 'foo' => 1], -1 ],
            'null_eq_null' => [['foo' => new NumericComparator], ['bar' => 1], ['bar' => 2], 0 ],
            'objects' => [['foo' => new ObjectComparator], ['foo' => new \stdClass], [], 1 ],
            'foo_eq_bar_gt' => [
                ['foo' => new NumericComparator, 'bar' => new NumericComparator],
                ['foo' => 1, 'bar' => 2], ['foo' => 1], 1 ],
        );
    }
    /**
     * Data provider for testInvalidArguments()
     * 
     * @return mixed[][]
     */
    public static function dataInvalidArguments()
    {
        return array(
        	[ array(), new \stdClass() ],
        	[ new \stdClass(), array() ],
            [ 'string', array() ],
            [ 42, array() ],
            [ null, array() ],
        );
    }
}

