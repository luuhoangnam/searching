<?php


namespace Nam\Searching\Query\Query;

use Closure;


/**
 * Class Match
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Mbibi\Searching\Query\Query
 *
 */
class Match
{
    // Operators
    const OPERATOR_OR = 'or';
    const OPERATOR_AND = 'and';
    // Zero Terms Query
    const ZERO_TERMS_NONE = 'none';
    const ZERO_TERMS_ALL = 'all';

    /**
     * @var string
     */
    protected $field;

    /**
     * @var array
     */
    protected $bindings = [ ];

    /**
     * @param string               $field
     * @param string|array|Closure $text
     */
    public function __construct($field, $text = null)
    {
        $this->field = $field;

        // String
        if (is_string($text)) {
            $this->bindings[$field] = $text;

            return $this;
        }

        // Array
        if (is_array($text)) {
            if (isset( $text['query'] )) {
                $this->bindings[$field]['query'] = $text['query'];
            }

            if (isset( $text['operator'] )) {
                $this->bindings[$field]['operator'] = $text['operator'];
            }

            return $this;
        }

        // Closure
        if ($text instanceof Closure) {
            call_user_func($text, $this);

            return $this;
        }

        return $this;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function query($text)
    {
        $this->bindings[$this->field]['query'] = $text;

        return $this;
    }

    /**
     * @param string $op
     *
     * @return $this
     */
    public function operator($op)
    {
        switch ($op) {
            case self::OPERATOR_OR:
                $this->bindings[$this->field]['operator'] = self::OPERATOR_OR;

                return $this;
            case self::OPERATOR_AND:
                $this->bindings[$this->field]['operator'] = self::OPERATOR_AND;

                return $this;
        }

        throw new \InvalidArgumentException("Invalid operator [{$op}] for field [{$this->field}]");
    }

    /**
     * @param string $option
     *
     * @return $this
     */
    public function zeroTermsQuery($option)
    {
        switch ($option) {
            case self::ZERO_TERMS_NONE:
                $this->bindings[$this->field]['zero_terms_query'] = self::ZERO_TERMS_NONE;

                return $this;
            case self::ZERO_TERMS_ALL:
                $this->bindings[$this->field]['zero_terms_query'] = self::ZERO_TERMS_ALL;

                return $this;
        }

        throw new \InvalidArgumentException("Invalid zero terms query option [{$option}] for field [{$this->field}]");
    }

    /**
     * @param float $freq
     *
     * @return $this
     */
    public function cutoffFrequency($freq)
    {
        $this->bindings[$this->field]['cutoff_frequency'] = $freq;

        return $this;
    }

}