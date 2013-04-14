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
 * Class Indexer
 *
 * Handles indexing of strings as properties of a
 * PHP Object. The properties of an object which are
 * interrogated are defined as a set of rules in the
 * Indexer class (or derivative class thereof)
 */
class Indexer
{

    /**
     * @var ObjectContentMap
     *
     * Defines which (string) properties of an object should be
     * tokenized and indexed.
     * An optional weighting can be applied per property so that
     * (for example) words in a title field will return higher than
     * the same words in a content or other field
     */
    public $map;


    /**
     * @var Tokenizer
     *
     * Breaks a string apart into unique, indexable tokens and returns
     * an array of found terms with extra data such as total occurrences
     * and positions within the text
     */
    public $tokenizer;


    /**
     * @var Persistor\AbstractPersistor
     *
     * Handles persistance of indexes. Probably some sort of database
     */
    public $persistor;


    /**
     * Construct a new instance of Indexer
     *
     * @param ObjectContentMap            $map       - Extracts object properties for tokenisation, and optionally sets weighting per property
     * @param Tokenizer                   $tokenizer
     * @param Persistor\AbstractPersistor $persistor
     */
    public function __construct(
        ObjectContentMap $map,
        Tokenizer $tokenizer,
        Persistor\AbstractPersistor $persistor
    ) {
        $this->map = $map;
        $this->tokenizer = $tokenizer;
        $this->persitor = $persistor;
    }


    /**
     * Index an object and persist the results
     *
     * @param string                $uid            Unique ID for this resource
     * @param object                $subject        The object to be indexed
     * @param ObjectContentMap|bool $mapper         [optional] Override the default mapper
     * @return TokenizedResource
     */
    public function indexResource($uid, $subject, $mapper = false)
    {
        // Allow overriding of the default mapper
        if (!$mapper instanceof ObjectContentMap) {
            $mapper = $this->map;
        }

        return new TokenizedResource($uid, $subject, $this->tokenizer, $mapper);
    }


}
