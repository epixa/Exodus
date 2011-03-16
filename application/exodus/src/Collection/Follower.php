<?php
/**
 * Epixa - Cards
 */

namespace Exodus\Collection;

use Exodus\Model\User as UserModel,
    Countable,
    IteratorAggregate,
    ArrayAccess,
    ArrayIterator;

/**
 * @category   Module
 * @package    Exodus
 * @subpackage Collection
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Cards/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class Follower implements Countable, IteratorAggregate, ArrayAccess
{
    /**
     * @var array
     */
    protected $_elements = array();
    
    /**
     * @var integer
     */
    protected $_count = 0;


    /**
     * ArrayAccess implementation of offsetExists()
     * 
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->_elements[$offset]);
    }

    /**
     * ArrayAccess implementation of offsetGet()
     *
     * @return null|UserModel
     */
    public function offsetGet($offset)
    {
        if (isset($this->_elements[$offset])) {
            return $this->_elements[$offset];
        }
        
        return null;
    }

    /**
     * ArrayAccess implementation of offsetGet()
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }
    
    /**
     * ArrayAccess implementation of offsetUnset()
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            $this->_count--;
        }
        
        unset($this->_elements[$offset]);
    }
    
    /**
     * Returns the number of elements in the collection.
     *
     * Implementation of the Countable interface.
     *
     * @return integer
     */
    public function count()
    {
        return $this->_count;
    }

    /**
     * Gets an iterator for iterating over the elements in the collection.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->_elements);
    }
    
    /**
     * Adds a user to this collection
     * 
     * @param UserModel $user
     */
    public function add(UserModel $user)
    {
        $this->_elements[] = $user;
        $this->_count++;
    }
    
    /**
     * Adds a user to the collection at the given offset
     * 
     * @param mixed     $offset
     * @param UserModel $user 
     */
    public function set($offset, UserModel $user)
    {
        if (!$this->offsetExists($offset)) {
            $this->_count++;
        }
        
        $this->_elements[$offset] = $user;
    }
}