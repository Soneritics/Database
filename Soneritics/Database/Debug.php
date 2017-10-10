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

use Database\Debug\ExecutedQuery;

/**
 * Class Debug
 * @package Database
 */
class Debug
{
    /**
     * @var array
     */
    private static $subscribers = [];

    /**
     * @param ExecutedQuery $query
     */
    public static function addQuery(ExecutedQuery $query): void
    {
        static::invokeSubscribers($query);
    }

    /**
     * @param callable $c
     */
    public static function addSubscriber(Callable $c)
    {
        static::$subscribers[] = $c;
    }

    /**
     * @return array
     */
    public static function getQueries()
    {
        return static::$queries;
    }

    /**
     * @param ExecutedQuery $query
     */
    private static function invokeSubscribers(ExecutedQuery $query)
    {
        if (!empty(static::$subscribers)) {
            foreach (static::$subscribers as $callable) {
                $callable($query);
            }
        }
    }
}