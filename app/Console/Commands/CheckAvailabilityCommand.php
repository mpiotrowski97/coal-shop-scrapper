<?php

namespace App\Console\Commands;

use App\Events\CoalAvailableEvent;
use App\Models\CoalLine;
use App\Services\ClientInterface;
use App\Services\ParserInterface;
use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Log;

class CheckAvailabilityCommand extends Command
{
    protected $signature = 'availability:check';

    protected $description = 'Check coal packages availability';

    public function __construct(private ClientInterface $client, private ParserInterface $parser)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $items = $this->tryToParseItems($this->client->getHtml());
        $isAvailable = in_array(true, array_map(fn(CoalLine $item) => $item->isAvailable(), $items));

        if (!$isAvailable) {
            Log::info('Checker finished with no items');
            $this->info('Checker finished with no items');
            return;
        }

        event(new CoalAvailableEvent());

        Log::info('Checker finished with success');
        $this->info('Checker finished with success');
    }

    /**
     * @param string $html
     * @return CoalLine[]
     */
    private function tryToParseItems(string $html): array
    {
        try {
            return $this->parser->parse($html);
        } catch (\InvalidArgumentException $e) {
            Log::critical(sprintf('Cannot parse items "%s"', $e->getMessage()));
            throw new \RuntimeException('Cannot parse', 0, $e);
        }
    }
}
