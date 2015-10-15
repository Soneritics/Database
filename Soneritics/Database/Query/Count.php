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

use Database\Exceptions\FatalException;
use Database\DatabaseConnectionFactory;

/**
 * Select query class.
 *
 * @author Jordi Jolink <mail@jordijolink.nl>
 * @since  2-1-2015
 */
class Count extends Select
{
    // Default select all fields
    protected $fields = 'COUNT(*)';

    /**
     * Set the field to count.
     * @param $fields
     * @return $this
     * @throws FatalException
     */
    public function fields($fields)
    {
        if (!is_string($fields)) {
            throw new FatalException('Only strings are allowed in COUNT query');
        }

        $this->fields = sprintf(
            'COUNT(%s)',
            DatabaseConnectionFactory::get()->quote($fields)
        );

        return $this;
    }

    /**
     * Override the default execute function.
     * @return int
     */
    public function execute()
    {
        $result = parent::execute();
        if ($result->count() === 0) {
            return 0;
        } else {
            return $result->get()['COUNT(*)'];
        }
    }
}
