# FulltextFinder

FulltextFinder is a PHP library for finding links to fulltext versions of articles from user input.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install FulltextFinder.

```bash
composer init # Only necessary when starting a project from scratch.
composer require bclibraries/fulltext-finder:^0.1
```

FulltextFinder is currently a 0.* release, so things will change drastically with any minor release.

## Usage

```php
use \BCLib\FulltextFinder\SearchText;

require_once 'vendor/autoload.php';

$search_text = new SearchText('https://doi.org/10.1108/RR-07-2014-0203');
$doi = $search_text->getDOI();
```

# Running tests

[PHPUnit](https://phpunit.de/) is used for testing. You may need to enable the sockets extension.

```bash
./vendor/bin/phpunit 
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
