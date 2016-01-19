<?php 
require_once(realpath(dirname(__FILE__))."/../config/dbconf.php");
global $config;
$pdo = new PDO($config['host'], 
               $config['user'], 
               $config['password']);
