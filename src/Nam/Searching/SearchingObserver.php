<?php


namespace Nam\Searching;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;


/**
 * Class SearchingObserver
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Searching
 *
 */
class SearchingObserver
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Listener for the 'created' event on a model.
     *
     * @param Model|SearchableTrait $model The model that fires the events
     */
    public function created(Model $model)
    {
        // TODO Check mapping and execute create mapping first

        $this->callMethodOnModel('index', $model);
    }

    /**
     * Listener for the 'updated' event on a model.
     *
     * @param Model $model The model that fires the events
     */
    public function updated(Model $model)
    {
        $this->callMethodOnModel('update', $model);
    }

    /**
     * Listener for the 'deleted' event on a model.
     *
     * @param Model $model The model that fires the events
     */
    public function deleted(Model $model)
    {
        $this->callMethodOnModel('delete', $model);
    }

    /**
     * @param string                $method
     * @param Model|SearchableTrait $model
     */
    private function callMethodOnModel($method, Model $model)
    {
        $searchEngine = $this->app->make('searching');

        $index = $model::getIndexName();
        $type = $model::getType();
        $id = $model->getKey();
        $doc = $model->toArray(); // TODO Do Something with mapping

        $searchEngine->{$method}($index, $type, $id, $doc);
    }

}