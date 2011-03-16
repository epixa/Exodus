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
class TwitterLink extends AbstractViewHelper
{
    /**
     * Creates a twitter profile link for the given username
     * 
     * @param  string $username
     * @return string
     */
    public function twitterLink($username)
    {
        return sprintf('http://twitter.com/%s', $username);
    }
}