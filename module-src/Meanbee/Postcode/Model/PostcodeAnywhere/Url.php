<?php

/**
 * Meanbee_Postcode
 *
 * Portions of this software uses code found at:
 *   - http://www.postcodeanywhere.co.uk/developers
 *
 * @category   Meanbee
 * @package    Meanbee_Postcode
 * @author     Meanbee Limited <hello@meanbee.com>
 * @copyright  Copyright (c) 2012 Meanbee Limited (http://www.meanbee.com)
 * @license    Single Site License, requiring consent from Meanbee
 */
namespace Meanbee\Postcode\Model\PostcodeAnywhere;

use Meanbee\Postcode\Model\UrlInterface;

class Url implements UrlInterface
{

    const DEFAULT_BASE_URL = 'services.postcodeanywhere.co.uk/';
    const DEFAULT_FILE_PATH = 'xml.aspx';
    const DEFAULT_QUERY_IDENTIFIER = '?';
    const SECURE_PROTOCOL = 'https://';
    const INSECURE_PROTOCOL = 'http://';

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var bool
     */
    protected $isSecure;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $queryIdentifier;


    /**
     * @var string
     */
    protected $filePath;

    /**
     * Url constructor.
     *
     * @param string $baseUrl
     * @param string $filePath
     * @param string $queryIdentifier
     * @param array  $params
     * @param bool   $isSecure
     */
    public function __construct(
        $baseUrl = self::DEFAULT_BASE_URL,
        $filePath = self::DEFAULT_FILE_PATH,
        $queryIdentifier = self::DEFAULT_QUERY_IDENTIFIER,
        $params = [],
        $isSecure = false
    ) {
        $this->setBaseUrl($baseUrl);
        $this->setFilePath($filePath);
        $this->setQueryIdentifier($queryIdentifier);
        $this->setParams($params);
        $this->setIsSecure($isSecure);
    }

    /**
     * Build and return the current url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getProtocol() .
        $this->getBaseUrl() .
        $this->getFilePath() .
        $this->getQueryIdentifier() .
        http_build_query($this->getParams());
    }

    /**
     * Get the parameters set on the url
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set the parameters on the url
     *
     * @param array $params
     *
     * @return $this
     */
    public function setParams($params)
    {
        foreach($params as $key => $value) {
            $this->setParam($key, $value);
        }

        return $this;
    }

    /**
     * Set a url parameter
     *
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setParam($key, $value)
    {
        $this->params[urlencode($key)] = urlencode($value);

        return $this;
    }

    /**
     * Is the current url secure
     *
     * @return bool
     */
    public function isSecure()
    {
        return $this->isSecure;
    }

    /**
     * Set whether the current url
     * should be secure.
     *
     * @param bool $isSecure
     *
     * @return $this
     */
    public function setIsSecure($isSecure)
    {
        $this->isSecure = boolval($isSecure);

        return $this;
    }

    /**
     * Get the current protocol
     *
     * @return string
     */
    public function getProtocol()
    {
        if ($this->isSecure()) {
            return static::SECURE_PROTOCOL;
        }

        return static::INSECURE_PROTOCOL;
    }

    /**
     * get the current base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Set the base url
     *
     * @param string $baseUrl
     *
     * @return $this
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * Get the query parameter
     *
     * @return string
     */
    public function getQueryIdentifier()
    {
        return $this->queryIdentifier;
    }

    /**
     * Set the current query parameter.
     *
     * @param string $queryIdentifier
     *
     * @return $this
     */
    public function setQueryIdentifier($queryIdentifier)
    {
        $this->queryIdentifier = $queryIdentifier;

        return $this;
    }

    /**
     * Get the current file path
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set the current file path
     *
     * @param string $filePath
     *
     * @return $this
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * Clear the current values and create a new
     * instance of self.
     *
     * @param string $baseUrl
     * @param string $filePath
     * @param string $queryIdentifier
     * @param array  $params
     * @param bool   $isSecure
     *
     * @return Url
     */
    public function clear(
        $baseUrl = self::DEFAULT_BASE_URL,
        $filePath = self::DEFAULT_FILE_PATH,
        $queryIdentifier = self::DEFAULT_QUERY_IDENTIFIER,
        $params = [],
        $isSecure = false
    ) {
        return new Url($baseUrl, $filePath, $queryIdentifier,  $params, $isSecure);
    }

}
