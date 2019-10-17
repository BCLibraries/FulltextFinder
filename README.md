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
use BCLib\FulltextFinder\Config;
use BCLib\FulltextFinder\FullTextFinder;

require_once __DIR__ . '/vendor/autoload.php';

# LibKey API identifiers.
$libkey_apikey = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
$libkey_id = 'xxx';

$config = new Config();
$config->setUserAgent('MyApp/1.1 (https://mylibrary.college.edu/search; mailto:myapp.admin@cikkege.edu)')
    ->setFindByCitationMinLength(50);

$finder = FullTextFinder::build($libkey_id, $libkey_apikey, $config);
$response = $finder->find('Ben-Harush, A., Ezra-Shiovitz, S., Doron, I., Alon, S., Leibovitz, A., et al. (2017). Ageism among physicians, nurses, and social workers: findings from a qualitative study. European Journal of Ageing, 14(1), 39-48.');

echo "{$response->getTitle()}\n";
echo "\t{$response->getFullText()}\n";
```

## Configuration

The `BCLib\FulltextFinder\Config` object carries all optional FullTextFinder configuration parameters:

Parameter | Description | Default
--------- | ------------| -------
`UserAgent` | The `User-Agent` header sent to the Crossref API. For User-Agent requirements, see  [the Crossref API docs](https://github.com/CrossRef/rest-api-doc#meta). If the User-Agent is not set appropriately or is set to `null`, Crossref requests will be made in the public API pool. | `null`
`FindByCitationMinLength` | The minimum length of a search string in characters before find-by-citation will be applied. Searches under this length will look for a DOI in the string but will not query Crossref if a DOI is not found. | 20


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
