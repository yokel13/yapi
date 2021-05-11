<?php
/**
 * @author      Andrey Konovalov <hello@yokel.tech>
 * @copyright   Copyright (c), 2021 Andrey Konovalov
 * @license     MIT public license
 */
namespace Yapi;

/**
 * Class Yapi
 * @package Yapi
 */
class Yapi {

    /**
     * @var Yapi Экземпляр класса
     */
    private static $_instance = null;

    /**
     * @var array Маршрутизация
     */
    private $routes = [];

    /**
     * @var string Точка входа
     */
    private $basePath = '/yapi';

    /**
     * @var string Тело запроса
     */
    private $requestBody = null;

    /**
     * @var array Заголовки запроса
     */
    private $requestHeaders = null;

    /**
     * @var array Параметры запроса
     */
    private $requestParams = [];

    /**
     * @var callable Функция, выполняемая перед роутингом
     */
    private $beforeAction = null;

    /**
     * @var string Контроллер
     */
    private $controller = null;

    /**
     * @var string Метод
     */
    private $method = null;

    /**
     * @var string Формат данных
     */
    private $format = null;

    /**
     * @var array Допустимые тип запросов (Access-Control-Allow-Methods)
     */
    private $allowMethods = [
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE'
    ];

    /**
     * @var array Допустимые заголовки запроса (Access-Control-Allow-Headers)
     */
    private $allowHeaders = [
        'Content-Type',
        'Access-Control-Allow-Origin'
    ];

    /**
     * Singleton
     * @return null|Yapi
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new Yapi();
        }

        return self::$_instance;
    }

    /**
     * Запускает маршрутизацию, устанавливает пути и точку входа
     * @param array $routes
     * @param bool $basePath
     * @param callable|null $beforeAction
     */
    public function run($routes = [], $basePath = false, $beforeAction = null) {
        EventManager::registerEvents();

        $this->routes = $routes;
        $this->beforeAction = $beforeAction;
        if ($basePath) {
            $this->basePath = $basePath;
        }

        $this->requestParams = Request::getRequestParams();
        $this->requestBody = Request::getRequestBody();
        $this->requestHeaders = Request::getRequestHeaders();
    }

    /**
     * Возвращает маршруты
     * @return array
     */
    public function getRoutes(): array {
        return $this->routes;
    }

    /**
     * Возвращает путь до точки входа
     * @return string
     */
    public function getBasePath(): string {
        return rtrim($this->basePath, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
    }

    /**
     * Возвращает тело запроса
     * @return null
     */
    public function getRequestBody() {
        return $this->requestBody;
    }

    /**
     * Возвращает заголовки запроса
     * @return null
     */
    public function getRequestHeaders() {
        return $this->requestHeaders;
    }

    /**
     * @return callable
     */
    public function getBeforeAction() {
        return $this->beforeAction;
    }

    /**
     * @return array
     */
    public function getRequestParams(): array {
        return $this->requestParams;
    }

    /**
     * @param bool $stringify
     * @return array|string
     */
    public function getAllowMethods(bool $stringify = false) {
        return $stringify ? implode(',', $this->allowMethods) : $this->allowMethods;
    }

    /**
     * @param bool $stringify
     * @return array
     */
    public function getAllowHeaders(bool $stringify = false) {
        return $stringify ? implode(',', $this->allowHeaders) : $this->allowHeaders;
    }

    /**
     * @param array $allowHeaders
     */
    public function setAllowHeaders(array $allowHeaders) {
        $this->allowHeaders = array_merge($this->allowHeaders, $allowHeaders);
    }

    /**
     * @return string
     */
    public function getController(): string {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller) {
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getMethod(): string {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method) {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getFormat(): string {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format) {
        $this->format = $format;
    }

}