<?php
/**
 * Epixa - Exodus
 */

namespace Core\Exception;

use RuntimeException;

/**
 * An exception to be thrown when a rate limit is exceeded
 * 
 * @category   Module
 * @package    Core
 * @subpackage Exception
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Exodus/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class RateLimitException extends RuntimeException
{}