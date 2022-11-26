<?php

namespace Ptrufanov1\SitemapGenerator\Exceptions;

use Exception;
use Ptrufanov1\SitemapGenerator\Sitemap;

class RequiredFieldException extends Exception {

	public function __construct(?int $index = null) {
		parent::__construct();

		$indexInfo = is_null($index) ?: " In index element $index";

		$this->message = 'Mandatory fields: "loc", "lastmod", "priority", "changefreq"'.$indexInfo;
	}

}