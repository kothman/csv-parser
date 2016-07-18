<?php

namespace Kothman;

class CSVParser
{

    protected $resource = null;
    protected $options = null;

    /**
     * Create a new CSVParser instance
     *
     * @param string $path A URL or file.
     * @param string $delimiter
     * @param int $length
     * @param string $enclosure
     * @param string $escape
     */
    public function __construct($path,
    	    	     		$delimiter = null,
			 	$length = null,
				$enclosure = null,
				$escape = null)
    {
        if (!$this->load($path)) {
	    throw new Exception('Unable to load resource: ' . $path);
        }
	$this->options = new \Kothman\CSVParserOptions($delimiter, $length, $enclosure, $escape);
    }

    /**
     * Load a resource to be used by the parser
     *
     * @param string $path A URL or file.
     * @return bool Indicate success or failiure
     */ 
     private function load($path)
     {
	$this->resource = fopen($path, 'r');
	return $this->resource?true:false;
     }

    /**
     * Called at the begining of any function that uses $resource
     *
     * @return void
     */
     protected function check() {
         if(!$this->resource) {
	     throw new Exception('The CSVParser does not have a loaded resource.');
	 }
     }

    /**
     * Set various options that get passed to fgetcsv in CSVParser::row
     *
     * See http://php.net/manual/en/function.fgetcsv.php for more info
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
			 $this->options->length,
			 $this->options->delimiter,
			 $this->options->enclosure,
			 $this->options->escape);
	 return $data;
     }

    /**
     * Resets the file position pointer back to the beginning of the file
     *
     * @return void
     */
     public function rewind() {
         $this->check();
         fseek($this->resource, 0);
     }

    /**
     * Returns the number of rows in the CSV resource by iterating through each row
     *
     * @return int Number of rows
     */
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

    /**
     * Count the number of columns based on the header row
     *
     * @return int Number of columns
     */
     public function countColumns() {
         $this->check();
	 $pos = ftell($this->resource);
	 
	 $this->rewind();
	 $row = $this->row();
	 fseek($this->resource, $pos);

	 return count($row);
     }

    /**
     * Convert the CSV resource to an associative array with the header row as keys
     *
     * @return array Associative array
     */
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