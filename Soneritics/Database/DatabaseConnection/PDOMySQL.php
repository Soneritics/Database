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

use Database\DatabaseConnection\DatabaseTypeTraits\MySQLTrait;
use Database\DatabaseRecord\DatabaseRecord;
use Database\DatabaseRecord\PDODatabaseRecord;
use Database\DatabaseRecord\EmptyDatabaseRecord;
use Database\Debug;

/**
 * DatabaseType object for MySQL using the PDO connector.
 *
 * @author Jordi Jolink <mail@jordijolink.nl>
 * @since  1-1-2015
 */
class PDOMySQL implements IDatabaseConnection
{
    use MySQLTrait;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * Set-up the database connection.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->pdo = new \PDO(
            $config['dsn'],
            isset($config['user']) ? $config['user'] : null,
            isset($config['password']) ? $config['password'] : null,
            isset($config['config']) ? $config['config'] : null
        );
    }

    /**
     * Quote a value for use in a query.
     * @param  $value
     * @return string
     */
    public function quote($value)
    {
        if (is_array($value)) {
            $result = [];
            foreach ($value as $single) {
                $result[] = $this->quote($single);
            }
            return sprintf(
                '(%s)',
                implode(', ', $result)
            );
        } else {
            return $this->pdo->quote($value);
        }
    }

    /**
     * Execute a query. The parameter can either be a Query(Abstract) object, or a string containing a full query.
     * @param $query
     * @return DatabaseRecord
     */
    public function query($query)
    {
        if (is_subclass_of($query, 'Database\Query\QueryAbstract')) {
            return $this->query($this->buildQuery($query));
        }

        $debug = (new Debug\ExecutedQuery($query))->setBacktrace(debug_backtrace());
        $startTime = microtime(true);
        try {
            $result = $this->pdo->query($query);
        } catch (\Throwable $throwable) {
            $debug->setException($throwable);
            throw $throwable;
        } finally {
            $debug->setExecutionTime(microtime(true) - $startTime);
            Debug::addQuery($debug);
        }

        return $this->getPDODatabaseRecord($result);
    }

    /**
     * Execute a query. The parameter can either be a Query(Abstract) object, or a string containing a full query.
     * @param $query
     * @return DatabaseRecord
     */
    public function execute($query)
    {
        if (is_subclass_of($query, 'Database\Query\QueryAbstract')) {
            return $this->execute($this->buildQuery($query));
        }

        $debug = (new Debug\ExecutedQuery($query, Debug\ExecutedQuery::QUERY_EXECUTE))->setBacktrace(debug_backtrace());
        $startTime = microtime(true);
        try {
            $result = $this->pdo->exec($query);
        } catch (\Throwable $throwable) {
            $debug->setException($throwable);
            throw $throwable;
        } finally {
            $debug->setExecutionTime(microtime(true) - $startTime);
            Debug::addQuery($debug);
        }

        return $this->getPDODatabaseRecord($result);
    }

    /**
     * Get the result as a DatabaseRecord object.
     * @param type $pdoStatement
     * @return PDODatabaseRecord
     */
    private function getPDODatabaseRecord($pdoStatement)
    {
        if (is_a($pdoStatement, '\PDOStatement')) {
            return new PDODatabaseRecord($pdoStatement);
        } else {
            return new EmptyDatabaseRecord;
        }
    }

    /**
     * Returns the last insert id.
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
