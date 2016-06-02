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
namespace Database;

use Database\DatabaseConnection\IDatabaseConnection;
use Database\Exceptions\MissingDatabaseConnectionException;

/**
 * Database connection factory for connecting to the database.
 *
 * @author Jordi Jolink <mail@jordijolink.nl>
 * @since  1-1-2015
 */
class DatabaseConnectionFactory
{
    /**
     * @var array
     */
    private static $databaseConnections = [];

    /**
     * @var null|string
     */
    private static $activeDatabaseConnection = null;

    /**
     * Set a database connection.
     * @param string $id
     * @param array  $config
     */
    public static function create($id, array $config)
    {
        static::$databaseConnections[$id] = static::createDatabaseConnection($config);

        if (static::$activeDatabaseConnection === null) {
            static::select($id);
        }
    }

    /**
     * Get a database connection.
     * @param  null $id
     * @return IDatabaseConnection
     * @throws MissingDatabaseConnectionException
     */
    public static function get($id = null)
    {
        if ($id === null && static::$activeDatabaseConnection === null) {
            throw new MissingDatabaseConnectionException('No databases defined.');
        }

        if ($id === null) {
            return static::$databaseConnections[static::$activeDatabaseConnection];
        } else {
            return static::$databaseConnections[$id];
        }
    }

    /**
     * Select a database as default database.
     * @param string $id
     */
    public static function select($id)
    {
        static::$activeDatabaseConnection = $id;
    }

    public static function getActiveDatabaseId()
    {
        return static::$activeDatabaseConnection;
    }

    /**
     * Create a database connection.
     * @param  array $config
     * @return IDatabaseConnection
     */
    private static function createDatabaseConnection(array $config)
    {
        $databaseConnectionClass = 'Database\DatabaseConnection\\' . $config['type'];
        return new $databaseConnectionClass($config);
    }
}
