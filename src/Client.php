<?php

namespace Wu\Guzzle;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Config;
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
            throw new RequestException(Config::get('app.debug')
                ? '接口调用失败, 调试信息: uri: ' . $uri . ', options: ' . json_encode($options, JSON_UNESCAPED_UNICODE)
                : '接口调用失败');
        }

        try {
            return \GuzzleHttp\json_decode($response, true);
        } catch (\Exception $e) {
            throw new BadResponseException(Config::get('app.debug')
                ? '接口返回错误, 调试信息: uri: ' . $uri . ', options: ' . json_encode($options, JSON_UNESCAPED_UNICODE) . ', response: ' . $response
                : '接口返回错误');
        }
    }
}
