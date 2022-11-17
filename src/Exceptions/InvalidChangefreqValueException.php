<?php

namespace Ptrufanov1\SitemapGenerator\Exceptions;

use Exception;
use Ptrufanov1\SitemapGenerator\Sitemap;

class InvalidChangefreqValueException extends Exception {

	public function __construct() {
		parent::__construct();
		$this->message = 'Invalid in the field "changefreq" value. Expected one of values: '. implode(', ', Sitemap::$availableChangefreq);
	}

}