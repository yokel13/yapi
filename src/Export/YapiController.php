<?php
/**
 * @author      Andrey Konovalov <hello@yokel.tech>
 * @copyright   Copyright (c), 2021 Andrey Konovalov
 * @license     MIT public license
 */
namespace Yapi\Export;

/**
 * Interface YapiController
 * @package Yapi\Export
 */
interface YapiController {

    /**
     * Возвращает кастомный обработчки результата (для разных форматов)
     * @param string $format
     * @return mixed
     */
    public function getResultHandler(string $format);

}