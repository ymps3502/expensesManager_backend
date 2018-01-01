<?php

namespace Tests;

use Artisan;
use Mockery\MockInterface;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Initial database and make migration
     */
    protected function initDatabase()
    {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => ''
            ]
        ]);

        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    protected function resetDatabase()
    {
        Artisan::call('migrate:reset');
    }

    /**
     * Initial mock object
     * 
     * @param string $className
     * @return MockInterface
     */
    protected function initMock(string $className) : MockInterface
    {
        $mock = Mockery::mock($className);
        App::instance($className, $mock);

        return $mock;
    }
}
