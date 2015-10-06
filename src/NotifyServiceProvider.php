<?php namespace Ravenuzz\Notify;

use Ravenuzz\Notify\Console\Commands\LarachetCommand;
use Illuminate\Support\ServiceProvider;
use Ravenuzz\Notify\Library\Pusher;
use Ravenuzz\Notify\Library\PushServer;
use Illuminate\Filesystem\Filesystem;
use Ravenuzz\Notify\Library\JsRenderer;
use Ravenuzz\Notify\Library\Larachet;

use ZMQContext;

class NotifyServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $larachet = function($app) {
            return new Larachet(new ZMQContext);
        };

        $this->app->bind('Admsa\Larachet\Library\Larachet', $larachet);
        $this->app->bind('larachet', $larachet);

        $this->app->bind('Larachet\PushServer', function($app) {
            return new PushServer(new Pusher);
        });

        $this->app->bind('Admsa\Larachet\Library\JsRenderer', function($app) {
            return new JsRenderer($app['files']);
        });

        $this->app['command.larachet.serve'] = $this->app->share(function($app) {
            return new LarachetCommand;
        });

        $this->commands(['command.larachet.serve']);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['larachet', 'command.larachet.serve'];
    }
}
