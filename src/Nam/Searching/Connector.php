<?php


namespace Nam\Searching;


/**
 * Interface Connector
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Searching
 *
 */
interface Connector
{
    /**
     * Establish a connection to search engine.
     *
     * @param  array $config
     *
     * @return BaseSearchEngine
     */
    public function connect(array $config);
}