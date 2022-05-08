<?php

namespace App\Services;

use GuzzleHttp\Client;

class CoalShopClient implements ClientInterface
{
    public function __construct(private string $url)
    {
    }

    public function getHtml(): string
    {
        $client = new Client();

        $res = $client->request('GET', $this->url);

        if (200 !== $res->getStatusCode()) {
            throw new \RuntimeException('Shop does not respond');
        }

        return $res->getBody()->getContents();
    }
}
