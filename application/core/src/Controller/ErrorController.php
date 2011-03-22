<?php
/**
 * Epixa - Exodus
 */

namespace Core\Controller;

use Epixa\Controller\AbstractController,
    Epixa\Exception\NotFoundException,
    Core\Exception\DeniedException,
    Zend_Controller_Plugin_ErrorHandler as ErrorHandlerPlugin;

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
     * @var array
     */
    protected $_errorTypes404 = array(
        ErrorHandlerPlugin::EXCEPTION_NO_ROUTE,
        ErrorHandlerPlugin::EXCEPTION_NO_CONTROLLER,
        ErrorHandlerPlugin::EXCEPTION_NO_ACTION
    );

    
    /**
     * Handle all application level exceptions
     */
    public function errorAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $error = $this->_getParam('error_handler', null);
        $exception = $error->exception;

        $httpStatusCode = 500;
        $template = 'error';
        if ($exception instanceof NotFoundException || in_array($error->type, $this->_errorTypes404)) {
            $httpStatusCode = 404;
            $template = 'not-found';
        } else if ($exception instanceof DeniedException) {
            $httpStatusCode = 403;
            $template = 'denied';
        }

        $this->getResponse()->clearBody();
        $this->getResponse()->setHttpResponseCode($httpStatusCode);

        $this->render($template);

        $debug = $this->getInvokeArg('bootstrap')->getOption('debug');
        if (isset($debug['renderExceptions']) && $debug['renderExceptions']) {
            $this->view->exception = $exception;
            $this->render('debug/exception');
        }
    }
}