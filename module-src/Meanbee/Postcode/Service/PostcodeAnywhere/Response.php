<?php

namespace Meanbee\Postcode\Service\PostcodeAnywhere;

use Exception;
use Meanbee\Postcode\Service\Response as BaseResponse;
use SimpleXMLElement;

class Response extends BaseResponse
{

    /**
     * @var array
     */
    protected $output = [];

    /**
     * @var SimpleXMLElement
     */
    protected $xml;

    /**
     * {@inheritdoc}
     */
    public function setContent($string)
    {
        try {
            $this->setXml($string);
            $this->setOutput();
            parent::setContent($this->output);
            $this->setError(false);
        } catch (Exception $e) {
            parent::setContent($e->getMessage());
            $this->setError(true);
        }

        return $this;
    }

    /**
     * Get the xml.
     *
     * @return SimpleXMLElement
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * Set the xml element.
     *
     * @param string $xml
     *
     * @return $this
     */
    public function setXml($xml)
    {
        $this->xml = simplexml_load_string($xml);

        return $this;
    }

    /**
     * Set the output from the Postcode Anywhere
     * response.
     *
     * @return $this
     * @throws Exception
     */
    protected function setOutput()
    {
        if ($this->hasErrors()) {
            throw new Exception($this->getError());
        }

        foreach ($this->xml->Data->children() as $row) {
            $rowItems = [];
            foreach ($row->attributes() as $key => $value) {
                $rowItems[$key] = $value;
            }

            $this->output[] = $rowItems;
        }

        if (empty($this->output)) {
            throw new Exception("Invalid Postcode");
        }

        return $this;
    }

    /**
     * Check if Postcode Anywhere's
     *
     * @return bool
     */
    protected function hasErrors()
    {
        if ($this->xml->Schema['items'] == 2) {
            return true;
        }

        return false;
    }

    /**
     * Get the errors from Postcode Anywhere.
     *
     * @return string
     */
    protected function getErrors()
    {
        return $this->xml->Data->Item['message'];
    }
}
