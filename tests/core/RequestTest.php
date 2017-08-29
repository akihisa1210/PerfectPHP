<?php

namespace src\application\core;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    private $target = null;

    public function setUp()
    {
        $this->target = new Request();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('src\application\core\Request', $this->target);
    }

    public function testIsPostReturnTrunIfPost()
    {
        $this->target = new Request(['REQUEST_METHOD' => 'POST'], null, null);
        $this->assertTrue($this->target->isPost());
    }

    public function testIsPostReturnFalseIfGet()
    {
        $this->target = new Request(['REQUEST_METHOD' => 'GET'], null, null);
        $this->assertFalse($this->target->isPost());
    }

    public function testIsPostReturnFalseIfEmpty()
    {
        $this->target = new Request(['REQUEST_METHOD' => ''], null, null);
        $this->assertFalse($this->target->isPost());
    }

    public function testGetGetReturnNullIfKeyNotExist()
    {
        $this->target = new Request(null, ['foo' => 'baa'], null);
        $this->assertNull($this->target->getGet('hoge'));
    }

    public function testGetGetReturnValueIfKeyExist()
    {
        $this->target = new Request(null, ['foo' => 'baa'], null);
        $this->assertEquals('baa', $this->target->getGet('foo'));
    }

    public function testGetPostReturnNullIfKeyNotExist()
    {
        $this->target = new Request(null, null, ['foo' => 'baa']);
        $this->assertNull($this->target->getPost('hoge'));
    }

    public function testGetPostReturnValueIfKeyExist()
    {
        $this->target = new Request(null, null, ['foo' => 'baa']);
        $this->assertEquals('baa', $this->target->getPost('foo'));
    }

    public function testGetHostReturnHttpHostIfHttpHostExist()
    {
        $this->target = new Request(['HTTP_HOST' => 'hostname', 'SERVER_NAME' => 'servername'], null, null);
        $this->assertEquals('hostname', $this->target->getHost());
    }

    public function testGetHostReturnServerNameIfHttpHostNotExist()
    {
        $this->target = new Request(['SERVER_NAME' => 'servername'], null, null);
        $this->assertEquals('servername', $this->target->getHost());
    }

    public function testGetHostReturnNullIfValueNotExist()
    {
        $this->target = new Request(['hoge' => 'fuga'], null, null);
        $this->assertNull($this->target->getHost());
    }

    public function testIsSslReturnTrueIfHttpsOn()
    {
        $this->target = new Request(['HTTPS' => 'on'], null, null);
        $this->assertTrue($this->target->isSsl());
    }

    public function testIsSslReturnFalseIfHttpsOff()
    {
        $this->target = new Request(['HTTPS' => 'off'], null, null);
        $this->assertFalse($this->target->isSsl());
    }

    public function testIsSslReturnFalseIfHttpsNotExist()
    {
        $this->target = new Request(['hoge' => 'fuga'], null, null);
        $this->assertFalse($this->target->isSsl());
    }

    public function testIsSslReturnTrueIfHttpsOnUppercase()
    {
        $this->target = new Request(['HTTPS' => 'ON'], null, null);
        $this->assertTrue($this->target->isSsl());
    }

    public function testGetRequestUriReturnUriIfKeyExist()
    {
        $this->target = new Request(['REQUEST_URI' => '/you/request/it'], null, null);
        $this->assertEquals('/you/request/it', $this->target->getRequestUri());
    }

    public function testGetRequestUriReturnNullIfKeyNotExist()
    {
        $this->target = new Request(['hoge' => 'huga'], null, null);
        $this->assertNull($this->target->getRequestUri());
    }

    public function testGetBaseUrReturnBaseUrlWhenFrontControllerIsContained()
    {
        $this->target = new Request(['REQUEST_URI' => '/foo/bar/index.php/list', 'SCRIPT_NAME' => '/foo/bar/index.php']);
        $this->assertEquals('/foo/bar/index.php', $this->target->getBaseUrl());
    }

    public function testGetBaseUrlReturnBaseUrlWithoutFrontControllerWhenFCIsNotContained()
    {
        $this->target = new Request(['REQUEST_URI' => '/foo/bar/list', 'SCRIPT_NAME' => '/foo/bar/index.php']);
        $this->assertEquals('/foo/bar', $this->target->getBaseUrl());
    }

    public function testGetPathInfoReturnPathInfo()
    {
        $this->target = new Request(['REQUEST_URI' => '/foo/bar/index.php/list', 'SCRIPT_NAME' => '/foo/bar/index.php']);
        $this->assertEquals('/list', $this->target->getPathInfo());
    }

    public function testGetPathInfoReturnPathInfoWhenFCIsNotContained()
    {
        $this->target = new Request(['REQUEST_URI' => '/foo/bar/list', 'SCRIPT_NAME' => '/foo/bar/index.php']);
        $this->assertEquals('/list', $this->target->getPathInfo());
    }

    public function testGetPathInfoReturnPathInfoWhenUrlParamExist()
    {
        $this->target = new Request(['REQUEST_URI' => '/foo/bar/index.php/list?hoge=fuga', 'SCRIPT_NAME' => '/foo/bar/index.php']);
        $this->assertEquals('/list', $this->target->getPathInfo());
    }
}
