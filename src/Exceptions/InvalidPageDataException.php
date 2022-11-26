<?php

namespace Ptrufanov1\SitemapGenerator\Exceptions;

use Exception;

class InvalidPageDataException extends Exception {

	protected $message = 'Invalid data page. Expected an array with a required fields: "loc", "lastmod", "priority", "changefreq" fields';

}