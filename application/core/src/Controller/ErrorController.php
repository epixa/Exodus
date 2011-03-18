<?php
/**
 * Epixa - Exodus
 */

namespace Core\Controller;

use Epixa\Controller\AbstractController;

/**
 * Error controller
 *
 * @category   Module
 * @package    Core
 * @subpackage Controller
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Exodus/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class ErrorController extends AbstractController
{
    /**
     * Handle all application level exceptions
     */
    public function errorAction()
    {
        $error = $this->_getParam('error_handler', null);
        if (null !== $error) {
            var_dump($error->exception);
        }
        
        die('<p>Core\Controller\ErrorController::errorAction()</p>');
    }
}