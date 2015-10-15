<?php
/* 
 * The MIT License
 *
 * Copyright 2014 Soneritics Webdevelopment.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Database\Query;

/**
 * Where object for creating where conditions for the queries.
 *
 * @author Jordi Jolink <mail@jordijolink.nl>
 * @since  1-1-2015
 */
class Where
{
    public $operator = 'AND';
    private $whereClause = [];

    /**
     * Constructor. Sets the operator.
     * Can be 'AND' or 'OR'.
     *
     * @param string $operator
     */
    public function __construct($operator = 'AND')
    {
        if (trim(strtolower($operator)) === 'or') {
            $this->operator = 'OR';
        } else {
            $this->operator = 'AND';
        }
    }

    /**
     * Add a(n extra) part to the where statement.
     *
     * @param  $where
     * @return $this
     */
    public function where($where)
    {
        $this->whereClause[] = ['=', $where];
        return $this;
    }

    /**
     * Add an IN part to the where clause.
     *
     * @param  $column
     * @param  array  $values
     * @return $this
     */
    public function in($column, array $values)
    {
        $this->whereClause[] = ['IN', $column, $values];
        return $this;
    }

    /**
     * Add a NOT IN part to the where clause.
     *
     * @param  $column
     * @param  array  $values
     * @return $this
     */
    public function notIn($column, array $values)
    {
        $this->whereClause[] = ['NOT IN', $column, $values];
        return $this;
    }

    /**
     * Add a NOT NULL part to the where clause.
     *
     * @param  $column
     * @return $this
     */
    public function notNull($column)
    {
        $this->whereClause[] = ['NOT NULL', $column];
        return $this;
    }

    /**
     * Add a LIKE part to the WHERE clause.
     *
     * @param  $column
     * @param  $value
     * @return $this
     */
    public function like($column, $value)
    {
        $this->whereClause[] = ['LIKE', $column, $value];
        return $this;
    }

    /**
     * Return the full where clause for the DatabaseType object to parse.
     *
     * @return array
     */
    public function getWhereClause()
    {
        return $this->whereClause;
    }

    /**
     * Get the operator.
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }
}
