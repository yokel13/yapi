<?php
/**
 * @author      Andrey Konovalov <hello@yokel.tech>
 * @copyright   Copyright (c), 2021 Andrey Konovalov
 * @license     MIT public license
 */
namespace Yapi\Result;

use Yapi\Export\YapiResultHandler;

/**
 * Class Html
 * @package Yapi\Result
 */
class Html implements YapiResultHandler {

    /**
     * Возвращает результат в заданном формате (html)
     * @param $result
     */
    public function handle($result) {
        echo $result;
    }

}