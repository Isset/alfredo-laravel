<?php

namespace IssetBv\AlfredoLaravel;

use Illuminate\Support\ServiceProvider;
use Alfredo\Server;

class AlfredoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('issetbv/alfredo-laravel');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['alfredo'] = $this->app->share(function($app)
        {
            $server = new Server(
                $app['config']->get('alfredo-laravel::api_url'),
                $app['config']->get('alfredo-laravel::consumer_key'),
                $app['config']->get('alfredo-laravel::private_key')
            );
            return new Alfredo($server);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('alfredo');
	}
}