<?php

    use GuzzleHttp\Psr7\Request;
    use GuzzleHttp\Psr7\LazyOpenStream;
    use GuzzleHttp\Exception\RequestException;

    class Http {
        public static $curl;

        public static function send(HttpClient $client, $endpoint, $options = array()) {

            $options = array_merge(array(
                'method' => 'GET',
                'contentType' => 'application/json',
                'postFields' => null,
                'queryParams' => null
            ), $options);

            $headers = array_merge(array(
                'Accept' => 'application/json',
                'Content-Type' => $options['contentType'],
                'User-Agent' => $client->getUserAgent()
            ), $client->getHeaders());

            $request = new Request(
                $options['method'],
                $client->getApiUrl() . $endpoint,
                $headers
            );

            $response = $client->guzzle->send($request);

            return json_decode($response->getBody()->getContents());
        }
    }