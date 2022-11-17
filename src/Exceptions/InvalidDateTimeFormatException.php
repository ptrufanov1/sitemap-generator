<?php

namespace Ptrufanov1\SitemapGenerator\Exceptions;

use Exception;

class InvalidDateTimeFormatException extends Exception {

	protected $message = 'Invalid in the field "lastmod" value. Available dataTime format ISO 8601';

}