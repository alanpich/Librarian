<?php
use AlanPich\Librarian\ObjectContentMap;


class DummyContentMap extends ObjectContentMap {


    public $availableProperties = array(
        'title' => 5,
        'content' => 1
    );


    public function getTitle($obj){
        return (string) $obj->xml->title[0];
    }


    public function getContent($obj){
        return (string) $obj->xml->content[0];
    }

}
