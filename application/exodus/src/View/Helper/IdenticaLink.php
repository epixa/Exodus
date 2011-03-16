<?php
/**
 * Epixa - Cards
 */

namespace Exodus\View\Helper;

use Zend_View_Helper_Abstract as AbstractViewHelper;

/**
 * @category   Module
 * @package    Exodus
 * @subpackage View\Helper
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Cards/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class IdenticaLink extends AbstractViewHelper
{
    /**
     * Creates an identica profile link for the given username
     * 
     * @param  string $username
     * @return string
     */
    public function identicaLink($username)
    {
        return sprintf('http://identi.ca/%s', $username);
    }
}