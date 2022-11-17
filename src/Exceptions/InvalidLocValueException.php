<?php

namespace Ptrufanov1\SitemapGenerator\Exceptions;

use Exception;

class InvalidLocValueException extends Exception {

	public function __construct($valueLoc) {
		parent::__construct();
		$this->message = "Invalid URL in the field \"loc\", pass value \"$valueLoc\". Expected valid URL";
	}

}