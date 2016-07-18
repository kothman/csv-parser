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
```

## Testing

```bash
$ composer test
```

