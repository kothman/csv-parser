# CSVParser
[![Build Status](https://travis-ci.org/kothman/csv-parser.svg?branch=master)](https://travis-ci.org/kothman/csv-parser) [![Latest Stable Version](https://poser.pugx.org/kothman/csv-parser/v/stable)](https://packagist.org/packages/kothman/csv-parser) [![Total Downloads](https://poser.pugx.org/kothman/csv-parser/downloads)](https://packagist.org/packages/kothman/csv-parser)

A CSV Parser for PHP.

## Install

Via Composer

```bash
$ composer require kothman/csv-parser
```

## Usage

```php
$parser = new Kothman\CSVParser("file.csv");
while($row = $parser->row()) {
    echo implode(", ", $row);
}

$parser->rewind();
$parser->row();

$parser->load("https://some.csv.file.csv");
$parser->set(['delimiter' => '.']);
echo $parser->toDictionary();
echo $parser->countColumns();
echo $parser->countRows();

```

## Testing

```bash
$ composer test
```

