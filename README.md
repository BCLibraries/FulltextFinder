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
use BCLib\FulltextFinder\FullTextFinder;

require_once __DIR__ . '/vendor/autoload.php';

# A unique User-Agent header string to send to Crossref.
$user_agent = 'BCBento/0.1 (https://library.bc.edu/search; mailto:benjamin.florin@bc.edu)';

# LibKey API identifiers.
$xxxxxx_xxxxxx = 'xxxxxxxx-xxx-xxxx-xxxx-xxxxxxxxxxxx';
$libkey_id = 'xxx';

$finder = FullTextFinder::build($libkey_id, $libkey_apikey, $user_agent);
$response = $finder->find('The DOI we are looking for is 10.1371/journal.pone.0193984');

echo $response->getTitle() . "\n";
echo "\t" . $response->getFullText() . "\n";
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
