<?php

namespace Sfneal\PostOffice\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Sfneal\PostOffice\Providers\PostOfficeServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    /**
     * Register package service providers.
     *
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            PostOfficeServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {

        // Set config values
        $app['config']->set('app.debug', true);
    }
}
