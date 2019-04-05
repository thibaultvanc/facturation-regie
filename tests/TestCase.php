<?php

namespace FacturationRegie\Tests;

use FacturationRegie\Tests\Stubs\Models\User;
use FacturationRegie\FacturationRegieServiceProvider;

//use Lab404\Tests\Stubs\Models\User;
//\PHPUnit\Framework\TestCase
class TestCase extends \Orchestra\Testbench\TestCase
{
    protected $config;



    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath(__DIR__.'/../migrations'),
        ]);
        
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath(__DIR__.'/stubs/database/migrations'),
        ]);
        
        if (empty($this->config)) {
            $this->config = require __DIR__.'/../config/config.php';
        }
        
        $this->app['config']->set('facturation-regie', $this->config);
        $this->app['config']->set('facturation-regie.user_model', User::class);
        
        //$this->loadLaravelMigrations();
        
        $this->artisan('migrate', ['--database' => 'testing'])->run();
        
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../../migrations'),
            ]);
            

        $this->withFactories(__DIR__.'/stubs/database/factories');

        //$this->loadRoutesFrom(__DIR__.'/../../routes.php');
    }
        
        
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }


    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            FacturationRegieServiceProvider::class,
        ];
    }


    /** @test */
    public function no_warning_with_this()
    {
        $this->assertTrue(true);
    }
}
