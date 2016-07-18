<?php

namespace Kothman\CSV;

class CSVParser
{

    private $resource = null;
    private $length = 0;
    private $delimiter = ',';
    private $enclosure = '"';
    private $escape = '\\';

    /**
     * Create a new CSVParser instance
     */
     public function __construct($path = null)
     {
         if($path) {
	     $this->load($path);
	 }
     }

    /**
     * Load a resource to be used by the parser
     *
     * @param string $path A URL or file.
     * @return bool
     */ 
     public function load($path)
     {
	$this->resource = fopen($path, 'r');
	return $this->resource?true:false;
     }


     private function check() {
         if(!$this->resource) {
	     throw new Exception('The CSVParser does not have a loaded resource.');
	 }
     }

    /**
     * Set various options that get passed to fgetcsv in CSVParser::row
     *
     * @param array $options length, delimiter, enclosure, escape.
     * @return void
     */
     public function set($options) {
	 $this->length = $options['length'] || $this->length;
	 $this->delimiter = $options['delimiter'] || $this->delimiter;
	 $this->enclosure = $options['enclosure'] || $this->enclosure;
	 $this->escape = $options['escape'] || $this->escape;
     }

    /**
     * Return the next row of the CSV file
     *
     * @return array | false
     */
     public function row() {
         $this->check();
	 $data = fgetcsv($this->resource,
			 $this->length,
			 $this->delimiter,
			 $this->enclosure,
			 $this->escape);
	 return $data;
     }

     public function rewind() {
         $this->check();
         fseek($this->resource, 0);
     }


     public function countRows() {
     	 $this->check();

         // Get current position, since we need to rewind the file
	 $pos = ftell($this->resource);

	 $rows = 0;
	 $this->rewind();
	 while($this->row()) {
	     $rows++;
	 }

	 // Restore original position
	 fseek($this->resource, $pos);

	 return $rows;
     }

     public function countColumns() {
         $this->check();
	 $pos = ftell($this->resource);
	 
	 $this->rewind();
	 $row = $this->row();
	 fseek($this->resource, $pos);

	 return count($row);
     }

     public function toDictionary()
     {
         $this->check();
	 $pos = ftell($this->resource);

	 $this->rewind();
	 
	 // first row is the header
	 $header = $this->row();
	 $rows = [];
	 while($r = $this->row()) {
	     $rows[] = array_combine($header, $r);
	 }

	 fseek($this->resource, $pos);
	 
	 return $rows;
     }

    /**
     * Release loaded resources when no longer needed
     */
     function __destruct()
     {
     	if($this->resource) {
	    fclose($this->resource);
	}
     }

}