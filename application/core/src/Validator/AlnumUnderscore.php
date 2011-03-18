<?php
/**
 * Epixa - Exodus
 */

namespace Core\Validator;

use Zend_Validate_Abstract as AbstractValidator;

/**
 * A validator that ensures the input is either a letter, number, or underscore.
 * 
 * @category   Module
 * @package    Core
 * @subpackage Validator
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Exodus/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class AlnumUnderscore extends AbstractValidator
{
    /**
     * Determines if the given value only has letters, numbers, and underscores
     * 
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        if (!preg_match('/^[a-zA-Z0-9_]*$/', $value)) {
            return false;
        }
        
        return true;
    }
}