<?php

namespace Statamic\Addons\Sitemap;

use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Statamic\Extend\ServiceProvider;

class SitemapServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    public $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Here we get all the current routes, then add our sitemap route right before the catch-all segment route
        $old_routes = app('router')->getRoutes();
        $new_routes = new RouteCollection();

        foreach ($old_routes as $i => $route) {
            if ($route->getUri() == '{segments?}') {
                $sitemap_route = new Route(['GET'], 'sitemap.xml', ['uses' => '\Statamic\Addons\Sitemap\SitemapController@index']);

                $new_routes->add($sitemap_route);
            }

            $new_routes->add($route);
        }

        app('router')->setRoutes($new_routes);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
