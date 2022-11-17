<?php

namespace Ptrufanov1\SitemapGenerator\Exceptions;

use Exception;

class UnknownTagException extends Exception {

	public function __construct(?string $tagName) {
		parent::__construct();
		$this->message = "Unknown tag \"$tagName\". Available tags: loc, lastmod, priority, changefreq";
	}

}