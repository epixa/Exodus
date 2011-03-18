<?php
/**
 * Epixa - Exodus
 */

use Epixa\Application\Bootstrap as BaseBootstrap;

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
}