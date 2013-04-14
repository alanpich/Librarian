<?php

class DummyDataObject {

    public $xml;

    public $title;
    public $content;

    public function __construct( $id ){
        $id = (int) $id;

        // Load xml file
        $this->xml = simplexml_load_file( dirname(__FILE__)."/res-{$id}.xml");
    }

}
