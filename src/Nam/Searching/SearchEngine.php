<?php


namespace Nam\Searching;


/**
 * Class ElasticSearch
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Searching\SearchEngines
 *
 */
interface SearchEngine
{
    /**
     * @param string $index
     * @param string $type
     * @param array  $query
     * @param int    $size
     * @param int    $from
     *
     * @return mixed
     */
    public function search($index, $type, array $query = [ ], $size = 10, $from = 0);

    /**
     * @param string $index
     * @param string $type
     * @param string $id
     * @param array  $doc
     *
     * @return mixed
     */
    public function index($index, $type, $id = null, array $doc = [ ]);

    /**
     * @param string $index
     * @param string $type
     * @param string $id
     * @param array  $doc
     *
     * @return mixed
     */
    public function update($index, $type, $id, array $doc = [ ]);

    /**
     * @param string $index
     * @param string $type
     * @param string $id
     *
     * @return mixed
     */
    public function delete($index, $type, $id);

}