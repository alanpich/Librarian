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


class Token
{

    public $root;
    public $score = 0;
    public $occurrences = 0;

    /**
     * @param string $root     Root of the word
     */
    public function __construct($root)
    {
        $this->root = $root;
    }

    /**
     * Add another occurrence for this token
     *
     * @param int $weight Weighting of
     */
    public function increment($weight)
    {
        ++$this->occurrences;
        $this->score += $weight;
    }

    /**
     * Get the weighted score for this token
     *
     * @return int
     */
    public function getWeightedScore()
    {
        return $this->score;
    }

}