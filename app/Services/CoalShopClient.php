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

        return file_get_contents(resource_path('mocks/coal-shop-page-available.html'));
//        return $res->getBody()->getContents();
    }
}
