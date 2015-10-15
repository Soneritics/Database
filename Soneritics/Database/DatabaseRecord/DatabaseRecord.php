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
 * Abstract class for a database record. When fetching from the database,
 * records get returned as a DatabaseRecord object.
 *
 * @author Jordi Jolink <mail@jordijolink.nl>
 * @since  5-1-2015
 */
abstract class DatabaseRecord
{
    /**
     * Get the array with mapping variables.
     * The array holds the numeric keys and an array [Table, fieldname].
     *
     * @return array
     */
    abstract protected function getMapping();

    /**
     * Return an array with all the data from the query.
     *
     * @return array
     */
    abstract public function all();

    /**
     * Get the total number of rows.
     *
     * @return int
     */
    abstract public function count();

    /**
     * Fetch the next (or first) row from the results.
     *
     * @return mixed
     */
    abstract public function get();

    /**
     * Reset the resource pointer. When using the get() function, this
     * will cause get to restart at the first position.
     *
     * @return mixed
     * @return $this;
     */
    abstract public function reset();

    /**
     * Map the record, based on the table and field name.
     * Records are mapped like: $record[Table][field], as:
     *     [
     *         Table => [
     *             id => 1
     *             field1 => 'value'
     *             field2 => 'other value'
     *         ]
     *     ]
     *
     * @param  array $record
     * @return array
     */
    protected function map(array $record)
    {
        $mapping = $this->getMapping();

        if (count($mapping) > 0) {
            $result = [];

            foreach ($mapping as $columnId => $data) {
                if (!empty($data[0])) {
                    if (!isset($result[$data[0]])) {
                        $result[$data[0]] = [];
                    }
                    $result[$data[0]][$data[1]] = $record[$columnId];
                } else {
                    $result[$data[1]] = $record[$columnId];
                }
            }

            return $result;
        } else {
            return $record;
        }
    }
}
