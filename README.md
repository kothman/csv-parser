# CSVParser



## Install

Via Composer

```bash
$ composer require kothman/csvparser
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

