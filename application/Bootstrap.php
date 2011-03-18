<?php
/**
 * Epixa - Exodus
 */

use Epixa\Application\Bootstrap as BaseBootstrap,
    Zend_Config as Config;

/**
 * Bootstrap the application
 *
 * @category  Bootstrap
 * @copyright 2011 epixa.com - Court Ewing
 * @license   http://github.com/epixa/Exodus/blob/master/LICENSE New BSD
 * @author    Court Ewing (court@epixa.com)
 */
class Bootstrap extends BaseBootstrap
{
    public function _initAnalytics()
    {
        $options = $this->getOptions();
        if (isset($options['google']['analytics']['account'])) {
            $view = $this->bootstrap('view')->getResource('view');
            $view->googleAnalyticsAccount = $options['google']['analytics']['account'];
        }
    }
    
    public function _initDebug()
    {
        $options = $this->getOptions();
        if (!empty($options['debug'])) {
            $config = new Config($options['debug']);
            
            $view = $this->bootstrap('view')->getResource('view');
            $view->debug = $config;
        }
    }
}