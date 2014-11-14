<?php


namespace Nam\Searching\SearchEngines;

use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Support\Collection;
use Nam\Searching\BaseSearchEngine;


/**
 * Class ElasticSearch
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Searching\SearchEngines
 *
 */
class Elasticsearch extends BaseSearchEngine
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $index
     * @param string $type
     * @param array  $query
     * @param int    $size
     * @param int    $from
     *
     * @return array|Collection
     */
    public function search($index, $type, array $query = [ ], $size = 10, $from = 0)
    {
        $searchParams = [
            'index' => $index,
            'type'  => $type,
        ];

        $searchParams['body']['query'] = $query ?: [ 'match_all' => [ ] ];
        $searchParams['body']['size'] = $size;
        $searchParams['body']['from'] = $from;

//        dd(json_encode($searchParams['body']));

        try {

            $response = $this->client->search($searchParams);

        } catch ( Missing404Exception $e ) {

            // the index doesn't exist: no results
            // TODO Do something
            return [ ];
        }

        return $response;
    }

    /**
     * @param string $index
     * @param string $type
     * @param string $id
     * @param array  $doc
     *
     * @return mixed
     */
    public function index($index, $type, $id = null, array $doc = [ ])
    {
        $params = [
            'index' => $index,
            'type'  => $type,
            'body'  => $doc,
        ];

        $id ? $params['id'] = $id : null;

        return $this->client->index($params);
    }

    /**
     * @param string $index
     * @param string $type
     * @param string $id
     * @param array  $doc
     *
     * @return mixed
     */
    public function update($index, $type, $id, array $doc = [ ])
    {
        $params = [
            'index' => $index,
            'type'  => $type,
            'id'    => $id,
            'body'  => [
                'doc' => $doc
            ],
        ];

        return $this->client->update($params);
    }


    /**
     * @param string $index
     * @param string $type
     * @param string $id
     *
     * @return mixed
     */
    public function delete($index, $type, $id)
    {
        $params = [
            'index' => $index,
            'type'  => $type,
            'id'    => $id,
        ];

        return $this->client->delete($params);
    }
}