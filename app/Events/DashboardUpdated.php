<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DashboardUpdated implements ShouldBroadcastNow 
{
    use Dispatchable, SerializesModels;

    public $stats;
    public $weekly;
    public $activities;

    public function __construct($stats, $weekly, $activities)
    {
        $this->stats = $stats;
        $this->weekly = $weekly;
        $this->activities = $activities;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('klinik-dashboard'),
        ];
    }
}