<?php
/**
 * Epixa - Exodus
 */

namespace Exodus\Service;

use HttpRequest,
    Exodus\Model\User as UserModel,
    Exodus\Collection\Follower as FollowerCollection,
    Zend_Cache as Cache,
    Epixa\Exception\NotFoundException,
    RuntimeException;

/**
 * Service that manages interaction with twitter api
 * 
 * @category   Module
 * @package    Exodus
 * @subpackage Service
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Exodus/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class Identica extends AbstractService
{
    /**
     * Set up the cache lifetime for this service
     */
    public function __construct()
    {
        $this->getCache()->setLifetime(null);
    }
    
    /**
     * Gets all users on identica that have the same username as the given 
     * twitter user's followees
     * 
     * @param  strings $username 
     * @return FollowerCollection
     */
    public function twitterIntersect($username)
    {
        $twitterService = new Twitter();
        $followers = $twitterService->getFriendsByUsername($username);
        
        foreach ($followers as $key => $follower) {
            if (!$this->usernameExists($follower->username)) {
                unset($followers[$key]);
            }
        }
        
        return $followers;
    }
    
    /**
     * Determines if the given username exists on identica
     * 
     * @param  string $username
     * @return boolean
     */
    public function usernameExists($username)
    {
        $cache = $this->getCache();
        
        $key = sha1(serialize(array('identica-username-exists' => $username)));

        if (($code = $cache->load($key)) === false) {
            $config = $this->getConfig()->identica;
            $request = new HttpRequest($config->url . '/users/show.json', HttpRequest::METH_HEAD);
            $request->setQueryData(array(
                'screen_name' => $username
            ));
            $response = $request->send();

            if ($response->responseCode != 200 && $response->responseCode != 404) {
                throw new RuntimeException(sprintf(
                    'Could not determine the existence of identica user `%s`: %s', 
                    $username, $response->responseStatus
                ));
            }
            
            $code = $response->responseCode;
            
            $cache->save($code, $key);
        }
        
        return $code == 200 ? true : false;
    }
}