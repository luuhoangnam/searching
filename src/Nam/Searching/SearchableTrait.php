<?php


namespace Nam\Searching;

use App;
use Config;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * Trait SearchableTrait
 *
 * @method static Builder whereIn( $column, $values, $boolean = 'and', $not = false )
 * @method static void    observe( $class )
 * @method        array   toArray()
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Searching
 *
 */
trait SearchableTrait
{

    public static function bootSearchableTrait()
    {
        static::observe(App::make('Nam\Searching\SearchingObserver'));
    }

    /**
     * @param array $query
     * @param int   $size
     *
     * @return array
     */
    public function search(array $query = [ ], $size = null)
    {
        $index = static::getIndexName();
        $type = static::getType();

        $paginator = App::make('paginator');

        // Get current page
        $page = $paginator->getCurrentPage();

        // Get per page
        $size = $size ?: 10; // default: 10 items per page

        // Query
        $from = ( $page - 1 ) * $size;

        $results = App::make('searching')->search($index, $type, $query, $size, $from);
        $results = $this->hydrateSearchResults($results);

        // Make pagination
        return $paginator->make($results->all(), $size);
    }

    /**
     * @return array
     */
    public function getIndexDocument()
    {
        return static::toArray();
    }

    /**
     * @return mixed
     */
    protected static function getIndexName()
    {
        $connection = Config::get('database.default');
        $index = Config::get("database.connections.{$connection}.database");

        return $index;
    }

    /**
     * @return string
     */
    protected static function getType()
    {
        /** @var Model $instance */
        $instance = new static;
        $type = str_singular($instance->getTable());

        return $type;
    }

    /**
     * @param array $results
     *
     * @return Collection
     */
    protected function hydrateSearchResults(array $results)
    {
        if ( ! $results['hits']['hits']) {
            return new Collection;
        }

        $ids = [ ];
        foreach ($results['hits']['hits'] as $hit) {
            $ids[] = $hit['_id'];
        }

        return static::whereIn('id', $ids)->get();
    }

}