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

use \Porter;

class Tokenizer
{


    public function __construct()
    {

    }


    /**
     * Tokenize a string and return an array of Words
     *
     * @param string $string String to be tokenized
     * @return array of Word objects
     */
    public function tokenizeString($string)
    {
        $wordsObjects = array();

        // Remove any extraneous characters (html tags, linebreaks, punctuation etc.)
        $string = $this->sanitize($string);

        // Loop through remaining words
        $words = preg_split("/\W+/", $string, 0, PREG_SPLIT_NO_EMPTY);

        for ($k = 0, $l = count($words); $k < $l; $k++) {

            // Trim up the word
            $word = strtolower(trim($words[$k]));

            // Ignore any words less than 3 characters
            if (strlen($word) < 3) {
                continue;
            }

            // Ignore any words in the ignore list
            if ($this->isIgnoredWord($word)) {
                continue;
            }

            // Use linguistic analysis to find the root form of the word
            $root = $this->getRootForm($word);

            // Add the word to the array
            $wordObjects[] = new Word($root, $word);

        }

        // Return an array of Word objects representing the found words
        return $wordObjects;
    }


    /**
     * Removes any extraneous characters (html tags, linebreaks, punctuation etc.) from string
     *
     * @param $string
     * @return mixed
     */
    public function sanitize($string)
    {
        $string = strip_tags($string);
        $string = preg_replace("/[^a-zA-Z0-9\s]/", "", $string);
        $string = preg_replace("/[\t\r\n]/", "", $string);
        return $string;
    }


    /**
     * Return the root part of a word
     *
     * @param $word
     * @return string
     */
    public function getRootForm($word)
    {
        // Use a Porter Stemmer
        return Porter::Stem($word);
    }


    /**
     * Array of words to ignore from indexing
     *
     * @param $word
     * @return bool
     */
    public function isIgnoredWord($word)
    {
        return in_array(
            $word,
            array(
                'the',
                'she',
                'and',
                'some',
                'its',
                'their',
                'they',
                'those',
                'then',
                'that',
                'this',
                'there',
                'would',
                'the'
            )
        );
    }

}
