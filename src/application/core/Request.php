<?php

namespace src\application\core;

class Request
{
    private $server;
    private $get;
    private $post;

    public function __construct($server = null, $get = null, $post = null)
    {
        if ($server !== null) {
            $this->server = new Server($server);
        } else {
            $this->server = new Server();
        }

        if ($get !== null) {
            $this->get = new Get($get);
        } else {
            $this->get = new Get();
        }

        if ($post !== null) {
            $this->post = new Post($post);
        } else {
            $this->post = new Post();
        }
    }

    public function isPost()
    {
        if ($this->server->getValue('REQUEST_METHOD') === 'POST') {
            return true;
        }

        return false;
    }

    public function getGet($name, $default = null)
    {
        if ($this->get->getValue($name) !== null) {
            return $this->get->getValue($name);
        }

        return $default;
    }

    public function getPost($name, $default = null)
    {
        if ($this->post->getValue($name) !== null) {
            return $this->post->getValue($name);
        }

        return $default;
    }

    public function getHost()
    {
        if (!empty($this->server->getValue('HTTP_HOST'))) {
            return $this->server->getValue('HTTP_HOST');
        } elseif (!empty($this->server->getValue('SERVER_NAME'))) {
            return $this->server->getValue('SERVER_NAME');
        } else {
            return null;
        }
    }

    public function isSsl()
    {
        $https = $this->server->getValue('HTTPS');

        if ($https !== null && strcasecmp($https, 'on') === 0) {
            return true;
        }

        return false;
    }

    public function getRequestUri()
    {
        return $this->server->getValue('REQUEST_URI');
    }

    public function getBaseUrl()
    {
        $script_name = $this->server->getValue('SCRIPT_NAME');
        $request_uri = $this->getRequestUri();

        if (strpos($request_uri, $script_name) === 0) {
            return $script_name;
        } elseif (strpos($request_uri, dirname($script_name)) === 0) {
            return rtrim(dirname($script_name), '/');
        }

        return '';
    }

    public function getPathInfo()
    {
        $base_url = $this->getBaseUrl();
        $request_uri = $this->getRequestUri();

        if (($pos = strpos($request_uri, '?')) !== false) {
            $request_uri = substr($request_uri, 0, $pos);
        }

        $path_info = (string)substr($request_uri, Strlen($base_url));

        return $path_info;
    }
}
