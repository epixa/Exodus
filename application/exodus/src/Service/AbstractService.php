<?php
/**
 * Epixa - Exodus
 */

namespace Exodus\Service;

use Zend_Config as Config,
    Zend_Cache_Core as Cache,
    Epixa\Exception\ConfigException;

/**
 * Abstract service object that handles the setting of configs for all services
 * 
 * @category   Module
 * @package    Exodus
 * @subpackage Service
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Exodus/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
abstract class AbstractService
{
    /**
     * @var null|Cache
     */
    protected $cache = null;

    /**
     * @var null|Cache
     */
    protected static $defaultCache = null;
    
    /**
     * @var null|Config
     */
    protected $config = null;

    /**
     * @var null|Config
     */
    protected static $defaultConfig = null;

    
    /**
     * Sets the default cache for all services
     * 
     * @param Cache $cache
     */
    public static function setDefaultCache(Cache $cache)
    {
        self::$defaultCache = $cache;
    }

    /**
     * Gets the default cache for all services
     * 
     * @return Cache
     * @throws ConfigException If no default cache is set
     */
    public static function getDefaultCache()
    {
        if (self::$defaultCache === null) {
            throw new ConfigException('No default cache set');
        }

        return self::$defaultCache;
    }
    
    /**
     * Sets the default config for all services
     * 
     * @param Config $config
     */
    public static function setDefaultConfig(Config $config)
    {
        self::$defaultConfig = $config;
    }

    /**
     * Gets the default config for all services
     * 
     * @return Config
     * @throws ConfigException If no default config is set
     */
    public static function getDefaultConfig()
    {
        if (self::$defaultConfig === null) {
            throw new ConfigException('No default config set');
        }

        return self::$defaultConfig;
    }
    
    /**
     * Sets the cache for this service
     * 
     * @param  Cache $cache
     * @return AbstractService *Fluent interface*
     */
    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
        
        return $this;
    }

    /**
     * Gets the cache for this service
     *
     * If no cache is set, sets it to the default cache.
     *
     * @return Cache
     */
    public function getCache()
    {
        if ($this->cache === null) {
            $this->setCache(self::getDefaultCache());
        }

        return $this->cache;
    }

    /**
     * Sets the config for this service
     * 
     * @param  Config $config
     * @return AbstractService *Fluent interface*
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
        
        return $this;
    }

    /**
     * Gets the config for this service
     *
     * If no config is set, sets it to the default config.
     *
     * @return Config
     */
    public function getConfig()
    {
        if ($this->config === null) {
            $this->setConfig(self::getDefaultConfig());
        }

        return $this->config;
    }
}