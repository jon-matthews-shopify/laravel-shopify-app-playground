<?php

namespace App\Models;

class ShopifyGraphQLAdminApi
{
    private $_accessToken = '';
    private $_endpoint = '';

    private $response = null;
    private $responseHeader = null;
    private $responseBody = null;

    public function __construct($accessToken, $storeName, $apiVersion)
    {
        $this->_accessToken = $accessToken;
        $this->_endpoint = "https://{$storeName}.myshopify.com/admin/api/{$apiVersion}/graphql.json";
    }

    public function request(string $query, array $vars = [])
    {
        // @TODO(JM) query var replacement
        // ...

        $chObj = curl_init();
        curl_setopt($chObj, CURLOPT_URL, $this->_endpoint);
        curl_setopt($chObj, CURLOPT_RETURNTRANSFER, true);    
        curl_setopt($chObj, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($chObj, CURLOPT_HEADER, true);
        curl_setopt($chObj, CURLOPT_VERBOSE, true);
        curl_setopt($chObj, CURLOPT_POSTFIELDS, $query);
        curl_setopt($chObj, CURLOPT_HTTPHEADER, [
            'Content-Type: application/graphql',
            'X-Shopify-Access-Token: ' . $this->_accessToken
        ]); 

        $response = curl_exec($chObj);

        $headerSize = curl_getinfo($chObj, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $headerSize);

        $this->_response = $response;
        $this->_responseHeader = $this->_getCurlResponseHeaders($header);
        $this->_responseBody = json_decode(substr($response, $headerSize), true);

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
