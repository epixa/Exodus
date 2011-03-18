<?php
/**
 * Epixa - Cards
 */

namespace Exodus\Controller;

use Epixa\Controller\AbstractController,
    Exodus\Form\Identity as IdentityForm,
    Exodus\Service\Identica as IdenticaService,
    Exodus\Service\Twitter as TwitterService,
    Zend_Session_Namespace as SessionNamespace,
    Zend_Auth as Auth,
    Core\Exception\DeniedException,
    LogicException;

/**
 * Default exodus controller
 *
 * @category   Module
 * @package    Exodus
 * @subpackage Controller
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Cards/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class IndexController extends AbstractController
{
    /**
     * Renders and the identity form
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        
        if ($request->getQuery('denied', null)) {
            throw new DeniedException('User has denied access');
        }
        
        $twitterService = new TwitterService();
        
        if ($request->getQuery('oauth_token', null)) {
            $twitterService->completeAuthentication($request->getQuery());
        }
        
        if (!$twitterService->isAuthenticated()) {
            $this->_forward('auth');
            return;
        }
        
        $form = new IdentityForm();
        $form->setAction($this->view->url());
        $form->setErrors($this->_helper->flashMessenger->getMessages());
        if ($username = $request->getParam('u', null)) {
            $form->populate(array('username' => $username));
        }
        
        if (!$request->isPost() || !$form->isValid($request->getPost())) {
            $this->view->form = $form;
            return;
        }
        
        $this->_helper->redirector->gotoRouteAndExit(array('u' => $form->getValue('username')), 'load', true);
    }
    
    /**
     * If the user is not already authenticated, renders a page describing the 
     * auth process and a button to initiate authentication
     */
    public function authAction()
    {
        $request = $this->getRequest();
        
        $username = $request->getParam('u', null);
        
        $twitterService = new TwitterService();
        
        if (!$request->isPost()) {
            $this->view->username = $username;
            return;
        }
        
        if ($twitterService->isAuthenticated()) {
            $this->_helper->redirector->gotoRouteAndExit(array(), 'begin', true);
        }
        
        $url = $this->view->url(array('u' => $username), 'begin', true);
        $twitterService->beginAuthentication($this->_createCallbackUrl($url));
        return;
    }
    
    /**
     * Loads the follower data for the given user
     */
    public function loadAction()
    {
        $request = $this->getRequest();
        
        $twitterService = new TwitterService();
        
        if (!$twitterService->isAuthenticated()) {
            $this->_forward('auth');
            return;
        }
        
        $username = $request->getParam('u', null);
        if ($username === null) {
            throw new LogicException('No username specified');
        }
        
        $form = new IdentityForm(array('disableHash' => true));
        if (!$form->isValid(array('username' => $username))) {
            $this->_helper->flashMessenger->addMessage('Please enter a valid twitter username');
            $this->_helper->redirector->gotoRouteAndExit(array('u' => $username), 'begin', true);
        }
        
        $username = $form->getValue('username');
        
        $identicaService = new IdenticaService();
        $this->view->users = $identicaService->twitterIntersect($username);
        $this->view->username = $username;
    }
    
    /**
     * Kills the user's auth with twitter
     */
    public function logoutAction()
    {
        $twitterService = new TwitterService();
        $twitterService->clearAuthentication();
        
        $this->_helper->redirector->gotoUrlAndExit('/');
    }
    
    /**
     * Creates a complete callback url with the given url
     * 
     * @param  string $url
     * @return string
     */
    protected function _createCallbackUrl($url)
    {
        $request = $this->getRequest();
        
        $host = $request->getHttpHost();
        $scheme = $request->getScheme();
        
        return sprintf('%s://%s%s', $scheme, $host, $url);
    }
}