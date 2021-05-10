# yokel/yapi
Библиотека для организации REST-api на Битрикс

## Системные требования
- PHP 7 и выше
- Битрикс 14+

## Установка
Через composer
```
composer require yokel/yapi
```

## Использование

По умолчантю обрабатываются все http-запросы вида:
`http(s)://yoursite.name/yapi/[controller]/[method].[format]`

Будет вызван метод `[method]` контроллера `[controller]` и возвращён результат в формате `[format]`. 

```php
<?php
# /local/php_interface/init.php
\Yapi\Yapi::getInstance()->run($routes, $basePath, $beforeAction);
```

### Параметры

- $routes:array - маппинг контроллеров
- $basePath:string - путь api запросов
- $beforeAction:callable - метод, выполняемый перед каждым вызовом api

### Примеры вызова

```php
<?php
// GET http://yoursite.name/yapi/test/result.html
\Yapi\Yapi::getInstance()->run([
    'test' => '\YourNameSpace\YourController'
]);
```
 
```php
<?php
// GET http://yoursite.name/my_api/test/result.html
\Yapi\Yapi::getInstance()->run(
    [
      'test' => '\YourNameSpace\YourController'
    ],
    '/my_api/'
);
```
  
```php
<?php
// GET http://yoursite.name/my_api/test/result.json
\Yapi\Yapi::getInstance()->run(
    [
      'test' => '\YourNameSpace\YourController'
    ],
    '/my_api/',
    function() {
        // do some action
    }
);
```

## Контроллеры

Все api-контроллеры должны реализовывать интерфейс `\Yapi\Export\YapiController`.

```php
<?php
# Export/YapiController.php
interface YapiController {

    /**
     * Возвращает кастомный обработчки результата (для разных форматов)
     * @param string $format
     * @return mixed
     */
    public function getResultHandler(string $format);

}
```

### Пример контроллера

```php
<?php
namespace YourNameSpace;

use Yapi\Export\YapiController;

class Test implements YapiController {

    public function getResultHandler(string $format) {
        if ($format === 'custom') {
            // Для обработки результатов в формате custom будет использован класс \YourNameSpace\CustomResultHandler
            return '\YourNameSpace\CustomResultHandler';
        } else {
            return null;
        }
    }
    
    public function result($params) {
        return 'some result as text';
    }
    
}
```

## Обработка результатов

По умолчанию результат может быть возвращён в формате `json` или `html`.

- GET http://yoursite.name/yapi/test/result.html
- GET http://yoursite.name/yapi/test/result.json

Также возможно вернуть результат в произвольном формате (см. пример выше).

- GET http://yoursite.name/yapi/test/result.custom

### Результат в произвольном формате

Чтобы сформировать результат в произвольном формате необходимо использовать класс, реализующий интерфейс `\Yapi\Export\YapiResultHandler`.

```php
<?php
namespace YourNameSpace;

use Yapi\Export\YapiResultHandler;

class CustomResultHandler implements YapiResultHandler {
    
    /**
     * Приведём результат в верхний регистр 
     * @param $result - результат, полученный от контроллера
     */
    public function handle($result) {
        echo strtoupper($result);
    }
    
}
```