<?php

require_once(__DIR__ . '/Exception.php');

abstract class HttpClient {

    const PAGERDUTY_AUTH_TYPE_BASIC = 'basic';

    protected $apiUrl;
    protected $subdomain = 'pagerdutysubdomain';
    protected $token = 'authorization_token';
    protected $scheme = 'https';
    protected $apiVer = 'v1';
    protected $hostname;
    protected $userAgent;

    private $headers = array();
    private $auth;

    public $guzzle = null;

    public function __construct($scheme, $subdomain, $guzzle) {

        if (is_null($guzzle)) {
            $this->guzzle = new \GuzzleHttp\Client();
        } else {
            $this->guzzle - $guzzle;
        }

        $this->scheme = $scheme;
        $this->subdomain = $subdomain;

        $this->apiUrl = "$scheme://$subdomain.pagerduty.com/api/{$this->apiVer}/";
    }

    public function getAuth() {
        return $this->auth;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function setHeader($key, $value) {
        $this->headers[$key] = $value;

        return $this;
    }

    public function getSubdomain() {
        return $this->subdomain;
    }

    public function getApiUrl() {
        return $this->apiUrl;
    }

    public function getUserAgent() {
        return $this->userAgent;
    }
    public function get($endpoint, $queryParams = []) {
        $response = Http::send(
            $this,
            $endpoint,
            ['queryParams' => $queryParams]
        );

        return $response;
    }

    public function post($endpoint, $postData = []) {
        $response = Http::send(
            $this,
            $endpoint,
            [
                'postFields' => $postData,
                'method'     => 'POST'
            ]
        );

        return $response;
    }
}