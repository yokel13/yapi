<?php
/**
 * @author      Andrey Konovalov <hello@yokel.tech>
 * @copyright   Copyright (c), 2021 Andrey Konovalov
 * @license     MIT public license
 */
namespace Yapi;

use Yapi\Exceptions\GeneralException;

/**
 * Class Factory
 * @package Yapi
 */
class Factory {

    /**
     * Создаёт экземпляр класса внешнего контроллера
     * @param $controller
     * @param $method
     * @return mixed
     * @throws GeneralException
     */
    public static function build($controller, $method) {
        if (empty($controller) || !class_exists($controller)) {
            throw new GeneralException('Контроллер не найден');
        }

        if (empty($method) || !method_exists($controller, $method)) {
            throw new GeneralException('Метод не найден');
        }

        return new $controller;
    }

}