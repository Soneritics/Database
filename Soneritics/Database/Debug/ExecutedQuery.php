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
namespace Database\Debug;

/**
 * Class ExecutedQuery
 * @package Database
 */
class ExecutedQuery
{
    const QUERY_QUERY = 'Query';
    const QUERY_EXECUTE = 'Execute';

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $type = self::QUERY_QUERY;

    /**
     * @var float
     */
    private $executionTime = 0.00;

    /**
     * @var array
     */
    private $backtrace = [];

    /**
     * @var \Exception
     */
    private $exception;

    /**
     * ExecutedQuery constructor.
     * @param string $query
     * @param string $type
     * @param float $executionTime
     * @param array $backtrace
     * @param \Exception $exception
     */
    public function __construct($query, $type = self::QUERY_QUERY, $executionTime = null, array $backtrace = [], \Exception $exception = null)
    {
        $this->setQuery($query);
        $this->setType($type);

        if (!empty($executionTime)) {
            $this->setExecutionTime($executionTime);
        }

        if (!empty($backtrace)) {
            $this->setBacktrace($backtrace);
        }

        if (!empty($exception)) {
            $this->setException($exception);
        }
    }


    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     * @return ExecutedQuery
     */
    public function setQuery(string $query): ExecutedQuery
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return ExecutedQuery
     */
    public function setType(string $type): ExecutedQuery
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return float
     */
    public function getExecutionTime(): float
    {
        return $this->executionTime;
    }

    /**
     * @param float $executionTime
     * @return ExecutedQuery
     */
    public function setExecutionTime(float $executionTime): ExecutedQuery
    {
        $this->executionTime = $executionTime;
        return $this;
    }

    /**
     * @return array
     */
    public function getBacktrace(): array
    {
        return $this->backtrace;
    }

    /**
     * @param array $backtrace
     * @return ExecutedQuery
     */
    public function setBacktrace(array $backtrace): ExecutedQuery
    {
        $this->backtrace = $backtrace;
        return $this;
    }

    /**
     * @return \Exception
     */
    public function getException(): \Exception
    {
        return $this->exception;
    }

    /**
     * @param \Exception $exception
     * @return ExecutedQuery
     */
    public function setException(\Exception $exception): ExecutedQuery
    {
        $this->exception = $exception;
        return $this;
    }
}