<?php

namespace src\application\core;

use PHPunit\Framework\TestCase;

class RouterTest extends TestCase
{
    private $target = null;

    private $definitions1 = [
        '/' => ['controller' => 'home', 'action' => 'index'],
        '/user/edit' => ['controller' => 'user', 'action' => 'edit']
    ];

    private $definitions2 = [
        '/user/:id' => ['controller' => 'user', 'action' => 'show']
    ];

    public function testInstance()
    {
        $this->target = new Router($this->definitions1);
        $this->assertInstanceOf('src\application\core\Router', $this->target);
    }

    public function testCompileRoutesReturnRoutes()
    {
        $this->target = new Router($this->definitions1);
        $routes = $this->target->compileRoutes($this->definitions1);
        $this->assertEquals(['controller' => 'user', 'action' => 'edit'], $routes['/user/edit']);
    }

    public function testCompileRoutesReturnRoutesIfColonExist()
    {
        $this->target = new Router($this->definitions2);
        $routes = $this->target->compileRoutes($this->definitions2);
        $this->assertEquals(['controller' => 'user', 'action' => 'show'], $routes['/user/(?P<id>[^/]+)']);
    }

    public function testResolveReturnFalseIfNoMatch()
    {
        $this->target = new Router($this->definitions1);
        $this->assertFalse($this->target->resolve('hoge'));
    }

    public function testResolveReturnParam()
    {
        $this->target = new Router($this->definitions1);
        $this->assertEquals(['controller' => 'user', 'action' => 'edit', 0 => '/user/edit'], $this->target->resolve('user/edit'));
    }

    public function testResolveReturnParamIfColonExist()
    {
        $this->target = new Router($this->definitions2);
        $this->assertEquals(['controller' => 'user', 'action' => 'show', 0 => '/user/:id', 'id' => ':id', 1 => ':id'], $this->target->resolve('user/:id'));
    }
}
