<?php

namespace Wu\Guzzle;

use GuzzleHttp\Client as GuzzleClient;
use Wu\Guzzle\Exception\BadResponseException;
use Wu\Guzzle\Exception\RequestException;

class Client extends GuzzleClient
{
    public function _get(string $uri, array $options = [])
    {
        return $this->_request('GET', $uri, $options);
    }

    public function _post(string $uri, array $options = [])
    {
        return $this->_request('POST', $uri, $options);
    }

    public function _request($method, $uri = '', array $options = [])
    {
        try {
            $response = parent::request($method, $uri, $options)->getBody()->getContents();
        } catch (\Exception $e) {
            throw RequestException::apiError('接口调用失败', $e->getMessage(), $uri, $options);
        }

        try {
            return \GuzzleHttp\json_decode($response, true);
        } catch (\Exception $e) {
            throw BadResponseException::apiError('接口调用失败', $e->getMessage(), $uri, $options, $response);
        }
    }
}
