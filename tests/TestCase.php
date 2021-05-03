<?php

namespace Sfneal\PostOffice\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Sfneal\PostOffice\Providers\PostOfficeServiceProvider;
use Sfneal\Users\Providers\UsersServiceProvider;

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
            UsersServiceProvider::class,
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

        // Migrate 'user' table
        include_once __DIR__.'/../vendor/sfneal/users/database/migrations/create_user_table.php.stub';
        (new \CreateUserTable())->up();
    }
}
