<?php

namespace Tests\Services;

use App\Models\CoalLine;
use App\Services\ClientInterface;
use App\Services\HtmlParser;
use Tests\TestCase;

class HtmlParserTest extends TestCase
{
    /**
     * @test
     */
    public function itParseCoalLines(): void
    {
        /**
         * @var HtmlParser $service
         */
        $service = $this->app->make(HtmlParser::class);

        $items = $service->parse(file_get_contents(resource_path('mocks/coal-shop-page.html')));

        self::assertCount(10, $items);
    }

    /**
     * @test
     */
    public function itParseCoalLinesWithAvailability(): void
    {
        /**
         * @var HtmlParser $service
         */
        $service = $this->app->make(HtmlParser::class);

        $items = $service->parse(file_get_contents(resource_path('mocks/coal-shop-page-available.html')));

        self::assertCount(10, $items);
        self::assertCount(3, array_filter($items, fn (CoalLine $line) => $line->isAvailable()));
    }
}
