<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

#[ShouldBroadcast]
class SeriesCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly string $seriesName,
        public readonly int $seriesId,
        public readonly int $seriesSeasonsQty,
        public readonly int $seriesEpisodesPerSeason
    ) {}

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('channel-name');
    }
}
