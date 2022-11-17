<?php

namespace Ptrufanov1\SitemapGenerator\Exceptions;

use Exception;

class InvalidPageDataException extends Exception {

	protected $message = 'Empty data page. Expected an array with a required "loc" parameter';

}