<?php
namespace App\Services\ProviderLoader\Infrastructure\Services\Events;

use Illuminate\Queue\SerializesModels;

class BootProviderLoaderEvent {
    use SerializesModels;
    public function __construct(){}
}
