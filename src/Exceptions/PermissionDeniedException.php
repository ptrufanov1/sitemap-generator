<?php

namespace Ptrufanov1\SitemapGenerator\Exceptions;

use Exception;
use Ptrufanov1\SitemapGenerator\Sitemap;

class PermissionDeniedException extends Exception {

	public function __construct() {
		parent::__construct();
		$this->message = 'Permission denied to create directory';
	}

}