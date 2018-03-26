<?php

namespace CheckItOnUs\StatusPage\Request;

use CheckItOnUs\StatusPage\Configuration;

interface WebRequest
{
    /**
     * Sets up the configuration for the web request.
     *
     * @param      \CheckItOnUs\StatusPage\Configuration  $configuration  The configuration
     */
    function setConfiguration(Configuration $configuration);

    /**
     * Performs a GET request.
     *
     * @param      string  $url    The URL suffix to send the request to
     * @return     \CheckItOnUs\StatusPage\Request\PagedResponse
     */
    function get($url);

    /**
     * Performs a raw GET request.
     *
     * @param      string  $url    The URL suffix to send the request to
     * @return     mixed
     */
    function getRaw($url);

    /**
     * Performs a DELETE request.
     *
     * @param      string  $url    The URL suffix to send the request to
     */
    function delete($url);

    /**
     * Performs a POST request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    function post($url, $data);

    /**
     * Performs a PUT request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    function put($url, $data);

    /**
     * Performs a PATCH request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    function patch($url, $data);
}