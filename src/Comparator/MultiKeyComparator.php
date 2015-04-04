<?php
namespace SGH\Comparable\Arrays\Comparator;

use SGH\Comparable\Comparator;
use SGH\Comparable\Comparator\NumericComparator;
use SGH\Comparable\ComparatorException;
/**
 * Array comparator that compares items with specific key, using another comparator.
 * 
 * Additionally, unlimited fallbacks can be specified, i.e. sort by key1 first, key2 second, ...
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable\Arrays
 * @since 1.0.0
 */
class MultiKeyComparator extends AbstractArrayComparator
{
    /**
     * @var Comparator[]
     */
    private $comparatorsByKey = array();
    /**
     * @var boolean
     */
    private $strict = true;
    /**
     * Constructor
     * 
     * @param Comprataor[] $comparatorsByKey
     */
    public function __construct(array $comparatorsByKey = array())
    {
        foreach ($comparatorsByKey as $key => $comparator) {
            $this->appendComparator($key, $comparator);
        }
    }
    /**
     * 
     * @param mixed $key
     * @param Comparator $comparator
     */
    public function appendComparator($key, Comparator $comparator)
    {
        $this->comparatorsByKey[$key] = $comparator;
    }
    /**
     * Turns strict mode on or off. In strict mode, array keys must exist for comparison. In non-strict mode, missing items are
     * treated as smaller than everything else. Two missing items are treated as equal. Default is strict mode.
     * If array keys are missing for an unused fallback comparator, nothing happens, even in strict mode.
     * 
     * @param boolean $strict
     * @return \SGH\Comparable\Arrays\Comparator\KeyComparator
     */
    public function setStrict($strict)
    {
        $this->strict = (bool) $strict;
        return $this;
    }
    /* (non-PHPdoc)
     * @see \SGH\Comparable\Comparator::compare()
     */
    public function compare($object1, $object2)
    {
        $this->checkTypes($object1, $object2);
        /* @var $comparator Comparator */
        foreach ($this->comparatorsByKey as $key => $comparator) {
            if ($this->strict) {
                if (! array_key_exists($key, $object1)) {
                    throw new ComparatorException(__METHOD__ . ' expects array key ' . $key . ' to exist in parameter 1.');
                }
                if (! array_key_exists($key, $object2)) {
                    throw new ComparatorException(__METHOD__ . ' expects array key ' . $key . ' to exist in parameter 2.');
                }
            } else {
                $null1 = $null2 = 0;
                if (! array_key_exists($key, $object1)) {
                    $null1 = -1;
                }
                if (! array_key_exists($key, $object2)) {
                    $null2 = -1;
                }
                if ($null1 || $null2) {
                    return $null1 - $null2;
                }
            }
            $result = $comparator->compare($object1[$key], $object2[$key]);
            if ($result !== 0) {
                return $result;
            }
        }
        return 0;
    }
}