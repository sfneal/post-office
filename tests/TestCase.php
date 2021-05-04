<?php

namespace Sfneal\PostOffice\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
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
        $app['config']->set('post-office.footer.enabled', true);
        $app['config']->set('post-office.footer.address', '35 Main Street, Milford MA 01747');
        $app['config']->set('post-office.footer.unsubscribe_route', 'unsubscribe');

        // Create mock 'unsubscribe' route
        Route::get('unsubscribe', function (string $email) {
            return response($email);
        })->name('unsubscribe');

        // Migrate 'user' table
        include_once __DIR__.'/../vendor/sfneal/users/database/migrations/create_user_table.php.stub';
        (new \CreateUserTable())->up();
    }
}
