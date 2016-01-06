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

use Meanbee\Postcode\Helper\Data;
use Symfony\Component\Config\Definition\Exception\Exception;

class Call
{

    /**
     * @var Data
     */
    protected $postcodeData;

    /**
     * @var Response
     */
    protected $response;

    /**
     * Call constructor.
     *
     * @param Data     $postcodeData
     * @param Response $response
     */
    public function __construct(Data $postcodeData, Response $response)
    {
        $this->postcodeData = $postcodeData;
        $this->response = $response;
    }

    /**
     * Return a response for a multiple.
     *
     * @param $postcode
     * @param $area
     *
     * @return array
     */
    public function findMultipleByPostcode($postcode, $area)
    {
        list($license, $account) = $this->checkAccountAndLicense($area);

        if ($this->response->getError() === true) {
            return $this->response->toArray();
        }

        try {
            $content = $this->_submitFindAddressesRequest($postcode, $account, $license, '');
            $this->response->setError(false);
            $this->response->setContent($content);
        } catch (Exception $e) {
            $this->response->setError(true);
            $this->response->setContent($e->getMessage());
        }

        return $this->response->toArray();
    }

    /**
     * @param $id
     * @param $area
     *
     * @return mixed
     */
    public function findSingleAddressById($id, $area)
    {
        list($license, $account) = $this->checkAccountAndLicense($area);

        if ($this->response->getError() === true) {
            return $this->response->toArray();
        }

        $id = intval($id);

        try {
            $result = $this->_submitFindSingleAddressRequest($id, 'english', 'simple', $account, $license, '', '');

            if (count($result)) {
                $this->response->setError(false);
                $this->response->setContent($result[0]);
            } else {
                $this->response->setError(true);
                $this->response->setContent("Unable to find address ($id)");
            }
        } catch (Exception $e) {
            $this->response->setError(true);
            $this->response->setContent($e->getMessage());
        }

        return $this->response->toArray();
    }

    protected function _submitFindAddressesRequest($postcode, $account_code, $license_code, $machine_id)
    {
        //Built with help from James at http://www.omlet.co.uk/
        //Build the url
        $url = "http://services.postcodeanywhere.co.uk/xml.aspx?";
        $url .= "&action=lookup";
        $url .= "&type=by_postcode";
        $url .= "&postcode=" . urlencode($postcode);
        $url .= "&account_code=" . urlencode($account_code);
        $url .= "&license_code=" . urlencode($license_code);
        $url .= "&machine_id=" . urlencode($machine_id);

        //Make the request
        $data = simplexml_load_string($this->_makeRequest($url));
        $output = array();

        //Check for an error
        if ($data->Schema['Items'] == 2) {
            throw new exception ($data->Data->Item['message']);
        }

        //Create the response
        foreach ($data->Data->children() as $row) {
            $rowItems = "";
            foreach ($row->attributes() as $key => $value) {
                $rowItems[$key] = strval($value);
            }
            $output[] = $rowItems;
        }

        if (empty($output)) {
            throw new exception ('Invalid Postcode');
        }

        //Return the result
        return $output;
    }

    protected function _submitFindSingleAddressRequest(
        $id,
        $language,
        $style,
        $account_code,
        $license_code,
        $machine_id,
        $options
    ) {
        //Built with help from James at http://www.omlet.co.uk/
        //Build the url
        $url = "http://services.postcodeanywhere.co.uk/xml.aspx?";
        $url .= "&action=fetch";
        $url .= "&id=" . urlencode($id);
        $url .= "&language=" . urlencode($language);
        $url .= "&style=" . urlencode($style);
        $url .= "&account_code=" . urlencode($account_code);
        $url .= "&license_code=" . urlencode($license_code);
        $url .= "&machine_id=" . urlencode($machine_id);
        $url .= "&options=" . urlencode($options);

        //Make the request
        $data = simplexml_load_string($this->_makeRequest($url));
        $output = array();

        //Check for an error
        if ($data->Schema['Items'] == 2) {
            throw new Exception ($data->Data->Item['message']);
        }

        foreach ($data->Data->children() as $row) {
            $rowItems = "";
            foreach ($row->attributes() as $key => $value) {
                $rowItems[$key] = strval($value);
            }
            $output[] = $rowItems;
        }

        return $output;
    }

    /**
     * Fetch the contents at a URL.  Use cURL if available.
     */
    protected function _makeRequest($url)
    {
        if (function_exists("curl_setopt")) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_URL, $url);
            $data = curl_exec($curl);
            curl_close($curl);

            return $data;
        } else {
            return file_get_contents($url);
        }
    }

    /**
     * @todo move license/account into own model.
     *
     * @param $area
     *
     * @return array
     */
    protected function checkAccountAndLicense($area)
    {
        $license = ($area == 'admin') ? $this->postcodeData->getAdminKey() : $this->postcodeData->getPublicKey();
        $account = $this->postcodeData->getAccountCode();

        if (empty($license) || empty($account)) {
            $this->response->setError(true);
            $this->response->setContent('License and/or Account keys are not set in the configuration');

            return [$license, $account];
        }

        return [$license, $account];
    }
}
