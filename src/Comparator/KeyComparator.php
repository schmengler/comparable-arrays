<?php
namespace SGH\Comparable\Arrays\Comparator;

use SGH\Comparable\Comparator;
use SGH\Comparable\Comparator\NumericComparator;
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
	/* (non-PHPdoc)
     * @see \SGH\Comparable\Comparator::compare()
     */
    public function compare($object1, $object2)
    {
        $this->checkTypes($object1, $object2);
        return $this->itemComparator->compare($object1[$this->key], $object2[$this->key]);
    }
}