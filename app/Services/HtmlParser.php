<?php

namespace App\Services;

use App\Models\CoalLine;
use Symfony\Component\DomCrawler\Crawler;

class HtmlParser implements ParserInterface
{
    private const NAME = 'Ekogroszek';
    private const OUT_OF_STOCK_LABEL = 'Brak towaru';
    private const NAME_SELECTOR = 'div.col-8.col-md-2.text-4.pt-3.text-center span.font-weight-bold';
    private const AVAILABILITY_SELECTOR = 'div.col-4.col-md-2.pt-3.text-center span.text-4.text-red';

    /**
     * @param string $content
     * @return CoalLine[]
     */
    public function parse(string $content): array
    {
        $lines = [];
        $crawler = new Crawler($content);

        $crawler
            ->filter('html > body div.shop div.row.mt-4.justify-content-center')
            ->reduce(function (Crawler $node) {
                return str_contains($node->filter(self::NAME_SELECTOR)
                    ->innerText(), self::NAME);
            })
            ->each(function (Crawler $node) use (&$lines) {
                $name = $node->filter(self::NAME_SELECTOR)->innerText();
                $isAvailable = $this->tryToCheckAvailability($node);

                $lines[] = new CoalLine($name, $isAvailable);
            });

        return $lines;
    }

    /**
     * @param Crawler $node
     * @return bool
     */
    function tryToCheckAvailability(Crawler $node): bool
    {
        try {
            return $node->filter(self::AVAILABILITY_SELECTOR)->innerText()
                !== self::OUT_OF_STOCK_LABEL;
        } catch (\InvalidArgumentException) {
            return true;
        }
    }
}
