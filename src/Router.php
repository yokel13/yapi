<?php
/**
 * @author      Andrey Konovalov <hello@yokel.tech>
 * @copyright   Copyright (c), 2021 Andrey Konovalov
 * @license     MIT public license
 */
namespace Yapi;

use Yapi\Export\YapiController;
use Yapi\Export\YapiResultHandler;

/**
 * Class Router
 * @package Yapi
 */
class Router {

    /**
     * @var array Маршрутизация
     */
    private static $controllers = [];

    /**
     * @var array Классы-обработчики результата
     */
    private static $resultHandlers = [
        YapiResultHandler::TYPE_HTML => 'Yapi\Result\Html',
        YapiResultHandler::TYPE_JSON => 'Yapi\Result\Json',
        YapiResultHandler::TYPE_ERROR => 'Yapi\Result\Error'
    ];

    /**
     * Обрабатывает результат, полученный от внешнего контроллера
     * @param $handlerClass
     * @param $result
     */
    private function handleResult($handlerClass, $result) {
        /** @var YapiResultHandler $handler */
        $handler = new $handlerClass();
        $handler->handle($result);
    }

    /**
     * Обрабатывает ошибки
     * @param \Exception $e
     */
    private function handleError(\Exception $e) {
        Http::setStatusCode($e->getCode());
        $this->handleResult(self::$resultHandlers[YapiResultHandler::TYPE_ERROR], $e->getMessage());
    }

    /**
     * Завершает работу скрипта
     */
    private static function stopPropagation() {
        // Bitrix final actions
        \CMain::finalActions();

        // stop
        die();
    }

    /**
     * Запускает роутинг
     */
    public static function run() {
        // var
        $yapi = Yapi::getInstance();
        self::$controllers = $yapi->getRoutes();

        $router = new \Bramus\Router\Router();

        // для обхода urlrewrite.php
        $router->setBasePath('/');

        // rules
        $router->all($yapi->getBasePath().'(\w+)/(\w+).([a-z]+)', '\Yapi\Router@serve');

        // не устанавливаем статус 404, если маршрут не найден
        $router->set404(function () {
            return;
        });

        $router->run();
    }

    /**
     * Точка входа
     * @param $controllerName
     * @param $method
     * @param $format
     */
    public function serve($controllerName, $method, $format) {
        // var
        $yapi = Yapi::getInstance();
        $yapi->setController($controllerName);
        $yapi->setMethod($method);
        $yapi->setFormat($format);

        // CORS
        Http::setHeaders([
            'Access-Control-Allow-Origin' => '*'
        ]);

        // OPTIONS
        if (Request::isOptions()) {
            Http::setHeaders([
                'Access-Control-Allow-Methods' => $yapi->getAllowMethods(true),
                'Access-Control-Allow-Headers' => $yapi->getAllowHeaders(true)
            ]);
            self::stopPropagation();
        }

        try {
            // beforeAction
            $beforeAction = $yapi->getBeforeAction();
            if (is_callable($beforeAction)) {
                call_user_func($beforeAction);
            }

            /** @var YapiController $controller */
            $controller = Factory::build(self::$controllers[$controllerName], $method);
            $result = call_user_func([$controller, $method], $yapi->getRequestParams());

            $resultHandlerClass = ($controller->getResultHandler($format) ?? self::$resultHandlers[$format])
                ?? self::$resultHandlers[YapiResultHandler::TYPE_HTML];
            $this->handleResult($resultHandlerClass, $result);
        } catch (\Exception $e) {
            $this->handleError($e);
        }

        self::stopPropagation();
    }

}
