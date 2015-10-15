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
namespace Database\DatabaseConnection;

use Database\Query\QueryAbstract;

/**
 * DatabaseType interface.
 *
 * @author Jordi Jolink <mail@jordijolink.nl>
 * @since  1-1-2015
 */
interface IDatabaseConnection
{
    /**
     * Constructor, loads the configs for the database type.
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * Quote a value.
     * @param  type $value
     * @return string
     */
    public function quote($value);

    /**
     * Quote a database name.
     * @param  type $db
     * @return string
     */
    public function quoteDatabase($db);

    /**
     * Quote a table name.
     * @param  type $table
     * @return string
     */
    public function quoteTable($table);

    /**
     * Quote an identifier (column name).
     * @param  type $id
     * @return string
     */
    public function quoteIdentifier($id);

    /**
     * Execute a query.
     * @param  type $query
     * @return DatabaseRecord
     */
    public function query($query);

    /**
     * Execute a query.
     * @param  type $query
     * @return DatabaseRecord
     */
    public function execute($query);

    /**
     * Build a value from a QueryAbstract object.
     * @param  QueryAbstract $query
     * @return string
     */
    public function buildQuery(QueryAbstract $query);

    /**
     * Returns the last insert id.
     * @return mixed
     */
    public function lastInsertId();
}
