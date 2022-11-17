<?php

namespace Ptrufanov1\SitemapGenerator\Exceptions;

use Exception;

class InvalidPriorityValueException extends Exception {

	protected $message = 'Invalid in the field "lastmod" value. Valid min value 0.0 and valid max value 1.0';

}