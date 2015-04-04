<?php
namespace SGH\Comparable\Arrays\Comparator;

use SGH\Comparable\Comparator;
use SGH\Comparable\Comparator\NumericComparator;
use SGH\Comparable\ComparatorException;
/**
 * Array comparator that compares items with specific key, using another comparator
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable\Arrays
 * @since 1.0.0
 */
class KeyComparator extends AbstractArrayComparator
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var boolean
     */
    private $strict = true;
    /**
     * @var Comparator
     */
    private $itemComparator;
    /**
     * Constructor
     * 
     * @param string $key
     */
    public function __construct($key, Comparator $itemComparator = null)
    {
        $this->setKey($key);
        if ($itemComparator === null) {
            $itemComparator = new NumericComparator();
        }
        $this->itemComparator = $itemComparator;
    }
    /**
     * Specifies key to use for comparison
     * 
     * @param string $key
     * @return \SGH\Comparable\Arrays\Comparator\KeyComparator
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }
    /**
     * Turns strict mode on or off. In strict mode, array keys must exist. In non-strict mode, missing items are
     * treated as smaller than everything else. Two missing items are treated as equal. Default is strict mode.
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
        if ($this->strict) {
            if (! array_key_exists($this->key, $object1)) {
                throw new ComparatorException(__METHOD__ . ' expects array key ' . $this->key . ' to exist in parameter 1.');
            }
            if (! array_key_exists($this->key, $object2)) {
                throw new ComparatorException(__METHOD__ . ' expects array key ' . $this->key . ' to exist in parameter 2.');
            }
        } else {
            $null1 = $null2 = 0;
            if (! array_key_exists($this->key, $object1)) {
                $null1 = -1;
            }
            if (! array_key_exists($this->key, $object2)) {
                $null2 = -1;
            }
            if ($null1 || $null2) {
                return $null1 - $null2;
            }
        }
        return $this->itemComparator->compare($object1[$this->key], $object2[$this->key]);
    }
}