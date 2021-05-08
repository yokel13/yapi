<?php
/**
 * @author      Andrey Konovalov <hello@yokel.tech>
 * @copyright   Copyright (c), 2021 Andrey Konovalov
 * @license     MIT public license
 */
namespace Yapi\Result;

use Yapi\Export\YapiResultHandler;

/**
 * Class Error
 * @package Yapi\Result
 */
class Error implements YapiResultHandler {

    /**
     * Возвращает результат в заданном формате (ошибка)
     * @param $result
     */
    public function handle($result) {
        header('Content-Type: application/json');
        echo json_encode(
            [
                'error' => $result
            ],
            JSON_UNESCAPED_UNICODE
        );
    }

}