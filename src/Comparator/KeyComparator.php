<?php
namespace SGH\Comparable\Arrays\Comparator;

use SGH\Comparable\Comparator;
use SGH\Comparable\Comparator\NumericComparator;
use SGH\Comparable\Comparator\InvokableComparator;
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
class KeyComparator implements Comparator
{
    /**
     * @var MultiKeyComparator
     */
    private $multiKeyComparator;
    /**
     * Constructor
     * 
     * @param string $key
     */
    public function __construct($key, Comparator $itemComparator = null)
    {
        $this->multiKeyComparator = new MultiKeyComparator();
        if ($itemComparator === null) {
            $itemComparator = new NumericComparator();
        }
        $this->multiKeyComparator->appendComparator($key, $itemComparator);
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
        $this->multiKeyComparator->setStrict($strict);
        return $this;
    }
	/* (non-PHPdoc)
     * @see \SGH\Comparable\Comparator::compare()
     */
    public function compare($object1, $object2)
    {
        return $this->multiKeyComparator->compare($object1, $object2);
    }
    /**
     * Returns a callback object that can be used for core functions that take a callback parameter
     *
     * @return \SGH\Comparable\Comparator\InvokableComparator
     */
    public static function callback($key, $itemComparator = null)
    {
        return new InvokableComparator(new static($key, $itemComparator));
    }
}