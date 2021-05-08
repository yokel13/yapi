<?php
namespace Yapi\Export;

/**
 * Interface YapiResultHandler
 * @package Yapi\Export
 */
interface YapiResultHandler {

    /**
     * Типа результата
     */
    const TYPE_HTML = 'html';
    const TYPE_JSON = 'json';
    const TYPE_ERROR = 'error';

    /**
     * Обработчки результата
     * @param $result
     * @return mixed
     */
    public function handle($result);

}