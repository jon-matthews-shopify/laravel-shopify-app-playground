<?php

namespace App\Models;

class ShopifyRestAdminApi
{
    private $_accessToken = '';
    private $_apiVersion = '';
    private $_storeName = '';

    private $response = null;
    private $responseHeader = null;
    private $responseBody = null;

    public function __construct($accessToken, $storeName, $apiVersion)
    {
        $this->_accessToken     = $accessToken;
        $this->_storeName       = $storeName;
        $this->_apiVersion      = $apiVersion;
    }

    public function post(string $resourceURI, array $payload = [])
    {
        $url = "https://{$this->_storeName}.myshopify.com/admin/api/{$this->_apiVersion}{$resourceURI}";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-Shopify-Access-Token: ' . $this->_accessToken
            ),
            CURLOPT_POSTFIELDS => json_encode($payload)
        ));

        $response = curl_exec($curl);

        $this->_response = $response;
        $this->_responseBody = json_decode($response, true);

        return $this;
    }

    public function request(string $httpMethod, string $resourceURI)
    {
        $url = "https://{$this->_storeName}.myshopify.com/admin/api/{$this->_apiVersion}{$resourceURI}";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => strtoupper($httpMethod),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-Shopify-Access-Token: ' . $this->_accessToken
            ),
        ));

        $response = curl_exec($curl);

        $this->_response = $response;
        $this->_responseBody = json_decode($response, true);

        return $this;
    }

    public function getResponse()
    {
        return $this->_response;
    }

    public function getHeader()
    {
        return $this->_responseHeader;
    }

    public function getBody()
    {
        return $this->_responseBody;
    }

    private function _getCurlResponseHeaders($respHeaders)
    {
        $headers = array();
    
        $headerText = substr($respHeaders, 0, strpos($respHeaders, "\r\n\r\n"));
    
        foreach (explode("\r\n", $headerText) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
            } else {
                list ($key, $value) = explode(': ', $line);
    
                $headers[$key] = $value;
            }
        }
    
        return $headers;
    }
}
