<?php

namespace Nam\Searching;

use Illuminate\Support\ServiceProvider;
use Nam\Searching\Connectors\ElasticsearchConnector;

/**
 * Class SearchingServiceProvider
 * @package Nam\Searching
 */
class SearchingServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     *
     */
    public function boot()
    {
        $this->package('nam/searching');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('searching', function ($app) {
            $manager = new SearchManager($app);

            foreach ([ 'Elasticsearch' ] as $connector) {
                $this->{"register{$connector}Connector"}($manager);
            }

            return $manager;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ ];
    }

    /**
     * @param SearchManager $manager
     *
     * @return ElasticsearchConnector
     */
    protected function registerElasticsearchConnector(SearchManager $manager)
    {
        $manager->addConnector('elasticsearch', function () {
            return new ElasticsearchConnector;
        });
    }

}
