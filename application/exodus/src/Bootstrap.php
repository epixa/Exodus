<?php
/**
 * Epixa - Cards
 */

namespace Exodus;

use Epixa\Application\Module\Bootstrap as ModuleBootstrap,
    Exodus\Service\AbstractService,
    Zend_Config as Config;

/**
 * Bootstrap the exodus module
 *
 * @category  Module
 * @package   Exodus
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/Cards/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class Bootstrap extends ModuleBootstrap
{
    protected $viewHelperPath = 'View/Helper';
    
    /**
     * Sets up the services config
     */
    public function _initServiceConfig()
    {
        $options = $this->getApplication()->getOptions();
        $config = new Config($options);
        
        AbstractService::setDefaultConfig($config->services);
    }
    
    public function _initServiceCache()
    {
        $bootstrap = $this->getApplication()->bootstrap('cacheManager');
        $cacheManager = $bootstrap->getResource('cacheManager');
        
        $cache = $cacheManager->getCache('service');
        
        AbstractService::setDefaultCache($cache);
    }
}