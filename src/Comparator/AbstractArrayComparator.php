<?php
namespace SGH\Comparable\Arrays\Comparator;

use SGH\Comparable\Comparator;
use SGH\Comparable\ComparatorException;
use SGH\Comparable\Comparator\InvokableComparator;

/**
 * Abstract base class for array comparators
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable\Arrays
 * @since 1.0.0
 */
abstract class AbstractArrayComparator implements Comparator
{
    protected $_acceptsArrayAccess = false;

    /**
     * Verifies that both operands are arrays
     *
     * @param unknown $object1
     * @param unknown $object2
     * @throws ComparatorException
     */
    protected function checkTypes($object1, $object2)
    {
        if (! is_array($object1) && ! ($this->_acceptsArrayAccess && $object1 instanceof \ArrayAccess)) {
            throw new ComparatorException('$object1 (type: ' . gettype($object1) . ') is not an array.');
        }
        if (! is_array($object2) && ! ($this->_acceptsArrayAccess && $object2 instanceof \ArrayAccess)) {
            throw new ComparatorException('$object2 (type: ' . gettype($object2) . ') is not an array.');
        }
    }
    
    /**
     * Returns a callback object that can be used for core functions that take a callback parameter
     *
     * @return \SGH\Comparable\Comparator\InvokableComparator
     */
    public static function callback()
    {
        return new InvokableComparator(new static);
    }
}