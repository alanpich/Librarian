<?php
/**
 * @package   AlanPich\Librarian
 * @author    Alan Pich <alan.pich@gmail.com>
 * @version   1.0
 * @copyright 2013 Alan Pich
 * @license
 *            Permission is hereby granted, free of charge, to any person
 *            obtaining a copy of this software and associated documentation
 *            files (the "Software"), to deal in the Software without
 *            restriction, including without limitation the rights to use,
 *            copy, modify, merge, publish, distribute, sublicense, and/or
 *            sell copies of the Software, and to permit persons to whom the
 *            Software is furnished to do so, subject to the following conditions:
 *
 *                The above copyright notice and this permission notice shall be
 *                included in all copies or substantial portions of the Software.
 *
 *           THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 *           EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 *           OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 *           IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 *           DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 *           OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR
 *           THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace AlanPich\Librarian;


class ObjectContentMap
{

    /**
     * Array mapping available property names to their weightings
     * format should be [Property Name] => [Weighting per occurrence]
     *
     * @var array
     */
    public $availableProperties = array();


    /**
     * Returns an array of the names of all available properties
     *
     * @return array
     */
    public function getAvailableProperties()
    {
        return array_keys($this->availableProperties);
    }


    /**
     * Returns a property of the subject as a string
     * The $property name must appear in the array
     * returned by self::getAvailableProperties
     *
     * @param string $property Name of property to retrieve
     * @param object $obj      Subject to query
     * @return string
     * @throws \Exception
     */
    public function get($property, $obj)
    {
        if (!in_array($property, array_keys($this->availableProperties))) {
            throw new \Exception("Invalid property requested");
        }

        /** @var string $methodName  */
        $methodName = 'get' . ucfirst($property);
        if (!method_exists($this, $methodName)) {
            throw new \Exception("Property [{$property}] exists, but does not have a defined mapping method");
        }

        return $this->{$methodName}($obj);
    }


}
