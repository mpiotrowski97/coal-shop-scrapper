<?php

namespace App\Providers;

use App\Services\ClientInterface;
use App\Services\CoalShopClient;
use App\Services\HtmlParser;
use App\Services\MockShopClient;
use App\Services\ParserInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ('testing' === $_ENV['APP_ENV']) {
            $this->app->bind(ClientInterface::class, function () {
                return new MockShopClient(resource_path('mocks/coal-shop-page.html'));
            });
        }

        $this->app->bind(ParserInterface::class, function () {
            return new HtmlParser();
        });

        $this->app->bindIf(ClientInterface::class, function () {
            return new CoalShopClient('https://sklep.pgg.pl');
        });
    }
}
