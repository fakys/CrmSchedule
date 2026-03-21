<?php

namespace Tests;

use App\Providers\AppServiceProvider;
use App\Providers\InitKernelProvider;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class AbstractTransactionTestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(
            AppServiceProvider::class
        );

        $this->app->register(InitKernelProvider::class);
        DB::beginTransaction();
    }

    public function tearDown(): void
    {
        DB::commit();
        parent::tearDown();
    }
}
