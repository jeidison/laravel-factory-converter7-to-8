# Laravel Factory Converter of 7 to 8 style
 
## Installation

### composer.json

```json
"repositories": [
        {
            "type": "git",
            "url": "https://github.com/jeidison/laravel-factory-converter7-to-8.git"
        }
    ],

...

"require-dev": {
    ...
    
    "jeidison/laravel-factory-converter7-to-8": "@dev"
    ...
}
```

```shell script
$ composer update
```

## Usage
 
```php
...
use Jeidison\Factory7to8\ConverterFactory;

...

$instance = new ConverterFactory;
$instance->convert();
```
