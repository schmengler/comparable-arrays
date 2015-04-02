<?php
namespace SGH\Comparable\Arrays\Comparator;

/**
 * Configurable array comparator
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
     * Constructor
     * 
     * @param string $key
     */
    public function __construct($key)
    {
        $this->setKey($key);
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
        if ($object1[$this->key] < $object2[$this->key]) {
            return -1;
        } elseif ($object1[$this->key] > $object2[$this->key])
        {
            return 1;
        }
        return 0;
    }
}