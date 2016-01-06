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
namespace Meanbee\Postcode\Model;

class Response implements ResponseInterface
{

    /**
     * @var bool
     */
    protected $error;

    /**
     * @var string
     */
    protected $content;

    /**
     * Response constructor.
     *
     * @param null $error
     * @param null $content
     */
    public function __construct($error = null, $content = null)
    {
        $this->setError($error);
        $this->setContent($content);
    }

    /**
     * Get the error value
     *
     * @return bool
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set the error value
     *
     * @param bool $error
     *
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get the content value.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the content value.
     *
     * @param string $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Return this object as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'error'   => $this->error,
            'content' => $this->content
        ];
    }
}
