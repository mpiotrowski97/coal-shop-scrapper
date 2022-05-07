<?php

namespace App\Services;

class MockShopClient implements ClientInterface
{
    public function __construct(private string $filePath)
    {
    }

    public function getHtml(): string
    {
        return file_get_contents($this->filePath);
    }
}
