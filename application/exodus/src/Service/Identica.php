<?php
/**
 * Epixa - Exodus
 */

namespace Exodus\Service;

use HttpRequest,
    Exodus\Model\User as UserModel,
    Exodus\Collection\Friend as FriendCollection,
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
     * Gets all users on identica that have the same username as the given 
     * twitter user's followees
     * 
     * @param  strings      $username
     * @param  null|integer $count
     * @return FriendCollection
     */
    public function twitterIntersect($username, &$count = null)
    {
        $twitterService = new Twitter();
        $friends = $twitterService->getFriendsByUsername($username);

        if ($count !== null) {
            $count = count($friends);
        }
        
        foreach ($friends as $key => $friend) {
            if (!$this->usernameExists($friend->username)) {
                unset($friends[$key]);
            }
        }
        
        return $friends;
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

            $code = $response->getResponseCode();

            if ($code != 200 && $code != 404) {
                throw new RuntimeException(sprintf(
                    'Could not determine the existence of identica user `%s`: %s', 
                    $username, $response->getResponseStatus()
                ));
            }
            
            $lifetime = $this->_getCacheLifetimeByCode($code);
            $cache->save($code, $key, array(), $lifetime);
        }
        
        return $code == 200 ? true : false;
    }
    
    
    /**
     * Gets a specific cache lifetime for the given code
     * 
     * @param  integer $code
     * @return boolean|integer 
     */
    protected function _getCacheLifetimeByCode($code)
    {
        $config = $this->getConfig()->identica;
        
        switch ($code) {
            case 200:
                $lifetime = $config->cache->get('userFound', false);
                break;
            
            case 404:
                $lifetime = $config->cache->get('userNotFound', false);
                break;
            
            default:
                $lifetime = false;
                break;
        }
        
        return $lifetime;
    }
}