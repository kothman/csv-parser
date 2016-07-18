<?php

namespace Kothman;

class CSVParserOptions
{
    
    public $delimiter = ',';
    public $length = 0;
    public $enclosure = '"';
    public $escape = '\\';
    
    public function __construct($delimiter = null,
                                $length = null,
                                $enclosure = null,
                                $escape = null)
    {
        $this->delimiter = $delimiter?$delimiter:$this->delimiter;
        $this->length = $length?$length:$this->length;
        $this->enclosure = $enclosure?$enclosure:$this->enclosure;
        $this->escape = $escape?$escape:$this->escape;
    }
    
}