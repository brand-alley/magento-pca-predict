<?php

namespace Meanbee\Postcode\Model;

interface UrlInterface {

    /**
     * Build and return the current url
     *
     * @return string
     */
    public function getUrl();

    /**
     * Get the parameters set on the url
     *
     * @return array
     */
    public function getParams();

    /**
     * Set the parameters on the url
     *
     * @param array $params
     *
     * @return $this
     */
    public function setParams($params);

    /**
     * Set a url parameter
     *
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setParam($key, $value);

    /**
     * Get the current file path
     *
     * @return string
     */
    public function getFilePath();

    /**
     * Set the current file path
     *
     * @param string $filePath
     *
     * @return $this
     */
    public function setFilePath($filePath);

    /**
     * Is the current url secure
     *
     * @return bool
     */
    public function isSecure();

    /**
     * Set whether the current url
     * should be secure.
     *
     * @param bool $isSecure
     *
     * @return $this
     */
    public function setIsSecure($isSecure);

    /**
     * Get the current protocol
     *
     * @return string
     */
    public function getProtocol();

    /**
     * Get the query identifier
     *
     * @return string
     */
    public function getQueryIdentifier();

    /**
     * Set the current query parameter.
     *
     * @param string $queryIdentifier
     *
     * @return $this
     */
    public function setQueryIdentifier($queryIdentifier);

    /**
     * get the current base url
     *
     * @return string
     */
    public function getBaseUrl();

    /**
     * Set the base url
     *
     * @param string $baseUrl
     *
     * @return $this
     */
    public function setBaseUrl($baseUrl);

}
