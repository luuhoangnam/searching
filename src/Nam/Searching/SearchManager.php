<?php


namespace Nam\Searching;

use Closure;
use Illuminate\Foundation\Application;


/**
 * Class SearchManager
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Searching
 *
 */
class SearchManager
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var array
     */
    private $connections;
    private $connectors;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $name
     *
     * @return \Nam\Searching\SearchEngine
     */
    public function connection($name = null)
    {
        $name = $name ?: $this->getDefaultConnection();

        if ( ! isset( $this->connections[$name] )) {
            $this->connections[$name] = $this->resolve($name);
        }

        return $this->connections[$name];
    }

    /**
     * @param string  $driver
     * @param Closure $resolver
     */
    public function addConnector($driver, Closure $resolver)
    {
        $this->connectors[$driver] = $resolver;
    }

    /**
     * @return mixed
     */
    protected function getDefaultConnection()
    {
        return $this->app->make('config')->get('searching::default');
    }

    /**
     * @param $name
     *
     * @return BaseSearchEngine
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        return $this->getConnector($config['driver'])->connect($config);
    }

    /**
     * @param string $name
     *
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->app->make('config')->get("searching::connections.{$name}");
    }

    /**
     * @param $driver
     *
     * @return Connector
     */
    protected function getConnector($driver)
    {
        if (isset( $this->connectors[$driver] )) {
            return call_user_func($this->connectors[$driver]);
        }

        throw new \InvalidArgumentException("No connector for [$driver]");
    }

    /**
     * Dynamically pass calls to the default connection.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $callable = [ $this->connection(), $method ];

        return call_user_func_array($callable, $parameters);
    }
}