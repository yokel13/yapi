<?php
/**
 * @author      Andrey Konovalov <hello@yokel.tech>
 * @copyright   Copyright (c), 2021 Andrey Konovalov
 * @license     MIT public license
 */
namespace Yapi;

/**
 * Class Request
 * @package Yapi
 */
class Request {

    /**
     * Возвращает параметры запроса
     * @return mixed
     */
    public static function getRequestParams() {
        $request = \Bitrix\Main\Context::getCurrent()->getRequest();
        return $request->getQueryList()->toArray();
    }

    /**
     * Возвращает тело запроса
     * @return bool|string
     */
    public static function getRequestBody() {
        return file_get_contents('php://input');
    }

    /**
     * Возвращает заголовки запроса
     * @return array|false
     */
    public static function getRequestHeaders() {
        return getallheaders();
    }

    /**
     * @return bool
     */
    public static function isOptions() {
        return $_SERVER['REQUEST_METHOD'] === 'OPTIONS';
    }

}