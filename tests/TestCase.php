<?php

namespace FacturationRegie\Tests;

//use Lab404\Tests\Stubs\Models\User;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $config;

    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite.database', ':memory:');
        return $app;
    }

    /**
     * @param   void
     * @return  void
     */
    public function setUp()
    {
        parent::setUp();


        if (empty($this->config)) {
            $this->config = require __DIR__.'/../config/facturation-regie.php';
        }


        $this->app['config']->set('follow', $this->config);
        //$this->app['config']->set('follow.user_model', User::class);

        // Setup the right User class (using stub)
        //$this->app()->config()->set('auth.providers.users.model', User::class);

        //$this->artisan('migrate', ['--database' => 'testbench']);

        //$this->loadMigrationsFrom([
        //    '--realpath' => realpath(__DIR__.'/../migrations'),
        //]);
    }
}
