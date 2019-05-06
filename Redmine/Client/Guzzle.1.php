<?php

namespace Redmine\Client;

class Guszzle
{
    protected $client;
    protected $headers;
    protected $status;
    protected $token;
    protected $baseUri;
    protected $response;

    public function __construct($baseUri, $apiKeyOrUsername, $password = null)
    {
        $this->baseUri = $baseUri;
        $this->setToken($token);
        $this->client = new \GuzzleHttp\Client();
    }

    protected function setRequestData(array $headers = [])
    {
        $allHeaders = $headers + [
            'Authorization' => 'Bearer '.$this->getToken(),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];

        $this->addHeaders($allHeaders);

        return[
            'base_uri' => $this->baseUri,
            'headers' => $this->getHeaders(),
        ];
    }

    public function get(string $url, array $headers = [])
    {
        $sentHeaders = $this->setRequestData($headers);
        logInfo([
          'ref' => 'Sending GET request',
          'url' => $url,
          'sentHeaders' => $sentHeaders,
        ]);
        $this->fire($this->client->get($url, $sentHeaders));

        return $this;
    }

    public function post(string $url, array $postData = [], array $headers = [])
    {
        $body = ['body' => json_encode($postData)];
        $sentHeaders = $this->setRequestData($headers);
        logInfo([
          'ref' => 'Sending POST request',
          'url' => $url,
          'sentHeaders' => $sentHeaders,
          'postData' => $postData,
        ]);
        try {
            $client = new \GuzzleHttp\Client($sentHeaders);
            $request = $client->post($url, $body);

            return $this->fire($request);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $this->handleGuzzleExceptions($e, 'post', $url, $body);
        }
    }

    public function put(string $url, array $postData = [], array $headers = [])
    {
        $body = ['body' => json_encode($postData)];
        $sentHeaders = $this->setRequestData($headers);
        logInfo([
          'ref' => 'Sending PUT request',
          'url' => $url,
          'sentHeaders' => $sentHeaders,
          'postData' => $postData,
        ]);
        try {
            $client = new \GuzzleHttp\Client($sentHeaders);
            $request = $client->put($url, $body);

            return $this->fire($request);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $this->handleGuzzleExceptions($e, 'put', $url, $body);
        }
    }

    public function delete(string $url, array $headers = [])
    {
        try {
            $this->fire($this->client->delete($url, $this->setRequestData($headers)));

            return $this;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $this->handleGuzzleExceptions($e, 'delete', $url);
        }
    }

    protected function handleGuzzleExceptions($e, $method, $url, $postData = [])
    {
        $this->setStatus($e->getCode());
        $this->response = json_decode($e->getResponse()->getBody()->getContents());
        if ($e->getCode() == 422) {
            logExceptionError($e, [
                'validation-errors' => $this->getResponse(),
                'http-method' => $method,
                'request-url' => $url,
                'post-data' => $postData,
                'post-data-json' => json_encode($postData),
            ]);
        }

        return $this;
        //we may need to catch more errors in due course
    }

    protected function fire($response)
    {
        $this->setStatus($response->getStatusCode());
        $this->setResponse($response);

        return $this;
    }

    /**
     * Get the value of status.
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status.
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set the value of token.
     *
     * @return self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get the value of token.
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get the value of response.
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set the value of response.
     *
     * @return self
     */
    public function setResponse($response)
    {
        $this->response = response()->json(json_decode($response->getBody()), $response->getStatusCode())->getData();

        return $this;
    }

    /**
     * Add new header to headers array.
     */
    public function addHeaders(array $headers = [])
    {
        foreach ($headers as $key => $header) {
            $this->addHeader($key, $header);
        }

        return $this;
    }

    /**
     * Add new header to headers array.
     */
    public function addHeader($key, $header)
    {
        $this->headers[$key] = $header;

        return $this;
    }

    /**
     * Get the value of headers.
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set the value of headers.
     *
     * @return self
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }
}
