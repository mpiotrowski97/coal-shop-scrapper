<?php

namespace Tests\Console\Commands;

use App\Console\Commands\CheckAvailabilityCommand;
use App\Services\ClientInterface;
use App\Services\ParserInterface;
use Illuminate\Events\Dispatcher;
use Tests\TestCase;

class CheckAvailabilityCommandTest extends TestCase
{
    /**
     * @test
     */
    public function itDoesNotDispatchEventIfThereIsNoAvailableItem(): void
    {
        $clientMock = $this->createMock(ClientInterface::class);
        $clientMock->method('getHtml')
            ->willReturn(file_get_contents(resource_path('mocks/coal-shop-page.html')));

        $dispatcherMock = $this->createMock(Dispatcher::class);
        $dispatcherMock->expects(self::never())->method('dispatch');
        $this->app->bind('events', function () use ($dispatcherMock) {
            return $dispatcherMock;
        });

        $command = new CheckAvailabilityCommand(
            $clientMock,
            $this->app->make(ParserInterface::class)
        );

        $command->handle();
    }

    /**
     * @test
     */
    public function itDispatchEventIfThereIsAvailableItem(): void
    {
        $clientMock = $this->createMock(ClientInterface::class);
        $clientMock->method('getHtml')
            ->willReturn(file_get_contents(resource_path('mocks/coal-shop-page-available.html')));

        $dispatcherMock = $this->createMock(Dispatcher::class);
        $dispatcherMock->expects(self::once())->method('dispatch');
        $this->app->bind('events', function () use ($dispatcherMock) {
            return $dispatcherMock;
        });


        $command = new CheckAvailabilityCommand(
            $clientMock,
            $this->app->make(ParserInterface::class)
        );

        $command->handle();
    }
}
