<?php

namespace Kothman\CSV;

class ParserTest extends \PHPUnit_Framework_TestCase
{

    public function __construct()
    {
        parent::__construct();
	chdir(__DIR__);
    }

    public function testCanBeLoaded()
    {
        $parserA = new CSVParser();
	$this->assertTrue($parserA->load('test.csv'));
    }

    public function testCanGetRow()
    {
        $parser = new CSVParser('test.csv');
	$row = $parser->row();
	$this->assertNotEmpty($row);
    }

    public function testCanRewind()
    {
	$parser = new CSVParser('test.csv');
	$firstRow = $parser->row();
	$parser->rewind();
	$alsoFirstRow = $parser->row();
	$this->assertEquals($firstRow, $alsoFirstRow);
    }

    public function testCanGetDifferentRows()
    {
        $parser = new CSVParser('test.csv');
	$firstRow = $parser->row();
	$secondRow = $parser->row();
	$this->assertNotEquals($firstRow, $secondRow);
    }

    public function testRowCount()
    {
        $p1 = new CSVParser('1row.csv');
	$this->assertEquals(1, $p1->countRows());
	
	$p2 = new CSVParser('2rows.csv');
	$this->assertEquals(2, $p2->countRows());

	$p10 = new CSVParser('10rows.csv');
	$this->assertEquals(10, $p10->countRows());
    }

    public function testDict()
    {
        $parser = new CSVParser('dict.csv');
	$dict = [['col1' => 'a',
	         'col2' => 'b',
		 'col3' => 'c']];
	$this->assertEquals($dict, $parser->toDictionary());
    }
}