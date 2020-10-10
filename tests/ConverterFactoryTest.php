<?php

namespace Tests;

use Jeidison\Factory7to8\ConverterFactory;
use PHPUnit\Framework\TestCase;

class ConverterFactoryTest extends TestCase
{

    public function testConvert()
    {
        $instance = new ConverterFactory();
        $instance->upgrade();
    }

}