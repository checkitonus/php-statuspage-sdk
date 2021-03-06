<?php

namespace CheckItOnUs\StatusPage\Request;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use CheckItOnUs\StatusPage\Configuration;
use GuzzleHttp\Exception\ClientException;
use CheckItOnUs\StatusPage\Request\PagedResponse;

class GuzzleRequest implements WebRequest
{
    /**
     * The base guzzle HTTP client.
     */
    private $_client;

    /**
     * The configuration object
     * 
     * @var \CheckItOnUs\StatusPage\Configuration
     */
    private $_configuration;

    /**
     * Initialize the object.
     */
    public function __construct()
    {
        $this->_client = new Client();
    }

    /**
     * Sets up the configuration for the web request.
     *
     * @param      \CheckItOnUs\StatusPage\Configuration  $configuration  The configuration
     * @return     \CheckItOnUs\StatusPage\Request\WebRequest
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->_configuration = $configuration;

        if($configuration->getBaseUrl()) {
            $this->_client = new Client([
            ]);
        }

        return $this;
    }

    /**
     * Performs a GET request.
     *
     * @param      string  $url    The URL suffix to send the request to
     */
    public function get($url)
    {
        return new PagedResponse(
            $this,
            $url
        );
    }

    /**
     * Performs a raw GET request
     *
     * @param      string  $url    THe URL suffix to send the request to
     * @return     mixed
     */
    public function getRaw($url)
    {
        try {
            return $this->raw('GET', $url);
        }
        catch(ClientException $ex) {
            if($ex->getResponse()->getStatusCode() == 404) {
                return null;
            }

            throw $ex;
        }
    }

    /**
     * Performs a DELETE request.
     *
     * @param      string  $url    The URL suffix to send the request to
     */
    public function delete($url)
    {
        return $this->raw('DELETE', $url);
    }

    /**
     * Performs a POST request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    public function post($url, $data)
    {
        return $this->raw('POST', $url, $data);
    }

    /**
     * Performs a PUT request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    public function put($url, $data)
    {
        return $this->raw('PUT', $url, $data);
    }

    /**
     * Performs a PATCH request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    public function patch($url, $data)
    {
        return $this->raw('PATCH', $url, $data);
    }

    /**
     * Processes a raw request.
     *
     * @param      string  $method  The method
     * @param      string  $url     The url
     * @param      mixed  $data    The data
     *
     * @return     Object
     */
    private function raw($method, $url, $data = null)
    {
        $headers = [
            'headers' => [
                'Authorization' => $this->_configuration->getApiKey(),
            ],
        ];

        if(!empty($data)) {
            $headers[RequestOptions::JSON] = $data;
        }

        $url = implode('/', [$this->_configuration->getBaseUrl(), $this->_configuration->getPageId(), $url . '.json']);

        return json_decode(
            $this->_client
                ->request($method, $url, $headers)
                ->getBody()
                ->__toString()
        );
    }
}
