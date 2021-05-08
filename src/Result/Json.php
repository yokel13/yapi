<?php
/**
 * @author      Andrey Konovalov <hello@yokel.tech>
 * @copyright   Copyright (c), 2021 Andrey Konovalov
 * @license     MIT public license
 */
namespace Yapi\Result;

use Yapi\Export\YapiResultHandler;

/**
 * Class Json
 * @package Yapi\Result
 */
class Json implements YapiResultHandler {

    /**
     * Возвращает результат в заданном формате (json)
     * @param $result
     */
    public function handle($result) {
        header('Content-Type: application/json');
        echo json_encode(
            [
                'json' => $result
            ],
            JSON_UNESCAPED_UNICODE
        );
    }

}