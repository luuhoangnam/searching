<?php


namespace Nam\Searching\Connectors;

use Elasticsearch\Client;
use Nam\Searching\Connector;
use Nam\Searching\SearchEngine;
use Nam\Searching\SearchEngines\Elasticsearch;


/**
 * Class ElasticSearchConnector
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Searching\Connectors
 *
 */
class ElasticsearchConnector implements Connector
{

    /**
     * Establish a connection to search engine.
     *
     * @param  array $config
     *
     * @return SearchEngine
     */
    public function connect(array $config)
    {
        array_forget($config, 'driver');
        $client = new Client($config);

        return new Elasticsearch($client);
    }
}