<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$app = [];

$app = require 'config.php';

require 'Autoload.php';

Autoload::load();
