<?php

namespace Ptrufanov1\SitemapGenerator\Exceptions;

use Exception;
use Ptrufanov1\SitemapGenerator\Sitemap;

class FileCreateException extends Exception {

	public function __construct() {
		parent::__construct();
		$this->message = 'File creation error';
	}

}