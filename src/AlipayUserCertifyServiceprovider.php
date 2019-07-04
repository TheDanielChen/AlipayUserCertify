<?php 
namespace Cstopery\AlipayUserCertify;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
class AlipayUserCertifyServiceprovider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    public function boot()
    {
        // this for conig
        $this->publishes([
            __DIR__.'/config/AlipayUserCertify.php' => config_path('AlipayUserCertify.php'),
        ]);
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     * @return void
     */


    public function register()
    {
        $this->app->bind('AlipayUserCertify',function($app){
            return new AlipayUserCertify();
        });
    }
}
