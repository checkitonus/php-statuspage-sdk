<?php

namespace CheckItOnUs\StatusPage;

use CheckItOnUs\StatusPage\Incident;
use CheckItOnUs\StatusPage\Component;
use CheckItOnUs\StatusPage\ComponentGroup;
use CheckItOnUs\StatusPage\Request\GuzzleRequest;
use CheckItOnUs\StatusPage\Request\SpoofedVerbRequest;

class Server
{
    /**
     * The configuration object
     *
     * @var        \CheckItOnUs\StatusPage\Configuration
     */
    private $_configuration;

    /**
     * The object which will be used for any web requests
     * 
     * @var \CheckItOnUs\StatusPage\Request\WebRequest
     */
    private $_webRequest;

    /**
     * Initializes the StatusPage component
     *
     * @param      $configuration  The configuration
     */
    public function __construct($configuration = null, $webRequest = null)
    {
        if(is_a($configuration, Configuration::class)) {
            $this->_configuration = $configuration;    
        }
        else if(!empty($configuration) && is_array($configuration)) {
            $this->_configuration = new Configuration($configuration);
        }

        if(!is_a($webRequest, WebRequest::class)) {
            $webRequest = ($this->_configuration['spoof'] ? new SpoofedVerbRequest() : new GuzzleRequest())
                            ->setConfiguration($this->_configuration);
        }

        $this->_webRequest = $webRequest;
    }

    /**
     * Sets the configuration.
     *
     * @param      Configuration  $value  The value
     *
     * @return     \CheckItOnUs\StatusPage\StatusPage
     */
    public function setConfiguration(Configuration $value)
    {
        $this->_configuration = $value;

        $this->request()
            ->setConfiguration($value);

        return $this;
    }

    /**
     * Retrieves the configuration object
     *
     * @return     \CheckItOnUs\StatusPage\Configuration  The configuration.
     */
    public function getConfiguration()
    {
        return $this->_configuration;
    }

    /**
     * Retrieves the web request object
     *
     * @return \CheckItOnUs\StatusPage\Request\WebRequest
     */
    public function request()
    {
        return $this->_webRequest;
    }

    /**
     * Returns a collection of components.
     *
     * @return     Illuminate\Support\Collection
     */
    public function components()
    {
        return Component::on($this)
                ->all();
    }

    /**
     * Retrieves a list of Incidents.
     *
     * @return     Illuminate\Support\Collection
     */
    public function incidents()
    {
        return Incident::on($this)
                ->all();
    }
}