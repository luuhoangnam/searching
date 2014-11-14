<?php


namespace Nam\Searching\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * Class SearchEngine
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Searching\Facades
 * @see \Mbibi\Contracts\Searching\SearchEngine
 *
 */
class SearchEngine extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'searching'; }

}