<?php
/**
 * @author      Andrey Konovalov <hello@yokel.tech>
 * @copyright   Copyright (c), 2021 Andrey Konovalov
 * @license     MIT public license
 */
namespace Yapi\Exceptions;

/**
 * Class GeneralException
 * @package Yapi\Exceptions
 */
class GeneralException extends \Exception {

    /**
     * GeneralException constructor.
     * @param string $message
     * @param int $code
     * @param null $previous
     */
    public function __construct($message = '', $code = 404, $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}