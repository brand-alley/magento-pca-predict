<?php

namespace Meanbee\Postcode\Api;

interface ServiceInterface
{
    /**
     * Return a unique code for the service.
     *
     * @return string
     */
    public function getCode();

    /**
     * Check if the account is valid.
     *
     * @return bool
     */
    public function isAccountValid();

    /**
     * Get a single address from a postcode.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function getSingleAddress($id);

    /**
     * Get multiple addresses
     *
     * @param string $postcode
     *
     * @return mixed
     */
    public function getMultipleAddresses($postcode);

}
