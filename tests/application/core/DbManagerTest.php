<?php

namespace src\application\core;

use PHPUnit\Framework\TestCase;

class DbManagerTest extends TestCase
{
    private $target = null;

    public function testInstance()
    {
        $this->target = new DbManager();
        $this->assertInstanceOf('src\application\core\DbManager', $this->target);
    }
}
