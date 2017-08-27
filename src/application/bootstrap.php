<?php

require 'core/ClassLoader.php';

$loader = new ClassLoader();
$loader->registrDir(dirname(__FILE__).'/core');
$loader->registrDir(dirname(__FILE__).'/models');
$loader->register();
