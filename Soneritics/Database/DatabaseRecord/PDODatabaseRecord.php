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
namespace Database\DatabaseRecord;

/**
 * DatabaseRecord for PDO connections.
 * Uses the PDOStatement object to fetch the rows from.
 *
 * @author Jordi Jolink <mail@jordijolink.nl>
 * @since  5-1-2015
 */
class PDODatabaseRecord extends DatabaseRecord
{
    private $pdoStatement;
    private $mapping = null;

    /**
     * Constructor. Takes the PDOStatement as a result of the query.
     * @param \PDOStatement $pdoStatement
     */
    public function __construct(\PDOStatement $pdoStatement)
    {
        $this->pdoStatement = $pdoStatement;
    }

    /**
     * Create the mapping to use for mapping the column names to a result array.
     */
    private function createMapping()
    {
        $columns = $this->pdoStatement->columnCount();
        if (count($columns) > 0) {
            $this->mapping = [];
            for ($i = 0; $i < $columns; $i++) {
                $meta = $this->pdoStatement->getColumnMeta($i);
                $this->mapping[$i] = [$meta['table'], $meta['name']];
            }
        }
    }

    /**
     * Get the array with mapping variables. The array holds the numeric keys and an array [Table, fieldname].
     * @return array
     */
    protected function getMapping()
    {
        if ($this->mapping === null) {
            $this->createMapping();
        }

        return $this->mapping;
    }

    /**
     * Return an array with all the data from the query.
     * @return array
     */
    public function all()
    {
        $this->reset();
        $result = [];

        while ($row = $this->get()) {
            $result[] = $row;
        }

        return $result;
    }

    /**
     * Get the total number of rows.
     * @return int
     */
    public function count()
    {
        return $this->pdoStatement->rowCount();
    }

    /**
     * Fetch the next (or first) row from the results.
     * @return mixed
     */
    public function get()
    {
        $row = $this->pdoStatement->fetch(\PDO::FETCH_NUM);
        return $row ? $this->map($row) : $row;
    }

    /**
     * Reset the resource pointer. When using the get() function, this will cause get to restart at the first position.
     * @return mixed
     * @return $this;
     */
    public function reset()
    {
        $this->pdoStatement->execute();
        return $this;
    }
}
