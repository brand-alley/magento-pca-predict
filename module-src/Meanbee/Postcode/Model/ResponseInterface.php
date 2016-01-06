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

interface ResponseInterface {

    /**
     * Get the error value
     *
     * @return bool
     */
    public function getError();

    /**
     * Set the error value
     *
     * @param bool $error
     *
     * @return $this
     */
    public function setError($error);

    /**
     * Get the content value.
     *
     * @return string
     */
    public function getContent();

    /**
     * Set the content value.
     *
     * @param string $content
     *
     * @return $this
     */
    public function setContent($content);

    /**
     * Return this object as an array.
     *
     * @return array
     */
    public function toArray();

}
