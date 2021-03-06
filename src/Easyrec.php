<?php
/**
 * Part of the Easyrec package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Easyrec
 * @version    0.0.1
 * @author     VerdeIT
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017-2017, VerdeIT
 * @link       https://github.com/hafael/easyrec
 */

namespace Hafael\Easyrec;


class Easyrec
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '0.0.1';

    /**
     * The Config repository instance.
     *
     * @var \Hafael\Easyrec\ConfigInterface
     */
    protected $config;

    /**
     * The amount converter class and method name.
     *
     * @var string
     */
    protected static $amountConverter = '\\Hafael\\Easyrec\\AmountConverter::convert';

    /**
     * Constructor.
     *
     * @param string $baseUrl
     * @param string $apiKey
     * @param string $tenantId
     * @param string $apiVersion
     * @param string $token
     */
    public function __construct($baseUrl = null, $apiKey = null, $tenantId= null, $apiVersion = null, $token = null)
    {
        $this->config = new Config(self::VERSION, $baseUrl, $apiKey, $tenantId, $apiVersion, $token);
    }

    /**
     * Create a new Easyrec API instance.
     *
     * @param  string $baseUrl
     * @param  string $apiKey
     * @param  string $tenantId
     * @param  string $apiVersion
     * @param  string $token
     * @return Easyrec
     */
    public static function make($baseUrl = null, $apiKey = null, $tenantId= null, $apiVersion = null, $token = null)
    {
        return new static($baseUrl, $apiKey, $tenantId, $apiVersion, $token);
    }

    /**
     * Returns the current package version.
     *
     * @return string
     */
    public static function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Returns the Config repository instance.
     *
     * @return \Hafael\Easyrec\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Sets the Config repository instance.
     *
     * @param  \Hafael\Easyrec\ConfigInterface  $config
     * @return $this
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Returns the Easyrec base URL.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->config->getBaseUrl();
    }

    /**
     * Sets the Easyrec base URL.
     *
     * @param  string  $baseUrl
     * @return $this
     */
    public function setBaseUrl($baseUrl)
    {
        $this->config->setBaseUrl($baseUrl);

        return $this;
    }

    /**
     * Returns the Easyrec API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->config->getApiKey();
    }

    /**
     * Sets the Easyrec API key.
     *
     * @param  string  $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->config->setApiKey($apiKey);

        return $this;
    }

    /**
     * Returns the Easyrec API version.
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->config->getApiVersion();
    }

    /**
     * Sets the Easyrec API version.
     *
     * @param  string  $apiVersion
     * @return $this
     */
    public function setApiVersion($apiVersion)
    {
        $this->config->setApiVersion($apiVersion);

        return $this;
    }

    /**
     * Returns the Easyrec Tenant ID.
     *
     * @return string
     */
    public function getTenantId()
    {
        return $this->config->getTenantId();
    }

    /**
     * Sets the Easyrec Tenant ID.
     *
     * @param  string  $tenantId
     * @return $this
     */
    public function setTenantId($tenantId)
    {
        $this->config->getTenantId($tenantId);

        return $this;
    }

    /**
     * Returns the token key.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->config->getToken();
    }

    /**
     * Sets the token key.
     *
     * @param  string  $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->config->setToken($token);

        return $this;
    }


    /**
     * Dynamically handle missing methods.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \Hafael\Easyrec\Api\ApiInterface
     */
    public function __call($method, array $parameters)
    {
        if ($this->isIteratorRequest($method)) {
            $apiInstance = $this->getApiInstance(substr($method, 0, -8));

            return (new Pager($apiInstance))->fetch($parameters);
        }

        return $this->getApiInstance($method);
    }

    /**
     * Determines if the request is an iterator request.
     *
     * @return bool
     */
    protected function isIteratorRequest($method)
    {
        return substr($method, -8) === 'Iterator';
    }

    /**
     * Returns the Api class instance for the given method.
     *
     * @param  string  $method
     * @return \Hafael\Easyrec\Api\ApiInterface
     * @throws \BadMethodCallException
     */
    protected function getApiInstance($method)
    {
        $class = "\\Hafael\\Easyrec\\Api\\".ucwords($method);

        if (class_exists($class)) {
            return new $class($this->config);
        }

        throw new \BadMethodCallException("Undefined method [{$method}] called.");
    }

}