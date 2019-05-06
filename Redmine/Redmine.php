<?php

namespace Redmine;

use Redmine\Client\Guzzle;

class Redmine
{
    public function __construct($baseUri, $apiKey)
    {
        $this->client = new Guzzle($baseUri, $apiKey);
    }

    public function getUsers()
    {
        $response = $this->client->get('users.json');

        return $response->getApiResponse();
    }
}
