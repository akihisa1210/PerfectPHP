<?php

namespace src\application\core;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    private $target = null;

    public function testInstance()
    {
        $this->target = new Response();
        $this->assertInstanceOf('src\application\core\Response', $this->target);
    }
}
