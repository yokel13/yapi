<?php
/**
 * @author      Andrey Konovalov <hello@yokel.tech>
 * @copyright   Copyright (c), 2021 Andrey Konovalov
 * @license     MIT public license
 */
namespace Yapi;

/**
 * Class EventManager
 * @package Yapi
 */
class EventManager {

    /**
     * Регистрирует обработчики событий Bitrix
     */
    public static function registerEvents() {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->addEventHandler(
            'main',
            'OnBeforeProlog',
            ['Yapi\\Router', 'run']
        );
    }

}