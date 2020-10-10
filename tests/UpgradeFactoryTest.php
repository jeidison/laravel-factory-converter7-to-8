<?php

namespace Tests;

use Jeidison\Factory7to8\UpgradeFactory;
use PHPUnit\Framework\TestCase;

class UpgradeFactoryTest extends TestCase
{

    public function testUpgrade()
    {
        $upgradeFactory = new UpgradeFactory();
        $upgradeFactory->upgrade();
    }

}