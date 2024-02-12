
# 🤖 Sitemap generator

Generate sitemap file from php. Available formats: xml, json, csv.


## Installation

Installation via Composer

```bash
composer require ptrufanov1/sitemap-generator
```

That, make sure your application autoload Composer classes by including vendor/autoload.php.

```php
require "vendor/autoload.php";
```
## Requirements

The minimum requirement by this project template that your Web server supports `PHP 8.0.`
## How to use it

```php
require_once "vendor/autoload.php";

use Ptrufanov1\SitemapGenerator\Sitemap;

$pages = [
	[
		'loc' => 'https://site.ru/',
		'lastmod' => '2022-10-14',
		'priority' => 1,
		'changefreq' => 'hourly',

	],
	[
		'loc' => 'https://site.ru/news',
		'lastmod' => '2022-10-10',
		'priority' => 0.5,
		'changefreq' => 'daily',

	],
	[
		'loc' => 'https://site.ru/about',
		'lastmod' => '2022-10-07',
		'priority' => 0.1,
		'changefreq' => 'weekly',

	],
	[
		'loc' => 'https://site.ru/products',
		'lastmod' => '2022-10-12',
		'priority' => 0.5,
		'changefreq' => 'daily',

	],
	[
		'loc' => 'https://site.ru/products/ps5',
		'lastmod' => '2022-10-11',
		'priority' => 0.1,
		'changefreq' => 'weekly',

	],
	[
		'loc' => 'https://site.ru/products/xbox',
		'lastmod' => '2022-10-12',
		'priority' => 0.1,
		'changefreq' => 'weekly',

	],
	[
		'changefreq' => 'weekly',
		'priority' => 0.3,
		'lastmod' => '2022-10-15',
		'loc' => 'https://site.ru/products/wii',

	]
];

/* Path to save sitemap file */
$path = $_SERVER['DOCUMENT_ROOT']."/sitemap/";

try {
	if (Sitemap::load($pages)->saveXml($path)) {
        echo "Sitemap save successful!";
    }
} catch (Exception $e) {
	echo "Error sitemap generate: ".$e->getMessage();
}
```

## Use cases

Generate xml sitemap file
```php
Sitemap::load($pages)->saveXml($path)
```

Generate csv sitemap file
```php
Sitemap::load($pages)->saveCsv($path)
```

Generate JSON sitemap file
```php
Sitemap::load($pages)->saveJson($path)
```

Return `true` if file successful generate. Or throw an exception on error.


[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)
