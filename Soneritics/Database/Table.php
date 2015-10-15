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

use Database\Query\Delete;
use Database\Query\Insert;
use Database\Query\Select;
use Database\Query\Truncate;
use Database\Query\Update;
use Database\Query\Count;

/**
 * Table class. Corresponds to a database table and holds functions to insert, update, delete and select.
 *
 * @author Jordi Jolink <mail@jordijolink.nl>
 * @since  1-1-2015
 */
class Table
{
    /**
     * @var string
     */
    private $name = null;

    /**
     * @var string
     */
    private $table = null;

    /**
     * @var array
     */
    private $columns = null;

    /**
     * Constructor. Takes the class name and sets the name and table properties.
     */
    public function __construct()
    {
        $parts = explode('\\', get_class($this));
        $name = $parts[count($parts) - 1];
        if ($name != 'Table') {
            $this->setName($name);
        }
    }

    /**
     * Set the database table from the $name property.
     */
    public function setTableFromName()
    {
        $fullName = $this->name;

        $uppercase = 0;
        for ($i = 0; $i < strlen($fullName); $i++) {
            $char = $fullName[$i];
            if ($char === strtoupper($char)) {
                $uppercase++;
                if ($uppercase > 2) {
                    $fullName[$i - 1] = strtolower($fullName[$i - 1]);
                }
            } else {
                $uppercase = 0;
            }
        }

        $tbl = strtolower(preg_replace('~(?!\A)(?=[A-Z]+)~', '_', $fullName));
        if (substr($tbl, -1) === 'y') {
            $tbl = substr($tbl, 0, -1) . 'ies';
        } elseif (substr($tbl, -1) === 's') {
            $tbl = substr($tbl, 0, -1) . 'ses';
        } else {
            $tbl .= 's';
        }

        $this->table = $tbl;
        return $this;
    }

    /**
     * Set the table name from the $table property.
     */
    public function setNameFromTable()
    {
        $fullName = '';
        $upperCase = true;
        for ($i = 0; $i < strlen($this->table); $i++) {
            $character = $this->table[$i];

            if ($character === '_') {
                $upperCase = true;
            } else {
                $fullName .= $upperCase ? strtoupper($character) : $character;
                $upperCase = false;
            }
        }

        if (substr($fullName, -3) === 'ies') {
            $fullName = substr($fullName, 0, -3) . 'y';
        } elseif (substr($fullName, -3) === 'ses') {
            $fullName = substr($fullName, 0, -3) . 's';
        } elseif (substr($fullName, -1) === 's') {
            $fullName = substr($fullName, 0, -1);
        }

        $this->name = $fullName;
        return $this;
    }

    /**
     * Setter for the name.
     * @param  $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->setTableFromName();
        return $this;
    }

    /**
     * Returns the name of the object. When no name has been set, returns the name of the table.
     * @return null|string
     */
    public function getName()
    {
        if ($this->name === null) {
            return $this->getTable();
        }

        return $this->name;
    }

    /**
     * Set the table.
     * @param  $table
     * @return $this
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Getter for the table.
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Reload the table schema.
     * @return $this
     */
    public function reloadTableSchema()
    {
        $this->columns = [];
        return $this;
    }

    /**
     * Fetch the column names of the current table.
     * @return array
     */
    public function getColumns()
    {
        if ($this->columns === null) {
            $this->reloadTableSchema();
        }

        return $this->columns;
    }

    /**
     * Truncate the current table's data.
     * @return $this
     */
    public function truncate()
    {
        new Truncate($this);
        return $this;
    }

    /**
     * Get a select object for the current table.
     * @param  null $fields
     * @return Select
     */
    public function select($fields = null)
    {
        $select = new Select($this);

        if ($fields !== null) {
            $select->fields($fields);
        }

        return $select;
    }

    /**
     * Get an insert object for the current table.
     * @return Insert
     */
    public function insert()
    {
        return new Insert($this);
    }

    /**
     * Get an update object for the current table.
     * @return Update
     */
    public function update()
    {
        return new Update($this);
    }

    /**
     * Get a delete object for the current table.
     * @return Delete
     */
    public function delete()
    {
        return new Delete($this);
    }

    /**
     * Execute a simple count query.
     * @return Count
     */
    public function count()
    {
        return new Count($this);
    }
}
