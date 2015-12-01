<?php namespace Ace\Tokens\Store;

use Exception;

/**
 * @author timrodger
 * Date: 29/03/15
 */
class MissingException extends Exception {

    public function __construct($message = "") {

        parent::__construct($message, 404, null);
    }
}