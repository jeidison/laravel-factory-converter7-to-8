# Converter factories laravel 7 to 8
 
## Install

### composer.json

```json
"repositories": [
        {
            "type": "git",
            "url": "https://github.com/jeidison/laravel-convert-factory7-to-8.git"
        }
    ],

...

"require-dev": {
    ...
    
    "jeidison/laravel-convert-factory7-to-8": "@dev"
    ...
}
```

```shell script
$ composer update
```
 
```php
...
use Jeidison\Factory7to8\ConverterFactory;

...

$instance = new ConverterFactory;
$instance->convert();
```