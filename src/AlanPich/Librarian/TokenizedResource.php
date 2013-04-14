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


/**
 * Class TokenizedResource
 *
 * Represents a resource the has been tokenized
 *
 * @package AlanPich\Librarian
 */
class TokenizedResource
{

    /**
     * Unique Identifier for this resource
     * @var string
     */
    public $uid;

    /**
     * Tokens indexed from this array
     * @var array
     */
    public $tokens = array();


    /**
     * @param string           $uid       Unique ID for resource
     * @param Object           $subject   Object to be indexed
     * @param Tokenizer        $tokenizer
     * @param ObjectContentMap $mapper    Resource content mapper
     */
    public function __construct($uid, $subject, $tokenizer, $mapper)
    {
        $this->uid = $uid;
        $this->mapper = $mapper;

        // Loop through mapped properties
        foreach ($mapper->getAvailableProperties() as $prop) {

            // Tokenize the property content
            $content = $mapper->get($prop, $subject);
            $words = $tokenizer->tokenizeString($content);

            // Weight words and add them to the tokens array
            $weight = $mapper->availableProperties[$prop];
            $this->addWeightedWords($words, $weight);

        }


        // Arrange tokens alphabetically for niceness
        ksort($this->tokens);

    }


    /**
     * Add words to the token array
     * Weightings are added per occurrence to the token score
     *
     * @param array $words   Array of Word objects to add
     * @param int   $weight  Weight to assign to word occurrences
     */
    protected function addWeightedWords(array $words, $weight)
    {
        foreach ($words as $word) {
            /** @var Word $word */
            $root = $word->root;

            // If a token for this word doesnt exist, create one
            if (!isset($this->tokens[$root])) {
                $this->tokens[$root] = new Token($root);
            }

            $this->tokens[$root]->increment($weight);
        }

    }

}
