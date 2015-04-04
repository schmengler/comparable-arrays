<?php
namespace SGH\Comparable\Arrays\Comparator;

use SGH\Comparable\Comparator;
use SGH\Comparable\Comparator\NumericComparator;
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
	/* (non-PHPdoc)
     * @see \SGH\Comparable\Comparator::compare()
     */
    public function compare($object1, $object2)
    {
        $this->checkTypes($object1, $object2);
        /* @var $comparator Comparator */
        foreach ($this->comparatorsByKey as $key => $comparator) {
            $result = $comparator->compare($object1[$key], $object2[$key]);
            if ($result !== 0) {
                return $result;
            }
        }
        return 0;
    }
}